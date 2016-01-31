<?php

namespace MTP\Network\Server\Response;

use MTP\Network\Utils;

/**
 * This file defines class for response of network communication which has EXIT output.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Quit implements IResponse {

    /**
     * Sends data to output.
     *
     * @param resource $socket Resource socket
     *
     * @return Data
     */
    public function send($socket) {
        Utils::sendMessage($socket, 'EXIT!'."\n");

        return $this;
    }
}
