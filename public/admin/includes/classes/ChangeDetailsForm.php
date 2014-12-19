<?php

use Zend\Db\TableGateway\TableGateway;

class ChangeDetailsForm extends ChangeDetailsBaseForm
{
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
		
		parent::init();
	}
	
	protected function getPrefixList()
	{
		$table = new TableGateway('customer_prefix', Session::$mysqlDbAdaper);
	
		$rowset = $table->select();
		$prefixOptions = array();
	
		foreach ($rowset as $row) {
			$prefixOptions[$row['prefix_id']] = $row['prefix'];
		}
	
		return $prefixOptions;
	}
}

?>