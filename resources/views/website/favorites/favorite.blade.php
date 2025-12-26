@extends('layouts.app')


@section('content')


<div id="favorites__page">
        <div id="favorites__container">

            <!-- Header -->
            <header id="favorites__header">
                <div id="favorites__header-left">
                    <h1 id="favorites__title">Favorilerim</h1>
                    <p id="favorites__subtitle"><span id="favorites__count">6</span> ürün</p>
                </div>
                <div id="favorites__header-right">
                    <div id="favorites__view-toggle">
                        <button class="favorites__view-btn active" data-view="grid" type="button">
                            <i class="bi bi-grid-3x3-gap"></i>
                        </button>
                        <button class="favorites__view-btn" data-view="list" type="button">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>

                </div>
            </header>

            <!-- Products Grid -->
            <main id="favorites__main">
                <div id="favorites__grid">

                   @foreach ($products as $product)
                    <article class="favorites__card" data-product-id="1">
                        <div class="favorites__card-badges">
                            <span class="favorites__badge badge--new">Yeni</span>
                            <span class="favorites__badge badge--discount">-25%</span>
                        </div>

                         <x-favorite-button
                                    :product-id="$product->id"
                                    :is-favorite="isset($favorites[$product->id])"
                         />

                        <figure class="favorites__card-image">
                            <img src="{{ asset('storage/products/' . $product->mainImage->image) }}"
                                 alt="Premium Akıllı Saat"
                                 loading="lazy">
                            <div class="favorites__card-overlay">
                                <button class="favorites__quick-view">
                                    <i class="bi bi-eye"></i>
                                    Hızlı Bakış
                                </button>
                            </div>
                        </figure>

                        <div class="favorites__card-content">
                            <span class="favorites__card-category">{{ $product->category->localized_name }}</span>
                            <h3 class="favorites__card-title">{{ $product->localized_name }}</h3>

                            <div class="favorites__card-rating">
                                <div class="favorites__stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <span class="favorites__rating-count">(128)</span>
                            </div>

                            <div class="favorites__card-pricing">
                                <span class="favorites__price-current">₺4.999</span>
                                <span class="favorites__price-original">₺6.699</span>
                            </div>

                            <button
                                    type="button"
                                    class="product__slider__card__add-to-cart"
                                    id="favorites__add-cart"
                                    data-id="{{ $product->id }}"
                                >
                                    <i class="bi bi-bag-plus"></i>
                                    <span>@lang('home.add_to_cart')</span>
                                </button>
                        </div>
                    </article>
                   @endforeach




                </div>

                <!-- Empty State -->
                <div id="favorites__empty" style="display: none;">
                    <i class="bi bi-heart"></i>
                    <h2>Henüz favoriniz yok</h2>
                    <p>Beğendiğiniz ürünleri kalp ikonuna tıklayarak favorilerinize ekleyebilirsiniz.</p>
                    <a href="/products" id="favorites__empty-btn">
                        <i class="bi bi-bag"></i>
                        Alışverişe Başla
                    </a>
                </div>
            </main>

        </div>
    </div>
@endsection
