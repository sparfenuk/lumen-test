<?php

namespace App\Repository\Eloquent;

/**
 * Query Scope interface.
 */
interface ScopeInterface
{
    /**
     * Call apply() method from the Scope.
     *
     * @param  mixed $builder
     * @return mixed
     */
    public function __invoke($builder);
}
