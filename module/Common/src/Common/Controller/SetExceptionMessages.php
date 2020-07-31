<?php

namespace Common\Controller;

use Exception;
use Laminas\Mvc\Controller\Plugin\FlashMessenger;

/**
 * Class SetExceptionMessages
 *
 * @package Common\Controller
 * @method FlashMessenger flashMessenger()
 */
trait SetExceptionMessages
{
    /**
     * Sets a exception message for flash plugin.
     *
     * @param Exception $e
     */
    public function setExceptionMessages(Exception $e)
    {
        $this->flashMessenger()->addErrorMessage([
            'message' => $e->getMessage(),
            'title' => 'Error!'
        ]);

        $prevException = $e->getPrevious();

        if ($prevException) {
            while ($prevException) {
                $this->flashMessenger()->addErrorMessage($prevException->getMessage());
                $prevException = $prevException->getPrevious();
            }
        }
    }
}
