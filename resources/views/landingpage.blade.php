<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetaTani Nusantara - Bertani Cerdas Bersama Komunitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
        /* .hero-bg styling is handled in style.css or via Tailwind */
        section .title {
            font-size: 2.2em; /* Styled title class */
            font-weight: 700;
            margin-bottom: 15px;
            text-align: center; /* This rule is already set to center the text */
        }
        .card-group .card button {
            background-color: var(--color-primary); /* Dark Green button */
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
            font-size: 1em;
            margin-top: 20px; /* Space above button */
        }
        .card-group .card button:hover {
             background-color: #0b3a12; /* Darker green */
        }
        /* Learning Section */
        /* Recommendation Section */
        /* Testimonials Section */
        #join-us .container {
            text-align: center;
        }
        #join-us h2 {
            color: var(--color-primary); /* Dark Green */
            margin-bottom: 20px; /* More space */
            font-size: 2.5em; /* Larger heading */
        }
        #join-us p {
             font-size: 1.2em; /* Larger paragraph */
            color: #555;
            margin-bottom: 40px;
             max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        #join-us .btn,
        #join-us .btn-secondary {
             font-size: 1.1em;
             padding: 14px 30px;
             border-radius: 5px;
             text-decoration: none;
             font-weight: 600;
             margin: 0 10px;
             transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
             display: inline-block;
        }
        #join-us .btn {
             background-color: var(--color-primary); /* Dark Green */
            color: #fff;
            border: 2px solid var(--color-primary);
        }
        #join-us .btn:hover {
            background-color: #0b3a12; /* Darker green */
            border-color: #0b3a12;
        }
        #join-us .btn-secondary {
             background-color: transparent;
            color: var(--color-primary); /* Dark Green text */
            border: 2px solid var(--color-primary); /* Dark Green border */
        }
        #join-us .btn-secondary:hover {
            background-color: var(--color-primary); /* Dark Green background */
            color: #fff; /* White text */
        }
        /* Footer Styling */
    </style>
</head>
<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="navbar-brand">
            <img src="{{ asset('img/peta.png') }}" class="w-8 h-8" alt="Logo">
            <span>PetaTani Nusantara</span>
        </div>
        <div class="nav-right">
            <ul class="nav-links">
                <li><a href="#features">Fitur</a></li>
                <li><a href="#community">Komunitas</a></li>
                <li><a href="#testimonials">Testimoni</a></li>
                <li><a href="#news">News/Berita</a></li>
            </ul>
            <div class="nav-utilities">
                <div class="search-box">
                    <input type="text" placeholder="Search..." class="search-input">
                    <a href="#" aria-label="Search" class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </a>
                </div>
                <a href="https://wa.me/6285294939357" class="btn btn-compact">
                    <span>Call Anytime</span><br />
                    <span>+62 852 9493 9357</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-bg h-screen flex items-center px-12 bg-cover bg-center relative">
        <div class="container text-left">
            <h3 class="uppercase text-sm tracking-widest mb-2">Welcome to Agriculture Farm</h3>
            <h1 class="text-left text-5xl md:text-6xl font-bold leading-tight">Agriculture</h1>
            <h1 class="text-left text-5xl md:text-6xl font-bold leading-tight">& Smart Farming</h1>
            <p class="mt-4 text-white/90">There are many of passages of lorem Ipsum, but the majori have suffered alteration in some form.</p>
            <button class="mt-6 btn" onclick="window.location.href = '{{ route('login') }}'">
                Login/Register
            </button>
        </div>
    </section>

    <!-- 3. Fitur Unggulan -->
    <section id="features">
        <div class="container">
            <div class="tagline">Fitur Unggulan</div>
            <h1>Belajar Bertani Dengan <span class="highlight">Cara Yang Lebih Modern</span></h1>
            <p class="subtitle">
              Dengan pendekatan modern dan teknologi terkini, kami hadir untuk membantu petani Indonesia mengembangkan potensi mereka. Mulai dari pemetaan lahan, prediksi cuaca, hingga forum diskusi antarpetani — semua fitur kami dirancang agar proses belajar dan bertani jadi lebih praktis, efisien, dan menyenangkan.
            </p>

            <div class="features">
              <div class="card">
                <div class="card-icon">
                  <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Peta Lahan</h3>
                <p>Pemetaan lahan interaktif berbasis WebGIS.</p>
              </div>
              <div class="card">
                <div class="card-icon">
                  <i class="fas fa-cloud-sun-rain"></i>
                </div>
                <h3>Prediksi Cuaca</h3>
                <p>Bantu petani merencanakan musim tanam.</p>
              </div>
              <div class="card">
                <div class="card-icon">
                  <i class="fas fa-bug"></i>
                </div>
                <h3>Laporan Hama & Penyakit</h3>
                <p>Laporkan dan lihat daerah rawan.</p>
              </div>
              <div class="card">
                <div class="card-icon">
                  <i class="fas fa-users"></i>
                </div>
                <h3>Komunitas Supportif</h3>
                <p>Tanya jawab antar petani se-Indonesia.</p>
              </div>
            </div>
        </div>
    </section>

    <!-- 4. Komunitas Kami -->
    <section id="community">
        <div class="container">
            <div class="title">Komunitas <span>Kami</span></div>
            <div class="subtitle">Bergabunglah dengan ribuan petani digital Indonesia yang saling membantu dan berbagi pengalaman.</div>
            <div class="card-group">
              <div class="card">
                <div class="card-icon">
                  <i class="fab fa-facebook"></i>
                </div>
                <h3>Facebook Group</h3>
                <p>Bergabunglah dengan grup Facebook kami untuk diskusi santai dan berbagi artikel menarik.</p>
                <a href="{{ route('login') }}" class="btn card-button">Gabung Sekarang</a>
              </div>
              <div class="card">
                <div class="card-icon">
                  <i class="fab fa-instagram"></i>
                </div>
                <h3>Instagram</h3>
                <p>Ikuti kami di Instagram untuk tips visual & update lapangan.</p>
                <a href="{{ route('login') }}" class="btn card-button">Follow Kami</a>
              </div>
              <div class="card">
                <div class="card-icon">
                  <i class="fab fa-discord"></i>
                </div>
                <h3>Discord Server</h3>
                <p>Bantuan langsung dari petani & pakar agar lebih interaktif dan dapat ilmu baru.</p>
                <a href="{{ route('login') }}" class="btn card-button">Join Server</a>
              </div>
            </div>
        </div>
    </section>

    

    <!-- 7. Testimoni -->
    <section id="testimonials">
        <div class="container">
            <h1>Testimoni <span>Petani</span></h1>
            <p class="subtitle">Apa kata mereka yang telah bergabung dengan komunitas PetaTani Nusantara?</p>
            <div class="testimonials">
              <div class="card">
                <p>"Dulu saya bingung mau tanam apa. Sekarang, pakai platform ini, saya bisa lihat rekomendasi lahan saya cocoknya untuk jagung!"</p>
                <div class="profile">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1fm-Z3OXciw55O5upNrpjwcktDnVIkXz0lA&s" alt="Pak Wawan">
                  <div class="profile-text">
                    <strong>Pak Wawan</strong>
                    <span>Petani Subang</span>
                  </div>
                </div>
              </div>
              <div class="card">
                <p>"Forum petaninya aktif banget. Bisa tanya tentang pupuk, hama, sampai jualan hasil panen!"</p>
                <div class="profile">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZF78LEUKsHm_cSJ-6-Yf7BYF0gKLPvcI9JA&s" alt="Bu Retno">
                  <div class="profile-text">
                    <strong>Bu Retno</strong>
                    <span>Petani Sayur</span>
                  </div>
                </div>
              </div>
               <div class="card">
                <p>"Fitur peta lahannya sangat informatif. Saya jadi tahu daerah mana saja yang cocok untuk komoditas tertentu."</p>
                <div class="profile">
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRAtG9XDKUXp5OHogXSgmHN4VPZL56BSUkn0zfRrFZWykYO2WYX_jN5zPeSn6HK3sITH8w&usqp=CAU" alt="Ibu Siti">
                  <div class="profile-text">
                    <strong>Ibu Siti</strong>
                    <span>Petani Hortikultura</span>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </section>

   <!-- 8. Berita Terbaru -->
<section id="news">
    <div class="container">
        <div class="tagline">Update Terbaru</div>
        <h2>Berita <span>Pertanian</span> Terkini</h2>
        <div class="news-list">
            <div class="news-item card">
                <img src="https://cdn.rri.co.id/berita/Sampang/o/1748355232603-1000844948/kglc9u5g9qmhusm.jpeg" alt="Smart Farming di Madura">
                <div class="news-content">
                    <h3>Smart Farming: Solusi Inovatif Pertanian Modern di Madura</h3>
                    <p>Dengan konsep smart farming, Bayu berharap dapat meningkatkan kualitas hidup masyarakat Madura melalui pemanfaatan teknologi dalam pertanian. Inisiatif ini juga diharapkan mampu memicu lahirnya inovasi dari putra daerah, menciptakan pertanian yang lebih efisien, produktif, dan berkelanjutan untuk masa depan Madura yang lebih maju.</p>
                    <a href="https://www.rri.co.id/iptek/1546010/smart-farming-solusi-inovatif-pertanian-modern-di-madura" class="read-more" target="_blank">Baca Selengkapnya</a>
                </div>
            </div>
            <div class="news-item card">
                <img src="https://storage.googleapis.com/pkg-portal-bucket/images/news/2024-11/tawangargo-smart-eco-farming-village-berhasil-ubah-pusat-hortikultura-desa-tawangargo-jadi-contoh-masa-depan-pertanian-berkelanjutan/IMG_SP_103_2024.jpeg" alt="Tawangargo Smart-Eco Farming Village">
                <div class="news-content">
                    <h3>Tawangargo Smart-Eco Farming Village Berhasil Ubah Pusat Hortikultura Desa Tawangargo Jadi Contoh Masa Depan Pertanian Berkelanjutan</h3>
                    <p>Desa Tawangargo, Kec. Karangploso, Kab. Malang, Jawa Timur kini telah bertransformasi menjadi pusat hortikultura modern dan ramah lingkungan melalui program Tawangargo Smart-Eco Farming Village (TAMENG).</p>
                    <a href="https://petrokimia-gresik.com/news/tawangargo-smart-eco-farming-village-berhasil-ubah-pusat-hortikultura-desa-tawangargo-jadi-contoh-masa-depan-pertanian-berkelanjutan?hl=en" class="read-more" target="_blank">Baca Selengkapnya</a>
                </div>
            </div>
            <div class="news-item card">
                <img src="https://mediabogor.co/wp-content/uploads/2024/04/IMG-20240419-WA0248-800x500.jpg" alt="IPB University dan Beyondsoft Dorong Pertanian Cerdas">
                <div class="news-content">
                    <h3>IPB University Luncurkan Drone Pertanian untuk Revolusi Agrikultur</h3>
                    <p>IPB University meluncurkan benih padi IPB 9 Garuda yang tahan hama, hemat pupuk dan air, serta cocok untuk lahan masam. Produktivitasnya tinggi, hingga 11 ton/ha. Benih ini mendukung pertanian ramah lingkungan dan telah bekerja sama dengan PRISMA untuk edukasi ke petani sejak 2021.</p>
                    <a href="https://sawitindonesia.com/tingkatkan-ekspor-pertanian-melalui-hilirisasi-sektor-pertanian/" class="read-more" target="_blank">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- 9. Ajakan Bergabung -->
    <section id="join-us">
        <div class="container">
            <h2>Bergabunglah dengan ribuan petani digital Indonesia</h2>
            <p>Belajar bersama, berbagi pengalaman, dan tingkatkan hasil pertanian.</p>
            <div>
                <a href="{{ route('login') }}" class="btn">Gabung Sekarang</a>
                <a href="#" class="btn btn-secondary">Jelajahi Peta Pertanian</a>
            </div>
        </div>
    </section>

    <!-- 9. Footer -->
    <footer>
        <div class="container">
            <p>© 2025 PetaTani Nusantara – Bertani Cerdas Bersama Komunitas</p>
        </div>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
