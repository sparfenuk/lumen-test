<?php

namespace App\Repository\Traits;

use App\Repository\Scope;
use Closure;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use ReflectionFunction;

/**
 * Extension for Repository that gives access to scoping.
 */
trait HasScopes
{
    /**
     * List of Scopes that have to be applied to Query.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Add new query scope.
     *
     * @param Scope|Closure $scope
     * @return self
     * @throws \ReflectionException
     */
    public function scope($scope): self
    {
        $this->concernNewScope($scope);

        return $this;
    }

    /**
     * Apply all registered scopes to Eloquent Builder.
     *
     * @param Builder $builder
     * @return Builder
     */
    protected function applyScopes(Builder $builder): Builder
    {
        // Let's call each scope one by one.
        //
        foreach ($this->scopes as $s) {
            $builder = $s($builder);
        }

        return $builder;
    }

    /**
     * Concern given scope as new one.
     *
     * @param mixed $scope
     * @return void
     * @throws \ReflectionException
     */
    protected function concernNewScope($scope): void
    {
        if ($scope instanceof Closure) {
            // Scope is a Closure so we need to check
            // if it's correct format.
            $this->reflectClosure($scope);
            $this->scopes[] = $scope;

        } elseif ($scope instanceof Scope) {
            // Scope is EloquentScope so can be diretly
            // apply to Query.
            $this->scopes[] = $scope;

        } elseif (!is_null($scope)) {
            throw new InvalidArgumentException(
                sprintf('Given [$scope] is not a valid Scope. Instance of Closure or Scope required. %s given.', gettype($scope))
            );
        }
    }

    /**
     * Determine if given argument is a valid Scope.
     *
     * @param mixed $scope
     * @return bool
     */
    protected function isScope($scope): bool
    {
        return $scope instanceof Scope || $scope instanceof Closure;
    }

    /**
     * Check if given Closure if well formated using Reflection.
     *
     * @param Closure $closure
     * @return void
     *
     * @throws InvalidArgumentException|\ReflectionException
     */
    private function reflectClosure(Closure $closure): void
    {
        $reflection = new ReflectionFunction($closure);
        $params = $reflection->getParameters();

        if (count($params) != 1) {
            throw new InvalidArgumentException('Closure Scope has to be pure function with only one parameter.');
        }

        if (!$reflection->getReturnType() != 'Illuminate\Database\Eloquent\Builder') {
            throw new InvalidArgumentException('Closure Scope has to return Illuminate\Database\Eloquent\Builder instance.');
        }

        if ($params[0]->getType() != 'Illuminate\Database\Eloquent\Builder') {
            throw new InvalidArgumentException('Argument of Closure Scope has to be Illuminate\Database\Eloquent\Builder instance.');
        }
    }
}
