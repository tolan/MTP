<?php

namespace MTP\Memory;

use MTP\Network;

/**
 * This file defines class for client of memory server.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Client {

    /**
     * Namespace
     *
     * @var string
     */
    private $_namespace;

    /**
     * Instance of network client for communication with server instance.
     *
     * @var Network\Client
     */
    private $_client;

    /**
     * Construct method for set network client and namespace.
     *
     * @param Network\Client $client    Instance of network client
     * @param string         $namespace Namespace
     *
     * @return void
     */
    public function __construct(Network\Client $client, $namespace = __NAMESPACE__) {
        $this->_namespace = $namespace;
        $this->_client    = $client;
    }

    /**
     * Gets data by given name.
     *
     * @param string $name Name
     *
     * @return mixed
     */
    public function get($name) {
        $message = $this->_createMessage(__FUNCTION__, $name);

        return $this->_sendMessage($message);
    }

    /**
     * Sets data to storage under given name.
     *
     * @param string $name  Name
     * @param mixed  $value Some value
     *
     * @return boolean
     */
    public function set($name, $data) {
        $message = $this->_createMessage(__FUNCTION__, $name);
        $message->setData($data);

        return $this->_sendMessage($message);
    }

    /**
     * Returns that the value is existed by given name.
     *
     * @param string $name Name
     *
     * @return boolean
     */
    public function has($name) {
        $message = $this->_createMessage(__FUNCTION__, $name);

        return $this->_sendMessage($message);
    }

    /**
     * Deletes value by given name.
     *
     * @param string $name Name
     *
     * @return boolean
     */
    public function delete($name) {
        $message = $this->_createMessage(__FUNCTION__, $name);

        return $this->_sendMessage($message);
    }

    /**
     * Gets all keys in current namespace.
     *
     * @return array
     */
    public function keys() {
        $message = $this->_createMessage(__FUNCTION__);

        return $this->_sendMessage($message);
    }

    /**
     * It sends message over network.
     *
     * @param Message $message Message with memory command
     *
     * @return mixed
     */
    private function _sendMessage(Message $message) {
        $answer = $this->_client->send($message);

        return $answer->getData();
    }

    /**
     * It creates message with current namespace and method.
     *
     * @param string $type Type of message (get, set, has...)
     * @param sttrin $name Name of variable
     *
     * @return Message
     */
    private function _createMessage($type, $name=null) {
        return new Message($type, $this->_namespace, $name);
    }
}
