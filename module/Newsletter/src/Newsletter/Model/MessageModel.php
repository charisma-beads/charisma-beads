<?php

namespace Newsletter\Model;

use DateTime;
use Common\Model\DateCreatedTrait;
use Common\Model\Model;
use Common\Model\ModelInterface;


class MessageModel implements ModelInterface
{
    use Model,
        DateCreatedTrait;

    /**
     * @var int
     */
    protected $messageId;

    /**
     * @var int
     */
    protected $newsletterId;

    /**
     * @var int
     */
    protected $templateId;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $params;

    /**
     * @var NewsletterModel
     */
    protected $newsletter;

    /**
     * @var TemplateModel
     */
    protected $template;

    /**
     * @var bool
     */
    protected $sent;

    /**
     * @var DateTime
     */
    protected $dateSent;

    /**
     * @return int
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     * @return $this
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;
        return $this;
    }

    /**
     * @return int
     */
    public function getNewsletterId()
    {
        return $this->newsletterId;
    }

    /**
     * @param int $newsletterId
     * @return $this
     */
    public function setNewsletterId($newsletterId)
    {
        $this->newsletterId = $newsletterId;
        return $this;
    }

    /**
     * @return int
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param int $templateId
     * @return $this
     */
    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return NewsletterModel
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param NewsletterModel $newsletter
     * @return $this
     */
    public function setNewsletter(NewsletterModel $newsletter)
    {
        $this->newsletter = $newsletter;
        return $this;
    }

    /**
     * @return TemplateModel
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param TemplateModel $template
     * @return $this
     */
    public function setTemplate(TemplateModel $template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * @param DateTime $dateSent
     * @return $this
     */
    public function setDateSent(DateTime $dateSent = null)
    {
        $this->dateSent = $dateSent;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * @param boolean $sent
     * @return $this
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
        return $this;
    }
}