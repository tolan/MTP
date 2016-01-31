<?php

namespace MTP\Network\Server\Response;

/**
 * This file defines class for response of network communication which does not send data to output.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Nope implements IResponse {

    /**
     * This method has empty process.
     *
     * @param resource $socket Resource socket
     *
     * @return Nope
     */
    public function send($socket) {
        return $this;
    }
}