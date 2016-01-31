<?php

namespace MTP\Network\Server\Response;

use MTP\Network\Utils;

/**
 * This file defines class for response of network communication which has OK output.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Ok implements IResponse {

    /**
     * Sends data to output.
     *
     * @param resource $socket Resource socket
     *
     * @return Data
     */
    public function send($socket) {
        Utils::sendMessage($socket, 'OK'."\n");

        return $this;
    }
}
