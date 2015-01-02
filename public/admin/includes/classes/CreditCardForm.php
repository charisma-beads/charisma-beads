<?php

require_once ('Zend/Form.php');
require_once ('Zend/View/Interface.php');

class CreditCardForm extends Zend_Form
{   
	protected $_months = array(
			'0'		=> '--Month--',
			'01'    => 'January',
			'02'    => 'February',
			'03'    => 'March',
			'04'    => 'April',
			'05'    => 'May',
			'06'    => 'June',
			'07'    => 'July',
			'08'    => 'August',
			'09'    => 'September',
			'10'    => 'October',
			'11'    => 'November',
			'12'    => 'December'
	);
	
	protected $_elementDecorators = array(
        'ViewHelper',
		'Errors'
    );
	
	public function setView(Zend_View_Interface $view = null)
	{
		parent::setView($view);
		foreach ($this as $item) {
			$item->setView($view);
		}
		return $this;
	}
	
    public function init()
    {	
        $this->addElement('hidden', 'oid', array(
                'required'    => true,
                'value'       => ''
        ));
        
        $this->addElement('hidden', 'total', array(
        		'required'    => true,
        		'value'       => ''
        ));
        
        $this->addElement('text', 'ccName', array(
                'filters'       => array('StripTags', 'StringTrim'),
                'required'      => true,
                'value'         => '',
        		'errorMessages'	=> array('Please enter the name of the card holder'),
        ));
        
       $this->addElement('select', 'ccType', array(
        		'multiOptions'	=> array(
        				'0'		=> 'Select a Card',
        				'v'     => 'Visa/Delta/Electron',
        				'm'     => 'MasterCard/Eurocard',
        				//'d'     => 'Discover',
        				'sm'    => 'Switch/Maestro',
        				//'s'     => 'Solo'
        		),
        		'validators'    => array('Alpha'),
        		'value'		=> '0',
        		'errorMessages'	=> array('Please select a card type'),
        		'required'	=> true
        ));
        
        $this->addElement('text', 'ccNumber', array(
        		'filters'       => array(
        		    'StripTags',
        		    'StringTrim',
        		    array('PregReplace', array(
        		        'match' => '/\s+/',
        		        'replace' => ''
        		    ))
        		),
        		'validators'    => array(array('CreditCard', true)),
        		'required'      => true,
        		'value'         => '',
        		'ErrorMessages' => array('The card you entered seems to be an invalid card number. Please check and re-enter.')
        ));
        
        $this->addElement('select', 'ccExpiryMonth', array(
        		'multiOptions'	=> $this->_months,
        		'validators'    => array(array('StringLength', true, array('min' => 2))),
        		'errorMessages'	=> array('Please select a expiry month.'),
        		'value'		=> '0',
        		'required'	=> true,
        		'decorators'	=> array('ViewHelper')
        ));
        
        $year = date('Y');
        $expiryYears = array('0' => '--Year--');
        
        for ($i=$year; $i<=$year+20; $i++) {
        	$expiryYears[$i] = $i;
        }
        
        $this->addElement('select', 'ccExpiryYear', array(
        		'multiOptions'	=> $expiryYears,
        		'validators'    => array(array('StringLength', true, array('min' => 2))),
        		'errorMessages'	=> array('Please select a expiry year.'),
        		'value'			=> '0',
        		'required'		=> true,
        		'decorators'	=> array('ViewHelper')
        ));
        
        $this->addElement('text', 'ccCardVerificationNumber', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'validators'    => array(
        		    'Digits',
        		    array('StringLength', false, array('min' => 3, 'max' => 3))
        		),
        		'required'      => true,
        		'attribs'		=> array(
        				'size'		=> '6',
        				'maxlength'	=> '4'
        		),
        		'ErrorMessages'	=> array('Card Verification number must contain only three digits.'),
        		'value'         => ''
        ));
        
        $this->addElement('text', 'ccIssueNumber', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'validators'    => array(
        		    'Digits'
        		),
        		'ErrorMessages'	=> array('Please a valid issue number.'),
        		'required'      => false,
        		'attribs'		=> array(
        				'size'		=> '6',
        				'maxlength'	=> '4'
        		),
        		'value'         => ''
        ));
        
        $this->addElement('select', 'ccStartMonth', array(
        		'multiOptions'	=> $this->_months,
        		//'validators'    => array(array('StringLength', true, array('min' => 2))),
        		'errorMessages'	=> array('Please select a start month.'),
        		'value'			=> '0',
        		'required'		=> false,
        		'decorators'	=> array('ViewHelper')
        ));
        
        $startYears = array('0' => '--Year--');
        
    	for ($i=$year-10; $i<=$year; $i++) {
            $startYears[$i] = $i;
        }
        
        $this->addElement('select', 'ccStartYear', array(
        		'multiOptions'	=> $startYears,
        		//'validators'    => array(array('StringLength', true, array('min' => 2))),
        		'errorMessages'	=> array('Please select a start year.'),
        		'value'			=> '0',
        		'required'		=> false,
        		'decorators'	=> array('ViewHelper')
        ));
        
        $this->addElement('radio', 'billing', array(
        		'multiOptions'	=> array(
        				'registered'	=> 'Use this address as billing address',
        				'new'			=> 'Enter a new address as billing address'
        				),
        		'value'		=> 'registered',
        		'required'	=> true
        ));
        
        $this->addElement('text', 'addressLine1', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'required'      => false,
        		'value'         => '',
        		'errorMessages'	=> array('Please enter the first line of your address'),
        ));
        
        $this->addElement('text', 'addressLine2', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'required'      => false,
        		'value'         => '',
        		'errorMessages'	=> array('Please enter the second line of your address'),
        ));
        
        $this->addElement('text', 'addressLine3', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'required'      => false,
        		'value'         => '',
        		'errorMessages'	=> array('Please enter the third line of your address'),
        ));
        
        $this->addElement('text', 'city', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'required'      => false,
        		'value'         => '',
        		'errorMessages'	=> array('Please enter your city'),
        ));
        
        $this->addElement('text', 'county', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'required'      => false,
        		'value'         => '',
        		'errorMessages'	=> array('Please enter your county'),
        ));
        
        $this->addElement('text', 'postcode', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'required'      => false,
        		'value'         => '',
        		'errorMessages'	=> array('Please enter your county'),
        ));
        
        $this->addElement('text', 'country', array(
        		'filters'       => array('StripTags', 'StringTrim'),
        		'required'      => false,
        		'value'         => '',
        		'errorMessages'	=> array('Please enter your country'),
        ));
        
    }
}

?>