<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Hydrator
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Hydrator;

use Common\Hydrator\AbstractHydrator;

/**
 * Class Faq
 *
 * @package Shop\Hydrator
 */
class FaqHydrator extends AbstractHydrator
{
    protected $addDepth = false;

    public function addDepth()
    {
        $this->addDepth = true;
    }

    /**
     * @param \Shop\Model\FaqModel $object
     * @return array $data
     */
    public function extract($object)
    {
        $data = [
            'faqId'     => $object->getFaqId(),
            'question'  => $object->getQuestion(),
            'answer'    => $object->getAnswer(),
            'lft'       => $object->getLft(),
            'rgt'       => $object->getRgt(),
        ];

        if (true === $this->addDepth) {
            $data['depth'] = $object->getDepth();
        }

        return $data;
    }
}
