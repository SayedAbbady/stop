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
	<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/custom/index.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="d-flex justify-content-center mt-4">
                            <div>
                                <img src="https://www.eaalim.com/wp-content/uploads/2021/01/cropped-logo_new1-192x192.png" alt="Charles Hall" class="img-fluid " width="80" height="80" />
                            </div>
                            <div class="mt-2 ">
                                <h1 class="h2 ">Welcome to eaalim</h1>
                                <p class="lead">
                                    Sign in to your account to continue
                                </p>
                            </div>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
										{{-- <img src="https://www.eaalim.com/wp-content/uploads/2021/01/cropped-logo_new1-192x192.png" alt="Charles Hall" class="img-fluid " width="150" height="150" /> --}}
									</div>
									<form method="POST"  action="{{ route('login') }}">
                                           @csrf
										<div class="mb-3">
											<label class="form-label">Email</label>
                                            <input id="email" type="email" class="form-control-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											
                                            <input id="password" type="password" class="form-control-lg form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
											
										</div>
										<div>
											<label class="form-check">
                                            
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="form-check-label">
                                            Remember me 
                                            </span>
                                        </label>
										</div>
										<div class="text-center mt-3">
											{{-- <a href="index.html" class="btn btn-lg btn-primary">Sign in</a> --}}
											 <button type="submit" class="btn btn-lg btn-primary">Sign in</button> 
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{asset('assets/js/app.js')}}"></script>

</body>

</html>