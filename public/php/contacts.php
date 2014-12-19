<?php // contacts.php Thursday, 7 April 2014
// This page allows users to reset their password, if forgotten.

// Set the page title and include the HTML header.
$page_title = "Contact Us"; 

// Include configuration file for error management and such.
require_once ($_SERVER['DOCUMENT_ROOT'] . '/../data/mail_options.php');

$contactForm = new ContactForm();
$inputFilter = new ContactInputFilter();
$contactForm->setInputFilter($inputFilter);
$contactForm->init();
$sent = false;

if ($request->isPost()) {
	
	$contactForm->setData($request->getPost());
	
	if ($contactForm->isValid()) {
		
		$data = $contactForm->getData();
		
		$sendMail = new SendMail($sendMailconfig);

        $data['message'] .= "\r\n\r\nFrom: " . $data['name'];
        $data['message'] .= "\r\nTelephone: " . $data['phone'];
		
		$sendMail->sendEmail(array(
			'from' => array(
				'name' => $data['name'],
				'address' => $data['email'],
			),
			'to' => $sendMailconfig['address_list'][$data['department']],
			'subject' => $data['subject'],
			'body' => $data['message'],
		));
		
		// send client copy
		
		$respondMessage = "Dear " . $data['name'] . ", \r\n\r\n We thank you for your enquiry and we will get back to you as soon as possible., \r\n\r\n Charisma Beads Ltd. ";
		$respondMessage .= "\r\n\r\n Here is a copy of your enquiry, for your records:\r\n\r\n";
		$respondMessage .= $data['message'];
		
		$sendMail->sendEmail(array(
			'to' => array(
				'name' => $data['name'],
				'address' => $data['email'],
			),
			'from' => $sendMailconfig['address_list'][$data['department']],
			'subject' => $data['subject'],
			'body' => $respondMessage,
		));
		
		$sent = true;
		
	} else {
		$contactForm->setMessages(array('security'=> array('Oops! Someting went wrong. Please try again.')));
    }
}

$viewScript = ($sent) ? 'thank-you' : 'contact';

$formRenderer = new ViewRenderer();

$content .= $formRenderer->render($viewScript, array(
		'form' => $contactForm,
));

?>