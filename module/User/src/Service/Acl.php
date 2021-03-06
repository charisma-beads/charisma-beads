<?php

declare(strict_types=1);

namespace User\Service;

use User\Controller\RegistrationController;
use User\Controller\UserController;
use User\Options\UserOptions;
use Laminas\Permissions\Acl\Acl as LaminasAcl;
use Laminas\Permissions\Acl\Role\GenericRole as Role;
use Laminas\Permissions\Acl\Resource\GenericResource as Resource;

class Acl extends LaminasAcl
{
    /**
     * @var array
     */
    protected $userRoles = [];

    /**
     * @var array
     */
    protected $userResources = [];

    /**
     * @var array
     */
    protected $allowRules = [];

    /**
     * @var array
     */
    protected $denyRules = [];

    public function __construct(array $config, UserOptions $options)
    {
        // block all by default.
        $this->deny();
        //$this->allow();

        if (isset($config['roles'])) {
            $this->userRoles = $config['roles'];
        }

        if (isset($config['resources'])) {
            $this->userResources = $config['resources'];
        }

        $this->addResources();
        $this->addRoles();
        $this->setupRules();

        if (true === $options->getDisableUserLogin()) {
            $this->removeAllow(
                'guest',
                UserController::class,
                ['login', 'authenticate', 'forgot-password']
            );
        }

        if (true === $options->getDisableUserRegister()) {
            $this->removeAllow(
                'guest',
                UserController::class,
                ['register', 'thank-you',]
            );

            $this->removeAllow(
                'guest',
                RegistrationController::class,
                'verify-email'
            );
        }
    }

    protected function addResources(): void
    {
        // add resources.
        foreach ($this->userResources as $value) {
            $this->addResource(new Resource($value));
        }
    }

    protected function addRoles(): void
    {
        foreach ($this->userRoles as $role => $values) {
            $this->addRole(new Role($role), $values['parent']);

            foreach ($values['privileges'] as $action => $privileges) {
                if ('allow' === $action) {
                    $this->allowRules[$role] = $privileges;
                }

                if ('deny' === $action) {
                    $this->denyRules[$role] = $privileges;
                }
            }
        }
    }

    protected function setupRules(): void
    {
        // set up allow rules.
        // TODO: this needs serious rethinking...
        foreach ($this->allowRules as $role => $privileges) {
            foreach ($privileges as $key => $value) {
                if ('resources' === $key) {
                    foreach ($value as $resource) {
                        $this->allow($role, $resource);
                    }
                }

                if ('controllers' === $key) {
                    foreach ($value as $controller => $actions) {
                        if (is_string($actions['action']) && 'all' === $actions['action']) {
                            $this->allow($role, $controller);
                        } else {
                            $this->allow($role, $controller, $actions['action']);
                        }
                    }
                }
            }
        }

        // set up deny rules.
        foreach ($this->denyRules as $role => $privileges) {
            foreach ($privileges as $key => $value) {
                if ('resources' === $key) {
                    foreach ($value as $resource) {
                        $this->deny($role, $resource);
                    }
                }

                if ('controllers' === $key) {
                    foreach ($value as $controller => $actions) {
                        if (is_string($actions['action']) && 'all' === $actions['action']) {
                            $this->deny($role, $controller);
                        } else {
                            $this->deny($role, $controller, $actions['action']);
                        }
                    }
                }
            }
        }
    }

}
