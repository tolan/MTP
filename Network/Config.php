<?php

namespace MTP\Network;

/**
 * This file defines class for configuration of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Config {

    /**
     * Server IP address.
     *
     * @var string
     */
    protected $_ip   = 'localhost';

    /**
     * Port where server is listening
     *
     * @var int
     */
    protected $_port = 63896;

    /**
     * Construct method for rewrite configuration options.
     *
     * @param array $config Configuration options
     *
     * @return void
     */
    public function __construct(array $config = array()) {
        foreach ($config as $key => $value) {
            if (isset($this->$key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Gets IP adress.
     *
     * @return string
     */
    public function getIp() {
        return $this->_ip;
    }

    /**
     * Gets port.
     *
     * @return int
     */
    public function getPort() {
        return $this->_port;
    }
}
