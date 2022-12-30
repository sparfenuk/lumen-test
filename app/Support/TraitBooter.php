<?php

namespace App\Support;

/**
 * Trait that provides booting mechanism for Extensions traits.
 */
trait TraitBooter
{
    /**
     * List of all already booted Traits.
     *
     * @var array
     */
    private $bootedTraits = [];

    /**
     * Boots traits if it's needed.
     *
     * @return void
     */
    protected function bootTraits(): void
    {
        foreach (class_uses_recursive($this) as $trait) {
            $method = 'boot'.class_basename($trait);

            if (method_exists($this, $method) && !in_array($method, $this->bootedTraits)) {
                // If there's a boot method for a Trait, we boot it
                // and add to the booted array.
                $this->{$method}();
                $this->bootedTraits[] = $method;
            }
        }
    }
}
