<?php

namespace App\Repository;

use App\Repository\Eloquent\ScopeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Eloquent Query Scope.
 */
abstract class Scope implements ScopeInterface
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @return Builder
     */
    abstract public function apply(Builder $builder): Builder;

    /**
     * Call apply() method from the Scope.
     *
     * @param  mixed $builder
     * @return Builder
     */
    public function __invoke($builder): Builder
    {
        return $this->apply($builder);
    }
}
