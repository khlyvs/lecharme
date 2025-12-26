@extends("layouts.app")

@section('content')
<div id="filter__page" class="filter__page" data-filter-url="{{ request()->url() }}">
    <!-- Mobile Filter Toggle Button -->
    <button id="filter__mobile-toggle" class="filter__mobile-toggle" aria-label="Filtreleri aç" aria-expanded="false" aria-controls="filter__sidebar">
        <i class="bi bi-funnel" aria-hidden="true"></i>
        <span> @lang('filters.filter')</span>
    </button>

    <!-- Mobile Overlay -->
    <div id="filter__overlay" class="filter__overlay" aria-hidden="true"></div>

    <div class="filter__wrapper">
        <!-- Sidebar Filters -->
        <aside id="filter__sidebar" class="filter__sidebar" role="region" aria-label="Filtreler">
            <div id="filter__header" class="filter__header">
                <h2 id="filter__title" class="filter__title">@lang('filters.filter')</h2>
                <div class="filter__header-actions">
                    <button id="filter__clear" class="filter__btn-clear" type="button">
                        <i class="bi bi-x-circle" aria-hidden="true"></i>
                        @lang('filters.clear')
                    </button>
                </div>
            </div>

            <!-- Mobile Close Button -->
            <button id="filter__close" class="filter__btn-close" type="button" aria-label="Filtreleri kapat">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>

            <!-- Price Range -->
            <div class="filter__section">
                <h3 class="filter__section-title">@lang('filters.price_range')</h3>
                <div class="filter__price-inputs">
                    <input type="number"
                           id="filter__price-min"
                           name="min_price"
                           class="filter__price-input"
                           placeholder="Min"
                           min="0"
                           value="{{ $filters['min_price'] ?? '' }}"
                           aria-label="Minimum fiyat">
                    <span class="filter__price-separator" aria-hidden="true">-</span>
                    <input type="number"
                           id="filter__price-max"
                           name="max_price"
                           class="filter__price-input"
                           placeholder="Max"
                           min="0"
                           value="{{ $filters['max_price'] ?? '' }}"
                           aria-label="Maximum fiyat">
                </div>
            </div>

            <!-- SubCategories - Dinamik (yalnız kateqoriya səhifəsində) -->
            @if(isset($category) && !isset($subcategory) && $category->subcategories->count() > 0)
                <div class="filter__section">
                    <h3 class="filter__section-title">@lang('filters.subcategories')</h3>
                    @foreach($category->subcategories as $sub)
                        <label class="filter__checkbox">
                            <input type="checkbox"
                                   name="subcategories[]"
                                   value="{{ $sub->id }}"
                                   {{ in_array($sub->id, $filters['subcategories'] ?? []) ? 'checked' : '' }}>
                            <span class="filter__checkbox-label">
                                {{ $sub->localized_name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            @endif

            <!-- Badges / Özelliklər -->
            <div class="filter__section">
                <h3 class="filter__section-title">@lang('filters.features')</h3>
                <div class="filter__badge-group" role="group" aria-label="Ürün özellikleri">
                    <button class="filter__badge {{ ($filters['has_discount'] ?? false) ? 'active' : '' }}"
                            data-badge="discount"
                            type="button"
                            aria-pressed="{{ ($filters['has_discount'] ?? false) ? 'true' : 'false' }}">
                        <i class="bi bi-percent" aria-hidden="true"></i>
                        @lang('filters.discounted')
                    </button>
                </div>
            </div>

            <!-- Apply Button (mobile only - desktop filters are instant) -->
            <button id="filter__apply" class="filter__btn-apply filter__mobile-only" type="button">
                <i class="bi bi-funnel" aria-hidden="true"></i>
                @lang('filters.apply')
            </button>
        </aside>

        <!-- Main Content -->
        <main id="filter__main" class="filter__main">
            <div id="filter__topbar" class="filter__topbar">
                <div id="filter__results" class="filter__results">
                    <h1 id="filter__results-title" class="filter__results-title">
                        {{ $subcategory->localized_name ?? $category->localized_name ?? __('filters.products') }}
                    </h1>
                    <p id="filter__results-count" class="filter__results-count" aria-live="polite">
                        {{ $products->total() }} @lang('filters.products_found')
                    </p>
                </div>
                <div id="filter__sort" class="filter__sort">
                    <label for="filter__sort-select" class="filter__sort-label">@lang('filters.sort_by')</label>
                    <select id="filter__sort-select" class="filter__sort-select" name="sort">
                        <option value="default" {{ ($filters['sort'] ?? 'default') === 'default' ? 'selected' : '' }}>
                            @lang('filters.default')
                        </option>
                        <option value="price-low" {{ ($filters['sort'] ?? '') === 'price-low' ? 'selected' : '' }}>
                            @lang('filters.price_low_high')
                        </option>
                        <option value="price-high" {{ ($filters['sort'] ?? '') === 'price-high' ? 'selected' : '' }}>
                            @lang('filters.price_high_low')
                        </option>
                        <option value="newest" {{ ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' }}>
                            @lang('filters.newest')
                        </option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div id="filter__products-grid" class="filter__products-grid" role="list">
                @include('website.filter.partials.products')
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div id="filter__pagination" class="filter__pagination">
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif
        </main>
    </div>
</div>

@push('scripts')
<script src="{{ asset('website/js/filter.js') }}"></script>
@endpush
@endsection
