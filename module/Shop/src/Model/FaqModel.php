<?php

namespace Shop\Model;

use Common\Model\Model;
use Common\Model\NestedSet;

/**
 * Class Faq
 *
 * @package Shop\Model
 */
class FaqModel extends NestedSet
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
