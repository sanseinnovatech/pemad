<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PEMAD - Platform E-commerce Modern</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: { 50:'#eff6ff',100:'#dbeafe',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',900:'#1e3a8a' },
            secondary: { 500:'#06b6d4',600:'#0891b2' }
          },
          animation: {
            'float':'float 6s ease-in-out infinite',
            'glow':'glow 2s ease-in-out infinite alternate',
            'slide-up':'slideUp 0.8s ease-out forwards',
            'fade-in':'fadeIn 1s ease-out forwards',
          },
          keyframes: {
            float:{ '0%,100%':{transform:'translateY(0px)'}, '50%':{transform:'translateY(-20px)'} },
            glow:{ '0%':{boxShadow:'0 0 20px rgba(59,130,246,0.5)'}, '100%':{boxShadow:'0 0 30px rgba(59,130,246,0.8)'} },
            slideUp:{ '0%':{opacity:'0',transform:'translateY(50px)'}, '100%':{opacity:'1',transform:'translateY(0)'} },
            fadeIn:{ '0%':{opacity:'0'}, '100%':{opacity:'1'} }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-50 overflow-x-hidden">
  <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-lg border-b border-gray-200/50" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
            <i class="fas fa-shopping-bag text-white text-lg"></i>
          </div>
          <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">PEMAD</span>
        </div>
        <div class="hidden md:flex items-center space-x-8">
          <a href="#home" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Home</a>
          <a href="#products" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Products</a>
          <a href="#about" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">About</a>
          <a href="#contact" class="text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Contact</a>
          <a href="/login" class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-2 rounded-full hover:shadow-lg hover:scale-105 transition-all duration-300 font-medium">
            <i class="fas fa-sign-in-alt mr-2"></i>Login
          </a>
        </div>
        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
          </button>
        </div>
      </div>
      <div id="mobile-menu" class="md:hidden hidden bg-white/95 backdrop-blur-lg border-t border-gray-200/50 absolute left-0 right-0 top-16">
        <div class="px-4 py-6 space-y-4">
          <a href="#home" class="block text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Home</a>
          <a href="#products" class="block text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Products</a>
          <a href="#about" class="block text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">About</a>
          <a href="#contact" class="block text-gray-700 hover:text-blue-600 transition-colors duration-300 font-medium">Contact</a>
          <a href="/login" class="block bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-full text-center font-medium">
            <i class="fas fa-sign-in-alt mr-2"></i>Login
          </a>
        </div>
      </div>
    </div>
  </nav>

  <section id="home" class="relative min-h-screen flex items-center bg-gradient-to-br from-blue-600 via-purple-600 to-cyan-500 overflow-hidden">
    <div class="absolute inset-0">
      <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float"></div>
      <div class="absolute bottom-20 right-10 w-96 h-96 bg-cyan-400/10 rounded-full blur-3xl animate-float" style="animation-delay:-3s;"></div>
      <div class="absolute top-1/2 left-1/3 w-48 h-48 bg-purple-400/10 rounded-full blur-2xl animate-float" style="animation-delay:-1.5s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="text-white space-y-8 animate-slide-up">
          <div class="space-y-4">
            <h1 class="text-5xl lg:text-7xl font-bold leading-tight">
              Belanja <span class="block bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Mudah</span>
              <span class="block text-4xl lg:text-5xl">Hidup Lebih Smart</span>
            </h1>
            <p class="text-xl lg:text-2xl text-blue-100 leading-relaxed">
              Temukan produk terbaik dengan harga terjangkau. Platform e-commerce modern yang mengutamakan kepuasan pelanggan.
            </p>
          </div>

          <div class="flex flex-col sm:flex-row gap-4">
            <a href="#products" class="group bg-white text-blue-600 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-50 transition-all duration-300 hover:scale-105 hover:shadow-2xl flex items-center justify-center">
              <i class="fas fa-shopping-bag mr-3 group-hover:scale-110 transition-transform duration-300"></i> Mulai Belanja
            </a>
            <a href="#about" class="group border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-blue-600 transition-all duration-300 flex items-center justify-center">
              <i class="fas fa-play mr-3 group-hover:scale-110 transition-transform duration-300"></i> Pelajari Lebih
            </a>
          </div>

          <div class="grid grid-cols-3 gap-8 pt-8">
            <div class="text-center"><div class="text-3xl font-bold text-yellow-400">10K+</div><div class="text-blue-200">Customers</div></div>
            <div class="text-center"><div class="text-3xl font-bold text-yellow-400">500+</div><div class="text-blue-200">Products</div></div>
            <div class="text-center"><div class="text-3xl font-bold text-yellow-400">99%</div><div class="text-blue-200">Satisfaction</div></div>
          </div>
        </div>

        <div class="relative animate-fade-in" style="animation-delay:.5s;">
          <div class="relative z-10">
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
              <div class="grid grid-cols-2 gap-4">
                <div class="bg-white/20 rounded-2xl p-6 animate-float"><i class="fas fa-laptop text-4xl text-white mb-4"></i><div class="text-white font-semibold">Electronics</div></div>
                <div class="bg-white/20 rounded-2xl p-6 animate-float" style="animation-delay:-1s;"><i class="fas fa-tshirt text-4xl text-white mb-4"></i><div class="text-white font-semibold">Fashion</div></div>
                <div class="bg-white/20 rounded-2xl p-6 animate-float" style="animation-delay:-2s;"><i class="fas fa-home text-4xl text-white mb-4"></i><div class="text-white font-semibold">Home</div></div>
                <div class="bg-white/20 rounded-2xl p-6 animate-float" style="animation-delay:-3s;"><i class="fas fa-gamepad text-4xl text-white mb-4"></i><div class="text-white font-semibold">Gaming</div></div>
              </div>
            </div>
          </div>
          <div class="absolute -top-6 -right-6 w-12 h-12 bg-yellow-400 rounded-full animate-glow"></div>
          <div class="absolute -bottom-4 -left-4 w-8 h-8 bg-cyan-400 rounded-full animate-glow" style="animation-delay:-1s;"></div>
        </div>
      </div>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
      <a href="#about" class="text-white hover:text-yellow-400 transition-colors duration-300"><i class="fas fa-chevron-down text-2xl"></i></a>
    </div>
  </section>

  <section id="about" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 opacity-0 animate-slide-up" data-animate>
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">Mengapa Memilih <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">PEMAD?</span></h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Platform belanja online terpercaya dengan berbagai keunggulan yang memberikan pengalaman terbaik</p>
      </div>

      <div class="grid lg:grid-cols-3 gap-8">
        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-200 opacity-0 animate-slide-up" data-animate>
          <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300"><i class="fas fa-shipping-fast text-2xl text-white"></i></div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Pengiriman Cepat</h3>
          <p class="text-gray-600 leading-relaxed">Pengiriman express ke seluruh Indonesia dengan jaminan barang sampai tepat waktu dan aman. Lacak paket real-time.</p>
          <div class="mt-6 flex items-center text-blue-600 font-semibold group-hover:translate-x-2 transition-transform duration-300"><span>Pelajari lebih</span><i class="fas fa-arrow-right ml-2"></i></div>
        </div>

        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-200 opacity-0 animate-slide-up" data-animate style="animation-delay:.2s;">
          <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300"><i class="fas fa-shield-alt text-2xl text-white"></i></div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Pembayaran Aman</h3>
          <p class="text-gray-600 leading-relaxed">Sistem pembayaran aman dengan berbagai metode modern dan enkripsi tingkat tinggi.</p>
          <div class="mt-6 flex items-center text-green-600 font-semibold group-hover:translate-x-2 transition-transform duration-300"><span>Pelajari lebih</span><i class="fas fa-arrow-right ml-2"></i></div>
        </div>

        <div class="group bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-200 opacity-0 animate-slide-up" data-animate style="animation-delay:.4s;">
          <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300"><i class="fas fa-headset text-2xl text-white"></i></div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Customer Service 24/7</h3>
          <p class="text-gray-600 leading-relaxed">Tim support siap membantu kapan saja dengan respon cepat.</p>
          <div class="mt-6 flex items-center text-purple-600 font-semibold group-hover:translate-x-2 transition-transform duration-300"><span>Pelajari lebih</span><i class="fas fa-arrow-right ml-2"></i></div>
        </div>
      </div>
    </div>
  </section>

  <section id="products" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="text-center mb-10 opacity-0 animate-slide-up" data-animate>
        <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
          Produk <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Kami</span>
        </h2>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">Semua kebutuhan Anda, di satu tempat.</p>
      </div>

      <div id="filters-panel" class="mb-8 bg-white/80 backdrop-blur border border-gray-200 rounded-2xl p-4 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
          <div class="md:col-span-3">
            <label for="f-search" class="block text-xs font-semibold text-gray-600 mb-1">Nama Produk</label>
            <input id="f-search" type="text" placeholder="Cari nama..."
                   class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">
          </div>

          <div class="md:col-span-3">
            <label for="f-category" class="block text-xs font-semibold text-gray-600 mb-1">Kategori</label>
            <select id="f-category"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">
              <option value="">Semua Kategori</option>
            </select>
          </div>

          <div class="md:col-span-2">
            <label for="f-min-price" class="block text-xs font-semibold text-gray-600 mb-1">Harga Min</label>
            <input id="f-min-price" type="number" min="0" placeholder="0"
                   class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">
          </div>
          <div class="md:col-span-2">
            <label for="f-max-price" class="block text-xs font-semibold text-gray-600 mb-1">Harga Max</label>
            <input id="f-max-price" type="number" min="0" placeholder="1000000"
                   class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">
          </div>
          <div class="md:col-span-2">
            <label for="f-min-rating" class="block text-xs font-semibold text-gray-600 mb-1">Rating Minimal</label>
            <select id="f-min-rating"
                    class="w-full rounded-xl border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2">
              <option value="">Semua</option>
              <option value="3">3+</option>
              <option value="4">4+</option>
              <option value="4.5">4.5+</option>
            </select>
          </div>
        </div>

        <div class="mt-3 flex items-center justify-end gap-2">
          <button id="btn-reset" class="px-4 py-2 text-sm rounded-xl border border-gray-300 hover:bg-gray-50">
            Reset
          </button>
          <button id="btn-apply" class="px-4 py-2 text-sm rounded-xl bg-blue-600 text-white hover:bg-blue-700">
            Terapkan
          </button>
        </div>
      </div>

      <div id="products-grid" class="grid lg:grid-cols-4 md:grid-cols-2 gap-8">
        <template id="product-skeleton">
          <div class="animate-pulse bg-gray-50 rounded-3xl overflow-hidden border border-gray-100">
            <div class="h-52 bg-gray-200"></div>
            <div class="p-6 space-y-3">
              <div class="h-5 bg-gray-200 rounded w-3/4"></div>
              <div class="h-4 bg-gray-200 rounded w-1/2"></div>
              <div class="h-6 bg-gray-200 rounded w-1/3"></div>
            </div>
          </div>
        </template>
      </div>
      <div id="products-pager" class="mt-6 flex items-center justify-center gap-2 text-sm text-gray-600"></div>

    </div>
  </section>
  <section class="py-20 bg-gradient-to-r from-gray-900 to-blue-900 relative overflow-hidden">
    <div class="absolute inset-0">
      <div class="absolute top-10 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-xl"></div>
      <div class="absolute bottom-10 right-10 w-48 h-48 bg-purple-500/20 rounded-full blur-xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="opacity-0 animate-slide-up" data-animate>
        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">Siap Untuk Memulai <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Belanja?</span></h2>
        <p class="text-xl text-gray-300 mb-8 leading-relaxed">Bergabung dengan ribuan customer yang sudah merasakan pengalaman terbaik dengan PEMAD</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="/register" class="bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 px-8 py-4 rounded-full font-bold text-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 inline-flex items-center justify-center">
            <i class="fas fa-user-plus mr-3"></i> Daftar Sekarang
          </a>
          <a href="#products" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-gray-900 transition-all duration-300 inline-flex items-center justify-center">
            <i class="fas fa-shopping-bag mr-3"></i> Explore Products
          </a>
        </div>
      </div>
    </div>
  </section>

  <footer id="contact" class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8">
        <div class="lg:col-span-2">
          <div class="flex items-center space-x-3 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
              <i class="fas fa-shopping-bag text-white text-xl"></i>
            </div>
            <span class="text-3xl font-bold bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">PEMAD</span>
          </div>
          <p class="text-gray-300 leading-relaxed mb-6 max-w-md">Platform e-commerce modern yang menghadirkan pengalaman belanja online terbaik untuk semua kebutuhan Anda.</p>
          <div class="flex space-x-4">
            <a href="#" class="w-12 h-12 bg-blue-600 hover:bg-blue-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="w-12 h-12 bg-cyan-600 hover:bg-cyan-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110"><i class="fab fa-twitter"></i></a>
            <a href="#" class="w-12 h-12 bg-pink-600 hover:bg-pink-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110"><i class="fab fa-instagram"></i></a>
            <a href="#" class="w-12 h-12 bg-purple-600 hover:bg-purple-500 rounded-xl flex items-center justify-center transition-all duration-300 hover:scale-110"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>

        <div>
          <h3 class="text-xl font-bold mb-6 text-blue-400">Quick Links</h3>
          <ul class="space-y-3">
            <li><a href="#home" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-sm"></i>Home</a></li>
            <li><a href="#products" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-sm"></i>Products</a></li>
            <li><a href="#about" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-sm"></i>About</a></li>
            <li><a href="#contact" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right mr-2 text-sm"></i>Contact</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-xl font-bold mb-6 text-blue-400">Support</h3>
          <ul class="space-y-3">
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-question-circle mr-2"></i>Help Center</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-shipping-fast mr-2"></i>Shipping Info</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-undo mr-2"></i>Returns</a></li>
            <li><a href="#" class="text-gray-300 hover:text-white transition-colors duration-300 flex items-center"><i class="fas fa-search mr-2"></i>Track Order</a></li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-700 mt-12 pt-8">
        <div class="grid md:grid-cols-3 gap-6">
          <div class="flex items-center space-x-3"><div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center"><i class="fas fa-map-marker-alt"></i></div><div><div class="font-semibold">Address</div><div class="text-gray-300">Jakarta, Indonesia</div></div></div>
          <div class="flex items-center space-x-3"><div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center"><i class="fas fa-phone"></i></div><div><div class="font-semibold">Phone</div><div class="text-gray-300">+62 123 456 789</div></div></div>
          <div class="flex items-center space-x-3"><div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center"><i class="fas fa-envelope"></i></div><div><div class="font-semibold">Email</div><div class="text-gray-300">info@pemad.com</div></div></div>
        </div>
      </div>

      <div class="border-t border-gray-700 mt-8 pt-8 text-center">
        <p class="text-gray-400">&copy; 2025 PEMAD. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <button id="back-to-top" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 opacity-0 invisible">
    <i class="fas fa-chevron-up"></i>
  </button>

  <div id="product-modal" class="fixed inset-0 z-[100] hidden">
    <div class="absolute inset-0 bg-black/60" id="pm-backdrop"></div>
    <div class="relative max-w-3xl mx-auto my-10 bg-white rounded-2xl shadow-xl overflow-hidden">
      <button id="pm-close" class="absolute top-3 right-3 w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center">
        <i class="fas fa-times"></i>
      </button>

      <div class="grid md:grid-cols-2 gap-0">
        <div class="bg-gray-50">
          <img id="pm-image" src="" alt="" class="w-full h-full max-h-[360px] object-cover">
        </div>
        <div class="p-6">
          <h3 id="pm-name" class="text-xl font-bold text-gray-900 mb-2">Nama Produk</h3>
          <div class="flex items-center text-yellow-400 text-sm mb-2" id="pm-stars"></div>
          <div id="pm-price" class="text-2xl font-extrabold text-blue-600 mb-3">Rp 0</div>
          <div class="text-sm text-gray-600 mb-3" id="pm-stock"><i class="fas fa-box mr-1.5"></i> Stok: -</div>
          <div class="text-sm text-gray-600 mb-1" id="pm-category"><i class="fas fa-tags mr-1.5"></i> Kategori: -</div>
          <p id="pm-desc" class="text-sm text-gray-700 mt-3 max-h-40 overflow-auto"></p>
          <div class="mt-5 flex items-center gap-3">
            <a id="pm-wa" target="_blank" rel="noopener"
               class="inline-flex items-center px-4 py-2 rounded-xl bg-green-600 text-white hover:bg-green-700">
              <i class="fab fa-whatsapp mr-2"></i> Order via WhatsApp
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
  if (!window.__PEMAD_INIT__) {
    window.__PEMAD_INIT__ = true;

    document.addEventListener('DOMContentLoaded', () => {
      'use strict';

      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');
      mobileMenuButton?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        const icon = mobileMenuButton.querySelector('i');
        icon.classList.toggle('fa-bars'); icon.classList.toggle('fa-times');
      });

      window.addEventListener('scroll', () => {
        const navbar = document.getElementById('navbar');
        const backToTop = document.getElementById('back-to-top');
        if (window.scrollY > 100) {
          navbar.classList.add('bg-white/95','shadow-lg'); navbar.classList.remove('bg-white/90');
          backToTop.classList.remove('opacity-0','invisible'); backToTop.classList.add('opacity-100','visible');
        } else {
          navbar.classList.remove('bg-white/95','shadow-lg'); navbar.classList.add('bg-white/90');
          backToTop.classList.add('opacity-0','invisible'); backToTop.classList.remove('opacity-100','visible');
        }
      });

      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          if (this.getAttribute('href') === '#') return;
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({ behavior:'smooth', block:'start' });
            mobileMenu.classList.add('hidden');
            const icon = mobileMenuButton?.querySelector('i'); icon?.classList.add('fa-bars'); icon?.classList.remove('fa-times');
          }
        });
      });

      document.getElementById('back-to-top')?.addEventListener('click', () => window.scrollTo({ top:0, behavior:'smooth' }));

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) { entry.target.style.opacity='1'; entry.target.style.transform='translateY(0)'; } });
      }, { threshold:0.1, rootMargin:'0px 0px -50px 0px' });
      document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));

      window.addEventListener('load', () => { document.body.style.opacity='0'; document.body.style.transition='opacity .5s ease'; setTimeout(()=>{ document.body.style.opacity='1'; }, 100); });
      window.addEventListener('scroll', () => { const s=window.pageYOffset, hero=document.getElementById('home'); if (hero) hero.style.transform = `translateY(${s * -0.5}px)`; });

      const GRID   = document.getElementById('products-grid');
      const PAGER  = document.getElementById('products-pager');
      const TPL    = document.getElementById('product-skeleton');
      const API_URL = "{{ url('/api/products') }}";

      const F_SEARCH     = document.getElementById('f-search');
      const F_CATEGORY   = document.getElementById('f-category');
      const F_MIN_PRICE  = document.getElementById('f-min-price');
      const F_MAX_PRICE  = document.getElementById('f-max-price');
      const F_MIN_RATING = document.getElementById('f-min-rating');
      const BTN_APPLY    = document.getElementById('btn-apply');
      const BTN_RESET    = document.getElementById('btn-reset');

      const PRODUCT_CACHE = new Map();
      let   CURRENT_PRODUCT = null;

      const state = {
        page: 1, limit: 8, sort: 'rating_desc', last: 1, total: 0,
        filters: { search:'', category:'', min_price:'', max_price:'', min_rating:'' }
      };

      function rupiah(n){ return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(Number(n||0)); }
      function starIcons(avg){
        avg = Number(avg||0); let html='';
        for(let i=1;i<=5;i++){ if(i<=Math.floor(avg)) html+='<i class="fas fa-star"></i>'; else if(i-avg<=0.5) html+='<i class="fas fa-star-half-alt"></i>'; else html+='<i class="far fa-star"></i>'; }
        return html;
      }
      function escapeHtml(s){ return String(s??'').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;').replaceAll("'","&#039;"); }
      function toImageUrl(p){
        const raw = p.image_url || p.image; if(!raw) return null;
        if(/^https?:\/\//i.test(raw)) return raw;
        const clean = String(raw).replace(/^\/+/,''); return `/storage/${clean}`;
      }

      function productCard(p){
        const id     = p.id ?? p.slug;
        const priceN = p.base_price ?? p.price ?? 0;
        const rAvg   = (p.rating && p.rating.avg) ?? p.rating_avg ?? 0;
        const rCnt   = (p.rating && p.rating.count) ?? p.rating_count ?? 0;
        const img    = toImageUrl(p);
        let badge = 'Hot';
        try{ if(Number(rAvg)>=4.6) badge='Best'; else if(p.created_at && new Date(p.created_at)>new Date(Date.now()-30*24*60*60*1000)) badge='New'; }catch(_){}

        return `
        <a href="javascript:void(0)" data-id="${escapeHtml(id)}"
           class="product-card group bg-gray-50 rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 block opacity-0 animate-slide-up"
           data-animate>
          <div class="relative h-52 bg-white flex items-center justify-center group-hover:scale-[1.02] transition-transform duration-500">
            ${img ? `
              <img src="${img}" alt="${escapeHtml(p.name)}" loading="lazy" decoding="async"
                   onerror="this.onerror=null;this.src='https://via.placeholder.com/480x320?text=No+Image';"
                   class="w-full h-full object-cover">
            ` : `
              <div class="w-full h-full bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center">
                <i class="fas fa-image text-5xl text-blue-400"></i>
              </div>
            `}
            <div class="absolute top-3 right-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white px-2.5 py-0.5 rounded-full text-xs font-semibold">${badge}</div>
          </div>
          <div class="p-5">
            <h3 class="text-base font-bold text-gray-900 mb-1.5">${escapeHtml(p.name)}</h3>
            <div class="flex items-center mb-2 text-sm">
              <div class="flex text-yellow-400">${starIcons(rAvg)}</div>
              <span class="text-gray-500 ml-2">(${Number(rAvg).toFixed(1)} / ${Number(rCnt)})</span>
            </div>
            <div class="flex items-center justify-between">
              <div class="text-xl font-bold text-blue-600">${rupiah(priceN)}</div>
              <span class="inline-flex items-center text-xs text-gray-500"><i class="fas fa-box mr-1.5"></i>${Number(p.stock ?? 0)} stok</span>
            </div>
          </div>
        </a>`;
      }

      function showSkeleton(count=8){
        if(!GRID) return;
        const fallback = `
          <div class="animate-pulse bg-gray-50 rounded-3xl overflow-hidden border border-gray-100">
            <div class="h-52 bg-gray-200"></div>
            <div class="p-6 space-y-3">
              <div class="h-5 bg-gray-200 rounded w-3/4"></div>
              <div class="h-4 bg-gray-200 rounded w-1/2"></div>
              <div class="h-6 bg-gray-200 rounded w-1/3"></div>
            </div>
          </div>`;
        const tplHtml = TPL ? TPL.innerHTML : fallback;
        GRID.innerHTML = Array.from({length:count}).map(()=>tplHtml).join('');
      }

      function readFiltersFromUI(){
        const f = {
          search: (F_SEARCH.value || '').trim(),
          category: (F_CATEGORY.value || '').trim(),
          min_price: F_MIN_PRICE.value ? Math.max(0, Number(F_MIN_PRICE.value)) : '',
          max_price: F_MAX_PRICE.value ? Math.max(0, Number(F_MAX_PRICE.value)) : '',
          min_rating: F_MIN_RATING.value ? Number(F_MIN_RATING.value) : ''
        };
        if (f.min_price !== '' && f.max_price !== '' && f.min_price > f.max_price) {
          const t = f.min_price; f.min_price = f.max_price; f.max_price = t;
        }
        return f;
      }

      function applyFiltersToURL(){
        const params = new URLSearchParams();
        if (state.filters.search) params.set('search', state.filters.search);
        if (state.filters.category) params.set('category', state.filters.category);
        if (state.filters.min_price !== '') params.set('min_price', state.filters.min_price);
        if (state.filters.max_price !== '') params.set('max_price', state.filters.max_price);
        if (state.filters.min_rating !== '') params.set('min_rating', state.filters.min_rating);
        params.set('page', state.page);
        const newUrl = `${location.pathname}${params.toString() ? '?' + params.toString() : ''}${location.hash}`;
        history.replaceState(null, '', newUrl);
      }

      function loadFiltersFromURL(){
        const q = new URLSearchParams(location.search);
        state.filters.search     = q.get('search') || '';
        state.filters.category   = q.get('category') || '';
        state.filters.min_price  = q.get('min_price') || '';
        state.filters.max_price  = q.get('max_price') || '';
        state.filters.min_rating = q.get('min_rating') || '';
        state.page               = Math.max(1, Number(q.get('page')||1));

        F_SEARCH.value     = state.filters.search;
        F_MIN_PRICE.value  = state.filters.min_price;
        F_MAX_PRICE.value  = state.filters.max_price;
        F_MIN_RATING.value = state.filters.min_rating;
      }

      function buildApiUrl(){
        const params = new URLSearchParams();
        params.set('limit', state.limit);
        params.set('sort', state.sort);
        params.set('page', state.page);
        if (state.filters.search) params.set('search', state.filters.search);
        if (state.filters.category) params.set('category', state.filters.category);
        if (state.filters.min_price !== '') params.set('min_price', state.filters.min_price);
        if (state.filters.max_price !== '') params.set('max_price', state.filters.max_price);
        if (state.filters.min_rating !== '') params.set('min_rating', state.filters.min_rating);
        return `${API_URL}?${params.toString()}`;
      }

      function renderPager(meta){
        if(!PAGER) return;
        state.last  = meta?.last_page || 1;
        state.page  = meta?.current_page || 1;
        state.total = meta?.total || 0;

        const prevDisabled = state.page <= 1 ? 'opacity-50 pointer-events-none' : '';
        const nextDisabled = state.page >= state.last ? 'opacity-50 pointer-events-none' : '';

        PAGER.innerHTML = `
          <div class="inline-flex items-center gap-2 text-sm">
            <button id="pg-first" class="px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 ${prevDisabled}" aria-label="First">&laquo;</button>
            <button id="pg-prev"  class="px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 ${prevDisabled}" aria-label="Prev">Prev</button>
            <span class="px-2 py-1 text-gray-500">Page <b>${state.page}</b>/<b>${state.last}</b></span>
            <button id="pg-next" class="px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 ${nextDisabled}" aria-label="Next">Next</button>
            <button id="pg-last" class="px-2 py-1 rounded border border-gray-200 hover:bg-gray-100 ${nextDisabled}" aria-label="Last">&raquo;</button>
          </div>`;
        document.getElementById('pg-first')?.addEventListener('click', ()=> { state.page=1; applyFiltersToURL(); loadProducts(); });
        document.getElementById('pg-prev') ?.addEventListener('click', ()=> { state.page=Math.max(1,state.page-1); applyFiltersToURL(); loadProducts(); });
        document.getElementById('pg-next') ?.addEventListener('click', ()=> { state.page=Math.min(state.last,state.page+1); applyFiltersToURL(); loadProducts(); });
        document.getElementById('pg-last') ?.addEventListener('click', ()=> { state.page=state.last; applyFiltersToURL(); loadProducts(); });
      }

      async function loadProducts(){
        if(!GRID) return;
        try{
          showSkeleton(state.limit);
          const url = buildApiUrl();
          const res = await fetch(url, { headers:{ 'Accept':'application/json' }});
          if(!res.ok) throw new Error(`HTTP ${res.status}`);
          const json  = await res.json();
          let items = json.data || [];

          PRODUCT_CACHE.clear();
          items.forEach(p => PRODUCT_CACHE.set(String(p.id ?? p.slug), p));

          const minR = Number(state.filters.min_rating || 0);
          if (minR > 0) {
            items = items.filter(p => {
              const r = (p.rating && p.rating.avg) ?? p.rating_avg ?? 0;
              return Number(r) >= minR;
            });
          }

          if(!items.length){
            GRID.innerHTML = `
              <div class="col-span-4">
                <div class="bg-gray-50 border border-dashed border-gray-300 rounded-3xl p-12 text-center text-gray-500">
                  Tidak menemukan produk dengan filter saat ini.
                </div>
              </div>`;
            renderPager(json.meta || { current_page: state.page, last_page: state.page, total: 0 });
            return;
          }

          GRID.innerHTML = items.map(productCard).join('');
          GRID.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));
          renderPager(json.meta || { current_page: state.page, last_page: state.page, total: items.length });
        }catch(err){
          console.error(err);
          GRID.innerHTML = `
            <div class="col-span-4">
              <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-red-700">
                Gagal memuat produk dari API. ${escapeHtml(err.message || '')}
              </div>
            </div>`;
          renderPager({ current_page: 1, last_page: 1, total: 0 });
        }
      }

      async function loadCategories(){
        try{
          const res = await fetch(`${API_URL}?limit=100`, { headers:{ 'Accept':'application/json' } });
          if(!res.ok) throw new Error(`HTTP ${res.status}`);
          const json = await res.json();
          const items = json.data || [];
          const map = new Map();
          items.forEach(p=>{
            const c = p.category || {};
            if (c?.slug && c?.name) map.set(c.slug, c.name);
          });

          const current = state.filters.category;
          F_CATEGORY.innerHTML = `<option value="">Semua Kategori</option>` +
            Array.from(map.entries()).map(([slug,name]) =>
              `<option value="${escapeHtml(slug)}"${slug===current?' selected':''}>${escapeHtml(name)}</option>`
            ).join('');
        }catch(err){
          console.warn('Gagal muat kategori:', err);
        }
      }

      const MODAL      = document.getElementById('product-modal');
      const PM_BACK    = document.getElementById('pm-backdrop');
      const PM_CLOSE   = document.getElementById('pm-close');
      const PM_IMG     = document.getElementById('pm-image');
      const PM_NAME    = document.getElementById('pm-name');
      const PM_STARS   = document.getElementById('pm-stars');
      const PM_PRICE   = document.getElementById('pm-price');
      const PM_STOCK   = document.getElementById('pm-stock');
      const PM_CAT     = document.getElementById('pm-category');
      const PM_DESC    = document.getElementById('pm-desc');
      const PM_WA      = document.getElementById('pm-wa');

      function buildWaLink(p){
        const phone = '6285602946601';
        const price = rupiah(p.base_price ?? p.price ?? 0);
        const text  = `Halo, saya ingin memesan:\n\n${p.name}\nHarga: ${price}\nQty: 1\n\nLink: ${location.origin}/catalog/${p.slug || p.id}`;
        return `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
      }
      function openModal(p){
        CURRENT_PRODUCT = p;
        PM_IMG.src   = toImageUrl(p) || 'https://via.placeholder.com/600x400?text=No+Image';
        PM_IMG.alt   = p.name || '';
        PM_NAME.textContent = p.name || '-';
        const rAvg = (p.rating && p.rating.avg) ?? p.rating_avg ?? 0;
        PM_STARS.innerHTML = `${starIcons(rAvg)} <span class="ml-2 text-gray-500">(${Number(rAvg).toFixed(1)})</span>`;
        PM_PRICE.textContent = rupiah(p.base_price ?? p.price ?? 0);
        PM_STOCK.innerHTML = `<i class="fas fa-box mr-1.5"></i> Stok: ${Number(p.stock ?? 0)}`;
        PM_CAT.innerHTML = `<i class="fas fa-tags mr-1.5"></i> Kategori: ${escapeHtml(p.category?.name ?? '-')}`;
        PM_DESC.textContent = p.description ?? p.short_description ?? '-';
        PM_WA.href = buildWaLink(p);

        MODAL.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
      }
      function closeModal(){
        MODAL.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        CURRENT_PRODUCT = null;
      }
      PM_BACK?.addEventListener('click', closeModal);
      PM_CLOSE?.addEventListener('click', closeModal);
      document.addEventListener('keydown', (e)=>{ if(e.key==='Escape' && !MODAL.classList.contains('hidden')) closeModal(); });

      GRID.addEventListener('click', (e)=>{
        const card = e.target.closest('.product-card');
        if(!card) return;
        const id = card.getAttribute('data-id');
        const p  = PRODUCT_CACHE.get(String(id));
        if (p) openModal(p);
      });

      BTN_APPLY.addEventListener('click', () => {
        state.filters = readFiltersFromUI();
        state.page = 1;
        applyFiltersToURL();
        loadProducts();
      });
      BTN_RESET.addEventListener('click', () => {
        F_SEARCH.value=''; F_CATEGORY.value=''; F_MIN_PRICE.value=''; F_MAX_PRICE.value=''; F_MIN_RATING.value='';
        state.filters = { search:'', category:'', min_price:'', max_price:'', min_rating:'' };
        state.page = 1;
        applyFiltersToURL();
        loadProducts();
      });

      [F_SEARCH, F_MIN_PRICE, F_MAX_PRICE].forEach(inp=>{
        inp.addEventListener('keydown', (e)=>{ if(e.key==='Enter'){ BTN_APPLY.click(); } });
      });
      [F_CATEGORY, F_MIN_RATING].forEach(sel=>{
        sel.addEventListener('change', ()=> BTN_APPLY.click());
      });

      loadFiltersFromURL();
      loadCategories().finally(()=>{
        if (state.filters.category && !F_CATEGORY.value) F_CATEGORY.value = state.filters.category;
        applyFiltersToURL();
        loadProducts();
      });

      document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight' && state.page < state.last) { state.page++; applyFiltersToURL(); loadProducts(); }
        if (e.key === 'ArrowLeft'  && state.page > 1)          { state.page--; applyFiltersToURL(); loadProducts(); }
      });

      document.addEventListener('mouseover', (e) => {
        const card = e.target.closest('.group'); if (!card) return;
        card.style.transform = 'translateY(-8px) scale(1.02)';
      });
      document.addEventListener('mouseout', (e) => {
        const card = e.target.closest('.group'); if (!card) return;
        card.style.transform = 'translateY(0) scale(1)';
      });
    });
  }
  </script>
</body>
</html>
