<?php

return array(
    'console' => array(
        'router' => array(
            'routes' => array(
                'mail/queue/send' => array(
                    'options' => array(
                        'route' => 'mailqueue send',
                        'defaults' => array(
                            '__NAMESPACE__' => 'Mail\Controller',
                            'controller' => 'MailQueue',
                            'action' => 'send'
                        ),
                    ),
                ),
            ),
        ),
    ),
);