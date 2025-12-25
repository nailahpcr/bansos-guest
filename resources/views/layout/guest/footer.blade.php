<footer class="footer bg-dark text-white py-4">
    <div class="footer-top">
        <div class="container">
            <div class="row align-items-start">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="single-footer f-about">
                        <div class="logo mb-2">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/images/logo/logo1-horizontal.png') }}" alt="Logo"
                                    style="height: 40px; width: auto; object-fit: contain;">
                            </a>
                        </div>
                        <p class="text-white-50 small mb-0">Pusat Bantuan Sosial dan Pemanfaatan Bina Desa. Membantu
                            mewujudkan kesejahteraan masyarakat desa.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <div class="single-footer f-link">
                                <h6 class="text-white mb-2 fw-bold">Menu</h6>
                                <ul class="list-unstyled small">
                                    <li class="mb-1"><a href="#"
                                            class="text-white-50 text-decoration-none hover-white">Beranda</a></li>
                                    <li class="mb-1"><a href="#"
                                            class="text-white-50 text-decoration-none hover-white">Data Master</a></li>
                                    <li class="mb-1"><a href="#"
                                            class="text-white-50 text-decoration-none hover-white">Penyaluran</a></li>
                                    <li><a href="{{ route('about') }}"
                                            class="text-white-50 text-decoration-none hover-white">Tentang Kami</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="single-footer f-contact">
                                <h6 class="text-white mb-2 fw-bold">Kontak</h6>
                                <ul class="list-unstyled text-white-50 small">
                                    <li class="d-flex mb-1">
                                        <i class="lni lni-phone me-2 mt-1"></i>
                                        <span>+62 812-3456</span>
                                    </li>
                                    <li class="d-flex">
                                        <i class="lni lni-envelope me-2 mt-1"></i>
                                        <a href="mailto:SistemBansos@mail.com"
                                            class="text-white-50 text-decoration-none">SistemBansos@mail.com</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12 mb-3">
                    <div class="single-footer">
                        <h6 class="text-white mb-2 fw-bold">Identitas Pengembang</h6>
                        <div class="developer-card p-3 rounded border border-white border-opacity-10"
                            style="background-color: rgba(0, 0, 0, 0.2); backdrop-filter: blur(5px);">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('assets/images/footer/nnai4.jpg') }}" alt="Foto"
                                    class="rounded-circle me-3 border border-2 border-white shadow-sm"
                                    style="width: 75px; height: 75px; object-fit: cover;">
                                <div>
                                    <h6 class="text-white mb-1 fw-bold" style="letter-spacing: 0.5px;">Nailah Houra
                                        Disanova</h6>
                                    <small class="text-white-50 d-block mb-1"></i>
                                        2457301108</small>
                                    <small class="text-white-50 d-block mb-1"></i>
                                        Sistem Informasi</small>
                                    <small class="text-white-50 d-block"></i>
                                        Politeknik Caltex Riau</small>
                                </div>
                            </div>
                            <div class="dev-social d-flex gap-3 ps-1 mt-2">
                                <a href="https://github.com/nailahpcr" target="_blank"
                                    class="text-white-50 hover-pink fs-5"><i class="lni lni-github-original"></i></a>
                                <a href="https://www.instagram.com/nailahdisanova" target="_blank"
                                    class="text-white-50 hover-pink fs-5"><i class="lni lni-instagram-original"></i></a>
                                <a href="https://www.linkedin.com/in/nailah-houra-2461853a1" target="_blank"
                                    class="text-white-50 hover-pink fs-5"><i class="lni lni-linkedin-original"></i></a>
                                <a href="mailto:nailah24si@mahasiswa.pcr.ac.id" class="text-white-50 hover-pink fs-5"><i
                                        class="lni lni-envelope"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom py-2 border-top border-white border-opacity-10 mt-3">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-white-50 small">
                <p class="mb-0">&copy; <span id="currentYear"></span> <strong>SiBansos</strong>. All Rights Reserved.
                </p>
                <p class="mb-0" style="font-size: 10px;">Designed by UIdeck | Customized by Nailah</p>
            </div>
        </div>
    </div>

    <a href="https://wa.me/6281234567890" class="float-whatsapp shadow-lg" target="_blank">
        <i class="fab fa-whatsapp my-float"></i>
    </a>

    <style>
        .footer {
            background-color: #1a1a1a;
        }

        .hover-white:hover {
            color: #fff !important;
        }

        .hover-pink:hover i {
            color: #F53C5E !important;
            transform: translateY(-2px);
            transition: 0.3s;
        }

        .float-whatsapp {
            position: fixed;
            width: 50px;
            height: 50px;
            bottom: 30px;
            right: 30px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50px;
            text-align: center;
            font-size: 25px;
            z-index: 1000;
            transition: 0.3s;
        }

        .my-float {
            line-height: 50px;
        }

        .dev-social a {
            font-size: 1.1rem;
            transition: 0.3s;
            opacity: 0.8;
        }
    </style>

    <script>
        document.getElementById("currentYear").innerHTML = new Date().getFullYear();
    </script>
</footer>
