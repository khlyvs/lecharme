

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeCharme</title>


    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset("website/css/bootstrap.min.css") }}" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{ asset("website/css/bootstrap-icons.css") }}">

    <!-- Google Fonts -->
    <link href="{{ asset("website/css/google-fonts.css") }}" rel="stylesheet">

    <!-- Custom CSS -->
     <link rel="stylesheet" href="{{ asset('website/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/header-slider.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/fontawesome-all.min.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/product-slider.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/footer.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/register.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/login.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/user.css') }}">
<link rel="stylesheet" href="{{ asset('website/css/filter.css') }}">





</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <!-- Desktop Layout -->
            <div class="row align-items-center py-3 header-desktop">
                <!-- Logo -->
                <div class="col-auto">
                   <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="logo">
                        <i class="bi bi-shop"></i>
                        <span>LeCharme</span>
                    </a>
                </div>

                <!-- Hamburger Menu Button -->
                <div class="col-auto">
                    <button class="btn btn-link p-0 hamburger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#catalogMenu">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>

                <!-- Search -->
                <div class="col">
                    <div class="search-wrapper">
                        <input type="text" class="form-control search-input" placeholder="Ürün, kategori veya marka ara..." autocomplete="off">
                        <button class="search-btn" type="button">
                            <i class="bi bi-search"></i>
                        </button>

                        <!-- Search Results Dropdown -->
                        <div class="search-dropdown" id="searchDropdown">
                            <!-- Popular Searches - shown when empty -->
                            <div class="search-section search-popular">
                                <div class="search-section-title">
                                    <i class="bi bi-fire"></i>
                                    <span>Populyar axtarışlar</span>
                                </div>
                                <div class="search-tags">
                                    <a href="#" class="search-tag">iPhone 15</a>
                                    <a href="#" class="search-tag">Samsung</a>
                                    <a href="#" class="search-tag">Airpods</a>
                                    <a href="#" class="search-tag">Laptop</a>
                                    <a href="#" class="search-tag">Smart saat</a>
                                </div>
                            </div>

                            <!-- Search Results - shown when typing -->
                            <div class="search-section search-results" style="display: none;">
                                <!-- Categories -->
                                <div class="search-group">
                                    <div class="search-section-title">
                                        <i class="bi bi-folder"></i>
                                        <span>Kateqoriyalar</span>
                                    </div>
                                    <div class="search-category-list">
                                        <a href="#" class="search-category-item">
                                            <i class="bi bi-phone"></i>
                                            <span>Telefon & Aksesuar</span>
                                            <span class="search-count">245</span>
                                        </a>
                                        <a href="#" class="search-category-item">
                                            <i class="bi bi-laptop"></i>
                                            <span>Kompyuter & Tablet</span>
                                            <span class="search-count">128</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Products -->
                                <div class="search-group">
                                    <div class="search-section-title">
                                        <i class="bi bi-box-seam"></i>
                                        <span>Məhsullar</span>
                                    </div>
                                    <div class="search-product-list">
                                        <a href="#" class="search-product-item">
                                            <div class="search-product-img">
                                                <img src="https://via.placeholder.com/60x60" alt="Product" loading="lazy">
                                            </div>
                                            <div class="search-product-info">
                                                <div class="search-product-name">iPhone 15 Pro Max 256GB</div>
                                                <div class="search-product-category">Telefon & Aksesuar</div>
                                                <div class="search-product-price">2,499 ₼</div>
                                            </div>
                                        </a>
                                        <a href="#" class="search-product-item">
                                            <div class="search-product-img">
                                                <img src="https://via.placeholder.com/60x60" alt="Product" loading="lazy">
                                            </div>
                                            <div class="search-product-info">
                                                <div class="search-product-name">iPhone 15 Pro 128GB</div>
                                                <div class="search-product-category">Telefon & Aksesuar</div>
                                                <div class="search-product-price">2,199 ₼</div>
                                            </div>
                                        </a>
                                        <a href="#" class="search-product-item">
                                            <div class="search-product-img">
                                                <img src="https://via.placeholder.com/60x60" alt="Product" loading="lazy">
                                            </div>
                                            <div class="search-product-info">
                                                <div class="search-product-name">iPhone 15 128GB</div>
                                                <div class="search-product-category">Telefon & Aksesuar</div>
                                                <div class="search-product-price">1,699 ₼</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <!-- View All Results -->
                                <a href="#" class="search-view-all">
                                    <span>Bütün nəticələrə bax</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>

                            <!-- No Results -->
                            <div class="search-section search-no-results" style="display: none;">
                                <div class="search-empty">
                                    <i class="bi bi-search"></i>
                                    <p>Heç bir nəticə tapılmadı</p>
                                    <span>Başqa açar sözlər yoxlayın</span>
                                </div>
                            </div>

                            <!-- Loading State -->
                            <div class="search-section search-loading" style="display: none;">
                                <div class="search-loader">
                                    <div class="spinner"></div>
                                    <span>Axtarılır...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Header Actions -->
                <div class="col-auto">
                    <div class="header-actions">
                        <!-- Language Selector -->
                        <div class="language-selector">
                            <button class="action-btn language-btn" type="button" id="languageBtn" title="Dil Seç">
                                <i class="bi bi-globe"></i>
                            </button>
                            <div class="language-dropdown" id="languageDropdown" data-current-locale="{{ app()->getLocale() }}">
                                <a class="a-login" href="{{ locale_url('ru') }}">
                                    <button class="lang-option" data-lang="ru">
                                        <span class="lang-flag">🇷🇺</span>
                                        <span class="lang-name">Русский</span>
                                    </button>
                                </a>

                                <a class="a-login" href="{{ locale_url('az') }}">
                                <button class="lang-option" data-lang="az">
                                    <span class="lang-flag">🇦🇿</span>
                                    <span class="lang-name">Azərbaycan</span>
                                </button>
                                </a>
                                <a class="a-login" href="{{ locale_url('en') }}">
                                <button class="lang-option" data-lang="en">
                                    <span class="lang-flag">🇬🇧</span>
                                    <span class="lang-name">English</span>
                                </button>
                                </a>
                            </div>
                        </div>

                        <button class="action-btn" title="Favoriler" type="button">
                            <i class="bi bi-heart"></i>
                        </button>

                        <button class="action-btn" title="Sepet" type="button">
                            <i class="bi bi-cart3"></i>
                            <span class="badge">3</span>
                        </button>

                        <!-- USER BUTTON + DROPDOWN -->
                       <div class="user-selector">
    <button class="action-btn" title="Hesabım" type="button" id="userBtn">
        <i class="bi bi-person"></i>
    </button>

    <div class="user-dropdown" id="userDropdown">

        {{-- Əgər istifadəçi GİRİŞ ETMƏYİBSƏ --}}
        @guest
            <a href="{{ route('login-page', ['locale' => app()->getLocale()]) }}" class="user-option">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Giriş et</span>
            </a>

            <a href="{{ route('register-page', ['locale' => app()->getLocale()]) }}" class="user-option">
                <i class="bi bi-person-plus"></i>
                <span>Qeydiyyat</span>
            </a>
        @endguest

        {{-- Əgər istifadəçi GİRİŞ ETMİŞDİRSƏ --}}
        @auth
            <a href="{{ route('profile', ['locale' => app()->getLocale()]) }}" class="user-option">
                <i class="bi bi-person-circle"></i>
                <span>Profilim</span>
            </a>

            <form action="{{ route("logout", ['locale' => app()->getLocale()]) }}" method="post">

                @csrf
            <button class="user-option" type="submit">
                <i class="bi bi-box-arrow-right"></i>
                <span>Çıxış</span>
            </button>
            </form>
        @endauth

    </div>
</div>

                    </div>
                </div>
            </div>

            <!-- Mobile Layout -->
            <div class="header-mobile">
                <!-- Top Row: Logo + Actions -->
                <div class="row align-items-center py-2 header-mobile-top">
                    <div class="col">
                        <a href="#" class="logo">
                            <i class="bi bi-shop"></i>
                            <span>LeCharme</span>
                        </a>
                    </div>
                    <div class="col-auto">
                        <div class="header-actions">
                            <!-- Language Selector -->
                            <div class="language-selector">
                                <button class="action-btn language-btn" type="button" id="languageBtnMobile" title="Dil Seç">
                                    <i class="bi bi-globe"></i>
                                </button>
                                <div class="language-dropdown" id="languageDropdownMobile">
                                    <button class="lang-option" data-lang="tr">
                                        <span class="lang-flag">🇹🇷</span>
                                        <span class="lang-name">Türkçe</span>
                                    </button>
                                    <button class="lang-option" data-lang="az">
                                        <span class="lang-flag">🇦🇿</span>
                                        <span class="lang-name">Azərbaycan</span>
                                    </button>
                                    <button class="lang-option" data-lang="en">
                                        <span class="lang-flag">🇬🇧</span>
                                        <span class="lang-name">English</span>
                                    </button>
                                </div>
                            </div>
                            <button class="action-btn" title="Favoriler" type="button">
                                <i class="bi bi-heart"></i>
                            </button>
                            <button class="action-btn" title="Sepet" type="button">
                                <i class="bi bi-cart3"></i>
                                <span class="badge">3</span>
                            </button>
                            <!-- USER BUTTON + DROPDOWN (Mobile) -->
                           <div class="user-selector">
                                <button class="action-btn" title="Hesabım" type="button" id="userBtnMobile">
                                    <i class="bi bi-person"></i>
                                </button>

                                <div class="user-dropdown" id="userDropdownMobile">

                                    @guest
                                        {{-- login --}}
                                        <form action="{{ route('login-page', ['locale' => app()->getLocale()]) }}">
                                            <button type="submit" class="user-option">
                                                <i class="bi bi-box-arrow-in-right"></i>
                                                <span>Giriş et</span>
                                            </button>
                                        </form>

                                        {{-- register --}}
                                        <form action="{{ route('register-page', ['locale' => app()->getLocale()]) }}">
                                            <button type="submit" class="user-option">
                                                <i class="bi bi-person-plus"></i>
                                                <span>Qeydiyyat</span>
                                            </button>
                                        </form>
                                    @endguest

                                    @auth
                                        <a href="{{ route('profile', ['locale' => app()->getLocale()]) }}" class="user-option">
                                            <i class="bi bi-person-circle"></i>
                                            <span>Profilim</span>
                                        </a>

                                        <form action="{{ route("logout", ['locale' => app()->getLocale()]) }}" method="post">

                                            @csrf
                                        <button class="user-option" type="submit">
                                            <i class="bi bi-box-arrow-right"></i>
                                            <span>Çıxış</span>
                                        </button>
                                        </form>
                                    @endauth

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Hamburger + Search -->
                <div class="row align-items-center py-2 header-mobile-bottom">
                    <div class="col-auto">
                        <button class="btn btn-link p-0 hamburger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#catalogMenu">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                    <div class="col">
                        <div class="search-wrapper">
                            <input type="text" class="form-control search-input" placeholder="Ürün, kategori veya marka ara..." autocomplete="off">
                            <button class="search-btn" type="button">
                                <i class="bi bi-search"></i>
                            </button>

                            <!-- Mobile Search Results Dropdown -->
                            <div class="search-dropdown" id="searchDropdownMobile">
                                <!-- Popular Searches -->
                                <div class="search-section search-popular">
                                    <div class="search-section-title">
                                        <i class="bi bi-fire"></i>
                                        <span>Populyar axtarışlar</span>
                                    </div>
                                    <div class="search-tags">
                                        <a href="#" class="search-tag">iPhone 15</a>
                                        <a href="#" class="search-tag">Samsung</a>
                                        <a href="#" class="search-tag">Airpods</a>
                                        <a href="#" class="search-tag">Laptop</a>
                                    </div>
                                </div>

                                <!-- Search Results -->
                                <div class="search-section search-results" style="display: none;">
                                    <div class="search-group">
                                        <div class="search-section-title">
                                            <i class="bi bi-box-seam"></i>
                                            <span>Məhsullar</span>
                                        </div>
                                        <div class="search-product-list">
                                            <a href="#" class="search-product-item">
                                                <div class="search-product-img">
                                                    <img src="https://via.placeholder.com/60x60/f0f0f0/333?text=📱" alt="Product" loading="lazy">
                                                </div>
                                                <div class="search-product-info">
                                                    <div class="search-product-name">iPhone 15 Pro 256GB</div>
                                                    <div class="search-product-category">Telefon</div>
                                                    <div class="search-product-price">2,299 ₼</div>
                                                </div>
                                            </a>
                                            <a href="#" class="search-product-item">
                                                <div class="search-product-img">
                                                    <img src="https://via.placeholder.com/60x60/f0f0f0/333?text=🎧" alt="Product" loading="lazy">
                                                </div>
                                                <div class="search-product-info">
                                                    <div class="search-product-name">AirPods Pro 2</div>
                                                    <div class="search-product-category">Aksesuar</div>
                                                    <div class="search-product-price">449 ₼</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <a href="#" class="search-view-all">
                                        <span>Bütün nəticələrə bax</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>

                                <!-- No Results -->
                                <div class="search-section search-no-results" style="display: none;">
                                    <div class="search-empty">
                                        <i class="bi bi-search"></i>
                                        <p>Heç bir nəticə tapılmadı</p>
                                    </div>
                                </div>

                                <!-- Loading -->
                                <div class="search-section search-loading" style="display: none;">
                                    <div class="search-loader">
                                        <div class="spinner"></div>
                                        <span>Axtarılır...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


@include('components.catalog-menu')

