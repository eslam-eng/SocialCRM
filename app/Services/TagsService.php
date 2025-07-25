<?php

namespace App\Services;

use App\DTOs\TagDTO;
use App\Models\Filters\TagsFilter;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TagsService extends BaseService
{
    protected function getFilterClass(): string
    {
        return TagsFilter::class;
    }

    protected function baseQuery(): Builder
    {
        return Tag::query();
    }

    public function create(TagDTO $dto): Tag
    {
        return $this->getQuery()->create($dto->toArray());
    }

    public function all(array $filters = [])
    {
        return $this->getQuery($filters)->get();
    }

    public function update(int $id, TagDTO $dto): Model
    {
        $tag = $this->findById($id);
        $tag->update($dto->toArray());

        return $tag;
    }

    public function delete(int $id): bool
    {
        $tag = $this->findById($id);

        return $tag->delete();
    }
}
