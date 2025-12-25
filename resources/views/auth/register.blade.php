<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Bantuan Sosial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background-color: #F53C5E;"> </body>
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden p-8 md:p-12">
        
        <div class="text-center mb-8">
            <div class="wow zoomIn inline-block mb-4" data-wow-delay=".2s">
                <img src="{{ asset('assets/images/logo/logo2-.png') }}" 
                     alt="Logo Aplikasi" 
                     class="max-h-[70px] w-auto mx-auto"> 
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Selamat Bergabung</h2>
            <p class="text-gray-500">Daftarkan akun Anda untuk mengakses sistem.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
                <p class="font-bold">Oops! Terjadi kesalahan:</p>
                <ul class="text-sm list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama sesuai KTP"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. KTP</label>
                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" placeholder="16 digit angka"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition" required>
                        <option value="">Pilih...</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Agama</label>
                    <select name="agama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition" required>
                        <option value="">Pilih...</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen Protestan">Kristen Protestan</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Khonghucu">Khonghucu</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: Buruh"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="telp" value="{{ old('telp') }}" placeholder="08xxxx"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Min. 8 karakter"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:outline-none transition" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition shadow-lg">
                Daftar 
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-8">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-black hover:underline">Masuk disini</a>
        </p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</body>
</html>