<div class="offcanvas offcanvas-start" tabindex="-1" id="catalogMenu" aria-labelledby="catalogMenuLabel" data-bs-backdrop="false">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="catalogMenuLabel">
            <i class="bi bi-grid-3x3-gap"></i>
            <span class="catalog-title-text">Kataloq</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">
        <ul class="category-list" id="categoryList">
            @foreach($menuCategories ?? [] as $cat)
                <li class="category-item">
                    <a
                        href="{{ locale_route('category.show', ['slug' => $cat->localized_slug]) }}"
                        class="category-link"
                    >
                        <span>{{ $cat->localized_name }}</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>

                    <ul class="subcategory-menu">
                        @foreach($cat->subcategories ?? [] as $sub)
                            <li>
                                <a
                                    href="{{ locale_route('subcategory.show', [
                                        'categorySlug' => $cat->localized_slug,
                                        'subSlug' => $sub->localized_slug
                                    ]) }}"
                                    class="subcategory-link"
                                >{{ $sub->localized_name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>
