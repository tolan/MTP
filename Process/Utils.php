<?php

namespace MTP\Process;

/**
 * This file defines utils class with helper methods
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Utils {

    /**
     * Returns key to storage by given identifier.
     *
     * @param string $id Identifier
     *
     * @return string
     */
    public static function getStatusKey($id) {
        return __NAMESPACE__.'_'.$id.'_status';
    }

    /**
     * Returns key to storage by given identifier.
     *
     * @param string $id Identifier
     *
     * @return string
     */
    public static function getResultKey($id) {
        return __NAMESPACE__.'_'.$id.'_result';
    }

    /**
     * Returns key to storage by given identifier.
     *
     * @param string $id Identifier
     *
     * @return string
     */
    public static function getCallbackKey($id) {
        return __NAMESPACE__.'_'.$id.'_callback';
    }
}
