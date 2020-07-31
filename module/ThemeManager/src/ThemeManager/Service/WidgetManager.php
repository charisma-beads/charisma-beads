<?php

namespace ThemeManager\Service;

use Common\Service\AbstractRelationalMapperService;
use ThemeManager\Form\WidgetForm;
use ThemeManager\Hydrator\WidgetHydrator;
use ThemeManager\InputFilter\WidgetInputFilter;
use ThemeManager\Mapper\WidgetMapper;
use ThemeManager\Model\WidgetModel;
use Laminas\EventManager\Event;

/**
 * Class WidgetManager
 * @package ThemeManager\Service
 * @method WidgetMapper getMapper($mapperClass = null, array $options = [])
 */
class WidgetManager extends AbstractRelationalMapperService
{
    protected $form         = WidgetForm::class;
    protected $hydrator     = WidgetHydrator::class;
    protected $inputFilter  = WidgetInputFilter::class;
    protected $mapper       = WidgetMapper::class;
    protected $model        = WidgetModel::class;

    protected $referenceMap = [
        'group' => [
            'refCol'    => 'widgetGroupId',
            'service'   => WidgetGroupManager::class,
        ],
    ];

    protected $tags = [
        'widget', 'widgetGroup'
    ];

    public function attachEvents()
    {
        $this->getEventManager()->attach(self::EVENT_PRE_ADD, [$this, 'setValidation']);
        $this->getEventManager()->attach(self::EVENT_PRE_EDIT, [$this, 'setValidation']);
    }

    public function setValidation(Event $event)
    {
        $form       = $event->getParam('form');
        $model      = $event->getParam('model', new WidgetModel());
        $exclude    = $model->getName() ?: '';

        /* @var WidgetInputFilter $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->noRecordExists('name', 'widget', 'name', $exclude);
    }

    /**
     * @param $name
     * @return WidgetModel|null
     */
    public function getWidgetByName($name)
    {
        $widget = $this->getMapper()->getWidgetByName($name);

        if ($widget instanceof WidgetModel) {
            $this->populate($widget, true);
        }

        return $widget;
    }

    public function getWidgetsByGroupId($id)
    {
        $widgets = $this->getMapper()->getWidgetsByGroupId($id);

        /** @var WidgetModel $widget */
        foreach ($widgets as $widget) {
            $this->populate($widget, true);
        }

        return $widgets;
    }
}
