<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-6">
                    <div class="single-footer f-about">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('assets/images/logo/logo1-horizontal.png') }}" alt="#" style="width: 40px; height: 40px;">
                            </a>
                        </div>
                        <p>Pusat Bantuan Sosial dan Pemanfaatan Bina Desa</p>
                        <ul class="social">
                            <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a></li>
                        </ul>
                        <p class="copyright-text">Designed and Developed by <a href="https://uideck.com/" rel="nofollow" target="_blank">UIdeck</a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-8 col-md-8 col-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-6">
                            <div class="single-footer f-link">
                                <h3>Menu</h3>
                                <ul>            
                                    <li><a href="javascript:void(0)">Beranda</a></li>
                                    <li><a href="javascript:void(0)">Data Master</a></li>
                                    <li><a href="javascript:void(0)">Penyaluran</a></li>
                                    <li><a href="javascript:void(0)">Tentang Kami</a></li>
                                </ul>
                            </div>
                        </div>

                      <div class="col-lg-3 col-md-6 col-6">
                            <div class="single-footer f-contact">
                                <h3>Hubungi Kami</h3>
                                <ul>
                                    <li>
                                        <i class="lni lni-phone"></i>
                                        <span>+62 812-3456-7890</span>
                                    </li>
                                    <li>
                                        <i class="lni lni-envelope"></i>
                                        <span><a href="mailto:admin@bansos.com" class="text-white">admin@bansos.com</a></span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-6">
                            <div class="single-footer f-link">
                                <h3>Identitas Pengembang</h3>
                                <div class="developer-card mt-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <img src="{{ asset('assets\images\footer\fotopengembang.jpg') }}" 
                                             alt="Foto Pengembang" 
                                             class="rounded-circle me-3 border border-white"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                        
                                        <div class="text-white">
                                            <h6 class="text-white mb-0 fw-bold">Nailah Houra Disanova</h6>
                                            <span class="d-block text-white-50" style="font-size: 13px;">NIM: 2457301108</span>
                                            <span class="d-block text-white-50" style="font-size: 13px;">Sistem Informasi</span>
                                            <span class="d-block text-white-50" style="font-size: 13px;">Politeknik Caltex Riau</span>
                                        </div>
                                    </div>
                                    
                                    <div class="dev-social">
                                        <a href="https://github.com/username-kamu" target="_blank" class="me-2 text-white" title="GitHub">
                                            <i class="lni lni-github-original" style="font-size: 24px;"></i>
                                        </a>
                                        <a href="https://instagram.com/username-kamu" target="_blank" class="text-white" title="Instagram">
                                            <i class="lni lni-instagram-original" style="font-size: 24px;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
    <a href="https://wa.me/6281234567890?text=Halo%20Admin..."
        class="float-whatsapp" target="_blank" title="Hubungi kami di WhatsApp">
        <i class="fab fa-whatsapp my-float"></i>
    </a>

    <style>
        /* Style Existing */
        .float-whatsapp {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            right: 40px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 3px #999;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        .float-whatsapp:hover {
            background-color: #128C7E;
            transform: scale(1.1);
        }

        .my-float {
            margin-top: 16px;
        }

        /* Style Tambahan untuk Developer Icon Hover */
        .dev-social a:hover i {
            color: #ff69b4; /* Warna hijau saat di hover */
            transition: 0.3s;
        }
    </style>

</footer>