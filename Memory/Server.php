<?php

namespace MTP\Memory;

use MTP\Network;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Server {

    private $_netServer;

    private $_storages = array();

    public function __construct(Config $config) {
        $this->_netServer = new Network\Server($config);

        $self = $this;
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

    public function __destruct() {
        foreach (array_keys($this->_storages) as $key) {
            $this->backup($key);
        }
    }

    public function backup($namespace) {
        $this->_getStorage($namespace)
            ->recovery($namespace)
            ->backup($namespace);

        return $this;
    }

    public function recovery($namespace) {
        $this->_getStorage($namespace)
            ->recovery($namespace);

        return $this;
    }

    public function run() {
        $this->_netServer->run();
    }

    private function _dispatchMessage(Message $message) {
        $namespace = $message->getNamespace();
        $method    = $message->getType();
        $key       = $message->getKey();
        $value     = $message->getData();

        $storage = $this->_getStorage($namespace);
        $storage->recovery($namespace);

        $data = $storage->$method($key, $value);

        $message->setData($data);

        return $message;
    }

    /**
     *
     * @param string $namespace
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
