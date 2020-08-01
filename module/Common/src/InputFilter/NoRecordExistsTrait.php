<?php

namespace Common\InputFilter;

use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Db\NoRecordExists;

trait NoRecordExistsTrait
{
    public function noRecordExists($name, $table, $field, $exclude)
    {
        $exclude = (!$exclude) ?: [
            'field' => $field,
            'value' => $exclude,
        ];

        $this->get($name)
            ->getValidatorChain()
            ->attachByName(NoRecordExists::class, [
                'table' => $table,
                'field' => $field,
                'adapter' => $this->getServiceLocator()
                    ->getServiceLocator()
                    ->get(DbAdapter::class),
                'exclude' => $exclude,
            ]);

        return $this;
    }
}
