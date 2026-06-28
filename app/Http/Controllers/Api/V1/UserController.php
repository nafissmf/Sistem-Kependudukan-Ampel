<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\DuplicateUserException;
use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller Layer
 * =======================================================
 * Aturan ketat (lihat dokumen "CLEAN ARCHITECTURE"):
 *   "Controller hanya menerima request dan mengembalikan response."
 * Tidak boleh ada query Eloquent atau logic bisnis di file ini.
 */
class UserController extends Controller
{
    public function __construct(private readonly UserService $users) {}

    public function index(Request $request): JsonResponse
    {
        abort_unless($request->user()?->can('user.read'), 403);

        $paginated = $this->users->list(
            page: (int) $request->query('page', 1),
            perPage: min((int) $request->query('per_page', 10), 100),
            search: $request->query('search'),
            roleId: $request->query('role_id'),
        );

        return ApiResponse::success([
            'items' => UserResource::collection($paginated->items()),
            'pagination' => [
                'page' => $paginated->currentPage(),
                'page_size' => $paginated->perPage(),
                'total' => $paginated->total(),
                'total_pages' => $paginated->lastPage(),
            ],
        ], 'Daftar user berhasil diambil.');
    }

    public function show(Request $request, string $id): JsonResponse
    {
        abort_unless($request->user()?->can('user.read'), 403);

        try {
            return ApiResponse::success(new UserResource($this->users->find($id)));
        } catch (UserNotFoundException) {
            return ApiResponse::notFound('User');
        }
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $created = $this->users->create($request->validated(), $request->user()->id, $request);

            return ApiResponse::success(new UserResource($created), 'User berhasil dibuat.', 201);
        } catch (DuplicateUserException $e) {
            return ApiResponse::conflict($e->getMessage());
        }
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        try {
            $updated = $this->users->update($id, $request->validated(), $request->user()->id, $request);

            return ApiResponse::success(new UserResource($updated), 'User berhasil diperbarui.');
        } catch (UserNotFoundException) {
            return ApiResponse::notFound('User');
        } catch (DuplicateUserException $e) {
            return ApiResponse::conflict($e->getMessage());
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        // Sesuai dokumen RBAC: Operator Kecamatan TIDAK BOLEH hapus permanen.
        // Endpoint ini hanya soft-delete, dan tetap memerlukan permission
        // 'delete' pada modul 'user' — yang menurut matrix hanya dimiliki
        // SUPER_ADMIN (lihat app/Support/Rbac.php).
        abort_unless($request->user()?->can('user.delete'), 403);

        try {
            $this->users->delete($id, $request->user()->id, $request);

            return ApiResponse::success(null, 'User berhasil dihapus (soft delete).');
        } catch (UserNotFoundException) {
            return ApiResponse::notFound('User');
        }
    }
}
