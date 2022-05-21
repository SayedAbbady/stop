<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Send email automaitc by Sayed Khaled">
	<meta name="author" content="Sayed Khaled">
	<meta name="keywords" content="Sayed, khaled, sayed khaled, sayed abbady, abbady,php,laravel,development">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />


	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">-->
	@yield('styles')
	<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/custom/index.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<style>
		.errorClass {
			color: #dc3545!important;
		}
		label span {
			font-weight: bold;
		}
	</style>


</head>

<body>
	<div class="loader"></div>
	<div class="wrapper">
		@include('layouts.slider')

		<div class="main">
			@include('layouts.navbar')

			<main class="content">
				<div class="container-fluid p-0">
					<audio id="soundGood" data-sound="{{asset('assets/mixkit.wav')}}"></audio>

                    @permission('display-alarms')
					<div class="popup-main-class">

						<div class="popup-dialog">
							<div class="row">
								<div class="col-12 mb-4">
									<img src="{{asset('assets/img/alarms.png')}}" alt="">
								</div>
								<div class="col-md-6 text-right"><b>Date:</b> <span id="popup-date">05-05-2022</span></div>
								<div class="col-md-6 text-left"><b>Time:</b> <span id="popup-time">10:20 PM</span></div>
								<div class="col-12 mt-2 mb-4"><b>Note:</b> <span id="popup-note">This note added by Sayed Khaled as alarm notes for me after another rime thanks god</span></div>
								<div class="col-12">
									<button class="btn btn-primary">Got it</button>
								</div>
							</div>
						</div>

					</div>
                    @endpermission



					@yield('content')
				</div>
			</main>
			@include('layouts.footer')
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
	<script src="{{asset('js/app.js')}}"></script>
	<script src="{{asset('assets/js/app.js')}}"></script>
	<script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>

	<script type="text/javascript">
		var link = "{{url('/')}}";
		$('.signUpLo').on('click',function (e) {
			e.preventDefault();
			$('#sunOut').submit();
		})
		$('#upload-teacher-form').on('change',function (e) {
			e.preventDefault();
			$('#form_as-ddd').submit();
		})

		$('.get_search').on('change',function (e) {
			$(this).submit();
		})

	  CKEDITOR.replace('Additional_info');
		CKEDITOR.replace('result_info');

	  // CKEDITOR.replace('info');


	</script>
	@yield('scripts')
	<script src="{{asset('assets/custom/sweetalert.js')}}"></script>
	<script src="{{asset('assets/custom/index.js')}}"></script>
	@permission('display-alarms')
	<script src="{{asset('assets/custom/popup.js')}}"></script>
    @endpermission
</body>

</html>