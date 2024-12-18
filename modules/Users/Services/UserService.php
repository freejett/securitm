<?php

declare(strict_types=1);

namespace Modules\Users\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Modules\Users\Http\Requests\UserFilterRequest;

final class UserService
{
    private const PER_PAGE = 10;

    /**
     * Получить список пользователей с учетом фильтров
     * @param UserFilterRequest $request
     * @return LengthAwarePaginator
     */
    public function getUsers(UserFilterRequest $request): LengthAwarePaginator
    {
        // через DTO было бы поизящнее, спешил
        $order = $request->get('order', 'asc');
        $col = $request->get('col', 'name');

        return User::query()
            ->when(
                $request->get('search'),
                static fn(Builder $query, string $search) => $query->where('name', 'LIKE', "%$search%")
            )
            ->when($order && $col, function ($query) use ($order, $col) {
                $query->orderBy($col, $order);
            })
            ->paginate(self::PER_PAGE);
    }
}
