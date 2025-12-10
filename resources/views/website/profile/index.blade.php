@extends("layouts.app")

@section('content')

<div id="user__page">
        <div id="user__container">
            <!-- Sidebar -->
            <aside id="user__sidebar">
                <div id="user__profile-header">

                    <h2 id="user__name">Ahmet Yılmaz</h2>
                    <p id="user__email">ahmet@example.com</p>
                </div>

                <nav id="user__nav">
                    <button class="user__nav-item active" data-tab="profile">
                        <i class="bi bi-person"></i>
                        <span>Profil Bilgileri</span>
                    </button>
                    <button class="user__nav-item" data-tab="orders">
                        <i class="bi bi-bag"></i>
                        <span>Siparişlerim</span>
                    </button>
                    <button class="user__nav-item" data-tab="wishlist">
                        <i class="bi bi-heart"></i>
                        <span>Favorilerim</span>
                    </button>
                    <button class="user__nav-item" data-tab="settings">
                        <i class="bi bi-gear"></i>
                        <span>Ayarlar</span>
                    </button>

                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                    </form>
                    <button class="user__nav-item" data-tab="logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Çıkış Yap</span>
                    </button>

                </nav>
            </aside>

            <!-- Main Content -->
            <main id="user__main">
                <!-- Profile Tab -->
                <div id="user__tab-profile" class="user__tab-content active">
                    <div id="user__tab-header">
                        <h1 id="user__tab-title">Profil Bilgileri</h1>
                        <p id="user__tab-subtitle">Kişisel bilgilerinizi güncelleyin</p>
                    </div>

                    <form id="user__profile-form">
                        <div id="user__form-section">
                            <h3 id="user__section-title">Kişisel Bilgiler</h3>

                            <div id="user__form-row">
                                <div id="user__form-group">
                                    <label for="firstName">Ad</label>
                                    <input type="text" id="firstName" name="firstName" value="Ahmet" required>
                                </div>

                            </div>

                            <div id="user__form-group">
                                <label for="email">E-posta</label>
                                <input type="email" id="email" name="email" value="ahmet@example.com" required>
                            </div>

                            <div id="user__form-group">
                                <label for="phone">Telefon</label>
                                <input type="tel" id="phone" name="phone" value="+90 555 123 4567">
                            </div>

                            
                        </div>

                        <div id="user__form-section">
                            <h3 id="user__section-title">Şifre Değiştir</h3>

                            <div id="user__form-group">
                                <label for="currentPassword">Mevcut Şifre</label>
                                <input type="password" id="currentPassword" name="currentPassword">
                            </div>

                            <div id="user__form-row">
                                <div id="user__form-group">
                                    <label for="newPassword">Yeni Şifre</label>
                                    <input type="password" id="newPassword" name="newPassword">
                                </div>
                                <div id="user__form-group">
                                    <label for="confirmPassword">Yeni Şifre Tekrar</label>
                                    <input type="password" id="confirmPassword" name="confirmPassword">
                                </div>
                            </div>
                        </div>

                        <div id="user__form-actions">
                            <button type="submit" id="user__save-btn">
                                <span>Değişiklikleri Kaydet</span>
                                <i class="bi bi-check-lg"></i>
                            </button>
                            <button type="button" id="user__cancel-btn">İptal</button>
                        </div>
                    </form>
                </div>

                <!-- Orders Tab -->
                <div id="user__tab-orders" class="user__tab-content">
                    <div id="user__tab-header">
                        <h1 id="user__tab-title">Siparişlerim</h1>
                        <p id="user__tab-subtitle">Geçmiş siparişlerinizi görüntüleyin</p>
                    </div>

                    <div id="user__orders-list">
                        <div class="user__order-item">
                            <div class="user__order-header">
                                <div>
                                    <span class="user__order-number">#12345</span>
                                    <span class="user__order-date">15 Ocak 2024</span>
                                </div>
                                <span class="user__order-status delivered">Teslim Edildi</span>
                            </div>
                            <div class="user__order-body">
                                <div class="user__order-products">
                                    <span>3 ürün</span>
                                </div>
                                <div class="user__order-total">
                                    <strong>₺1,250.00</strong>
                                </div>
                            </div>
                            <div class="user__order-actions">
                                <button class="user__order-btn">Detayları Gör</button>
                                <button class="user__order-btn secondary">Tekrar Sipariş Ver</button>
                            </div>
                        </div>

                        <div class="user__order-item">
                            <div class="user__order-header">
                                <div>
                                    <span class="user__order-number">#12344</span>
                                    <span class="user__order-date">10 Ocak 2024</span>
                                </div>
                                <span class="user__order-status shipping">Kargoda</span>
                            </div>
                            <div class="user__order-body">
                                <div class="user__order-products">
                                    <span>1 ürün</span>
                                </div>
                                <div class="user__order-total">
                                    <strong>₺450.00</strong>
                                </div>
                            </div>
                            <div class="user__order-actions">
                                <button class="user__order-btn">Detayları Gör</button>
                                <button class="user__order-btn secondary">Takip Et</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Tab -->
                <div id="user__tab-wishlist" class="user__tab-content">
                    <div id="user__tab-header">
                        <h1 id="user__tab-title">Favorilerim</h1>
                        <p id="user__tab-subtitle">Beğendiğiniz ürünler</p>
                    </div>

                    <div id="user__wishlist-grid">
                        <article class="user__product-card" data-product-id="1">
                            <div class="user__product-badges">
                                <span class="user__product-badge badge--new">Yeni</span>
                                <span class="user__product-badge badge--discount">-25%</span>
                            </div>

                            <button class="user__product-remove" aria-label="Favorilerden çıkar">
                                <i class="bi bi-heart-fill"></i>
                            </button>

                            <figure class="user__product-image">
                                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&h=600&fit=crop"
                                     alt="Premium Akıllı Saat"
                                     loading="lazy">
                                <div class="user__product-overlay">
                                    <button class="user__product-quick-view">
                                        <i class="bi bi-eye"></i>
                                        Hızlı Bakış
                                    </button>
                                </div>
                            </figure>

                            <div class="user__product-content">
                                <span class="user__product-category">Akıllı Saatler</span>
                                <h3 class="user__product-title">Premium Akıllı Saat Pro</h3>

                                <div class="user__product-rating">
                                    <div class="user__product-stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <span class="user__product-rating-count">(128)</span>
                                </div>

                                <div class="user__product-pricing">
                                    <span class="user__product-price-current">₺4.999</span>
                                    <span class="user__product-price-original">₺6.699</span>
                                </div>

                                <button class="user__product-add-cart">
                                    <i class="bi bi-bag-plus"></i>
                                    <span>Sepete Ekle</span>
                                </button>
                            </div>
                        </article>

                        <article class="user__product-card" data-product-id="2">
                            <div class="user__product-badges">
                                <span class="user__product-badge badge--bestseller">Çok Satan</span>
                            </div>

                            <button class="user__product-remove" aria-label="Favorilerden çıkar">
                                <i class="bi bi-heart-fill"></i>
                            </button>

                            <figure class="user__product-image">
                                <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&h=600&fit=crop"
                                     alt="Kablosuz Kulaklık"
                                     loading="lazy">
                                <div class="user__product-overlay">
                                    <button class="user__product-quick-view">
                                        <i class="bi bi-eye"></i>
                                        Hızlı Bakış
                                    </button>
                                </div>
                            </figure>

                            <div class="user__product-content">
                                <span class="user__product-category">Ses Sistemleri</span>
                                <h3 class="user__product-title">Elite Kablosuz Kulaklık</h3>

                                <div class="user__product-rating">
                                    <div class="user__product-stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <span class="user__product-rating-count">(256)</span>
                                </div>

                                <div class="user__product-pricing">
                                    <span class="user__product-price-current">₺2.499</span>
                                </div>

                                <button class="user__product-add-cart">
                                    <i class="bi bi-bag-plus"></i>
                                    <span>Sepete Ekle</span>
                                </button>
                            </div>
                        </article>

                        <article class="user__product-card" data-product-id="3">
                            <div class="user__product-badges">
                                <span class="user__product-badge badge--limited">Sınırlı</span>
                            </div>

                            <button class="user__product-remove" aria-label="Favorilerden çıkar">
                                <i class="bi bi-heart-fill"></i>
                            </button>

                            <figure class="user__product-image">
                                <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&h=600&fit=crop"
                                     alt="Polaroid Kamera"
                                     loading="lazy">
                                <div class="user__product-overlay">
                                    <button class="user__product-quick-view">
                                        <i class="bi bi-eye"></i>
                                        Hızlı Bakış
                                    </button>
                                </div>
                            </figure>

                            <div class="user__product-content">
                                <span class="user__product-category">Fotoğrafçılık</span>
                                <h3 class="user__product-title">Retro Polaroid Kamera</h3>

                                <div class="user__product-rating">
                                    <div class="user__product-stars">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <span class="user__product-rating-count">(89)</span>
                                </div>

                                <div class="user__product-pricing">
                                    <span class="user__product-price-current">₺1.899</span>
                                    <span class="user__product-price-original">₺2.299</span>
                                </div>

                                <button class="user__product-add-cart">
                                    <i class="bi bi-bag-plus"></i>
                                    <span>Sepete Ekle</span>
                                </button>
                            </div>
                        </article>
                    </div>
                </div>

                <!-- Settings Tab -->
                <div id="user__tab-settings" class="user__tab-content">
                    <div id="user__tab-header">
                        <h1 id="user__tab-title">Ayarlar</h1>
                        <p id="user__tab-subtitle">Hesap ayarlarınızı yönetin</p>
                    </div>

                    <div id="user__settings-list">
                        <div class="user__settings-item">
                            <div class="user__settings-info">
                                <h3 class="user__settings-title">E-posta Bildirimleri</h3>
                                <p class="user__settings-desc">Sipariş ve kampanya bildirimlerini e-posta ile alın</p>
                            </div>
                            <label class="user__settings-toggle">
                                <input type="checkbox" checked>
                                <span></span>
                            </label>
                        </div>

                        <div class="user__settings-item">
                            <div class="user__settings-info">
                                <h3 class="user__settings-title">SMS Bildirimleri</h3>
                                <p class="user__settings-desc">Önemli bildirimleri SMS ile alın</p>
                            </div>
                            <label class="user__settings-toggle">
                                <input type="checkbox">
                                <span></span>
                            </label>
                        </div>

                        <div class="user__settings-item">
                            <div class="user__settings-info">
                                <h3 class="user__settings-title">Dil</h3>
                                <p class="user__settings-desc">Arayüz dilini seçin</p>
                            </div>
                            <select class="user__settings-select">
                                <option value="tr" selected>Türkçe</option>
                                <option value="en">English</option>
                                <option value="az">Azərbaycan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

@endsection

