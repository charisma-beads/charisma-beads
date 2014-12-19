<?php

use Zend\Form\Form;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class ChangeDetailsBaseForm extends Form
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
	}
	
	protected function getCountryList()
	{
		$rowset = $this->countryTable->select();
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
}

?>