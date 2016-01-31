<?php

namespace MTP\Process;

/**
 * This file defines class for callback definition of process.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Callback {

    /**
     * Class which will be called.
     *
     * @var mixed
     */
    private $_class;

    /**
     * Name of method.
     *
     * @var string
     */
    private $_method;

    /**
     * Input parameters for method.
     *
     * @var array
     */
    private $_params = array();

    /**
     * Sets seriazable class.
     *
     * @param mixed $class Class which will be called
     *
     * @return Callback
     */
    public function setClass($class) {
        $this->_class = $class;

        return $this;
    }

    /**
     * Sets name of method.
     *
     * @param string $method Name of method
     *
     * @return Callback
     */
    public function setMethod($method) {
        $this->_method = $method;

        return $this;
    }

    /**
     * Sets parameters for method. These parameters must be seriazable.
     *
     * @param array $params Input parameters
     *
     * @return Callback
     */
    public function setParams(array $params=array()) {
        $this->_params = $params;

        return $this;
    }

    /**
     * It calls given method of the class with parameters and returns result.
     *
     * @return mixed
     */
    public function invoke() {
        return call_user_func_array(array($this->_class, $this->_method), $this->_params);
    }
}

