<?php

namespace App\Services;

use App\DTOs\TagDTO;
use App\Models\Filters\TagsFilter;
use App\Models\Tag;

class TagsService extends BaseService
{
    protected function getFilterClass(): string
    {
        return TagsFilter::class;
    }

    protected function baseQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Tag::query();
    }

    public function create(TagDTO $dto): Tag
    {
        return $this->getQuery()->create([
            'name' => $dto->name,
            'description' => $dto->description,
        ]);
    }

    public function all(array $filters = [])
    {
        return $this->getQuery($filters)->get();
    }

    public function find(int $id)
    {
        return $this->getQuery()->find($id);
    }

    public function update(int $id, TagDTO $dto): ?Tag
    {
        $tag = $this->getQuery()->find($id);
        if ($tag) {
            $tag->update([
                'name' => $dto->name,
                'description' => $dto->description,
            ]);
        }

        return $tag;
    }

    public function delete(int $id): bool
    {
        $tag = $this->getQuery()->find($id);
        if ($tag) {
            return $tag->delete();
        }

        return false;
    }
}
