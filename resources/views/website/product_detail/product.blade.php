@extends('layouts.app')


@section('content')

 <nav id="product_detail___breadcrumb">
        <div id="product_detail___breadcrumb_container">
            <a href="{{ locale_route('dashboard') }}"> @lang('home.main_page') </a>
            <span>/</span>
          <a href="{{ locale_route('category.show', ['slug' => $product->category->localized_slug]) }}">
                {{ $product->category->localized_name }}
        </a>

            <span>/</span>
            <span id="product_detail___breadcrumb_current">{{ $product->localized_name }}</span>
        </div>
    </nav>
<!-- Lightbox Modal -->
<div id="product_detail___lightbox">
    <button id="product_detail___lightbox_close"></button>
    <div id="product_detail___lightbox_container">
        <button id="product_detail___lightbox_prev"></button>
        <div id="product_detail___lightbox_slides">
            @foreach ($product->images as $index => $image)
                <img src="{{ asset('storage/products/' . $image->image) }}"
                     alt="{{ $product->localized_name }} {{ $index + 1 }}"
                     class="{{ $index === 0 ? 'active' : '' }}">
            @endforeach
        </div>
        <button id="product_detail___lightbox_next"></button>
        <span id="product_detail___lightbox_counter">1 / {{ count($product->images) }}</span>
    </div>
    <div id="product_detail___lightbox_thumbs">
        @foreach ($product->images as $index => $image)
            <img src="{{ asset('storage/products/' . $image->image) }}"
                 alt="Thumb {{ $index + 1 }}"
                 class="{{ $index === 0 ? 'active' : '' }}"
                 data-index="{{ $index }}">
        @endforeach
    </div>
</div>
    <!-- Product Detail -->
    <main id="product_detail___main">
        <div id="product_detail___container">
            <div id="product_detail___grid">
            {{-- {{ dd($product->images) }} --}}
                <!-- Gallery -->
                <div id="product_detail___gallery">
                    <!-- Hidden radios for gallery -->
                    @foreach ($product->images as $index => $image)
                        <input
                            type="radio"
                            name="gallery"
                            id="product_detail___gallery_radio_{{ $index }}"
                            {{ $index === 0 ? 'checked' : '' }}
                        >
                    @endforeach
                    <div id="product_detail___gallery_wrapper">
                        <div id="product_detail___gallery_main">
                            <div id="product_detail___gallery_badges">
                                <span id="product_detail___badge_new">Yeni</span>
                                <span id="product_detail___badge_discount">-25%</span>
                            </div>
                            @foreach ($product->images as $image)
                               <img src="{{ asset('storage/products/'.$image->image) }}" alt="{{ $product->localized_name }}">
                            @endforeach


                        </div>

                        <div id="product_detail___gallery_thumbs">
                           @foreach ($product->images as $index => $image)
                                <label for="product_detail___gallery_radio_{{ $index }}">
                                    <img
                                        src="{{ asset('storage/products/' . $image->image) }}"
                                        alt="{{ $product->localized_name }} {{ $index + 1 }}"
                                    >
                                </label>
                            @endforeach


                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div id="product_detail___info">
                    <span id="product_detail___category">
                        <i class="bi bi-smartwatch"></i>
                        {{ $product->subcategory->localized_name }}
                    </span>

                    <h1 id="product_detail___title">{{ $product->localized_name }}</h1>

                    <div id="product_detail___rating">
                        <div id="product_detail___rating_stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <span id="product_detail___rating_text"><strong>4.5</strong> / 5 (128 değerlendirme)</span>
                    </div>

                    <div id="product_detail___pricing">
                        <div id="product_detail___price_row">
                            <span id="product_detail___price_current">{{ number_format($product->price, 0, ',', '.') }} AZN</span>
                        </div>
                    </div>

                    <p id="product_detail___desc">
                        {{ $product->localized_description }}
                    </p>

                    <!-- Quantity -->
                    <div id="product_detail___option_qty">
                        <label id="product_detail___option_qty_label">Adet</label>
                        <div id="product_detail___qty_selector">
                            <button id="product_detail___qty_minus" onclick="changeQty(-1)">−</button>
                            <input type="number" id="product_detail___qty_input" value="1" min="1" max="10">
                            <button id="product_detail___qty_plus" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div id="product_detail___actions">
                        <button id="product_detail___btn_cart" data-product-id="{{ $product->id }}">
                            <i class="bi bi-bag-plus"></i>
                            Səbətə əlavə et
                        </button>
                        <button id="product_detail___btn_wishlist" aria-label="Favorilere Ekle"
                        data-product-id="{{ $product->id }}">
                            <i class="bi {{ $favorites->has($product->id) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>

                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <section id="product_detail___tabs">
                <input type="radio" name="tab" id="product_detail___tab_radio_1" checked>
                <input type="radio" name="tab" id="product_detail___tab_radio_2">
                <input type="radio" name="tab" id="product_detail___tab_radio_3">

                <nav id="product_detail___tab_nav">
                    <label for="product_detail___tab_radio_1">Ürün Açıklaması</label>
                    <label for="product_detail___tab_radio_2">Özellikler</label>
                    <label for="product_detail___tab_radio_3">Değerlendirmeler</label>
                </nav>

                <div id="product_detail___tab_panels">
                    <!-- Description -->
                    <article id="product_detail___tab_desc">
                        <h4>Premium Akıllı Saat Pro ile Hayatı Akıllıca Yaşayın</h4>
                        <p>
                            Günlük aktivitelerinizi takip edin, sağlığınızı izleyin ve bağlantıda kalın.
                            Premium Akıllı Saat Pro, şık tasarımı ve güçlü özellikleriyle hayatınızı kolaylaştırmak için tasarlandı.
                            En son teknoloji sensörleri ve gelişmiş algoritmaları ile sağlık verilerinizi doğru bir şekilde analiz eder.
                        </p>

                        <h4>Öne Çıkan Özellikler</h4>
                        <ul>
                            <li>1.8" Super AMOLED Always-On Display</li>
                            <li>7 günü aşan batarya ömrü</li>
                            <li>50+ spor modu ve otomatik antrenman algılama</li>
                            <li>Gelişmiş kalp ritmi ve SpO2 izleme</li>
                            <li>IP68 su ve toz geçirmezlik</li>
                            <li>GPS + GLONASS konum takibi</li>
                            <li>Bluetooth 5.2 ve WiFi bağlantısı</li>
                            <li>Hızlı şarj teknolojisi - 15 dakikada 1 gün kullanım</li>
                        </ul>
                    </article>

                    <!-- Specs -->
                    <article id="product_detail___tab_specs">
                        <table id="product_detail___specs_table">
                            <tr>
                                <td>Ekran</td>
                                <td>1.8" Super AMOLED, 466x466 piksel, 326 PPI</td>
                            </tr>
                            <tr>
                                <td>Kasa Malzemesi</td>
                                <td>Titanyum Alaşım + Safir Cam</td>
                            </tr>
                            <tr>
                                <td>Kordon</td>
                                <td>Silikon / Deri (değiştirilebilir)</td>
                            </tr>
                            <tr>
                                <td>Batarya</td>
                                <td>420mAh, 7+ gün kullanım</td>
                            </tr>
                            <tr>
                                <td>Su Dayanıklılığı</td>
                                <td>IP68, 5ATM (50m derinliğe kadar)</td>
                            </tr>
                            <tr>
                                <td>Bağlantı</td>
                                <td>Bluetooth 5.2, WiFi 802.11 b/g/n, NFC</td>
                            </tr>
                            <tr>
                                <td>Sensörler</td>
                                <td>Kalp ritmi, SpO2, İvmeölçer, Jiroskop, Barometrik altimetre</td>
                            </tr>
                            <tr>
                                <td>Konum</td>
                                <td>GPS, GLONASS, Galileo, BeiDou</td>
                            </tr>
                            <tr>
                                <td>Uyumluluk</td>
                                <td>iOS 13+, Android 8.0+</td>
                            </tr>
                            <tr>
                                <td>Boyutlar</td>
                                <td>44 x 38 x 10.7 mm</td>
                            </tr>
                            <tr>
                                <td>Ağırlık</td>
                                <td>32g (kordon hariç)</td>
                            </tr>
                            <tr>
                                <td>Kutu İçeriği</td>
                                <td>Saat, Manyetik Şarj Kablosu, 2x Kordon, Kullanım Kılavuzu</td>
                            </tr>
                        </table>
                    </article>

                    <!-- Reviews -->
                    <article id="product_detail___tab_reviews">
                        <div id="product_detail___reviews_summary">
                            <div id="product_detail___reviews_average">
                                <div id="product_detail___reviews_score">4.5</div>
                                <div id="product_detail___reviews_stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <p id="product_detail___reviews_total">128 değerlendirme</p>
                            </div>
                            <div id="product_detail___reviews_bars">
                                <div id="product_detail___review_bar_5">
                                    <span>5</span>
                                    <div><div style="width: 68%"></div></div>
                                </div>
                                <div id="product_detail___review_bar_4">
                                    <span>4</span>
                                    <div><div style="width: 22%"></div></div>
                                </div>
                                <div id="product_detail___review_bar_3">
                                    <span>3</span>
                                    <div><div style="width: 6%"></div></div>
                                </div>
                                <div id="product_detail___review_bar_2">
                                    <span>2</span>
                                    <div><div style="width: 3%"></div></div>
                                </div>
                                <div id="product_detail___review_bar_1">
                                    <span>1</span>
                                    <div><div style="width: 1%"></div></div>
                                </div>
                            </div>
                        </div>

                        <div id="product_detail___reviews_list">
                            <div id="product_detail___review_1">
                                <div>
                                    <div>AK</div>
                                    <div>
                                        <h5>Ahmet K.</h5>
                                        <div>
                                            <div>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <span>•</span>
                                            <span>2 hafta önce</span>
                                            <span>•</span>
                                            <span>Onaylı Alıcı</span>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    Harika bir ürün! Batarya ömrü gerçekten uzun, ekran kalitesi mükemmel. Fitness takibi çok doğru çalışıyor.
                                    Kesinlikle tavsiye ederim.
                                </p>
                            </div>

                            <div id="product_detail___review_2">
                                <div>
                                    <div>SY</div>
                                    <div>
                                        <h5>Selin Y.</h5>
                                        <div>
                                            <div>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                            </div>
                                            <span>•</span>
                                            <span>1 ay önce</span>
                                            <span>•</span>
                                            <span>Onaylı Alıcı</span>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    Tasarım çok şık, günlük kullanımda çok memnun kaldım. Tek eksisi uygulama biraz yavaş açılıyor,
                                    ama genel olarak fiyat/performans açısından çok iyi.
                                </p>
                            </div>

                            <div id="product_detail___review_3">
                                <div>
                                    <div>MÖ</div>
                                    <div>
                                        <h5>Mehmet Ö.</h5>
                                        <div>
                                            <div>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <span>•</span>
                                            <span>1 ay önce</span>
                                            <span>•</span>
                                            <span>Onaylı Alıcı</span>
                                        </div>
                                    </div>
                                </div>
                                <p>
                                    Daha önce kullandığım saatlerden çok daha kaliteli. Özellikle uyku takibi ve kalp ritmi ölçümü çok başarılı.
                                    Hızlı kargo ve güzel paketleme için de ayrıca teşekkürler.
                                </p>
                            </div>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$('#product_detail___btn_wishlist').on('click', function (e) {
    e.preventDefault();

    let btn = $(this);
    let icon = btn.find('i');

    // ❗ DÜZƏLİŞ BURADADIR
    let productId = btn.data('product-id');

    $.ajax({
        url: '/favorite/' + productId,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function () {
            icon.toggleClass('bi-heart bi-heart-fill');
            btn.toggleClass('active');
        },
        error: function (err) {
            console.log(err);
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('product_detail___lightbox');
    const galleryMain = document.getElementById('product_detail___gallery_main');
    const closeBtn = document.getElementById('product_detail___lightbox_close');
    const prevBtn = document.getElementById('product_detail___lightbox_prev');
    const nextBtn = document.getElementById('product_detail___lightbox_next');
    const slides = document.querySelectorAll('#product_detail___lightbox_slides img');
    const thumbs = document.querySelectorAll('#product_detail___lightbox_thumbs img');
    const counter = document.getElementById('product_detail___lightbox_counter');
    const slidesContainer = document.getElementById('product_detail___lightbox_slides');

    let currentIndex = 0;
    const totalSlides = slides.length;

    // Touch/Swipe değişkenleri
    let touchStartX = 0;
    let touchEndX = 0;
    const swipeThreshold = 50;

    // Ana resme tıklanınca lightbox aç
    galleryMain.addEventListener('click', function(e) {
        if (e.target.tagName === 'IMG') {
            const mainImages = galleryMain.querySelectorAll('img');
            mainImages.forEach((img, index) => {
                if (window.getComputedStyle(img).opacity === '1') {
                    currentIndex = index;
                }
            });
            openLightbox(currentIndex);
        }
    });

    function openLightbox(index) {
        currentIndex = index;
        updateSlide();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = '';
    }

    function updateSlide() {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === currentIndex);
        });
        thumbs.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === currentIndex);
        });
        counter.textContent = `${currentIndex + 1} / ${totalSlides}`;
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateSlide();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateSlide();
    }

    // Touch/Swipe olayları
    slidesContainer.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    slidesContainer.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        const swipeDistance = touchEndX - touchStartX;

        if (Math.abs(swipeDistance) > swipeThreshold) {
            if (swipeDistance > 0) {
                // Sağa kaydırma - önceki resim
                prevSlide();
            } else {
                // Sola kaydırma - sonraki resim
                nextSlide();
            }
        }
    }

    // Event listeners
    closeBtn.addEventListener('click', closeLightbox);
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    // Thumbnail tıklama
    thumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            currentIndex = index;
            updateSlide();
        });
    });

    // ESC tuşu ile kapat
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') nextSlide();
        if (e.key === 'ArrowLeft') prevSlide();
    });

    // Dış alana tıklayınca kapat
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) closeLightbox();
    });
});
</script>
@endsection


