@extends("layouts.app")

@section('content')




 <div id="filter__page" class="filter__page">
        <!-- Mobile Filter Toggle Button -->
        <button id="filter__mobile-toggle" class="filter__mobile-toggle" aria-label="Filtreleri aç" aria-expanded="false" aria-controls="filter__sidebar">
            <i class="bi bi-funnel" aria-hidden="true"></i>
            <span>Filtreler</span>
        </button>

        <!-- Mobile Overlay -->
        <div id="filter__overlay" class="filter__overlay" aria-hidden="true"></div>

        <div class="filter__wrapper">
            <!-- Sidebar Filters -->
            <aside id="filter__sidebar" class="filter__sidebar" role="region" aria-label="Filtreler">
                <div id="filter__header" class="filter__header">
                    <h2 id="filter__title" class="filter__title">Filtreler</h2>
                    <div class="filter__header-actions">
                        <button id="filter__clear" class="filter__btn-clear" type="button">
                            <i class="bi bi-x-circle" aria-hidden="true"></i>
                            Temizle
                        </button>
                    </div>
                </div>

                <!-- Mobile Close Button -->
                <button id="filter__close" class="filter__btn-close" type="button" aria-label="Filtreleri kapat">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>

                <!-- Price Range -->
                <div class="filter__section">
                    <h3 class="filter__section-title">Fiyat Aralığı</h3>
                    <div class="filter__price-inputs">
                        <input type="number" id="filter__price-min" class="filter__price-input" placeholder="Min" min="0" aria-label="Minimum fiyat">
                        <span class="filter__price-separator" aria-hidden="true">-</span>
                        <input type="number" id="filter__price-max" class="filter__price-input" placeholder="Max" min="0" aria-label="Maximum fiyat">
                    </div>
                </div>

                <!-- SubCategories - Dinamik -->
                @php
                    $subcategoriesToShow = isset($category) ? $category->subcategories : [];
                @endphp

                @if(count($subcategoriesToShow) > 0)
                    <div class="filter__section">
                        <h3 class="filter__section-title">SubKateqoriyalar</h3>
                        @foreach($subcategoriesToShow as $subcategory)
                            <label class="filter__checkbox">
                                <input type="checkbox"
                                       name="subcategories[]"
                                       value="{{ $subcategory->id }}">
                                <span class="filter__checkbox-label">
                                    {{ $subcategory->localized_name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                @endif



                <!-- Rating -->
                <div class="filter__section">
                    <h3 class="filter__section-title">Değerlendirme</h3>
                    <div class="filter__rating-group">
                        <label class="filter__rating-item">
                            <input type="radio" name="rating" value="5">
                            <div class="filter__rating-stars">
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <span class="filter__rating-text">ve üzeri</span>
                            </div>
                        </label>
                        <label class="filter__rating-item">
                            <input type="radio" name="rating" value="4">
                            <div class="filter__rating-stars">
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star" aria-hidden="true"></i>
                                <span class="filter__rating-text">ve üzeri</span>
                            </div>
                        </label>
                        <label class="filter__rating-item">
                            <input type="radio" name="rating" value="3">
                            <div class="filter__rating-stars">
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star-fill" aria-hidden="true"></i>
                                <i class="bi bi-star" aria-hidden="true"></i>
                                <i class="bi bi-star" aria-hidden="true"></i>
                                <span class="filter__rating-text">ve üzeri</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Badges -->
                <div class="filter__section">
                    <h3 class="filter__section-title">Özellikler</h3>
                    <div class="filter__badge-group" role="group" aria-label="Ürün özellikleri">
                        <button class="filter__badge" data-badge="new" type="button" aria-pressed="false">
                            <i class="bi bi-star" aria-hidden="true"></i>
                            Yeni
                        </button>
                        <button class="filter__badge" data-badge="discount" type="button" aria-pressed="false">
                            <i class="bi bi-percent" aria-hidden="true"></i>
                            İndirimli
                        </button>
                        <button class="filter__badge" data-badge="bestseller" type="button" aria-pressed="false">
                            <i class="bi bi-fire" aria-hidden="true"></i>
                            Çok Satan
                        </button>
                        <button class="filter__badge" data-badge="limited" type="button" aria-pressed="false">
                            <i class="bi bi-gem" aria-hidden="true"></i>
                            Sınırlı
                        </button>
                    </div>
                </div>

                <!-- Apply Button -->
                <button id="filter__apply" class="filter__btn-apply" type="button">
                    <i class="bi bi-funnel" aria-hidden="true"></i>
                    Filtrele
                </button>
            </aside>

            <!-- Main Content -->
            <main id="filter__main" class="filter__main">
                <div id="filter__topbar" class="filter__topbar">
                    <div id="filter__results" class="filter__results">
                        <h1 id="filter__results-title" class="filter__results-title">
                            {{ $category->localized_name ?? $subcategory->localized_name ?? 'Ürünlerim' }}
                        </h1>
                        <p id="filter__results-count" class="filter__results-count" aria-live="polite">8 ürün bulundu</p>
                    </div>
                    <div id="filter__sort" class="filter__sort">
                        <label for="filter__sort-select" class="filter__sort-label">Sırala:</label>
                        <select id="filter__sort-select" class="filter__sort-select">
                            <option value="default">Varsayılan</option>
                            <option value="price-low">Fiyat: Düşükten Yükseğe</option>
                            <option value="price-high">Fiyat: Yüksekten Düşüğe</option>
                            <option value="rating">En Yüksek Puan</option>
                            <option value="newest">En Yeni</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div id="filter__products-grid" class="filter__products-grid" role="list">
                    <!-- Product 1 -->
                    <article class="product__slider__card" data-product-id="1" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--new">Yeni</span>
                            <span class="product__slider__badge-item badge--discount">-25%</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop"
                                 alt="Premium Akıllı Saat"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Akıllı Saatler</span>
                            <h3 class="product__slider__card__title">Premium Akıllı Saat Pro</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="4.5 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-half" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(128)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺4.999</span>
                                <span class="product__slider__price-original">₺6.699</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>

                    <!-- Product 2 -->
                    <article class="product__slider__card" data-product-id="2" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--bestseller">Çok Satan</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop"
                                 alt="Kablosuz Kulaklık"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Ses Sistemleri</span>
                            <h3 class="product__slider__card__title">Elite Kablosuz Kulaklık</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="5 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(256)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺2.499</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>

                    <!-- Product 3 -->
                    <article class="product__slider__card" data-product-id="3" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--limited">Sınırlı</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&h=600&fit=crop"
                                 alt="Polaroid Kamera"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Fotoğrafçılık</span>
                            <h3 class="product__slider__card__title">Retro Polaroid Kamera</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="4 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(89)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺1.899</span>
                                <span class="product__slider__price-original">₺2.299</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>

                    <!-- Product 4 -->
                    <article class="product__slider__card" data-product-id="4" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--new">Yeni</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=600&h=600&fit=crop"
                                 alt="Lüks Parfüm"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Kozmetik</span>
                            <h3 class="product__slider__card__title">Signature Lüks Parfüm</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="4.5 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-half" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(312)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺3.299</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>

                    <!-- Product 5 -->
                    <article class="product__slider__card" data-product-id="5" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--discount">-40%</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&h=600&fit=crop"
                                 alt="Deri Çanta"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Aksesuar</span>
                            <h3 class="product__slider__card__title">El Yapımı Deri Çanta</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="5 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(178)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺1.799</span>
                                <span class="product__slider__price-original">₺2.999</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>

                    <!-- Product 6 -->
                    <article class="product__slider__card" data-product-id="6" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--bestseller">Çok Satan</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop"
                                 alt="Spor Ayakkabı"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Ayakkabı</span>
                            <h3 class="product__slider__card__title">Ultra Comfort Spor</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="4.5 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-half" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(445)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺2.199</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>

                    <!-- Product 7 -->
                    <article class="product__slider__card" data-product-id="7" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--new">Yeni</span>
                            <span class="product__slider__badge-item badge--discount">-15%</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=600&h=600&fit=crop"
                                 alt="Akıllı Bileklik"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Giyilebilir Teknoloji</span>
                            <h3 class="product__slider__card__title">Fitness Akıllı Bileklik</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="4 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(67)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺899</span>
                                <span class="product__slider__price-original">₺1.059</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>

                    <!-- Product 8 -->
                    <article class="product__slider__card" data-product-id="8" role="listitem">
                        <div class="product__slider__card__badges">
                            <span class="product__slider__badge-item badge--limited">Son 5 Adet</span>
                        </div>

                        <button class="product__slider__card__wishlist" type="button" aria-label="Favorilere ekle">
                            <i class="bi bi-heart" aria-hidden="true"></i>
                        </button>

                        <figure class="product__slider__card__image">
                            <img src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=600&h=600&fit=crop"
                                 alt="Akıllı Telefon"
                                 loading="lazy"
                                 decoding="async">
                            <div class="product__slider__card__overlay">
                                <button class="product__slider__btn-quick-view" type="button">
                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="product__slider__card__content">
                            <span class="product__slider__card__category">Telefon</span>
                            <h3 class="product__slider__card__title">Pro Max Akıllı Telefon</h3>

                            <div class="product__slider__card__rating">
                                <div class="product__slider__stars" aria-label="5 yıldız">
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                                </div>
                                <span class="product__slider__rating-count">(521)</span>
                            </div>

                            <div class="product__slider__card__pricing">
                                <span class="product__slider__price-current">₺42.999</span>
                            </div>

                            <button class="product__slider__card__add-to-cart" type="button">
                                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                                <span>Sepete Ekle</span>
                            </button>
                        </div>
                    </article>
                </div>
            </main>
        </div>
    </div>
@endsection
