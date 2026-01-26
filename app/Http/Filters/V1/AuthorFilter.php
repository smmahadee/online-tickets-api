<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;

class AuthorFilter extends QueryFilter
{
    protected array $sortable = [
        'name',
        'email',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at',
    ];

    public function status(string $value): Builder
    {
        return $this->builder->whereIn('status', explode(',', $value));
    }

    public function include(string $relationship): Builder
    {
        return $this->builder->with($relationship);
    }

    public function name(string $value): Builder
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }

    public function email(string $value): Builder
    {
        return $this->builder->where('email', 'like', "%{$value}%");
    }

    public function id(string $value): Builder
    {
        return $this->builder->whereIn('id', explode(',', $value));
    }

    public function createdAt(string $date): Builder
    {
        $dates = explode(',', $date);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->where('created_at', $dates);
    }

    public function updatedAt(string $date): Builder
    {
        $dates = explode(',', $date);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->where('updated_at', $dates);
    }
}