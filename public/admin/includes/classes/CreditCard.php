<?php
/*
 * CreditCard.php
 *
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 * This file is part of Charisma Beads.
 *
 * Charisma Beads is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Charisma Beads is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Charisma Beads.  If not, see <http ://www.gnu.org/licenses/>.
 */

/**
 * Description of CreditCard
 *
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class CreditCard
{
    protected $_db;

    protected $_error;

    const EOL = "\n";

    public $_template = '/shop/html';
    
    public $form;
  	
    public $view;
    
    public $invoiceNumber;
    
    protected $_billingAddresses = array();

    public function __construct($dbc)
    {
        $this->_db = $dbc;
        $this->_error = ErrorLogging::getInstance();
        $this->_year = date('Y');
        
        $this->view = new Zend_View();
        $this->view->setScriptPath($_SERVER['DOCUMENT_ROOT'] . $this->_template);
        
        $this->form = new CreditCardForm();

        $this->form->setView($this->view);
    }

    public function addBillingAddress($address)
    {
        $address = (array) $address;
        $array = array();

        foreach ($address as $value) {
            if ($value != '') {
                $array[] = $value;
            }
        }

        $this->_billingAddresses[] = join(', ', $array);

        return $this;
    }

    public function getOptions($which, $addKeyToValue=false, $selected=null)
    {
        $returnString = '<select name="registeredBillingAddresses">' . self::EOL;
        $which = '_' . $which;

        foreach ($this->$which as $key => $value) {
            $returnString .= '<option value="'.$key.'"'.$selected.'>';
            $returnString .= $value;
            if (true === $addKeyToValue) $returnString .= ' (' . $key . ')';
            $returnString .= '</option>' . self::EOL;
        }
        $returnString .= '</select>' . self::EOL;

        return $returnString;
    }

    public function toString()
    {
        global $https;
        $registeredBillingAddresses = $this->getOptions('billingAddresses');
        $this->url = $https;
        
        $this->view->assign(array(
        		'https'							=> $https,
        		'form'							=> $this->form,
        		'invoiceNumber'					=> $this->invoiceNumber,
        		'registeredBillingAddresses'	=> $registeredBillingAddresses
        		));

        return $this->view->render('creditCard.phtml');
    }

    public function getErrors()
    {
        return $this->_validateErrors;
    }
}

?>


