
<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>LeCharme Manager</title>

		<meta name="viewport" content="width=device-width, initial-scale=1" />


		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

		<link href="{{ asset("website/manager/css/plugins.bundle.css") }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset("website/manager/css/style.bundle.css") }}" rel="stylesheet" type="text/css" />

	</head>

	<body id="kt_body" class="bg-dark">

		<div class="d-flex flex-column flex-root">

			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-size1: 100% 50%; background-image: url(assets/media/misc/outdoor.png)">

				<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
					<!--begin::Logo-->
					<!--end::Logo-->
					<!--begin::Wrapper-->
					<div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
						<!--begin::Form-->
						<form class="form w-100" method="post" action="">
							<!--begin::Heading-->
                            @csrf
							<div class="text-center mb-10">
								<h1 class="text-dark mb-3">LeCharme Manager</h1>
							</div>
                            <div class="fv-row mb-10">

								<label class="form-label fs-6 fw-bolder text-dark">Email</label>

								<input class="form-control form-control-lg form-control-solid" type="text" name="email" autocomplete="off" />

							</div>

							<div class="fv-row mb-10">
								<!--begin::Wrapper-->
								<div class="d-flex flex-stack mb-2">

									<label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>

								</div>

								<input class="form-control form-control-lg form-control-solid" type="password" name="password" autocomplete="off" />

							</div>
							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<!--begin::Submit button-->
								<button type="submit"  class="btn btn-lg btn-primary w-100 mb-5">
									<span class="indicator-label">Login</span>

								</button>

							</div>
							<!--end::Actions-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				<div class="d-flex flex-center flex-column-auto p-10">
					<!--begin::Links-->

					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
 @if ($errors->any())
        <div style="color:red;">
            {{ $errors->first() }}
        </div>
    @endif
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>
