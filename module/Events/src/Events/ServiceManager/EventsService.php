<?php

namespace Events\ServiceManager;

use Common\Hydrator\Strategy\DateTime;
use Common\Service\AbstractMapperService;
use Events\Form\EventsForm;
use Events\Hydrator\EventsHydrator;
use Events\InputFilter\EventsInputFilter;
use Events\Mapper\EventsMapper;
use Events\Model\EventModel;
use Events\Options\EventsOptions;
use Zend\EventManager\Event;

/**
 * Class EventsService
 *
 * @package Events\ServiceManager
 * @method EventsMapper getMapper($mapperClass = null, array $options = [])
 */
class EventsService extends AbstractMapperService
{
    protected $form         = EventsForm::class;
    protected $hydrator     = EventsHydrator::class;
    protected $inputFilter  = EventsInputFilter::class;
    protected $mapper       = EventsMapper::class;
    protected $model        = EventModel::class;

    /**
     * @var array
     */
    protected $tags = [
        'events',
    ];

    /**
     * Attach the events for this service
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.add', 'pre.edit',
        ], [$this, 'setDateFormat']);
    }

    /**
     * Add date format
     *
     * @param Event $e
     */
    public function setDateFormat(Event $e)
    {
        /* @var EventsForm $form */
        $form = $e->getParam('form');
        /* @var EventsHydrator $hydrator */
        $hydrator = $form->getHydrator();
        /* @var DateTime $dateTimeStrategy */
        $dateTimeStrategy = $hydrator->getStrategy('dateTime');
        $dateTimeStrategy->setHydrateFormat($this->getOptions()->getDateFormat());
    }

    /**
     * @return \Zend\Db\ResultSet\HydratingResultSet|\Zend\Db\ResultSet\ResultSet|\Zend\Paginator\Paginator
     */
    public function getTimeLine()
    {
        $this->getMapper()->setListOldEntries(
            $this->getOptions()->getShowExpiredEvents()
        );

        $events = $this->search([
            'sort' => $this->getOptions()->getSortOrder(),
        ]);

        return $events;
    }

    /**
     * @return EventsOptions
     */
    public function getOptions()
    {
        return $this->getService(EventsOptions::class);
    }
}
