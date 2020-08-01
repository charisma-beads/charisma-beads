<?php

namespace Common\Mapper;

use Common\Model\ModelAwareInterface;
use Common\Model\ModelManager;
use Common\Options\DbOptions;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\Exception\InvalidPluginException;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\Hydrator\ClassMethods;
use Laminas\Hydrator\HydratorAwareInterface;


class MapperManager extends AbstractPluginManager
{
    /**
     * @var bool
     */
    protected $sqliteConstraints = false;

    /**
     * @param null $configOrContainerInstance
     * @param array $v3config
     */
    public function __construct($configOrContainerInstance = null, array $v3config = [])
    {
        parent::__construct($configOrContainerInstance, $v3config);

        $this->addInitializer([$this, 'injectDbAdapter']);
        $this->addInitializer([$this, 'injectHydrator']);
        $this->addInitializer([$this, 'injectModel']);
    }

    /**
     * @param AbstractDbMapper $mapper
     */
    public function injectDbAdapter($mapper)
    {
        if ($mapper instanceof DbAdapterAwareInterface) {
            /* @var $dbAdapter Adapter */
            $dbAdapter = (isset($this->creationOptions['dbAdapter'])) ? $this->creationOptions['dbAdapter'] :
                $this->serviceLocator->get(Adapter::class);
            /** @var  $dbOptions DbOptions */
            $dbOptions = $this->serviceLocator->get(DbOptions::class);

            // enable foreign key constraints on sqlite.
            if ($dbOptions->isSqliteConstraints() && !$this->sqliteConstraints) {
                $dbAdapter->query('PRAGMA FOREIGN_KEYS = ON', Adapter::QUERY_MODE_EXECUTE);
                $this->sqliteConstraints = true;
            }

            $mapper->setMysql57Compatible($dbOptions->isMysql57Compatible())
                ->setDbAdapter($dbAdapter);
        }
    }

    /**
     * @param $mapper
     */
    public function injectHydrator($mapper)
    {
        if ($mapper instanceof HydratorAwareInterface) {
            if (isset($this->creationOptions['hydrator'])) {
                $hydratorManager = $this->serviceLocator->get('HydratorManager');
                $mapper->setHydrator($hydratorManager->get($this->creationOptions['hydrator']));
            } else {
                $mapper->setHydrator(new ClassMethods());
            }
        }
    }

    /**
     * @param $mapper
     */
    public function injectModel($mapper)
    {
        if ($mapper instanceof ModelAwareInterface) {
            if (isset($this->creationOptions['model'])) {
                $modelManager = $this->serviceLocator->get(ModelManager::class);
                $mapper->setModel($modelManager->get($this->creationOptions['model']));
            }
        }
    }

    /**
     * Validate the plugin
     *
     * Checks that the mapper is an instance of MapperInterface
     *
     * @param  mixed $plugin
     * @throws InvalidPluginException
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof MapperInterface) {
            return;
        }

        throw new InvalidPluginException(sprintf(
            'Plugin of type %s is invalid; must implement %s\Mapper\MapperInterface',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }
}
