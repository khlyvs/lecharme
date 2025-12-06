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
        <link rel="stylesheet" href="{{ asset('website/css/header.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('website/css/header-slider.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('website/css/fontawesome-all.min.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('website/css/swiper-bundle.min.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('website/css/product-slider.css') }}?v={{ time() }}">
        <link rel="stylesheet" href="{{ asset('website/css/footer.css') }}?v={{ time() }}">




</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <!-- Desktop Layout -->
            <div class="row align-items-center py-3 header-desktop">
                <!-- Logo -->
                <div class="col-auto">
                    <a href="#" class="logo">
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
                            <div class="language-dropdown" id="languageDropdown">
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

                        <!-- USER BUTTON + DROPDOWN -->
                        <div class="user-selector">
                            <button class="action-btn" title="Hesabım" type="button" id="userBtn">
                                <i class="bi bi-person"></i>
                            </button>
                            <div class="user-dropdown" id="userDropdown">
                                <button class="user-option" onclick="window.location.href='/login'">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    <span>Giriş et</span>
                                </button>
                                <button class="user-option" onclick="window.location.href='/register'">
                                    <i class="bi bi-person-plus"></i>
                                    <span>Qeydiyyat</span>
                                </button>
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
                                    <button class="user-option" onclick="window.location.href='/login'">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                        <span>Giriş et</span>
                                    </button>
                                    <button class="user-option" onclick="window.location.href='/register'">
                                        <i class="bi bi-person-plus"></i>
                                        <span>Qeydiyyat</span>
                                    </button>
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

    <!-- Catalog Offcanvas Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="catalogMenu" aria-labelledby="catalogMenuLabel" data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="catalogMenuLabel">
                <i class="bi bi-grid-3x3-gap"></i> <span class="catalog-title-text">Kataloq</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="category-list" id="categoryList">
                <li class="category-item">
                    <a href="#" class="category-link" data-category="electronics">
                        <span>Elektronika</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <ul class="subcategory-menu">
                        <li><a href="#" class="subcategory-link">Telefon & Aksesuar</a></li>
                        <li><a href="#" class="subcategory-link">Kompyuter & Ofis</a></li>
                        <li><a href="#" class="subcategory-link">TV & Audio</a></li>
                        <li><a href="#" class="subcategory-link">Foto & Video</a></li>
                    </ul>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="appliances">
                        <span>Məişət Texnikası</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <ul class="subcategory-menu">
                        <li><a href="#" class="subcategory-link">Böyük Texnika</a></li>
                        <li><a href="#" class="subcategory-link">Kiçik Texnika</a></li>
                        <li><a href="#" class="subcategory-link">İqlim Texnikası</a></li>
                    </ul>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="clothing">
                        <span>Geyim & Ayaqqabı</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <ul class="subcategory-menu">
                        <li><a href="#" class="subcategory-link">Kişi Geyimi</a></li>
                        <li><a href="#" class="subcategory-link">Qadın Geyimi</a></li>
                        <li><a href="#" class="subcategory-link">Ayaqqabı</a></li>
                        <li><a href="#" class="subcategory-link">Aksesuar</a></li>
                    </ul>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="kids">
                        <span>Uşaq Məhsulları</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <ul class="subcategory-menu">
                        <li><a href="#" class="subcategory-link">Oyuncaqlar</a></li>
                        <li><a href="#" class="subcategory-link">Geyim</a></li>
                        <li><a href="#" class="subcategory-link">Məktəb</a></li>
                    </ul>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="sports">
                        <span>İdman & Hobi</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <ul class="subcategory-menu">
                        <li><a href="#" class="subcategory-link">Fitness</a></li>
                        <li><a href="#" class="subcategory-link">Açıq Hava</a></li>
                    </ul>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="cosmetics">
                        <span>Kosmetika</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    <ul class="subcategory-menu">
                        <li><a href="#" class="subcategory-link">Yüz Bakımı</a></li>
                        <li><a href="#" class="subcategory-link">Saç Bakımı</a></li>
                        <li><a href="#" class="subcategory-link">Makyaj</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
