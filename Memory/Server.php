<?php

namespace MTP\Memory;

use MTP\Network;

/**
 * This file defines class for server of memory module.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Server {

    /**
     * Instance of network server for communication.
     *
     * @var Network\Server
     */
    private $_netServer;

    /**
     * Instances of storages.
     *
     * @var Storage\IStorage[]
     */
    private $_storages = array();

    /**
     * Constuct method for set configuration and create listeners for server.
     *
     * @param Config $config Configuration
     *
     * @return void
     */
    public function __construct(Config $config) {
        $this->_netServer = new Network\Server($config);

        $self     = $this;
        $listener = new Network\Server\Listener\Receive();
        $listener->setClosure(function($message) use ($self) {
            $answer = null;
            if ($message instanceof Message) {
                $answer = $self->_dispatchMessage($message);
            }

            return $answer;
        });

        $this->_netServer->addListener($listener);
    }

    /**
     * Destruct method for call backup on all storages.
     *
     * @return void
     */
    public function __destruct() {
        foreach (array_keys($this->_storages) as $key) {
            $this->backup($key);
        }
    }

    /**
     * It backups storage with given namespace.
     *
     * @param string $namespace Namespace
     *
     * @return Server
     */
    public function backup($namespace) {
        $this->_getStorage($namespace)
            ->recovery($namespace)
            ->backup($namespace);

        return $this;
    }

    /**
     * It does recovery process on storage by given namespace.
     *
     * @param string $namespace Namespace
     *
     * @return Server
     */
    public function recovery($namespace) {
        $this->_getStorage($namespace)
            ->recovery($namespace);

        return $this;
    }

    /**
     * It runs memory server in loop.
     *
     * @return void
     */
    public function run() {
        $this->_netServer->run();
    }

    /**
     * It dispatches received message.
     *
     * @param Message $message Message with command for storage
     *
     * @return Message
     */
    private function _dispatchMessage(Message $message) {
        $namespace = $message->getNamespace();
        $method    = $message->getType();
        $key       = $message->getName();
        $value     = $message->getData();

        $storage = $this->_getStorage($namespace);
        $storage->recovery($namespace);

        $data = $storage->$method($key, $value);

        $message->setData($data);

        return $message;
    }

    /**
     * Return instance of storage by given namespace.
     *
     * @param string $namespace Namespace
     *
     * @return Storage\IStorage
     */
    private function _getStorage($namespace) {
        if (!array_key_exists($namespace, $this->_storages)) {
            $storage = new Storage\Memory();

            $this->_storages[$namespace] = $storage;
        }

        return $this->_storages[$namespace];
    }
}
