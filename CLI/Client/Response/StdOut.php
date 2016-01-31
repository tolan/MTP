<?php

namespace MTP\CLI\Client\Response;

/**
 * This file defines class for write response data to standard output.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class StdOut extends AResponse {

    /**
     * It writes response data to standard output.
     *
     * @return void
     */
    public function flush() {
        fwrite(STDOUT, $this->getData());
    }
}