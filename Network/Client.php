<?php

namespace MTP\Network;

/**
 * This file defines class for client of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Client {

    /**
     * Network stream socket.
     *
     * @var resource
     */
    private $_socket;

    /**
     * Construct method for create connection to the server.
     *
     * @param Config $config Configuration of connection
     *
     * @throws Exception Throws when socket was not created
     *
     * @return void
     */
    public function __construct(Config $config) {
        $this->_socket = stream_socket_client('tcp://'.$config->getIp().':'.$config->getPort());

        if (empty($this->_socket)) {
            throw new Exception('Socket was not created.');
        }
    }

    /**
     * Sends data to the server and receives answer.
     *
     * @param mixed $data Serializable data
     *
     * @return mixed|Message
     *
     * @throws Exception Throws when socket was not created
     */
    public function send($data) {
        $message = (new Message())->setData($data);

        if (empty($this->_socket)) {
            throw new Exception('Socket was not created.');
        }

        Utils::sendMessage($this->_socket, serialize($message));

        do {
            $string = trim(Utils::receiveMessage($this->_socket));
        } while(empty($string) || $string === 'OK');


        $answer = @unserialize($string); /* @var $answer Message */
        if ($answer instanceof Message) {
            $answer = $answer->getData();
        }

        return $answer;
    }

    /**
     * Destruct method for close connection.
     *
     * @return void
     */
    public function __destruct() {
        @stream_socket_shutdown($this->_socket, STREAM_SHUT_WR);
    }
}
