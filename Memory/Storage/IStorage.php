<?php

namespace MTP\Memory\Storage;

/**
 *
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
interface IStorage {

    public function backup($namespace);
    public function recovery($namespace);
    public function get($name);
    public function set($name, $value);
    public function has($name);
    public function delete($name);
}
