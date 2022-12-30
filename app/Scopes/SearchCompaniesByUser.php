<?php

namespace App\Scopes;

use App\Repository\Scope;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class SearchCompaniesByUser extends Scope
{
    protected $user;

    /**
     * Construct Scope with additional params required for scoping.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $userId = $this->user->id;
        return $builder->whereHas('users', function ($query) use ($userId) {
            return $query->where('user_id', '=', $userId);
        });

    }
}
