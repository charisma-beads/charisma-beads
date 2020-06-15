<?php

namespace Common\Service;

use Common\Model\ModelInterface;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;


interface ServiceInterface
{
    /**
     * events to set up. This should be overridden in parent class.
     */
    public function attachEvents();

    /**
     * Gets Service Class
     *
     * @param $service
     * @return AbstractService
     */
    public function getService($service);

    /**
     * Sets Service Class
     *
     * @param $service
     * @return $this
     */
    public function setService($service);

    /**
     * @return array
     */
    public function getFormOptions();

    /**
     * @param array $formOptions
     */
    public function setFormOptions($formOptions);

    /**
     * Gets the default form for the service.
     *
     * @param ModelInterface $model
     * @param array $data
     * @param bool $useInputFilter
     * @param bool $useHydrator
     * @return Form $form
     */
    public function prepareForm(ModelInterface $model = null, array $data = null, $useInputFilter = false, $useHydrator = false);

    /**
     * Gets model from ModelManager
     *
     * @param null|string $model
     * @return ModelInterface
     */
    public function getModel($model = null);

    /**
     * Gets the default input filter
     *
     * @return InputFilter
     */
    public function getInputFilter();

    /**
     * @param $argv
     * @return \ArrayObject
     */
    public function prepareEventArguments($argv);

    /**
     * get application config option by its key.
     *
     * @param string $key
     * @return array $config
     */
    public function getConfig($key);
}
