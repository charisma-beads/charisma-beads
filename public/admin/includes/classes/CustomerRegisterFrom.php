<?php

use Zend\Form\Form;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class CustomerRegisterFrom extends Form
{
	protected $dbAdapter;
	
	protected $countryId;
	
	protected $country;
	
	protected $countryTable;
	
	public function __construct($countryId=1)
	{
		parent::__construct();
		
		$this->countryId = $countryId;
		
		$this->dbAdapter = new Adapter(array(
			'driver'   => 'PDO_SQLITE',
			'database' => $_SERVER['DOCUMENT_ROOT'] . '/../data/countries.db',
		));
		
		$this->countryTable = new TableGateway('country', $this->dbAdapter);
		$rowset = $this->countryTable->select(array('country_id' => $this->countryId));
		$this->country = $rowset->current();
	}
	
	public function init()
	{
		$this->add(array(
			'name' => 'prefix_id',
			'type' => 'select',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Prefix:',
				'empty_option' => 'Please choose a prefix',
				'value_options' => $this->getPrefixList(),
			),
		));
		
		$this->add(array(
			'name' => 'first_name',
			'type' => 'text',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'First name:',
			),
		));
		
		$this->add(array(
			'name' => 'last_name',
			'type' => 'text',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Last name:',
			),
		));
		
		$this->add(array(
			'name' => 'address1',
			'type' => 'text',
			'attributes' => array(
				'required' => true,
				'size' => 30,
			),
			'options' => array(
				'label' => 'Address Line 1:',
			),
		));
		
		$this->add(array(
			'name' => 'address2',
			'type' => 'text',
			'attributes' => array(
				'size' => 30,
			),
			'options' => array(
				'label' => 'Address Line 2:',
			),
		));
		
		$this->add(array(
			'name' => 'address3',
			'type' => 'text',
			'attributes' => array(
				'size' => 30,
			),
			'options' => array(
				'label' => 'Address Line 3:',
			),
		));
		
		$this->add(array(
			'name' => 'city',
			'type' => 'text',
			'attributes' => array(
				'required' => true,
				'size' => 30,
			),
			'options' => array(
				'label' => 'Town/City:',
			),
		));
		
		$this->add(array(
			'name' => 'county',
			'type' => 'select',
			'attributes' => array(
				'required' => true,
				'id' => 'provinces',
			),
			'options' => array(
				'label' => 'County/Province:',
				'empty_option' => 'Please choose a province',
				'value_options' => $this->getProvinceList($this->country['country_id']),
			),
		));
		
		$this->add(array(
			'name' => 'post_code',
			'type' => 'text',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Postcode:',
			),
		));
		
		$this->add(array(
			'name' => 'country_id',
			'type' => 'select',
			'attributes' => array(
				'required' => true,
				'id' => 'country_select',
			),
			'options' => array(
				'label' => 'Country:',
				'empty_option' => 'Please choose a country',
				'value_options' => $this->getCountryList(),
			),
		));
		
		$this->add(array(
			'name' => 'phone',
			'type' => 'text',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Phone:',
			),
		));
		
		$this->add(array(
			'name' => 'email',
			'type'  => 'email',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Email:'
			),
		));
		
		$this->add(array(
			'name' => 'confirm-email',
			'type'  => 'email',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Confirm Email:'
			),
		));
		
		$this->add(array(
			'name' => 'ad_referrer',
			'type' => 'select',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Where did you hear about us:',
				'empty_option' => 'Please select one',
				'value_options' => $this->getAdRefererList(),
			),
		));
		
		$this->add(array(
			'name' => 'newsletter',
			'type' => 'select',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Add to mailing list:',
				'value_options' => array(
					array(
						'label' => 'Yes',
						'value' => 'Y',
						'selected' => true,
					),
					array(
						'label' => 'No',
						'value' => 'N',
					),
				),
			),
		));
		
		$this->add(array(
			'name' => 'password',
			'type'  => 'password',
			'attributes' => array(
				'required' => true,
				'id' => 'password',
			),
			'options' => array(
				'label' => 'Password:'
			),
		));
		
		$this->add(array(
			'name' => 'confirm-password',
			'type'  => 'password',
			'attributes' => array(
				'required' => true,
			),
			'options' => array(
				'label' => 'Confirm Password:'
			),
		));
		
		/*$this->add(array(
			'name' => 'captcha',
			'type' => 'CBCaptcha',
			'options' => array(
				'label' => 'Please verify you are human.'
			),
		));*/
		
		$this->add(array(
			'name' => 'security',
			'type' => 'csrf',
		));
		
		$this->add(array(
			'name' => 'referer_link',
			'type' => 'hidden',
		));
	}
	
	protected function getCountryList()
	{
		$rowset = $this->countryTable->select(function(\Zend\Db\Sql\Select $select){
            $select->order('sort ASC');
        });
		$countryOptions = array();
	
		foreach ($rowset as $row) {
			$countryOptions[] = array(
				'label' => $row['country'],
				'value' => $row['country_id'],
				'selected' => ($this->country['country_id'] == $row['country_id']) ? true : false,
			);
		}
	
		return $countryOptions;
	
	}
	
	public function getCountry()
	{
		return $this->country;
	}
	
	public function getProvinceList($id)
	{
		$table = new TableGateway('provinces', $this->dbAdapter);
	
		$rowset = $table->select(array('country_id' => $id));
		$provinceOptions = array();
	
		foreach ($rowset as $row) {
			$provinceOptions[$row['name']] = $row['name'];
		}
	
		return $provinceOptions;
	}
	
	protected function getPrefixList()
	{
		$table = new TableGateway('customer_prefix', Session::$mysqlDbAdaper);

		$rowSet = $table->select();
		$prefixOptions = array();
		
		foreach ($rowSet as $row) {
			$prefixOptions[$row['prefix_id']] = $row['prefix'];
		}
		
		return $prefixOptions;
	}
	
	protected function getAdRefererList()
	{
		$table = new TableGateway('ad_referrer', Session::$mysqlDbAdaper);
		
		$rowset = $table->select();
		$prefixOptions = array();
		
		foreach ($rowset as $row) {
			$prefixOptions[$row['ad_referrer_id']] = $row['ad_referrer'];
		}
		
		return $prefixOptions;
	}
}

?>