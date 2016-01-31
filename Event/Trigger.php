<?php

namespace MTP\Event;

/**
 * This file defines class for triggering of event.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Trigger {

    /**
     * Name of event
     *
     * @var string
     */
    private $_name;

    /**
     * Data for closure.
     *
     * @var mixed
     */
    private $_data;

    /**
     * Construct method for set name of event.
     *
     * @param string $name Name of event
     */
    public function __construct($name) {
        $this->_name = $name;
    }

    /**
     * Gets name of event.
     *
     * @return string
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Sets data for closure.
     *
     * @param mixed $data Data for closure
     *
     * @return Trigger
     */
    public function setData($data) {
        $this->_data = $data;

        return $this;
    }

    /**
     * Gets data for closure.
     *
     * @return mixed
     */
    public function getData() {
        return $this->_data;
    }
}
