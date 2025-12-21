@extends("layouts.manager")
@section("content")

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-place="true" data-kt-place-mode="prepend" data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3 flex-wrap mb-5 mb-lg-0 lh-1">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Məhsullar</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-200 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="index.php?module=dashboard&page=main" class="text-muted text-hover-primary">Baş Səhifə</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Məhsullar</li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-200 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-dark">Məhsullar List'i</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <!--begin::Svg Icon | path: icons/duotone/General/Search.svg-->
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <input type="text" type="text" autocomplete="off" id="live_search" class="form-control form-control-solid w-250px ps-15" placeholder="Axtar" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <!--begin::Add customer-->
                                <!-- Yeni Modal Açma Butonu -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#my_new_modal">
                                    Əlavə et
                                </button>
                                <!--end::Add customer-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card toolbar-->

                        <!--begin::Modal-->
                        <div class="modal fade" id="my_new_modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered mw-900px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Yeni Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" id="add_product_form">
                                            @csrf

                                            {{-- ERRORS --}}
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            {{-- ================= CATEGORY ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Kateqoriya</label>
                                                <select name="category_id" id="category_select" class="form-select" required>
                                                    <option value="">Seçin</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name_az }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- ================= SUBCATEGORY ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Alt Kateqoriya</label>
                                                <select name="subcategory_id" id="subcategory_select" class="form-select">
                                                    <option value="">Seçin</option>
                                                </select>
                                            </div>

                                            {{-- ================= NAME ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Məhsul Adı (AZ)</label>
                                                <input type="text" class="form-control" name="name_az" value="{{ old('name_az') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Название продукта (RU)</label>
                                                <input type="text" class="form-control" name="name_ru" value="{{ old('name_ru') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Product Name (EN)</label>
                                                <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}">
                                            </div>

                                            {{-- ================= DESCRIPTION ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Açıqlama (AZ)</label>
                                                <textarea name="description_az" class="form-control" rows="3">{{ old('description_az') }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Описание (RU)</label>
                                                <textarea name="description_ru" class="form-control" rows="3">{{ old('description_ru') }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Description (EN)</label>
                                                <textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea>
                                            </div>

                                            {{-- ================= SLUG ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Slug (AZ)</label>
                                                <input type="text" class="form-control" name="slug_az" value="{{ old('slug_az') }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Slug (RU)</label>
                                                <input type="text" class="form-control" name="slug_ru" value="{{ old('slug_ru') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Slug (EN)</label>
                                                <input type="text" class="form-control" name="slug_en" value="{{ old('slug_en') }}">
                                            </div>

                                            {{-- ================= META TITLE ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Meta Title (AZ)</label>
                                                <input type="text" class="form-control" name="meta_title_az" value="{{ old('meta_title_az') }}" placeholder="50–60 simvol">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Meta Title (RU)</label>
                                                <input type="text" class="form-control" name="meta_title_ru" value="{{ old('meta_title_ru') }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Meta Title (EN)</label>
                                                <input type="text" class="form-control" name="meta_title_en" value="{{ old('meta_title_en') }}">
                                            </div>

                                            {{-- ================= META DESCRIPTION ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Meta Description (AZ)</label>
                                                <textarea name="meta_description_az" class="form-control" rows="2" placeholder="140–160 simvol">{{ old('meta_description_az') }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Meta Description (RU)</label>
                                                <textarea name="meta_description_ru" class="form-control" rows="2">{{ old('meta_description_ru') }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Meta Description (EN)</label>
                                                <textarea name="meta_description_en" class="form-control" rows="2">{{ old('meta_description_en') }}</textarea>
                                            </div>

                                            {{-- ================= PRICE ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Qiymət</label>
                                                <input type="number" class="form-control" name="price" step="0.01" value="{{ old('price') }}" required>
                                            </div>

                                            {{-- ================= DISCOUNT ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Endirimli Qiymət</label>
                                                <input type="number" class="form-control" name="discount_price" step="0.01" value="{{ old('discount_price') }}">
                                            </div>

                                            {{-- ================= STOCK ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Stok</label>
                                                <input type="number" class="form-control" name="stock" value="{{ old('stock', 0) }}">
                                            </div>

                                            {{-- ================= IMAGES ================= --}}
                                            <div class="mb-3">
                                                <label class="form-label">Şəkillər</label>
                                                <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                                                <small class="text-muted">
                                                    Birdən çox şəkil üçün <b>Ctrl</b> basılı saxla
                                                </small>
                                            </div>

                                            {{-- ================= STATUS ================= --}}
                                            <div class="mb-3">
                                                <label class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                    <span class="form-check-label">Aktiv</span>
                                                </label>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ləğv et</button>
                                        <button type="submit" form="add_product_form" class="btn btn-primary">Əlavə et</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Modal-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div id="kt_customers_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table" role="grid">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                            <th class="min-w-125px">Adı</th>
                                            <th class="min-w-50px">Kateqoriya</th>
                                            <th class="min-w-125px">Subkateqoriya</th>
                                            <th class="min-w-50px">Qiymət</th>
                                            <th class="min-w-50px">Endirim</th>
                                            <th class="min-w-50px">Status</th>
                                            <th class="text-end min-w-70px">Əməliyyatlar</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody id="not_search" class="fw-bold text-gray-600">
                                         @foreach ($products as $product)
                                            <tr>
                                                <td>
                                                    <a href="#" class="text-dark fw-bold">{{ $product->name_az}}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-dark fw-bold">{{ $product->category->name_az}}</a>
                                                </td>
                                                 <td>
                                                    <a href="#" class="text-dark fw-bold">{{ $product->subcategory->name_az}}</a>
                                                </td>

                                                <td>
                                                    <a href="#" class="text-dark fw-bold">{{ $product->price}} AZN</a>
                                                </td>

                                                <td>
                                                    <a href="#" class="text-dark fw-bold">{{ $product->discount_price}} %</a>
                                                </td>
                                                <td>
                                                    @if($product->is_active == 1)
                                                        <i class="fa-solid fa-circle-check" style="color:#06923E; font-size:20px;"></i>
                                                    @else
                                                        <i class="fa-solid fa-circle-xmark" style="color:#f1416c; font-size:20px;"></i>
                                                    @endif
                                                </td>
                                                <!--end::Date=-->
                                                <!--begin::Action=-->
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-dark btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                                        Əməliyyatlar
                                                        <!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                                                                </g>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3 edit-admin-link" data-bs-toggle="modal" data-bs-target="#edit_modal_{{ $product->id }}" data-slider-id="">
                                                                Redaktə Et
                                                            </a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('slider.store', $product->id) }}" class="menu-link px-3 delete-link">Sil</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!--begin::Edit Customer Modal-->
                                            <div class="modal fade" id="edit_modal_{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered mw-900px">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Slayd Redaktə</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bağla"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('product.update',$product->id) }}" method="POST" id="edit_product_form" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')

                                                                {{-- ================= CATEGORY ================= --}}
                                                                  <div class="mb-3">
                                                                     <label class="form-label">Kateqoriya</label>
                                                                        <select name="category_id"
                                                                                id="category_select_{{ $product->id }}"
                                                                                class="form-select"
                                                                                required>

                                                                            <option value="">Seçin</option>

                                                                            @foreach($categories as $category)
                                                                                <option value="{{ $category->id }}"
                                                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                                                    {{ $category->name_az }}
                                                                                </option>
                                                                            @endforeach

                                                                        </select>
                                                                  </div>

                                                                {{-- ================= SUBCATEGORY ================= --}}
                                                                <div class="mb-3">
                                                                     <label class="form-label">Sub Kateqoriya</label>
                                                                        <select name="subcategory_id"
                                                                                    id="subcategory_select_{{ $product->id }}"
                                                                                    class="form-select">

                                                                                <option value="">Seçin</option>

                                                                                {{-- ilk açılış üçün --}}
                                                                                @if($product->subcategory)
                                                                                    <option value="{{ $product->subcategory->id }}" selected>
                                                                                        {{ $product->subcategory->name_az }}
                                                                                    </option>
                                                                                @endif

                                                                            </select>
                                                                </div>

                                                                {{-- ================= NAME ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Məhsul Adı (AZ)</label>
                                                                    <input type="text" class="form-control" name="name_az" value="{{ $product->name_az }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Название продукта (RU)</label>
                                                                    <input type="text" class="form-control" name="name_ru" value="{{ $product->name_ru }}">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Product Name (EN)</label>
                                                                    <input type="text" class="form-control" name="name_en" value="{{ $product->name_en }}">
                                                                </div>

                                                                {{-- ================= DESCRIPTION ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Açıqlama (AZ)</label>
                                                                    <textarea name="description_az" class="form-control" rows="3">{{ $product->description_az }}</textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Описание (RU)</label>
                                                                    <textarea name="description_ru" class="form-control" rows="3">{{ $product->description_ru }}</textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Description (EN)</label>
                                                                    <textarea name="description_en" class="form-control" rows="3">{{ $product->description_en }}</textarea>
                                                                </div>

                                                                {{-- ================= SLUG ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Slug (AZ)</label>
                                                                    <input type="text" class="form-control" name="slug_az" value="{{ $product->slug_az }}" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Slug (RU)</label>
                                                                    <input type="text" class="form-control" name="slug_ru" value="{{ $product->slug_ru }}">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Slug (EN)</label>
                                                                    <input type="text" class="form-control" name="slug_en" value="{{ $product->slug_en }}">
                                                                </div>

                                                                {{-- ================= META TITLE ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Meta Title (AZ)</label>
                                                                    <input type="text" class="form-control" name="meta_title_az" value="{{ $product->meta_title_az }}" placeholder="50–60 simvol">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Meta Title (RU)</label>
                                                                    <input type="text" class="form-control" name="meta_title_ru" value="{{ $product->meta_title_ru }}">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Meta Title (EN)</label>
                                                                    <input type="text" class="form-control" name="meta_title_en" value="{{ $product->meta_title_en }}">
                                                                </div>

                                                                {{-- ================= META DESCRIPTION ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Meta Description (AZ)</label>
                                                                    <textarea name="meta_description_az" class="form-control" rows="2" placeholder="140–160 simvol">{{ $product->meta_description_az }}</textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Meta Description (RU)</label>
                                                                    <textarea name="meta_description_ru" class="form-control" rows="2">{{ $product->meta_description_ru }}</textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Meta Description (EN)</label>
                                                                    <textarea name="meta_description_en" class="form-control" rows="2">{{ $product->meta_description_en }}</textarea>
                                                                </div>

                                                                {{-- ================= PRICE ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Qiymət</label>
                                                                    <input type="number" class="form-control" name="price" step="0.01" value="{{ $product->price }}" required>
                                                                </div>

                                                                {{-- ================= DISCOUNT ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Endirimli Qiymət</label>
                                                                    <input type="number" class="form-control" name="discount_price" step="0.01" value="{{ $product->discount_price }}">
                                                                </div>

                                                                {{-- ================= STOCK ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Stok</label>
                                                                    <input type="number" class="form-control" name="stock" value="{{ $product->stock }}">
                                                                </div>

                                                                {{-- ================= IMAGES ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-label">Şəkillər</label>
                                                                    <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                                                                    <small class="text-muted">
                                                                        Birdən çox şəkil üçün <b>Ctrl</b> basılı saxla
                                                                    </small>
                                                                </div>

                                                                {{-- ================= STATUS ================= --}}
                                                                <div class="mb-3">
                                                                    <label class="form-check form-switch">
                                                                        <input type="checkbox" class="form-check-input" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}>
                                                                        <span class="form-check-label">Aktiv</span>
                                                                    </label>
                                                                </div>
                                                            </form>
                                                        </div>
                                                       @if($product->images->count())
    <div class="mb-4">
        <label class="form-label fw-bold">Mövcud Şəkillər</label>

        <div class="row g-3">
            @foreach($product->images as $image)
                <div class="col-6 col-md-3">

                    <div class="card h-100 shadow-sm">

                        {{-- IMAGE --}}
                        <div class="position-relative">
                            <img src="{{ asset('storage/'.$image->image) }}"
                                 class="card-img-top"
                                 style="height:150px; object-fit:cover">

                            {{-- MAIN BADGE --}}
                            @if($image->is_main)
                                <span class="badge bg-success position-absolute top-0 start-0 m-2">
                                    Əsas
                                </span>
                            @endif
                        </div>

                        {{-- ACTIONS --}}
                        <div class="card-body p-2 text-center">

                            {{-- SET MAIN --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                       type="radio"
                                       name="main_image_id"
                                       value="{{ $image->id }}"
                                       {{ $image->is_main ? 'checked' : '' }}>
                                <label class="form-check-label small">
                                    Əsas seç
                                </label>
                            </div>

                            {{-- DELETE --}}
                            <div class="form-check form-check-inline text-danger">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="delete_images[]"
                                       value="{{ $image->id }}">
                                <label class="form-check-label small">
                                    Sil
                                </label>
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
@endif
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ləğv et</button>
                                                            <button type="submit" name="edit_product_button" form="edit_product_form" class="btn btn-primary">Yadda saxla</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Edit Customer Modal-->
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .swal2-actions {
            gap: 10px !important;
        }
        .swal2-confirm, .swal2-cancel {
            width: 100% !important;
        }
        .swal2-popup {
            display: flex !important;
            flex-direction: column !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Error-lar olduqda modal-ı aç
            @if($errors->any() && old('_token'))
                @if(request()->routeIs('subcategory.store'))
                    var addModal = new bootstrap.Modal(document.getElementById('my_new_modal'));
                    addModal.show();
                @elseif(request()->routeIs('subcategory.update'))
                    // Update üçün hansı modal açılacağını bilmək çətindir, ona görə error mesajı yuxarıda göstərilir
                @endif
            @endif

            // Delete subcategory functionality
            document.querySelectorAll('.delete-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const deleteUrl = this.getAttribute('href');

                    Swal.fire({
                        title: 'Əminsinizmi?',
                        text: "Bu məlumat silinəcək və geri qaytarmaq mümkün olmayacaq!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#50cd89',
                        cancelButtonColor: '#f1416c',
                        confirmButtonText: 'Bəli, Sil !',
                        cancelButtonText: 'Ləğv Et',
                        customClass: {
                            popup: 'swal2-centered-icon'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form and submit it for DELETE request
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = deleteUrl;

                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';

                            const csrfInput = document.createElement('input');
                            csrfInput.type = 'hidden';
                            csrfInput.name = '_token';
                            csrfInput.value = csrfToken || '{{ csrf_token() }}';

                            form.appendChild(methodInput);
                            form.appendChild(csrfInput);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category_select');
            const subcategorySelect = document.getElementById('subcategory_select');

            categorySelect.addEventListener('change', function () {
                const categoryId = this.value;

                // subcategory-ni sıfırla
                subcategorySelect.innerHTML = '<option value="">Seçin</option>';

                if (!categoryId) return;

                const url = "{{ route('admin.subcategories.byCategory', ':id') }}".replace(':id', categoryId);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(subcategory => {
                            const option = document.createElement('option');
                            option.value = subcategory.id;
                            option.textContent = subcategory.name_az;
                            subcategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Subcategory load error:', error);
                    });
            });
        });
    </script>

    <script>
document.addEventListener('DOMContentLoaded', function () {

    @foreach($products as $product)

        const categorySelect{{ $product->id }} =
            document.getElementById('category_select_{{ $product->id }}');

        const subcategorySelect{{ $product->id }} =
            document.getElementById('subcategory_select_{{ $product->id }}');

        categorySelect{{ $product->id }}.addEventListener('change', function () {

            const categoryId = this.value;
            subcategorySelect{{ $product->id }}.innerHTML = '<option value="">Seçin</option>';

            if (!categoryId) return;

            const url = "{{ route('admin.subcategories.byCategory', ':id') }}"
                .replace(':id', categoryId);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    data.forEach(sub => {
                        const option = document.createElement('option');
                        option.value = sub.id;
                        option.textContent = sub.name_az;
                        subcategorySelect{{ $product->id }}.appendChild(option);
                    });
                });
        });

    @endforeach

});
</script>

@endsection
