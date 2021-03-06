<?php

declare(strict_types=1);

namespace Common\Controller;

use Common\Service\ServiceTrait;
use Laminas\Filter\Word\UnderscoreToDash;
use Laminas\Form\Fieldset;
use Laminas\Form\Form;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Config\Writer\PhpArray;
use Laminas\Hydrator\AbstractHydrator;
use Laminas\Mvc\Controller\Plugin\FlashMessenger;
use Laminas\Mvc\Controller\Plugin\PostRedirectGet;
use Laminas\Stdlib\AbstractOptions;

/**
 * Class SettingsTrait
 *
 * @package Common\Controller
 * @method array|PostRedirectGet prg()
 * @method FlashMessenger flashMessenger()
 */
trait SettingsTrait
{
    use ServiceTrait;

    /**
     * @var string
     */
    protected $formName;

    /**
     * @var string
     */
    protected $configKey;

    /**
     * @return array
     */
    public function indexAction()
    {
        /* @var $form Form */
        $form = $this->getService('FormElementManager')
            ->get($this->getFormName());

        $prg = $this->prg();

        $config = $this->getService('config');
        $settings = $config[$this->getConfigKey()] ?? [];

        if ($prg instanceof Response) {
            return $prg;
        } elseif (false === $prg) {
            $defaults = $settings;

            foreach ($settings as $key => $value) {

                // this needs moving to the form to set defaults there.
                if ($form->has($key) && $form->get($key) instanceof Fieldset) {
                    /** @var Fieldset $fieldSet */
                    $fieldSet       = $form->get($key);
                    /** @var AbstractOptions $object */
                    $object         = $fieldSet->getObject();
                    /** @var AbstractHydrator $hydrator */
                    $hydrator       = $fieldSet->getHydrator();
                    $object         = $hydrator->hydrate($defaults[$key], $object);
                    $defaults[$key] = $hydrator->extract($object);
                }
            }

            $form->setData($defaults);

            return ['form' => $form,];
        }

        $form->setData($prg);

        if ($form->isValid()) {

            $arrayOrObject = $form->getData();

            if (is_array($arrayOrObject)) {
                unset($arrayOrObject['button-submit']);

                foreach ($arrayOrObject as $key => $value) {
                    // this needs moving to the form to set defaults there.

                    if ($form->has($key) && $form->get($key) instanceof Fieldset) {
                        /** @var Fieldset $fieldSet */
                        $fieldSet               = $form->get($key);
                        /** @var AbstractOptions $object */
                        $object                 = $fieldSet->getObject();
                        /** @var AbstractHydrator $hydrator */;
                        $hydrator               = $fieldSet->getHydrator();
                        $object                 = $hydrator->hydrate($arrayOrObject[$key], $object);
                        $arrayOrObject[$key]    = $object->toArray();
                        //$arrayOrObject[$key]    = $hydrator->extract($object);
                    }
                }
            }

            if ($arrayOrObject instanceof AbstractOptions) {
                $arrayOrObject = $arrayOrObject->toArray();
            }

            $filter = new UnderscoreToDash();
            $fileName = $filter->filter($this->getConfigKey());

            $config = new PhpArray();
            $config->setUseBracketArraySyntax(true);

            $config->toFile('./config/autoload/' . $fileName . '.local.php', [$this->getConfigKey() => $arrayOrObject]);

            $appConfig = $this->getService('Application\Config');

            // delete cached config.
            if (true === $appConfig['module_listener_options']['config_cache_enabled']) {
                $configCache = $appConfig['module_listener_options']['cache_dir'] . '/module-config-cache.' . $appConfig['module_listener_options']['config_cache_key'] . '.php';
                if (file_exists($configCache)) {
                    unlink($configCache);
                }
            }

            $this->flashMessenger()->addSuccessMessage('Settings have been updated!');
        } else {
            $this->flashMessenger()->addErrorMessage('There is a wrong setting, please check all values are corect!');
        }

        return ['form' => $form,];
    }

    /**
     * @return string
     */
    public function getFormName(): string
    {
        return $this->formName;
    }

    /**
     * @param string $formName
     * @return $this
     */
    public function setFormName(string $formName)
    {
        $this->formName = $formName;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigKey(): string
    {
        return $this->configKey;
    }

    /**
     * @param string $configKey
     * @return $this
     */
    public function setConfigKey(string $configKey)
    {
        $this->configKey = $configKey;
        return $this;
    }
}
