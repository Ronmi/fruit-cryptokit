<?php

namespace Fruit\CryptoKit;

/**
 * Define api interface to compute hashsum.
 *
 * The design is roughly copy of php hash extension.
 */
interface Hasher extends \Fruit\Module
{
    /**
     * update() and updateStream() allocates a context if needed,
     * and pump data into the context.
     */
    public function update($data);
    public function updateStream($handle);

    /**
     * Get computed hashsum and free the context.
     */
    public function sum($raw = false);
}
