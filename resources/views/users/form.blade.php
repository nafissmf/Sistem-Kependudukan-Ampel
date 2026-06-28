<x-layouts.app :title="$user->exists ? 'Edit Pengguna' : 'Tambah Pengguna'">
    <x-page-header :title="$user->exists ? 'Edit Pengguna' : 'Tambah Pengguna'"
                   :description="$user->exists ? 'Perbarui data akun pengguna.' : 'Buat akun pengguna baru.'">
        <x-slot:actions>
            <a href="{{ route('users.index') }}" class="flex h-10 items-center gap-2 rounded-xl border border-[var(--border)] px-4 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                <x-icon name="arrow-left" class="size-4" /> Kembali
            </a>
        </x-slot:actions>
    </x-page-header>

    @if ($errors->any())
        <div class="mb-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-700 dark:bg-red-600/15 dark:text-red-300">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="rounded-card border border-[var(--border)] bg-[var(--card-bg)] p-6">
        <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}">
            @csrf
            @if ($user->exists) @method('PUT') @endif

            <div class="grid gap-5 sm:grid-cols-2">
                <x-form-group label="Nama Lengkap" name="fullname" required>
                    <x-text-input name="fullname" :value="old('fullname', $user->fullname)" required />
                </x-form-group>

                <x-form-group label="Username" name="username" required>
                    <x-text-input name="username" :value="old('username', $user->username)" required
                                  :disabled="$user->exists" :class="$user->exists ? 'opacity-60 cursor-not-allowed' : ''" />
                    @if ($user->exists)
                        <input type="hidden" name="username" value="{{ $user->username }}">
                    @endif
                </x-form-group>

                <x-form-group label="Email" name="email" required>
                    <x-text-input name="email" type="email" :value="old('email', $user->email)" required />
                </x-form-group>

                <x-form-group label="{{ $user->exists ? 'Password Baru (opsional)' : 'Password' }}" name="password" :required="!$user->exists">
                    <x-text-input name="password" type="password" :required="!$user->exists"
                                  placeholder="{{ $user->exists ? 'Kosongkan jika tidak ingin mengubah' : '' }}" />
                </x-form-group>

                <x-form-group label="Nomor HP" name="phone">
                    <x-text-input name="phone" :value="old('phone', $user->phone)" placeholder="08xxxxxxxxxx" />
                </x-form-group>

                <x-form-group label="Role" name="role_id" required>
                    <x-select-input name="role_id" required>
                        <option value="">— Pilih Role —</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id) === $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </x-form-group>

                <x-form-group label="Desa" name="village_id">
                    <x-select-input name="village_id">
                        <option value="">— Pilih Desa (opsional) —</option>
                        @foreach ($villages as $village)
                            <option value="{{ $village->id }}" @selected(old('village_id', $user->village_id) === $village->id)>
                                {{ $village->name }}
                            </option>
                        @endforeach
                    </x-select-input>
                </x-form-group>

                @if ($user->exists)
                    <x-form-group label="Status Akun" name="is_active">
                        <select name="is_active" class="h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--bg)] px-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                            <option value="1" @selected(old('is_active', $user->is_active) == '1')>Aktif</option>
                            <option value="0" @selected(old('is_active', $user->is_active) == '0')>Nonaktif</option>
                        </select>
                    </x-form-group>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('users.index') }}" class="flex h-10 items-center rounded-xl border border-[var(--border)] px-5 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5">
                    Batal
                </a>
                <button type="submit" class="flex h-10 items-center gap-2 rounded-xl bg-primary-600 px-5 text-sm font-medium text-white hover:bg-primary-700">
                    <x-icon name="save" class="size-4" />
                    {{ $user->exists ? 'Simpan Perubahan' : 'Buat Pengguna' }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
