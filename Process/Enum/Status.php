<?php

namespace MTP\Process\Enum;

/**
 * This file defines enum class for status of process.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Status {
    const NONE    = 'none';
    const START   = 'start';
    const RUN     = 'run';
    const DONE    = 'done';
    const ERROR   = 'error';
    const PARTIAL = 'partial';
}
