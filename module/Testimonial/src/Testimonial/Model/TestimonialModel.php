<?php

namespace Testimonial\Model;

use Common\Model\DateCreatedTrait;
use Common\Model\DateModifiedTrait;
use Common\Model\Model;
use Common\Model\ModelInterface;


class TestimonialModel implements ModelInterface
{
    use Model,
        DateCreatedTrait,
        DateModifiedTrait;

    /**
     * @var int
     */
    protected $testimonialId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $image;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var string
     */
    protected $sector;

    /**
     * @var string
     */
    protected $text;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param $company
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $image
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param $location
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * @param $sector
     * @return $this
     */
    public function setSector($sector)
    {
        $this->sector = $sector;
        return $this;
    }

    /**
     * @return int
     */
    public function getTestimonialId()
    {
        return $this->testimonialId;
    }

    /**
     * @param $testimonialId
     * @return $this
     */
    public function setTestimonialId($testimonialId)
    {
        $this->testimonialId = $testimonialId;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param $website
     * @return $this
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

} 