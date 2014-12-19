<?php // change_details.php Tuesday, 5 April 2014
// This page allows logged-in users to change their details

if (!isset($_SESSION['cid'])) {

	header ("Location: $merchant_website/index.php");

} else {
	// Include configuration file for error management and such.
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_files.php');
	
	// Set the page title.
	$page_title = "Change Address";
	
	$countryId = $request->getPost('country_id', 1);
	
	$CBA = new ChangeDetailsForm($countryId);
	$CDA = new ChangeDetailsBaseForm($countryId);
	
	if ($request->isPost() && $request->getPost('submit') == 'Change Details') {
		
	}
	
	if ($request->getPost('submit') == 'Register') {
		$registerForm->setData(array(
			'referer_link' => $request->getPost('referer_link')
		));
	}
	
	$viewRenderer = new ViewRenderer();
	
	$content .= $viewRenderer->render('register', array(
			'billingForm' => $CBA,
			'deliveryForm' => $CDA,
			'merchant_name' => $merchant_name,
	));
	
	// Include html footer.
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/includes/inc_bottom.php');
}
?>