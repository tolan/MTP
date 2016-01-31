<?php

namespace MTP\scripts\Memory\Client;

use MTP\CLI;
use MTP\Memory;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Listener extends CLI\Client\Listener {

    public function __construct(Memory\Config $config) {
        $namespace = 'MTP\Memory';
        $this->setClosure(function($message) use ($config, $namespace) {
            if (in_array(trim($message), ['help', 'h', '?'])) {
                $output = new CLI\Client\Response\StdOut();

                $response = array(
                    'Help for memory client.',
                    "\tCommands:\t\t - example:",
                    "\tGET [key]\t\t - (GET test)",
                    "\tSET [key] [value]\t - (SET test 123)",
                    "\tHAS [key]\t\t - (HAS test)",
                    "\tDELETE [key]\t\t - (DELETE test)",
                    "\tKEYS\t\t\t - (KEYS)",
                    ''
                );

                $output->setData(join("\n", $response));
            } elseif (in_array(trim(strtolower($message)), ['quit', 'exit'])) {
                $output = new CLI\Client\Response\Quit();
            } else {
                try {
                    $client = Memory\Factory::getClient($config, $namespace);
                    list ($method, $params) = Parser::parse($message, $client);
                    if ($method === 'switch') {
                        $namespace = current($params);
                        $client    = Memory\Factory::getClient($config, $namespace);
                        $response  = 'true';
                    } elseif ($method) {
                        $response = var_export(call_user_func_array(array($client, $method), $params), true);
                    }
                } catch (CLI\Exception $exp) {
                    $response = $exp->getMessage();
                }

                $output = new CLI\Client\Response\StdOut();
                $output->setData($response."\n");
            }

            return $output;
        });
    }
}
