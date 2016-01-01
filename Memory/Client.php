<?php

namespace MTP\Memory;

use MTP\Network;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Client {

    private $_namespace;

    /**
     *
     * @var Network\Client
     */
    private $_client;

    public function __construct(Network\Client $client, $namespace = __NAMESPACE__) {
        $this->_namespace = $namespace;
        $this->_client    = $client;
    }

    public function get($name) {
        $message = $this->_createMessage(__FUNCTION__, $name);
        return $this->_sendMessage($message);
    }

    public function set($name, $data) {
        $message = $this->_createMessage(__FUNCTION__, $name);
        $message->setData($data);
        return $this->_sendMessage($message);
    }

    public function has($name) {
        $message = $this->_createMessage(__FUNCTION__, $name);
        return $this->_sendMessage($message);
    }

    public function delete($name) {
        $message = $this->_createMessage(__FUNCTION__, $name);
        return $this->_sendMessage($message);
    }

    private function _sendMessage(Message $message) {
        $answer = $this->_client->send($message);

        return $answer->getData();
    }

    private function _createMessage($type, $name) {
        return new Message($type, $this->_namespace, $name);
    }
}
