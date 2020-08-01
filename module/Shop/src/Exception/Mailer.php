<?php

namespace Shop\Exception;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Mime\Message as MimeMessage;
use Laminas\Mime\Mime;
use Laminas\Mime\Part;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Model\ViewModel;
use Laminas\View\Renderer\PhpRenderer;

/**
 * Class Mailer
 *
 * @package Shop\Exception
 */
class Mailer
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var ServiceManager
     */
    protected $sm;

    /**
     * Mailer constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param \Laminas\ServiceManager\ServiceManager $sm
     *
     * @return Mailer
     */
    public function setServiceManager($sm)
    {
        $this->sm = $sm;
        return $this;
    }

    /**
     * @return \Laminas\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->sm;
    }

    /**
     * @param \Exception $e
     * @param array $extraVars
     * @return MimeMessage
     * @throws \Exception
     */
    public function getHtmlBody($e, $extraVars = [])
    {
        /** @var PhpRenderer $view */
        $view = $this->getServiceManager()->get('ViewRenderer');
        /* @var \Laminas\Http\PhpEnvironment\Request $request */
        $request = $this->getServiceManager()->get('Request');

        $model = new ViewModel(array_merge($extraVars, [
            'exception'     => $e,
            'getVars'       => $request->getQuery()->toArray(),
            'postVars'      => $request->getPost()->toArray(),
            'requestString' => $request->toString(),
            'sessionVars'   => $_SESSION,
        ]));

        $model->setTemplate($this->config['exception_mailer']['template']);

        $content = $view->render($model);
        $text = new Part('');
        $text->type = "text/plain";
        $html = new Part($content);
        $html->type = Mime::TYPE_HTML;
        $mime = new MimeMessage();
        $mime->setParts([$text, $html]);

        return $mime;
    }

    /**
     * @param \Exception $e
     * @param array $extraVars
     */
    public function mailException($e, $extraVars = [])
    {
        // Mail
        if (!$this->config['exception_mailer']['send']) {
            return;
        }

        $subject = $this->config['exception_mailer']['subject'];
        $sender = $this->config['exception_mailer']['sender'];
        $recipients = $this->config['exception_mailer']['recipients'];

        // no one to send it to
        if (empty($sender) || empty ($recipients)) {
            return;
        }

        // should we ignore the exception
        if ($e instanceof IgnoreExceptionInterface) {
            return;
        }

        if ($this->config['exception_mailer']['exceptionInSubject']) {
            $subject .= ' ' . $e->getMessage();
        }

        $message = new Message();
        $message->addFrom($sender)
            ->addTo($recipients)
            ->setSubject($subject)
            ->setEncoding('UTF-8');

        // check if we should use the template
        if ($this->getServiceManager() !== null
            && $this->config['exception_mailer']['useTemplate'] == true
        ) {
            $message->setBody($this->getHtmlBody($e, $extraVars));
        } else {
            $message->setBody($e->getTraceAsString());
        }

        $options = $this->getServiceManager()->get('config')['uthando_mail']['mail_transport']['webmaster']['options'];

        $options = new SmtpOptions($options);

        $transport = new Smtp($options);
        $transport->send($message);
    }
}
