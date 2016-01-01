<?php

namespace MTP\Network;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Message {

    private $_id;

    private $_data = null;

    public function __construct($id = null) {
        $this->_id = uniqid();
    }

    public function getId() {
        return $this->_id;
    }

    public function setData($data) {
        $this->_data = $data;

        return $this;
    }

    public function getData() {
        return $this->_data;
    }
}
