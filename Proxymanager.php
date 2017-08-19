<?php
//TODO add option Type proxy - Links to check And what content for success checking
//TODO add parserd
//TODO add checkers
namespace vistarsvo\proxymanager;
use yii\base\BootstrapInterface;
use yii\console\Application;

/**
 * proxy module definition class
 */
class Proxymanager extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var string Module version
     */
    protected $version = "1";
    /**
     * @var string Alias for module
     */
    public $alias = "@proxymanager";

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'vistarsvo\proxymanager\controllers';

    /**
     * Get module version
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Bootstrap for console commands
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $this->controllerNamespace = 'vistarsvo\proxymanager\commands';
        }
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // set alias
        $this->setAliases([
            $this->alias => __DIR__,
        ]);
        // custom initialization code goes here
    }


}
