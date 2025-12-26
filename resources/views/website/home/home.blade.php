@extends("layouts.app")


@section("content")

 <div class="container my-4">
        <div class="row g-3">
            <!-- Sol Taraf - Slider -->
            <div class="col-lg-8">
                <div class="slider-wrapper">
                    <div class="swiper main-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="slide-content" style="background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&q=80');">
                                    <div class="slide-overlay"></div>
                                    <div class="slide-text">
                                        <h2 class="slide-title">Yeni Koleksiyon</h2>
                                        <p class="slide-description">Şık ve modern tasarımlarla gardırobunuzu yenileyin</p>
                                        <a href="#" class="btn-slide">
                                            <span>Keşfet</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slide-content" style="background-image: url('https://images.unsplash.com/photo-1445205170230-053b83016050?w=1200&q=80');">
                                    <div class="slide-overlay"></div>
                                    <div class="slide-text">
                                        <h2 class="slide-title">Özel İndirimler</h2>
                                        <p class="slide-description">Seçili ürünlerde %50'ye varan indirimler</p>
                                        <a href="#" class="btn-slide">
                                            <span>Alışverişe Başla</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="slide-content" style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1200&q=80');">
                                    <div class="slide-overlay"></div>
                                    <div class="slide-text">
                                        <h2 class="slide-title">Premium Kalite</h2>
                                        <p class="slide-description">En kaliteli malzemelerle üretilmiş ürünler</p>
                                        <a href="#" class="btn-slide">
                                            <span>İncele</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>

            <!-- Sağ Taraf - Kampanyalı Ürünler -->
            <div class="col-lg-4">
                <div class="campaign-section">
                    <div class="campaign-header">
                        <div class="campaign-header-content">
                            <h3 class="campaign-title"> @lang('home.campaign_title') </h3>
                            <div class="countdown-timer">
                                <div class="countdown-display">
                                    <span class="countdown-item">
                                        <span class="countdown-value" id="days">00</span>
                                        <span class="countdown-label-small">@lang('home.day')</span>
                                    </span>
                                    <span class="countdown-separator">:</span>
                                    <span class="countdown-item">
                                        <span class="countdown-value" id="hours">00</span>
                                    </span>
                                    <span class="countdown-separator">:</span>
                                    <span class="countdown-item">
                                        <span class="countdown-value" id="minutes">00</span>
                                    </span>
                                    <span class="countdown-separator">:</span>
                                    <span class="countdown-item">
                                        <span class="countdown-value" id="seconds">00</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="campaign-slider-wrapper">
                        <div class="swiper campaign-slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="campaign-item">
                                        <div class="product-header">
                                            <h4 class="product-name">
                                                <a href="#">Premium Elbise</a>
                                            </h4>
                                            <div class="product-brand">
                                                <span class="brand-text"></span>
                                            </div>
                                        </div>
                                        <div class="product-image-wrapper">
                                            <a href="#" class="product-image">
                                                <img src="https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?w=400&q=80" alt="Premium Elbise">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="campaign-item">
                                        <div class="product-header">
                                            <h4 class="product-name">
                                                <a href="#">Klasik Gömlek</a>
                                            </h4>
                                            <div class="product-brand">
                                                <span class="brand-text">Yetkili Satıcı</span>
                                            </div>
                                        </div>
                                        <div class="product-image-wrapper">
                                            <a href="#" class="product-image">
                                                <img src="https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=400&q=80" alt="Klasik Gömlek">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="campaign-item">
                                        <div class="product-header">
                                            <h4 class="product-name">
                                                <a href="#">Şık Ceket</a>
                                            </h4>
                                            <div class="product-brand">
                                                <span class="brand-text">Yetkili Satıcı</span>
                                            </div>
                                        </div>
                                        <div class="product-image-wrapper">
                                            <a href="#" class="product-image">
                                                <img src="https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&q=80" alt="Şık Ceket">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide">
                                    <div class="campaign-item">
                                        <div class="product-header">
                                            <h4 class="product-name">
                                                <a href="#">Elegant Pantolon</a>
                                            </h4>
                                            <div class="product-brand">
                                                <span class="brand-text">Yetkili Satıcı</span>
                                            </div>
                                        </div>
                                        <div class="product-image-wrapper">
                                            <a href="#" class="product-image">
                                                <img src="https://images.unsplash.com/photo-1473966968600-fa801b869a1a?w=400&q=80" alt="Elegant Pantolon">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pagination -->
                            <div class="swiper-pagination campaign-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



     <main id="product__slider__section">
        <div class="container">
            <!-- Slider -->
            <div id="product__slider__wrapper">
                <!-- Top Row: Header + Navigation -->
                <div id="product__slider__top">
                    <header id="product__slider__header">
                        <span id="product__slider__badge">
                            <i class="bi bi-gem"></i>
                           @lang('home.premium_collection')
                        </span>
                        <h1 id="product__slider__title">@lang('home.featured_products')</h1>
                        <p id="product__slider__subtitle">@lang('home.featured_subtitle')</p>
                    </header>

                    <!-- Navigation -->
                    <div id="product__slider__navigation">
                        <button class="product__slider__nav swiper-nav--prev" aria-label="Önceki">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <button class="product__slider__nav swiper-nav--next" aria-label="Sonraki">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <div class="swiper" id="product__slider__swiper">
                    <div class="swiper-wrapper">


                        @foreach ($products as $product)


                        <!-- Product 5 -->
                        <div class="swiper-slide">
                            <article class="product__slider__card" data-product-id="{{ $product->id }}">
                                @if($product->has_discount)
                                    <div class="product__slider__card__badges">
                                        <span class="product__slider__badge-item badge--discount">
                                            {{ $product->discount_price }}
                                        </span>
                                    </div>
                                @endif

                              <x-favorite-button
                                    :product-id="$product->id"
                                    :is-favorite="isset($favorites[$product->id])"
                                />

                                <figure class="product__slider__card__image">
                                    <img src="{{ asset('/storage/products/' . $product->mainImage->image) }}"
                                         alt="Deri Çanta"
                                         loading="lazy">
                                    <div class="product__slider__card__overlay">
                                       <a href="{{ locale_route('product.detail', ['slug' => $product->localized_slug]) }}"
                                            class="product__slider__btn-quick-view">
                                                <i class="bi bi-eye"></i>
                                                @lang('home.quick_view')
                                            </a>
                                    </div>
                                </figure>

                                <div class="product__slider__card__content">
                                    <span class="product__slider__card__category">{{ $product->category->localized_name }}</span>
                                    <h3 class="product__slider__card__title">{{ $product->localized_name }}</h3>

                                    <div class="product__slider__card__rating">
                                        <div class="product__slider__stars">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                        <span class="product__slider__rating-count">(178)</span>
                                    </div>

                                    <div class="product__slider__card__pricing">
                                       @if($product->has_discount)
                                        <span class="product__slider__price-current">
                                            {{ $product->discount_price_formatted }}
                                            <small class="currency">AZN</small>
                                        </span>

                                        <span class="product__slider__price-original">
                                            {{ $product->price_formatted }}
                                            <small class="currency">AZN</small>
                                        </span>
                                    @else
                                        <span class="product__slider__price-current">
                                            {{ $product->price_formatted }}
                                            <small class="currency">AZN</small>
                                        </span>
                                    @endif
                                    </div>

                                   <button
                                    type="button"
                                    class="product__slider__card__add-to-cart"
                                    data-id="{{ $product->id }}"
                                >
                                    <i class="bi bi-bag-plus"></i>
                                    <span>@lang('home.add_to_cart')</span>
                                </button>


                                </div>
                            </article>
                        </div>
                        @endforeach


                    </div>
                </div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>

            <!-- View All -->
            <div class="text-center mt-5">
                <a href="#" class="product__slider__btn-view-all">
                    <span>@lang('home.view_all')</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </main>






@endsection
