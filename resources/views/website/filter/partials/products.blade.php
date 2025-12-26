@forelse ($products as $product)
    <article class="product__slider__card" data-product-id="{{ $product->id }}" role="listitem">
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
                 alt="{{ $product->localized_name }}"
                 loading="lazy"
                 decoding="async">
            <div class="product__slider__card__overlay">
                <a href="{{ locale_route('product.detail', ['slug' => $product->localized_slug]) }}"
                   class="product__slider__btn-quick-view">
                    <i class="bi bi-eye" aria-hidden="true"></i>
                    @lang('home.quick_view')
                </a>
            </div>
        </figure>

        <div class="product__slider__card__content">
            <span class="product__slider__card__category">{{ $product->category->localized_name }}</span>
            <h3 class="product__slider__card__title">{{ $product->localized_name }}</h3>

            <div class="product__slider__card__rating">
                <div class="product__slider__stars" aria-label="5 yıldız">
                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                </div>
                <span class="product__slider__rating-count">(0)</span>
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
                <i class="bi bi-bag-plus" aria-hidden="true"></i>
                <span>@lang('home.add_to_cart')</span>
            </button>
        </div>
    </article>
@empty
    <div class="filter__no-products">
        <p>@lang('filters.no_products_found')</p>
    </div>
@endforelse

