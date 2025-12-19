
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
									<h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">Category</h1>
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
										<li class="breadcrumb-item text-muted">Category</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-200 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-dark">Category List'i</li>
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
												<input type="text"type="text" autocomplete="off" id="live_search"  class="form-control form-control-solid w-250px ps-15" placeholder="Axtar" />
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
										<div class="modal-dialog modal-dialog-centered mw-750px">
											<div class="modal-content">

											<div class="modal-header">
												<h5 class="modal-title">Yeni Kateqoriya</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
											</div>

											<div class="modal-body">
												<form action="{{ route('category.store') }}" method="POST" id="add_category_form">
													@csrf
													@if ($errors->any())
														<div class="alert alert-danger">
															<ul class="mb-0">
																@foreach ($errors->all() as $error)
																	<li>{{ $error }}</li>
																@endforeach
															</ul>
														</div>
													@endif

													<div class="mb-3">
														<label for="add_name" class="form-label">Kateqoriya Adı (Azərbaycan)</label>
														<input type="text" class="form-control" id="add_name" name="name_az" value="{{ old('name') }}" required>
													</div>

													<div class="mb-3">
														<label for="add_email" class="form-label">Kateqoriya Adı (English)</label>
														<input type="text" class="form-control" id="add_email" name="name_en" value="{{ old('email') }}" required>
													</div>

													<div class="mb-3">
														<label for="add_password" class="form-label">Kateqoriya Adı (Русский)</label>
														<input type="text" class="form-control" id="add_password" name="name_ru" required>
													</div>

                                                    <div class="mb-3">
														<label for="add_slug_az" class="form-label">Slug (Azərbaycan)</label>
														<input type="text" class="form-control" id="add_slug_az" name="slug_az" value="{{ old('slug_az') }}" placeholder="Avtomatik yaradılacaq">


													</div>

													<div class="mb-3">
														<label for="add_slug_en" class="form-label">Slug (English)</label>
														<input type="text" class="form-control " id="add_slug_en" name="slug_en" value="{{ old('slug_en') }}" placeholder="Avtomatik yaradılacaq">



													</div>

													<div class="mb-3">
														<label for="add_slug_ru" class="form-label">Slug (Русский)</label>
														<input type="text" class="form-control" id="add_slug_ru" name="slug_ru" value="{{ old('slug_ru') }}" placeholder="Avtomatik yaradılacaq">

													</div>
													<div class="mb-3">
														<label for="add_position" class="form-label">Position</label>
														<input type="number" class="form-control" id="add_position" name="position" value="{{ old('position', 0) }}" min="0">
													</div>

													<div class="mb-3">
														<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
															<input type="checkbox" class="form-check-input" id="add_is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}>
															<span class="form-check-label">Status (Aktiv)</span>
														</label>
													</div>


												</form>
											</div>

											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ləğv et</button>
												<button type="submit" form="add_category_form" class="btn btn-primary">Əlavə et</button>
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
										<table class="table  align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table" role="grid">
											<!--begin::Table head-->
											<thead>
												<!--begin::Table row-->
												<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
													<th class="min-w-125px">Kateqoriya</th>
													<th class="min-w-50px">Slug</th>
													<th class="min-w-50px">Position</th>
													<th class="min-w-125px">Status</th>

													<th class="text-end min-w-70px">Əməliyyatlar</th>
												</tr>
												<!--end::Table row-->
											</thead>
											<!--end::Table head-->
											<!--begin::Table body-->

											<tbody  id="not_search"   class="fw-bold text-gray-600">

                                                @foreach ($categoryMenus as $category)


												<tr>

                                                    <td>
                                                        <a href="#" class="text-dark fw-bold">{{ $category->name_az }}</a>
                                                    </td>

                                                    <td>
                                                        <a href="#" class="text-dark fw-bold">{{ $category->slug_az}}</a>
                                                    </td>

                                                    <td>
                                                        <a href="#" class="text-dark fw-bold">{{ $category->position}}</a>
                                                    </td>

                                                    <td>
                                                         @if($category->is_active == 1)
                                                                <i class="fa-solid fa-circle-check" style="color:#06923E; font-size:20px;"></i>
                                                            @else
                                                                <i class="fa-solid fa-circle-xmark" style="color:#f1416c; font-size:20px;"></i>
                                                            @endif
                                                    </td>




													<!--end::Date=-->
													<!--begin::Action=-->
													<td class="text-end">
														<a href="#" class="btn btn-sm btn-dark btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">Əməliyyatlar
														<!--begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg-->
														<span class="svg-icon svg-icon-5 m-0">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<polygon points="0 0 24 0 24 24 0 24" />
																	<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
																</g>
															</svg>
														</span>
														<!--end::Svg Icon--></a>
														<!--begin::Menu-->
														<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

														<div class="menu-item px-3">
                                                            <a href="#"
                                                            class="menu-link px-3 edit-admin-link"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit_modal_{{ $category->id }}"
                                                            data-admin-id="">
                                                                Redaktə Et
                                                            </a>
                                                        </div>

															<div class="menu-item px-3">
																<a href="" class="menu-link px-3 delete-link">Sil</a>
															</div>


														</div>

													</td>

												</tr>






												<!--begin::Edit Customer Modal-->
												<div class="modal fade" id="edit_modal_{{ $category->id }}" tabindex="-1" aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered">
													<div class="modal-content">

													<div class="modal-header">
														<h5 class="modal-title">Kateqoriya  Redaktə</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Bağla"></button>
													</div>

													<div class="modal-body">
														<form action="{{ route('category.update' , $category->id) }}" method="POST" id="edit_customer_form">
															@csrf
															@method('PUT')

															<div class="mb-3">
														<label for="add_name" class="form-label">Kateqoriya Adı (Azərbaycan)</label>
														<input type="text" class="form-control" id="edit_name_az_{{ $category->id }}" name="name_az" value="{{ $category->name_az }}" required>
													</div>

													<div class="mb-3">
														<label for="add_email" class="form-label">Kateqoriya Adı (English)</label>
														<input type="text" class="form-control" id="edit_name_en_{{ $category->id }}" name="name_en" value="{{ $category->name_en }}" required>
													</div>

													<div class="mb-3">
														<label for="add_password" class="form-label">Kateqoriya Adı (Русский)</label>
														<input type="text" class="form-control" id="edit_name_ru_{{ $category->id }}" name="name_ru" value="{{ $category->name_ru }}" required>
													</div>

                                                    <div class="mb-3">
														<label for="add_slug_az" class="form-label">Slug (Azərbaycan)</label>
														<input type="text" class="form-control" id="edit_slug_az_{{ $category->id }}" name="slug_az" value="{{ $category->slug_az }}" placeholder="Avtomatik yaradılacaq">


													</div>

													<div class="mb-3">
														<label for="add_slug_en" class="form-label">Slug (English)</label>
														<input type="text" class="form-control " id="edit_slug_en_{{ $category->id }}" name="slug_en" value="{{ $category->slug_en }}" placeholder="Avtomatik yaradılacaq">



													</div>

													<div class="mb-3">
														<label for="add_slug_ru" class="form-label">Slug (Русский)</label>
														<input type="text" class="form-control" id="edit_slug_ru_{{ $category->id }}" name="slug_ru" value="{{ $category->slug_ru }}" placeholder="Avtomatik yaradılacaq">

													</div>
													<div class="mb-3">
														<label for="add_position" class="form-label">Position</label>
														<input type="number" class="form-control" id="edit_position_{{ $category->id }}" name="position" value="{{ $category->position }}" min="0">
													</div>

													<div class="mb-3">
														<label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
															<input type="checkbox" class="form-check-input" id="edit_is_active_{{ $category->id }}" name="is_active" value="1" {{ $category->is_active ==1 ? 'checked' : '' }}>
															<span class="form-check-label">Status (Aktiv)</span>
														</label>
													</div>








														</form>
													</div>

													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ləğv et</button>
														<button type="submit" name="edit_admin_button" form="edit_customer_form" class="btn btn-primary">Yadda saxla</button>
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
    document.querySelectorAll('.delete-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
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
                    window.location.href = this.getAttribute('href');
                }
            });
        });
    });
});
</script>


@endsection


