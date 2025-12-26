@props([
    'productId',
    'isFavorite' => false,
])

<button
    {{ $attributes->merge([
        'class' => 'product__slider__card__wishlist' . ($isFavorite ? ' active' : '')
    ]) }}
    data-id="{{ $productId }}"
    aria-label="Favorilere ekle"
>
    <i class="bi {{ $isFavorite ? 'bi-heart-fill' : 'bi-heart' }}"></i>
</button>
