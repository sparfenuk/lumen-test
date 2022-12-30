<?php

namespace App\Scopes;

use App\Repository\Scope;
use Illuminate\Database\Eloquent\Builder;

class EmailToken extends Scope
{
    protected $email_token;

    /**
     * Construct Scope with additional params required for scoping.
     *
     * @param $email_token
     */
    public function __construct($email_token)
    {
        $this->email_token = $email_token;
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
        return $builder->where('email_token', '=', $this->email_token);
    }
}
