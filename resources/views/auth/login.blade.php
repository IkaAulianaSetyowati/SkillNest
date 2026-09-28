<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SkillNest</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-x-hidden">

    <!-- Ambient Background Glow -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-gradient-to-tr from-indigo-200/40 to-purple-200/40 rounded-full blur-3xl -z-10"></div>

    <!-- Main Container -->
    <div class="w-full max-w-4xl bg-white/85 backdrop-blur-xl rounded-3xl p-3 shadow-2xl shadow-indigo-100/50 border border-white/60 grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch">
        
        <!-- SISI KIRI: Banner Visual -->
        <div class="relative bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 rounded-2xl p-8 md:p-10 text-white flex flex-col justify-between overflow-hidden min-h-[380px] md:min-h-[500px]">
            
            <!-- Glow Shapes Background -->
            <div class="absolute -top-16 -left-16 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-16 -right-16 w-56 h-56 bg-purple-500/30 rounded-full blur-2xl"></div>

            <!-- Top Header Logo -->
            <a href="{{ url('/') }}" class="relative z-10 flex items-center gap-2.5 w-max">
                <div class="w-9 h-9 bg-white text-indigo-900 rounded-xl flex items-center justify-center font-black text-lg shadow-lg shadow-black/10">
                    S
                </div>
                <span class="text-xl font-extrabold tracking-tight">SkillNest</span>
            </a>

            <!-- Middle Illustration / Card Floating -->
            <div class="relative z-10 my-auto py-6">
                <!-- Floating Card Widget 1 -->
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl mb-4 shadow-xl transform -rotate-1 hover:rotate-0 transition duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-500/50 rounded-xl flex items-center justify-center text-white text-lg">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold">Belajar Tanpa Batas</p>
                            <p class="text-[10px] text-indigo-100/80">Ikuti webinar terbaik dari para ahli</p>
                        </div>
                    </div>
                </div>

                <!-- Floating Card Widget 2 -->
                <div class="bg-white/15 backdrop-blur-md border border-white/20 p-4 rounded-2xl shadow-xl ml-6 transform rotate-2 hover:rotate-0 transition duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-500/50 rounded-xl flex items-center justify-center text-white text-lg">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold">Komunitas Aktif</p>
                            <p class="text-[10px] text-purple-100/80">Terhubung dengan ribuan peserta lain</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Caption -->
            <div class="relative z-10">
                <h2 class="text-xl font-bold leading-tight">Selamat Datang Kembali</h2>
                <p class="text-xs text-indigo-100/80 mt-1">Masuk untuk melanjutkan perjalanan belajarmu.</p>
            </div>
        </div>

        <!-- SISI KANAN: Form Login -->
        <div class="p-6 sm:p-8 flex flex-col justify-center">
            
            <div class="mb-6">
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-3 shadow-inner">
                    <i class="fas fa-lock text-sm"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Masuk</h1>
                <p class="text-xs text-gray-500 mt-1.5 font-medium">Masukkan email dan kata sandi kamu</p>
            </div>

            <!-- Session Status Alert -->
            @if (session('status'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs text-emerald-700 flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-500"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Error Validation Alert -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 bg-red-50/80 border border-red-100 rounded-2xl text-xs text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center gap-1.5"><i class="fas fa-exclamation-circle text-red-500"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 text-xs">
                            <i class="far fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 bg-gray-50/80 border border-gray-200/80 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <label class="block text-xs font-bold text-gray-700">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400 text-xs">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-3 bg-gray-50/80 border border-gray-200/80 rounded-xl text-xs text-gray-800 placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition duration-200">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 text-xs focus:outline-none">
                            <i id="eye-icon" class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center text-gray-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 transition cursor-pointer">
                        <span class="ml-2 font-medium text-xs text-gray-600">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-indigo-200 active:scale-[0.99] transition duration-200 mt-2">
                    Masuk
                </button>
            </form>

            <!-- Link Daftar -->
            @if (Route::has('register'))
                <p class="text-center text-xs text-gray-500 mt-5">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Daftar di sini</a>
                </p>
            @endif

            <!-- Redirect Link Kembali ke Beranda -->
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-xs text-gray-500 hover:text-indigo-600 transition font-medium">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>

        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>