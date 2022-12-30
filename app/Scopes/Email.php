<?php

namespace App\Scopes;

use App\Repository\Scope;
use Illuminate\Database\Eloquent\Builder;

class Email extends Scope
{
    protected $email;

    /**
     * Construct Scope with additional params required for scoping.
     *
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        return $builder->where('email', '=', $this->email);
    }
}
