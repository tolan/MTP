<?php

namespace MTP\Network;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Client {

    private $_socket;

    public function __construct(Config $config) {
        $this->_socket = stream_socket_client('tcp://'.$config->getIp().':'.$config->getPort());
    }

    public function send($data) {
        $message = (new Message())->setData($data);

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

    public function __destruct() {
        @fclose($this->_socket);
    }
}
