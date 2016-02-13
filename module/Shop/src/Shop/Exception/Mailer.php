<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @package   ${NAMESPACE}
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2016 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Exception;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Mime;
use Zend\Mime\Part;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

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

    function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Zend\ServiceManager\ServiceManager $sm
     *
     * @return Mailer
     */
    public function setServiceManager($sm)
    {
        $this->sm = $sm;
        return $this;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->sm;
    }

    /**
     * @param \Exception $e
     * @return \Zend\Mime\Message
     */
    public function getHtmlBody(\Exception $e)
    {
        /** @var PhpRenderer $view */
        $view = $this->getServiceManager()->get('ViewRenderer');
        /* @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getServiceManager()->get('Request');

        $model = new ViewModel([
            'exception'     => $e,
            'getVars'       => $request->getQuery()->toArray(),
            'postVars'      => $request->getPost()->toArray(),
            'requestString' => $request->toString(),
            'sessionVars'   => $_SESSION,
        ]);

        $model->setTemplate($this->config['exception_mailer']['template']);

        $content = $view->render($model);
        $text = new Part('');
        $text->type = "text/plain";
        $html = new Part($content);
        $html->type = Mime::TYPE_HTML;
        $msg = new \Zend\Mime\Message();
        $msg->setParts(Array($text, $html));
        return $msg;
    }

    /**
     * @param \Exception $e
     */
    public function mailException(\Exception $e)
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
            $message->setBody($this->getHtmlBody($e));
        } else {
            $message->setBody($e->getTraceAsString());
        }

        $options = $this->getServiceManager()->get('config')['uthando_mail']['mail_transport']['webmaster']['options'];

        $options = new SmtpOptions($options);

        $transport = new Smtp($options);
        $transport->send($message);
    }
}
