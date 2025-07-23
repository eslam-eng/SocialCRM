<?php

namespace App\Services;

use App\DTOs\CustomerDTO;
use App\Models\Customer;
use App\Models\Filters\CustomersFilter;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CustomerService extends BaseService
{
    protected function getFilterClass(): ?string
    {
        return CustomersFilter::class;
    }

    protected function baseQuery(): Builder
    {
        return Customer::query();
    }

    public function create(CustomerDTO $customerDTO): Tag
    {
        return $this->getQuery()->create($customerDTO->toArray());
    }

    public function paginate(array $filters = [], $limit = 15)
    {
        return $this->getQuery($filters)->paginate($limit);
    }

    public function update(int $id, CustomerDTO $customerDTO): Model
    {
        $customer = $this->findById($id);
        $customer->update($customerDTO->toArray());

        return $customer->fresh();
    }

    public function delete(int $id): bool
    {
        $customer = $this->findById($id);

        return $customer->delete();
    }
}
