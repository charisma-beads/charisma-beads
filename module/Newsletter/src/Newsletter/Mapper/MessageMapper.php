<?php

namespace Newsletter\Mapper;

use Common\Mapper\AbstractDbMapper;
use Laminas\Db\Sql\Select;


class MessageMapper extends AbstractDbMapper
{
    protected $table = 'newsletterMessage';
    protected $primary = 'messageId';

    public function search(array $search, $sort, $select = null)
    {
        $select = $this->getSelect();

        $sort = str_replace('_', '.', $sort);

        $select->join(
            'newsletter',
            'newsletter.newsletterId=newsletterMessage.newsletterId',
            [],
            Select::JOIN_LEFT
        )->join(
            'newsletterTemplate',
            'newsletterTemplate.templateId=newsletterMessage.templateId',
            [],
            Select::JOIN_LEFT
        );

        return parent::search($search, $sort, $select);
    }
}