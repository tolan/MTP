<?php

namespace MTP\Network\Server\Response;

use MTP\Network\Utils;
use MTP\Network\Message;

/**
 * This file defines class for data response of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Data implements IResponse {

    /**
     * Response data
     *
     * @var mixed
     */
    private $_data;

    /**
     * Sends data to output.
     *
     * @param resource $socket Resource socket
     *
     * @return Data
     */
    public function send($socket) {
        $data = $this->_data;
        if ($data instanceof Message) {
            $data = serialize($data);
        }

        Utils::sendMessage($socket, $data);

        return $this;
    }

    /**
     * Sets response data.
     *
     * @param mixed $data Response data
     */
    public function setData($data) {
        $this->_data = $data;
    }
}
