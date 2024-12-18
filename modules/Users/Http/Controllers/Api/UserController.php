<?php

namespace Modules\Users\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Http\Requests\UserCreateOrUpdateRequest;
use Modules\Users\Http\Requests\UserFilterRequest;
use Modules\Users\Http\Resources\UserResource;
use Modules\Users\Services\UserService;

class UserController extends Controller
{
    /**
     * Список пользователей
     * @param UserFilterRequest $request
     * @return JsonResponse
     */
    public function index(UserFilterRequest $request): JsonResponse
    {
        // список пользователей с учетом фильтров
        // фильтрация вынесена в сервис
        $users = app(UserService::class)->getUsers($request);

        return response()->json(
            // с пагинацией
            UserResource::collection($users)->response()->getData()

            // без пагинации
            //UserResource::collection($users)
        );
    }

    /**
     * Создать пользователя
     * @param UserCreateOrUpdateRequest $request
     * @return JsonResponse
     */
    public function store(UserCreateOrUpdateRequest $request): JsonResponse
    {
        $password = Hash::make($request->get('password'));
        $request->password = $password;

        return response()->json(
            new UserResource(
                User::create($request->all())
            )
        );
    }

    /**
     * Показать пользователя
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Обновить пользователя
     * @param UserCreateOrUpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserCreateOrUpdateRequest $request, User $user): JsonResponse
    {
        $user->update($request->all());
        return response()->json(new UserResource($user));
    }

    /**
     * Удалить пользователя
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        return response()->json($user->delete());
    }
}
