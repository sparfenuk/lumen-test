<?php

namespace App\Repository\Eloquent;

use ArrayAccess;

/**
 * Repository interface.
 *
 */
interface RepositoryInterface
{
    /**
     * Return full collection.
     *
     * @param  array $columns
     * @return \ArrayAccess
     */
    public function all(array $columns = ['*']): ArrayAccess;

    /**
     * Create new instance of Entity and return.
     *
     * @param  array  $fields
     * @return mixed
     */
    public function create(array $fields);

    /**
     * Destroy instance of Entity.
     *
     * @param int|string $id
     * @return void
     */
    public function delete($id): void;

    /**
     * Return entity class.
     *
     * @return string
     */
    public function entityClass(): string;

    /**
     * Determine if given scope Entity exists.
     *
     * @param  mixed $scope
     * @return bool
     */
    public function exists($scope = null): bool;

    /**
     * Return single instance of Entity.
     *
     * @param  int|string $id
     * @param  mixed      $scope
     * @param  array      $columns
     * @return mixed
     */
    public function find($id, $scope = null, array $columns = ['*']);

    /**
     * Return single instance by given scope.
     *
     * @param  mixed $scope
     * @param  array $columns
     * @return mixed
     */
    public function first($scope = null, array $columns = ['*']);

    /**
     * Return some collection.
     *
     * @param  mixed $scope
     * @param  array $columns
     * @return \ArrayAccess
     */
    public function get($scope = null, array $columns = ['*']): ArrayAccess;

    /**
     * Update Entitly if exists.
     *
     * @param $id
     * @param array $fileds
     * @return mixed
     *
     * @throws \Exception
     */
    public function update($id, array $fileds);
}
