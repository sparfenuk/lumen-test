<?php

namespace App\Repository\Traits;

use ArrayAccess;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Extension for Repository that gives access to relations.
 */
trait HasRelations
{
    /**
     * List of Counts that have to be applied to Query.
     *
     * @var array
     */
    protected $counts = [];

    /**
     * List of Relations that have to be applied to Query.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Create new instance of Entity and return.
     *
     * @param  mixed  $id
     * @param  string $relation
     * @param  array  $fields
     * @return mixed
     */
    public function createRelated($id, string $relation, array $fields)
    {
        $model = ($id instanceof Model) ? $id : $this->getBuilder()->findOrFail($id);

        return $model->{$relation}()->create($fields);
    }

    /**
     * Return some collection of related entities.
     *
     * @param  int    $id
     * @param  string $relation
     * @param  array  $columns
     * @return ArrayAccess
     */
    public function getRelated(int $id, string $relation, array $columns = ['*']): ArrayAccess
    {
        $model = $this->getBuilder()->findOrFail($id);

        return $model->{$relation}()->get($columns);
    }

    /**
     * Add new relations to load.
     *
     * @param  array $relations
     * @return self
     */
    public function with(array $relations): self
    {
        $this->relations = $relations;

        return $this;
    }

    /**
     * Add new counting to load.
     *
     * @param  array $counts
     * @return self
     */
    public function withCount(array $counts): self
    {
        $this->counts = $counts;

        return $this;
    }

    /**
     * Apply relations to Eloquent Builder.
     *
     * @param Builder $builder
     * @return Builder
     */
    protected function applyRelations(Builder $builder): Builder
    {
        if (count($this->counts)) {
            $builder->withCount($this->counts);
        }

        if (count($this->relations)) {
            $builder->with($this->relations);
        }

        return $builder;
    }
}
