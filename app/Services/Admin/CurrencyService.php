<?php

namespace App\Services\Admin;

use App\DTOs\TagDTO;
use App\Models\Currency;
use App\Models\Tag;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CurrencyService extends BaseService
{
    protected function getFilterClass(): ?string
    {
        return null;
    }

    protected function baseQuery(): Builder
    {
        return Currency::query();
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
