<?php

namespace MTP\Network\Server\Response;

/**
 * This file defines interfacce for response of network communication.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
interface IResponse {

    /**
     * Sends data to output.
     *
     * @param resource $socket Resource socket
     *
     * @return IResponse
     */
    public function send($socket);
}
