<?php

namespace MTP\Network;

/**
 * This file defines class for message of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Message {

    /**
     * Identifier
     *
     * @var string
     */
    private $_id;

    /**
     * Message data
     *
     * @var mixed
     */
    private $_data = null;

    /**
     * Construct method for set id.
     *
     * @param string $id Identifier
     *
     * @return void
     */
    public function __construct($id = null) {
        $this->_id = $id ?: uniqid();
    }

    /**
     * Returns identifier of message.
     *
     * @return string
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Sets data of message.
     *
     * @param mixed $data Message data
     *
     * @return Message
     */
    public function setData($data) {
        $this->_data = $data;

        return $this;
    }

    /**
     * Gets data of message.
     *
     * @return mixed
     */
    public function getData() {
        return $this->_data;
    }
}
