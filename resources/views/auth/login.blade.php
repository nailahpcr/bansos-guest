<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Bantuan Sosial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background-color: #F53C5E;">

    <div class="bg-white rounded-[2rem] shadow-2xl max-w-4xl w-full overflow-hidden flex flex-col md:flex-row animate__animated animate__fadeIn">
        
        {{-- Bagian Kiri: Form --}}
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            
            <div class="mb-8">
                <img src="{{ asset('assets/images/logo/logo2-.png') }}" 
                     alt="Logo" 
                     class="max-h-[70px] w-auto"> 
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang!</h2>
            <p class="text-gray-500 mb-8">Silakan masukkan detail Anda</p>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Masukkan password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:outline-none transition" required>
                </div>

                <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition shadow-lg mt-4">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-10">
                Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-black hover:underline">Daftar disini</a>
            </p>
        </div>

        {{-- Bagian Kanan: Gambar (Opsional untuk Login agar lebih estetik) --}}
        <div class="hidden md:block md:w-1/2 relative">
            <img src="{{ asset('assets/images/login/program9.jpg') }}" alt="Social Program" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute bottom-12 left-12 right-12 text-white">
                <h3 class="text-3xl font-bold leading-tight">Sistem Bantuan Sosial</h3>
            </div>
        </div>
    </div>

</body>
</html>