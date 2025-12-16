<!--begin::Footer-->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<!--begin::Container-->
						<div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
							<!--begin::Copyright-->
							<div class="text-dark order-2 order-md-1">
								<a href="" target="_blank" class="text-gray-800 text-hover-primary">Bütün hüquqlar qorunur © Guliyevs {{ date("Y") }} </a>
							</div>
							<!--end::Copyright-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->

   <!--begin::Javascript-->
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('website/manager/plugins/plugins.bundle.js') }}"></script>
		<script src="{{ asset("website/manager/js/scripts.bundle.js") }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="{{ asset('website/manager/plugins/plugins.bundle.js') }}"></script>
		<!--end::Page Vendors Javascript-->
		<!--begin::Page Custom Javascript(used by this page)-->

        <script src=" {{ asset('website/manager/js/custom/apps/customers/list/export.js') }} " ></script>
        <script src=" {{ asset('website/manager/js/custom/apps/customers/list/list.js') }} " ></script>
        <script src=" {{ asset('website/manager/js/custom/apps/customers/add.js') }} " ></script>

        <script src="{{ asset('website/manager/js/custom/widgets.js') }}" ></script>
        <script src="{{ asset('website/manager/js/custom/apps/chat/chat.js') }}" ></script>
        <script src="{{ asset('website/manager/js/custom/modals/create-app.js') }}" ></script>
        <script src="{{ asset('website/manager/js/custom/modals/upgrade-plan.js') }}" ></script>

		<script src="https://kit.fontawesome.com/8b6bf36043.js" crossorigin="anonymous"></script>

</body>
</html>
