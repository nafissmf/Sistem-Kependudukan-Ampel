<x-layouts.guest title="Login">
    <div class="grid min-h-screen lg:grid-cols-2">
        {{-- ==========================================================
             PANEL KIRI — hero dekoratif.
             Signature element: garis kontur berlapis bergaya peta topografi,
             merepresentasikan posisi geografis Ampel di lereng Gunung
             Merbabu, Boyolali — bukan gradient generik.
             ========================================================== --}}
        <div class="relative hidden overflow-hidden bg-primary-700 lg:flex lg:flex-col lg:justify-between lg:p-12">
            <svg class="pointer-events-none absolute inset-0 h-full w-full opacity-40" viewBox="0 0 600 800" preserveAspectRatio="none" aria-hidden="true">
                <defs>
                    <linearGradient id="contourFade" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="white" stop-opacity="0.35" />
                        <stop offset="100%" stop-color="white" stop-opacity="0.02" />
                    </linearGradient>
                </defs>
                @foreach ([820, 760, 700, 640, 580, 520, 460, 400] as $i => $y)
                    <path d="M -50 {{ $y }} C 120 {{ $y - 70 }}, 220 {{ $y + 40 }}, 340 {{ $y - 30 }} S 560 {{ $y + 50 }}, 700 {{ $y - 20 }}"
                          fill="none" stroke="url(#contourFade)" stroke-width="{{ $i === 0 ? 3 : 1.5 }}" />
                @endforeach
            </svg>

            <div class="relative z-10 flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="flex size-11 items-center justify-center rounded-full bg-white/15 text-white">
                        <x-icon name="landmark" class="size-6" />
                    </div>
                    <span class="text-sm font-medium text-white">Kab. Boyolali</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex size-11 items-center justify-center rounded-full bg-white/15 text-white">
                        <x-icon name="building-2" class="size-6" />
                    </div>
                    <span class="text-sm font-medium text-white">Kec. Ampel</span>
                </div>
            </div>

            <div class="relative z-10 max-w-md">
                <h1 class="font-display text-3xl font-bold leading-tight text-white" style="font-family: var(--font-display);">
                    Sistem Informasi Kependudukan<br>Kecamatan Ampel
                </h1>
                <p class="mt-3 text-sm leading-relaxed text-white/80">
                    Satu platform terintegrasi untuk Operator Desa, Operator Kecamatan, Validator, Kepala
                    Desa, dan Camat dalam mengelola data Penduduk, Kartu Keluarga, dan Rumah secara
                    digital dan akuntabel.
                </p>
            </div>

            <div class="relative z-10 flex items-end justify-between" x-data="{ now: new Date() }" x-init="setInterval(() => now = new Date(), 1000)">
                <div>
                    <p class="font-mono text-3xl font-semibold tracking-wide text-white" style="font-family: var(--font-mono);" x-text="now.toLocaleTimeString('id-ID')"></p>
                    <p class="text-sm text-white/80" x-text="now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })"></p>
                </div>
                <div class="flex items-center gap-2 rounded-2xl bg-white/10 px-4 py-2.5 text-white backdrop-blur-sm">
                    <x-icon name="cloud-sun" class="size-5" />
                    <div class="text-sm leading-tight">
                        <p class="font-semibold">Boyolali, 27°C</p>
                        <p class="text-white/70">Cerah berawan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==========================================================
             PANEL KANAN — form login.
             ========================================================== --}}
        <div class="flex flex-col bg-[var(--bg)] px-6 py-8 sm:px-12 lg:px-16">
            <div class="flex items-center justify-between lg:justify-end">
                <div class="flex items-center gap-2 lg:hidden">
                    <div class="flex size-9 items-center justify-center rounded-full bg-primary-600 text-white">
                        <x-icon name="landmark" class="size-5" />
                    </div>
                    <span class="text-sm font-medium">Kec. Ampel</span>
                </div>
                <button type="button" x-data @click="$store.theme.toggle()" class="flex size-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5" aria-label="Ganti tema">
                    <x-icon name="moon" class="size-5" x-show="!$store.theme.dark" x-cloak />
                    <x-icon name="sun" class="size-5" x-show="$store.theme.dark" x-cloak />
                </button>
            </div>

            <div class="m-auto w-full max-w-sm">
                <div class="glass-panel rounded-card p-8">
                    <h2 class="font-display text-xl font-bold" style="font-family: var(--font-display);">Selamat Datang</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Masuk dengan akun yang diberikan oleh administrator kecamatan/desa Anda.
                    </p>

                    @if ($errors->any())
                        <div class="mt-4 rounded-xl bg-danger-500/10 px-4 py-3 text-sm text-danger-600 dark:text-danger-400">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5" novalidate>
                        @csrf

                        <div>
                            <label for="identifier" class="text-sm font-medium text-slate-700 dark:text-slate-200">Username atau Email</label>
                            <input
                                id="identifier" name="identifier" type="text" autocomplete="username"
                                value="{{ old('identifier') }}" placeholder="contoh: operator.ampel"
                                class="mt-1.5 flex h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 text-sm shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('identifier') border-danger-500 @enderror"
                            >
                            @error('identifier')
                                <p class="mt-1 text-xs text-danger-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div x-data="{ show: false }">
                            <label for="password" class="text-sm font-medium text-slate-700 dark:text-slate-200">Password</label>
                            <div class="relative mt-1.5">
                                <input
                                    id="password" name="password" :type="show ? 'text' : 'password'" autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="flex h-10 w-full rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 pr-10 text-sm shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('password') border-danger-500 @enderror"
                                >
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600" aria-label="Tampilkan/sembunyikan password">
                                    <x-icon name="eye" class="size-4" x-show="!show" />
                                    <x-icon name="eye-off" class="size-4" x-show="show" x-cloak />
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-danger-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700 dark:text-slate-200">Verifikasi keamanan</label>
                            <div class="mt-1.5 flex items-center gap-2">
                                <div class="flex h-10 min-w-[6.5rem] items-center justify-center rounded-xl border border-[var(--border)] bg-slate-50 px-3 font-display text-base font-semibold tracking-wide select-none dark:bg-white/5" style="font-family: var(--font-display);">
                                    {{ $challenge['a'] }} + {{ $challenge['b'] }} = ?
                                </div>
                                <input
                                    id="captcha_answer" name="captcha_answer" inputmode="numeric" placeholder="Hasil"
                                    class="h-10 w-24 rounded-xl border border-[var(--border)] bg-[var(--card-bg)] px-3.5 py-2 text-sm shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 @error('captcha_answer') border-danger-500 @enderror"
                                >
                                <button type="submit" form="refresh-captcha-form" class="flex size-10 items-center justify-center rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-white/5" aria-label="Ganti soal" title="Muat ulang soal">
                                    <x-icon name="refresh-cw" class="size-4" />
                                </button>
                            </div>
                            @error('captcha_answer')
                                <p class="mt-1 text-xs text-danger-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                                <input type="checkbox" name="remember" value="1" class="size-4 rounded border-[var(--border)]">
                                Ingat saya
                            </label>
                            <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline">Lupa password?</a>
                        </div>

                        <button type="submit" class="flex h-12 w-full items-center justify-center gap-2 rounded-xl bg-primary-600 text-base font-medium text-white shadow-sm transition-colors hover:bg-primary-700">
                            <x-icon name="log-out" class="size-4" />
                            Masuk
                        </button>
                    </form>

                    {{-- Form kosong khusus tombol "ganti soal" captcha — submit GET ke
                         /login akan men-generate soal baru tanpa mengirim password. --}}
                    <form id="refresh-captcha-form" method="GET" action="{{ route('login') }}" class="hidden"></form>
                </div>

                <p class="mt-8 text-center text-xs text-slate-400">
                    © {{ now()->year }} Pemerintah Kabupaten Boyolali — Kecamatan Ampel.
                    <br>Seluruh aktivitas pada sistem ini tercatat dalam log audit.
                </p>
            </div>
        </div>
    </div>
</x-layouts.guest>
