<?php

namespace MTP\scripts\Memory\Client;

use ReflectionMethod;
use MTP\CLI\Exception;
use MTP\Memory;
/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Parser {

    public static function parse($message, Memory\Client $memClient) {
        list ($method, $others) = explode(' ', trim($message).' ', 2);
        $method = strtolower($method);
        $others = trim($others);
        $params = array();

        if (method_exists($memClient, $method)) {
            $reflection = new ReflectionMethod($memClient, $method);
            $parameters = $reflection->getParameters();

            if (!empty($parameters)) {
                $params = array_filter(explode(' ',  $others, count($parameters)));
            }

            if (count($params) < count($parameters)) {
                $names = array();
                foreach ($parameters as $parameter) {
                    $names[] = $parameter->getName();
                }

                throw new Exception('Mising parameter! Syntax: '.$method.' ['.join(', ', $names).'].');
            }
        } elseif ($method === 'switch') {
            $params = array(trim($others));
        } else {
            throw new Exception('Undefined method "'.$method.'".');
        }

        return array($method, $params);
    }
}
