<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\UpdateExposedFqdnList;

use Piwik\Plugins\SitesManager\API;
use Piwik\Config;
use Redis;

class UpdateExposedFqdnList extends \Piwik\Plugin
{
    protected $pluginConfig;

    public function __construct()
    {
        parent::__construct();

        $this->pluginConfig = Config::getInstance()->{$this->pluginName};
    }

    public function registerEvents()
    {
        return [
            'MeasurableSettings.updated' => 'UpdateFqdnList',
        ];
    }

    public function UpdateFqdnList($settings, $idSite)
    {
        $config = $this->pluginConfig;

        $redis = new Redis();

        $redis->connect($config["redis_host"], (int) $config["redis_port"], 3);
        $isConnected = $redis->ping();

        if ($isConnected) {
            $redis->select((int) $config['redis_db_index']);
            $isValueSet = $redis->get($idSite);

            $urls = API::getInstance()->getSiteUrlsFromId($idSite);
            $urlsToString = implode(" ", $urls);

            if ($isValueSet === false || $isValueSet !== $urlsToString) {
                $redis->set($idSite, $urlsToString);
            }
        }
    }
}
