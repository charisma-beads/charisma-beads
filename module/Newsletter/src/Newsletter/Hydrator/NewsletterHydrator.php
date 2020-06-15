<?php

namespace Newsletter\Hydrator;

use Common\Hydrator\AbstractHydrator;
use Common\Hydrator\Strategy\TrueFalse;


class NewsletterHydrator extends AbstractHydrator
{
    /**
     * Newsletter constructor. Set up strategies
     */
    public function __construct()
    {
        parent::__construct();

        $this->addStrategy('visible', new TrueFalse());
    }

    /**
     * @param \Newsletter\Model\NewsletterModel $object
     * @return array
     */
    public function extract($object)
    {
        return [
            'newsletterId'  => $object->getNewsletterId(),
            'name'          => $object->getName(),
            'description'   => $object->getDescription(),
            'visible'       => $this->extractValue('visible', $object->isVisible()),
        ];
    }
}