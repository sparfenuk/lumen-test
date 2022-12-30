<?php

namespace App\Repository\Traits;

use App\Exceptions\ConfigurationException;
use ReflectionClass;

/**
 * Extension for Repository that gives access to Json mappers.
 */
trait HasJsonResource
{
    /**
     * Initial Json Resource extension.
     *
     * @return void
     */
    protected function bootHasJsonResource()
    {
        if (!property_exists($this, 'jsonResource')) {
            throw new ConfigurationException(
                'When use HasJsonResource trait, property [$jsonResource] must be defined.'
            );
        }

        $resource = new ReflectionClass($this->jsonResource);

        if (!$resource->isSubclassOf('Illuminate\Http\Resources\Json\JsonResource')) {
            throw new ConfigurationException(
                sprintf('Illuminate\Http\Resources\Json\JsonResource is required as [$jsonResource] in %s.', get_class($this))
            );
        }
    }

    /**
     * Return mapped json collection response.
     *
     * @param  mixed $scope
     * @param  array $meta
     * @return \Illuminate\Http\Response
     */
    public function collection($scope = null, array $meta = [])
    {
        if (is_array($scope) && isset($scope['collection'])) {
            // If the scope is an array with key colection,
            // it means that there're already retrived entities
            // that should be inserted directly.
            //
            $insert = $scope['collection'];
        } else {
            $insert = $this->get($scope);
        }

        $response = empty($this->jsonCollection) ?
            ($this->jsonResource::collection($insert)) : (new $this->jsonCollection($insert));

        return (count($meta) > 0) ? $response->additional($meta) : $response;
    }

    /**
     * Return mapped json response.
     *
     * @param  mixed $scope
     * @param  array $meta
     * @return \Illuminate\Http\Response
     */
    public function json($scope = null, array $meta = [])
    {
        if (is_array($scope) && isset($scope['entity'])) {
            // If the scope is an array with key entity,
            // it means that there's already retrived entity
            // that should be inserted directly.
            //
            $insert = $scope['entity'];
        } else {
            $insert = $this->first($scope);
        }

        $response = (new $this->jsonResource($insert));

        return (count($meta) > 0) ? $response->additional($meta) : $response;
    }
}
