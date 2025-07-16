<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    /**
     * Get the query builder with optional filters.
     * Child classes must implement getFilterClass() to specify their filter.
     *
     * @param array|null $filters
     * @return Builder|null
     */
    public function getQuery(?array $filters = []): ?Builder
    {
        $query = $this->baseQuery();
        $filterClass = $this->getFilterClass();
        if (!empty($filters) && class_exists($filterClass)) {
            $query = $query->filter(new $filterClass($filters));
        }
        return $query;
    }

    /**
     * Child classes should return the filter class name.
     *
     * @return string
     */
    abstract protected function getFilterClass(): string;

    /**
     * Child classes should return the base query (e.g., Model::query()).
     *
     * @return Builder
     */
    abstract protected function baseQuery(): Builder;

    /**
     * Find a model by its primary key.
     *
     * @param mixed $id
     * @return Model|null
     */
    public function findById($id): ?Model
    {
        return $this->baseQuery()->find($id);
    }

    /**
     * Find a model by a given key and value.
     *
     * @param string $key
     * @param mixed $value
     * @return Model|null
     */
    public function findByKey(string $key, $value): ?Model
    {
        return $this->baseQuery()->where($key, $value)->first();
    }

    // Add more shared methods as needed...
}
