<?php

namespace MTP\Network\Server\Response;

use MTP\Network\Utils;
use MTP\Network\Message;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Data implements IResponse {

    private $_data;

    public function send($socket) {
        $data = $this->_data;
        if ($data instanceof Message) {
            $data = serialize($data);
        }

        Utils::sendMessage($socket, $data);

        return $this;
    }

    public function setData($data) {
        $this->_data = $data;
    }
}
