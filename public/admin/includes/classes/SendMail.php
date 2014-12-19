<?php

use Zend\Mail\Message;
use Zend\Mail\Transport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class SendMail
{
	protected $config;
	
	public function __construct(array $config)
	{
		$this->config = $config;
	}
	
	public function sendEmail($data)
	{
		$to		 = $data['to'];
		$from	 = $data['from'];
		$subject = $data['subject'];
		$body    = (isset($data['body'])) ? $data['body'] : null;
        $htmlBody    = (isset($data['html'])) ? $data['html'] : null;

        $parts = [];

        if ($body) {
            $text = new MimePart($body);
            $text->type = "text/plain";
            $parts[] = $text;
        }

        if ($htmlBody) {
            $html = new MimePart($htmlBody);
            $html->type = "text/html";
            $parts[] = $html;
        }

        $body = new MimeMessage();
        $body->setParts($parts);

        $message = $this->getMailMessage()
            ->setSubject($subject)
            ->setBody($body)
            ->setEncoding('utf-8');
		
		if (is_array($to)) {
			$message->setTo($to['address'], $to['name']);
		} else {
			$message->setTo($to);
		}
		
		if (is_array($from)) {
			$message->setFrom($from['address'], $from['name']);
		} else {
			$message->setFrom($from);
		}
	
		return $this->getMailTransport()
			->send($message);
	}
	
	public function getMailMessage()
	{
		$message = new Message();
	
		return $message;
	}
	
	public function getMailTransport()
	{
		$config  = $this->config['mail_transport'];
		$class   = $config['class'];
		$options = $config['options'];
	
		switch ($class) {
			case 'Zend\Mail\Transport\Sendmail':
			case 'Sendmail':
			case 'sendmail';
			$transport = new Transport\Sendmail();
			break;
			case 'Zend\Mail\Transport\Smtp';
			case 'Smtp';
			case 'smtp';
			$options = new Transport\SmtpOptions($options);
			$transport = new Transport\Smtp($options);
			break;
			case 'Zend\Mail\Transport\File';
			case 'File';
			case 'file';
			$options = new Transport\FileOptions($options);
			$transport = new Transport\File($options);
			break;
			default:
				throw new \DomainException(sprintf(
					'Unknown mail transport type provided ("%s")',
					$class
				));
		}
		
		return $transport;
	}
}

?>