<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        /* CSS tambahan agar konten berada di tengah vertikal */
        body,
        html {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f4f7f6;
            /* Warna latar belakang lembut */
        }
    </style>
</head>

<body>

    {{-- KODE INTI ANDA DIMULAI DARI SINI --}}
    <section id="features" class="features section">
        <div class="container">
            {{-- SECTION TITLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h3 class="wow zoomIn" data-wow-delay=".2s">Akses Terbatas</h3>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Selamat Datang Kembali</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">Silakan masuk menggunakan email dan password Anda
                            untuk mengelola data.</p>
                    </div>
                </div>
            </div>

            {{-- FORM LOGIN --}}
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-20 col-20  ">
                    <div class="card shadow-sm wow fadeInUp" data-wow-delay=".8s">
                        <div class="card-body p-4 p-md-5">

                            @if (session('status'))
                                <div class="alert alert-success mb-4">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{-- Menampilkan error validasi umum jika ada --}}
                            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                                <div class="alert alert-danger">
                                    Terjadi kesalahan. Silakan coba lagi.
                                </div>
                            @endif


                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Field Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label"><strong>Alamat Email:</strong></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Field Password --}}
                                <div class="mb-4">
                                    <label for="password" class="form-label"><strong>Password:</strong></label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Baris untuk "Ingat Saya" dan "Lupa Password" --}}
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Ingat Saya
                                        </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a class="small" href="{{ route('password.request') }}">
                                            Lupa Password?
                                        </a>
                                    @endif
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Masuk</button>
                                </div>
                                {{-- Link ke Halaman Registrasi --}}
                                <div class="text-center mt-3">
                                    <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar di
                                            sini</a></p>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- KODE INTI ANDA BERAKHIR DI SINI --}}


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <script src="{{ asset('assets/js/wow.min.js') }}"></script>

    <script>
        new WOW().init();
    </script>

</body>

</html>
