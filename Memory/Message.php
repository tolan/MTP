<?php

namespace MTP\Memory;

/**
 * This file defines class for message of memory module.
 * The message contains namespace, type, name and data.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Message {

    /**
     * Type of message (get, set, has ...).
     *
     * @var string
     */
    private $_type;

    /**
     * Namespace
     *
     * @var string
     */
    private $_namespace;

    /**
     * Name of variable.
     *
     * @var string
     */
    private $_name;

    /**
     * Data for set or get command.
     *
     * @var mixed
     */
    private $_data;

    /**
     * Construct method for set a basic data.
     *
     * @param string $type      Type of message (get, set, has ...)
     * @param string $namespace Namespace of data
     * @param string $name      Name of variable
     *
     * @return void
     */
    public function __construct($type, $namespace, $name=null) {
        $this->_type      = $type;
        $this->_namespace = $namespace;
        $this->_name      = $name;
    }

    /**
     * Gets type of message (get, set, has ...).
     *
     * @return string
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * Gets namespace of this message.
     *
     * @return string
     */
    public function getNamespace() {
        return $this->_namespace;
    }

    /**
     * Gets name of variable in storage.
     *
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Sets data of variable.
     *
     * @param mixed $data Some seriazable data
     *
     * @return Message
     */
    public function setData($data) {
        $this->_data = $data;

        return $this;
    }

    /**
     * Gets data of variable.
     *
     * @return mixed
     */
    public function getData() {
        return $this->_data;
    }
}
