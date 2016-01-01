<?php

namespace MTP\Network;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Config {

    protected $_ip   = 'localhost';
    protected $_port = 63896;

    public function getIp() {
        return $this->_ip;
    }

    public function getPort() {
        return $this->_port;
    }
}
