<?php

namespace Rabiloo\Searchy\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Rabiloo\Searchy\SearchyBuilder;

trait Searchable
{
    abstract function searchableColumns(): array;

    public function scopeSearch(Builder $builder, string $keyword, string|array $columns = '')
    {
        $driver = config('searchy.default');
        return $this->search($keyword, $columns, $driver)->getQuery();
    }

    public function scopeFuzzySearch(Builder $builder, string $keyword, string|array $columns = '')
    {
        return $this->search($keyword, $columns, 'fuzzy')->getQuery();
    }

    public function scopeUFuzzySearch(Builder $builder, string $keyword, string|array $columns = '')
    {
        return $this->search($keyword, $columns, 'ufuzzy')->getQuery();
    }

    public function scopeSimpleSearch(Builder $builder, string $keyword, string|array $columns = '')
    {
        return $this->search($keyword, $columns, 'simple')->getQuery();
    }

    public function scopeLevenshteinSearch(Builder $builder, string $keyword, string|array $columns = '')
    {
        return $this->search($keyword, $columns, 'levenshtein')->getQuery();
    }

    private function search(string $keyword, string|array $columns = '', string $driver = '')
    {
        $builder = new SearchyBuilder(app('config'));
        if (!$columns) {
            $columns = $this->searchableColumns();
        }
        return $builder->driver($driver)->search($this->getTable())->fields($columns)->query($keyword);
    }
}
