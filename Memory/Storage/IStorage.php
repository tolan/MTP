<?php

namespace MTP\Memory\Storage;

/**
 * This file defines interface for memory storage.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
interface IStorage {

    /**
     * It creates backup of actual data.
     *
     * @param string $namespace Namespace of the data
     *
     * @return IStorage
     */
    public function backup($namespace);

    /**
     * It loads data from backup.
     *
     * @param string $namespace Namespace of the data
     *
     * @return IStorage
     */
    public function recovery($namespace);

    /**
     * Gets data by given name.
     *
     * @param string $name Name
     *
     * @return mixed
     */
    public function get($name);

    /**
     * Sets data to storage under given name.
     *
     * @param string $name  Name
     * @param mixed  $value Some value
     *
     * @return boolean
     */
    public function set($name, $value);

    /**
     * Returns that the value is existed by given name.
     *
     * @param string $name Name
     *
     * @return boolean
     */
    public function has($name);

    /**
     * Deletes value by given name.
     *
     * @param string $name Name
     *
     * @return boolean
     */
    public function delete($name);

    /**
     * Gets all keys in current namespace.
     *
     * @return array
     */
    public function keys();
}
