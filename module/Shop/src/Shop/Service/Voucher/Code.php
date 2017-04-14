<?php
/**
 * charisma-beads (http://www.shaunfreeman.co.uk/)
 *
 * @author      Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @link        https://github.com/uthando-cms for the canonical source repository
 * @copyright   Copyright (c) 2017 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license     see LICENSE
 */

namespace Shop\Service\Voucher;

use Shop\Model\Voucher\Code as CodeModel;
use UthandoCommon\Hydrator\Strategy\DateTime;
use UthandoCommon\Service\AbstractMapperService;
use Zend\EventManager\Event;

/**
 * Class Code
 *
 * @package Shop\Service\Voucher
 */
class Code extends AbstractMapperService
{
    /**
     * @var string
     */
    protected $serviceAlias = 'ShopVoucherCode';

    /**
     * @var array
     */
    protected $tags = [
        'voucher',
    ];

    /**
     * setup events
     */
    public function attachEvents()
    {
        $this->getEventManager()->attach([
            'pre.add', 'pre.edit'
        ], [$this, 'setupForm']);
    }

    /**
     * @param Event $e
     */
    public function setupForm(Event $e)
    {
        $form = $e->getParam('form');
        $model = $e->getParam('model');
        $post = $e->getParam('post');

        $code = ($model instanceof CodeModel && $model->getCode() === $post['code']) ? $model->getCode() : null;

        /* @var $inputFilter \Shop\InputFilter\Voucher\Code */
        $inputFilter = $form->getInputFilter();
        $inputFilter->addNoRecordExists($code);

        $hydrator = $form->getHydrator();
        /* @var DateTime $dateTimeStrategy */
        $dateTimeStrategy = $hydrator->getStrategy('startDate');
        $dateTimeStrategy->setHydrateFormat('d/m/Y');
        $dateTimeStrategy = $hydrator->getStrategy('endDate');
        $dateTimeStrategy->setHydrateFormat('d/m/Y');
    }
}