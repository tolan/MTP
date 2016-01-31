<?php

namespace MTP\Network\Server\Event;

use MTP\Network\Message;

/**
 * This file defines abstract class for event of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
abstract class AEvent {

    /**
     * Event data.
     *
     * @var mixed
     */
    private $_data = null;

    /**
     * Event message.
     *
     * @var Message
     */
    private $_message = null;

    /**
     * Sets event data. If message is set then data are sends to message.
     *
     * @param mixed $data Event data
     *
     * @return AEvent
     */
    public function setData($data) {
        if ($this->_message !== null) {
            $this->_data->setData($data);
        } else {
            $this->_data = $data;
        }

        return $this;
    }

    /**
     * Gets event data. It message is set then data are loaded from message.
     *
     * @return mixed
     */
    public function getData() {
        $data = $this->_data;
        if ($this->_message !== null) {
            $data = $this->_message->getData();
        }

        return $data;
    }

    /**
     * Sets event message.
     *
     * @param Message $message Event message
     *
     * @return AEvent
     */
    public function setMessage(Message $message) {
        $this->_message = $message;

        return $this;
    }

    /**
     * Returns instance of event message.
     *
     * @return Message
     */
    public function getMessage() {
        return $this->_message;
    }
}
