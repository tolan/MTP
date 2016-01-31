<?php

namespace MTP\CLI\Client\Response;

/**
 * This file defines class for EXIT response of CLI client.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Quit extends AResponse {

    /**
     * It write exit message to standard output.
     *
     * @return void
     */
    public function flush() {
        fwrite(STDOUT, 'Exit'."\n");
    }
}
