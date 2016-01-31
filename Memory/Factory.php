<?php

namespace MTP\Memory;

use MTP\Network;

/**
 * This file defines class for factory of components from memory module.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Factory {

    /**
     * Common instance of network client.
     *
     * @var Network\Client
     */
    private static $_netClient;

    /**
     * Instances of memory clients grouped by namespace.
     *
     * @var Client[]
     */
    private static $_clients = array();

    /**
     * Returns instance of memory client for namespace.
     *
     * @param Config $config    Configuration
     * @param string $namespace Namespace
     *
     * @return Client
     */
    public static function getClient(Config $config, $namespace = __NAMESPACE__) {
        if (!array_key_exists($namespace, self::$_clients)) {
            self::$_clients[$namespace] = new Client(self::_getNetworkClient($config), $namespace);
        }

        return self::$_clients[$namespace];
    }

    /**
     * Returns instance of network client.
     *
     * @param Config $config Configuration
     *
     * @return Network\Client
     */
    private static function _getNetworkClient(Config $config) {
        if (!self::$_netClient) {
            self::$_netClient = new Network\Client($config);
        }

        return self::$_netClient;
    }
}
