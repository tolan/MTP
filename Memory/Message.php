<?php

namespace MTP\Memory;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Message {

    private $_type;

    private $_namespace;

    private $_key;

    private $_data;

    public function __construct($type, $namespace, $key) {
        $this->_type      = $type;
        $this->_namespace = $namespace;
        $this->_key       = $key;
    }

    public function getType() {
        return $this->_type;
    }

    public function getNamespace() {
        return $this->_namespace;
    }

    public function getKey() {
        return $this->_key;
    }

    public function setData($data) {
        $this->_data = $data;

        return $this;
    }

    public function getData() {
        return $this->_data;
    }
}
