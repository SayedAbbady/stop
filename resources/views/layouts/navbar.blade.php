<nav class="navbar navbar-expand navbar-light navbar-bg" style="display: block">
	<div class="row">
		<div class="col-2 mt-1">
			<a class="sidebar-toggle js-sidebar-toggle">
				<i class="hamburger align-self-center"></i>
			</a>
		</div>
		<div class="col-6 mt-2 mx-auto" >
			<form action="{{route('search')}}" method="get">
{{--				@csrf--}}
				<input
								name="searchtext"
								type="text"
								class="form-control"
								placeholder="Students, Categories, Teachers"
								style="position: relative"
								value="{{isset($req)?$req:''}}"
				>
				<button
								type="submit"
								class="btn-primary border-0"
								style="	position: absolute;
												top: 0;
												height: 100%;
												right: 13px;
												width: 44px;">
					<i class="align-middle" data-feather="search"></i>
				</button>
			</form>
		</div>
		<div class="col-4">
			<div class="navbar-collapse collapse">
				<ul class="navbar-nav navbar-align">
					@permission('display-alarms')
					<li class="nav-item dropdown">
						<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
							<div class="position-relative">
								<i class="align-middle" data-feather="bell"></i>
								<span class="indicator">{{$notifi->count()}}</span>
							</div>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
							<div class="dropdown-menu-header">
								{{$notifi->count()}} New alarm/s
							</div>
							<div class="list-group">
								@foreach ($notifi as $item)
									@isset($item->students_remember->id)
										<a href="{{route('alarms.index')}}" class="list-group-item">
											<div class="row g-0 align-items-center">
												<div class="col-2">
													<i class="text-primary" data-feather="alert-circle"></i>
												</div>
												<div class="col-10">
													<div class="text-danger">
														{{$item->students_remember->parent_name}}
													</div>
													<div class="text-muted small mt-1">
														Added by: <span class="text-primary"> {{$item->admin->name}} ({{$item->date}} - {{$item->time}})</span>
													</div>
													<div class="text-muted small mt-1">{{ Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</div>
												</div>
											</div>
										</a>
									@endisset
								@endforeach

							</div>
							<div class="dropdown-menu-footer">
								<a href="{{route('alarms.index')}}" class="text-muted">Show all alarms</a>
							</div>
						</div>
					</li>
					@endpermission
					<li class="nav-item dropdown">
						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
							<i class="align-middle" data-feather="settings"></i>
						</a>
						@auth

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
								<img src="{{asset('assets/img/avatars/icon-user-default.png')}}" class="avatar img-fluid rounded-circle me-1" alt="Charles Hall" /> <span class="text-dark">{{Auth::user()->name}}</span>
							</a>
						@endauth
						<div class="dropdown-menu dropdown-menu-end">

							<div class="dropdown-divider"></div>
							<form action="{{route('logout')}}" id="sunOut" method='post'>
								@csrf
							</form>
							<a class="dropdown-item signUpLo"  href="#" >Log out</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>


	

</nav>