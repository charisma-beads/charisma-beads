<?php

namespace ThemeManager\Service;

use Common\Service\AbstractRelationalMapperService;
use ThemeManager\Form\WidgetGroupForm;
use ThemeManager\Hydrator\WidgetGroupHydrator;
use ThemeManager\InputFilter\WidgetGroupInputFilter;
use ThemeManager\Mapper\WidgetGroupMapper;
use ThemeManager\Model\WidgetGroupModel;
use Laminas\EventManager\Event;

/**
 * Class WidgetGroupManager
 * @package ThemeManager\Service
 * @method WidgetGroupMapper getMapper($mapperClass = null, array $options = [])
 */
class WidgetGroupManager extends AbstractRelationalMapperService
{
    protected $form         = WidgetGroupForm::class;
    protected $hydrator     = WidgetGroupHydrator::class;
    protected $inputFilter  = WidgetGroupInputFilter::class;
    protected $mapper       = WidgetGroupMapper::class;
    protected $model        = WidgetGroupModel::class;

    protected $referenceMap = [
        'widgets' => [
            'refCol'    => 'widgetGroupId',
            'getMethod' => 'getWidgetsByGroupId',
            'service'   => WidgetManager::class,
        ],
    ];

    protected $tags = [
        'widget', 'widget-group',
    ];

    public function attachEvents()
    {
        $this->getEventManager()->attach(self::EVENT_PRE_ADD, [$this, 'setValidation']);
        $this->getEventManager()->attach(self::EVENT_PRE_EDIT, [$this, 'setValidation']);
    }

    public function setValidation(Event $event)
    {
        $form       = $event->getParam('form');
        $model      = $event->getParam('model', new WidgetGroupModel());
        $exclude    = $model->getName() ?: '';

        /* @var WidgetGroupInputFilter $inputFilter */
        $inputFilter = $form->getInputFilter();
        $inputFilter->noRecordExists('name', 'widgetGroup', 'name', $exclude);
    }

    /**
     * @param $name
     * @return WidgetGroupModel|null
     */
    public function getWidgetGroupByName($name)
    {
        $widgetGroup = $this->getCacheItem($name);

        if (!$widgetGroup) {
            $widgetGroup = $this->getMapper()->getWidgetGroupByName($name);

            if ($widgetGroup instanceof WidgetGroupModel) {
                $this->populate($widgetGroup, true);
            }

            if ($this->useCache) {
                $this->setCacheItem($name, $widgetGroup);
            }
        }

        return $widgetGroup;
    }
}
