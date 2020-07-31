<?php

namespace News\InputFilter;

use Common\Filter\Slug;
use News\Options\NewsOptions;
use Laminas\Filter\Digits;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\InputFilter;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use Laminas\ServiceManager\ServiceLocatorAwareTrait;
use Laminas\Validator\StringLength;


class NewsInputFilter extends InputFilter implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function init()
    {
        $options = $this->getNewsOptions();

        $this->add([
            'name' => 'newsId',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
                ['name' => Digits::class],
            ],
        ]);

        $this->add([
            'name' => 'userId',
            'required'      => true,
            'filters'       => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
        ]);

        $titleFilters = [
            ['name' => StripTags::class],
            ['name' => StringTrim::class],
        ];

        if ('none' !== $options->getTitleCase() && class_exists($options->getTitleCase())) {
            $titleFilters[]['name'] = $options->getTitleCase();
        }

        $this->add([
            'name' => 'title',
            'required'      => true,
            'filters'       => $titleFilters,
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255
                ]],
            ],
        ]);

        $this->add([
            'name' => 'slug',
            'required'      => true,
            'filters'       => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => Slug::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 2,
                    'max' => 255
                ]],
            ],
        ]);

        $this->add([
            'name' => 'image',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'layout',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                    'max'      => 255,
                ]],
            ],
        ]);

        $this->add([
            'name' => 'lead',
            'required' => false,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                ['name'    => StringLength::class,'options' => [
                    'encoding' => 'UTF-8',
                ]],
            ],
        ]);

        $this->add([
            'name' => 'description',
            'required'      => true,
            'filters'       => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators'    => [
                ['name' => StringLength::class, 'options' => [
                    'encoding' => 'UTF-8',
                    'min' => 30,
                    'max' => 255
                ]],
            ],
        ]);
    }

    protected function getNewsOptions(): NewsOptions
    {
        $newsOptions = $this->getServiceLocator()->getServiceLocator()->get(NewsOptions::class);
        return $newsOptions;
    }
}