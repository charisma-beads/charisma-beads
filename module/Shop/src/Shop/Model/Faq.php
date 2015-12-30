<?php
/**
 * Uthando CMS (http://www.shaunfreeman.co.uk/)
 *
 * @package   Shop\Model
 * @author    Shaun Freeman <shaun@shaunfreeman.co.uk>
 * @copyright Copyright (c) 2015 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license   see LICENSE
 */

namespace Shop\Model;

use UthandoCommon\Model\Model;
use UthandoCommon\Model\NestedSet;

/**
 * Class Faq
 *
 * @package Shop\Model
 */
class Faq extends NestedSet
{
    use Model;

    /**
     * @var int
     */
    protected $faqId;

    /**
     * @var string
     */
    protected $question;

    /**
     * @var string
     */
    protected $answer;

    /**
     * @return int
     */
    public function getFaqId()
    {
        return $this->faqId;
    }

    /**
     * @param int $faqId
     * @return $this
     */
    public function setFaqId($faqId)
    {
        $this->faqId = $faqId;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     * @return $this
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     * @return $this
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }
}
