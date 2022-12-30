<?php

namespace App\Repository;

use App\Exceptions\ConfigurationException;
use App\Repository\Eloquent\RepositoryInterface;
use App\Repository\Traits\HasRelations;
use App\Repository\Traits\HasScopes;
use App\Support\TraitBooter;
use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent based Repository.
 * @method bootTraits()
 */
abstract class Repository implements RepositoryInterface
{
    use TraitBooter;
    use HasRelations;
    use HasScopes;

    /**
     * Reference to Entity class.
     *
     * @var string
     */
    protected $entityClass;

    /**
     * Initial repository.
     *
     * @return void
     * @throws ConfigurationException
     */
    public function __construct()
    {
        if (!(new $this->entityClass) instanceof Model) {
            throw new ConfigurationException(
                sprintf('Eloquent Model is required as [$entityClass] in %s.', get_class($this))
            );
        }

        $this->bootTraits();
    }

    /**
     * Return full collection.
     *
     * @param  array $columns
     * @return \ArrayAccess
     */
    public function all(array $columns = ['*']): ArrayAccess
    {
        return $this->entityClass::all($columns);
    }

    /**
     * Create new instance of Entity and return.
     *
     * @param  array  $fields
     * @return mixed
     */
    public function create(array $fields)
    {
        return $this->entityClass::create($fields);
    }

    /**
     * Destroy instance of Entity.
     *
     * @param int|string $id
     * @return void
     */
    public function delete($id): void
    {
        $this->entityClass::destroy($id);
    }

    /**
     * Return entity class.
     *
     * @return string
     */
    public function entityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * Determine if given scope Entity exists.
     *
     * @param mixed $scope
     * @return bool
     * @throws \ReflectionException
     */
    public function exists($scope = null): bool
    {
        $this->concernNewScope($scope);

        return $this->getBuilder()->exists();
    }

    /**
     * Return single instance of Entity.
     *
     * @param int|string $id
     * @param mixed $scope
     * @param array $columns
     * @return mixed
     * @throws \ReflectionException
     */
    public function find($id, $scope = null, array $columns = ['*'])
    {
        $this->concernNewScope($scope);

        return $this->getBuilder()->find($id, $columns);
    }

    /**
     * Return single instance or throw Exception.
     *
     * @param  int|string $id
     * @param  mixed      $scope
     * @param  array      $columns
     * @return mixed
     *
     * @throws \Exception
     */
    public function findOrFail($id, $scope = null, array $columns = ['*'])
    {
        $this->concernNewScope($scope);

        return $this->getBuilder()->findOrFail($id, $columns);
    }

    /**
     * Return single instance by given scope.
     *
     * @param mixed $scope
     * @param array $columns
     * @return mixed
     * @throws \ReflectionException
     */
    public function first($scope = null, array $columns = ['*'])
    {
        $this->concernNewScope($scope);

        return $this->getBuilder()->first($columns);
    }

    /**
     * Return single instance by given scope or throw Exception.
     *
     * @param  mixed $scope
     * @param  array $columns
     * @return mixed
     *
     * @throws \Exception
     */
    public function firstOrFail($scope = null, array $columns = ['*'])
    {
        $this->concernNewScope($scope);

        return $this->getBuilder()->firstOrFail($columns);
    }

    /**
     * Return single instance or create new one.
     *
     * @param  array $find
     * @param  array $fields
     * @return mixed
     */
    public function firstOrCreate(array $find, array $fields = [])
    {
        return $this->entityClass::firstOrCreate($find, $fields);
    }

    /**
     * Return some collection.
     *
     * @param  mixed $scope
     * @param  array $columns
     * @return \ArrayAccess
     */
    public function get($scope = null, array $columns = ['*']): ArrayAccess
    {
        $this->concernNewScope($scope);

        return $this->getBuilder()->get($columns);
    }

    /**
     * Update Entitly if exists.
     *
     * @param  mixed $id
     * @param  array $fields
     * @return mixed
     *
     * @throws \Exception
     */
    public function update($id, array $fields)
    {
        if ($this->isScope($id)) {
            // Multiupload based on given Scope.
            $this->concernNewScope($id);

            return $this->getBuilder()->update($fields);
        } elseif (is_array($id)) {
            // Multiupload based on array of ids.
            return $this->newInstance()->whereIn('id', $id)->update($fields);
        } elseif (in_array(gettype($id), ['integer', 'string'])) {
            // Update of specific Entity.
            $model = $this->newInstance()->find($id);

            return $model ? $model->update($fields) : false;
        }
    }

    /**
     * Update Entity or create new one and return.
     *
     * @param  array $find
     * @param  array $fields
     * @return mixed
     */
    public function updateOrCreate(array $find, array $fields)
    {
        return $this->entityClass::updateOrCreate($find, $fields);
    }

    /**
     * Return Eloquent Builder instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getBuilder(): Builder
    {
        return $this->applyScopes(
            $this->applyRelations(
                $this->newInstance()->newQuery()
            )
        );
    }

    /**
     * Return new instance of Eloquent Model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function newInstance() : Model
    {
        return new $this->entityClass;
    }
}
