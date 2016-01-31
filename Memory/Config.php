<?php

namespace MTP\Memory;

use MTP\Network;

/**
 * This file defines class for configuration of memory module.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Config extends Network\Config {

    /**
     * Default port for communication.
     *
     * @var int
     */
    protected $_port = 63667;
}
