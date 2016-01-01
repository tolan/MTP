<?php

namespace MTP\Network\Server\Event;

use MTP\Network\Message;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
abstract class AEvent {

    private $_data = null;

    private $_message = null;

    public function setData($data) {
        if ($this->_message !== null) {
            $this->_data->setData($data);
        } else {
            $this->_data = $data;
        }

        return $this;
    }

    public function getData() {
        $data = $this->_data;
        if ($this->_message !== null) {
            $data = $this->_message->getData();
        }

        return $data;
    }

    public function setMessage(Message $message) {
        $this->_message = $message;

        return $this;
    }

    public function getMessage() {
        return $this->_message;
    }
}
