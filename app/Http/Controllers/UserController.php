<?php

namespace App\Http\Controllers;

use App\Enums\RoleCode;
use App\Exceptions\DuplicateUserException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Village;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private readonly UserService $users) {}

    public function index(Request $request): View
    {
        abort_unless($request->user()->can('user.read'), 403);

        $search = $request->query('search');
        $roleId = $request->query('role_id');

        $users = User::with('role', 'village')
            ->when($search, fn ($q) => $q->where(fn ($q) => $q
                ->where('username', 'like', "%{$search}%")
                ->orWhere('fullname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")))
            ->when($roleId, fn ($q) => $q->where('role_id', $roleId))
            ->orderBy('fullname')
            ->paginate(15)
            ->withQueryString();

        return view('users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(['id', 'name']),
            'filters' => $request->only(['search', 'role_id']),
        ]);
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()->can('user.create'), 403);

        return view('users.form', [
            'user' => new User,
            'roles' => Role::orderBy('name')->get(['id', 'name', 'code']),
            'villages' => Village::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            $user = $this->users->create($request->validated(), $request->user()->id, $request);

            return redirect()->route('users.index')->with('success', "User {$user->username} berhasil dibuat.");
        } catch (DuplicateUserException $e) {
            return back()->withInput()->withErrors(['username' => 'Username atau email sudah digunakan.']);
        }
    }

    public function edit(Request $request, string $user): View
    {
        abort_unless($request->user()->can('user.update'), 403);

        $userModel = User::with('role', 'village')->findOrFail($user);

        return view('users.form', [
            'user' => $userModel,
            'roles' => Role::orderBy('name')->get(['id', 'name', 'code']),
            'villages' => Village::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(UpdateUserRequest $request, string $user): RedirectResponse
    {
        try {
            $updated = $this->users->update($user, $request->validated(), $request->user()->id, $request);

            return redirect()->route('users.index')->with('success', "User {$updated->username} berhasil diperbarui.");
        } catch (UserNotFoundException) {
            abort(404);
        } catch (DuplicateUserException $e) {
            return back()->withInput()->withErrors(['username' => 'Username atau email sudah digunakan.']);
        }
    }

    public function destroy(Request $request, string $user): RedirectResponse
    {
        abort_unless($request->user()->can('user.delete'), 403);

        if ($user === $request->user()->id) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        }

        try {
            $this->users->delete($user, $request->user()->id, $request);

            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        } catch (UserNotFoundException) {
            abort(404);
        }
    }
}
