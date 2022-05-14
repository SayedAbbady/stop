@extends('layouts.app')

@permission('display-dashboard')

@section('content')
<h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

					<div class="row">
						<div class="col-xl-6 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Category</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="archive"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{$catnum}}</h1>
												<div class="mb-0">
													<a class="text-primary" href="{{route('cat')}}">Show all</a>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Students</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="users"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{$studentnum}}</h1>
												<div class="mb-0">
													<span class="text-primary"> <i class="mdi mdi-arrow-bottom-right"></i> {{$childnum}} </span>
													<span class="text-muted">Children added</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Teachers</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="edit-3"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{$teachernum}}</h1>
												<div class="mb-0">
													<a href="{{route('teachers.index')}}" class="text-primary"> <i class="mdi mdi-arrow-bottom-right"></i>Show all </a>
													
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Alarms</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="align-middle" data-feather="clock"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3">{{$allarmnum}}</h1>
												<div class="mb-0">
													<a href="{{route('alarms.index')}}" class="text-primary"> <i class="mdi mdi-arrow-bottom-right"></i> Show all </a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-6 col-xxl-7">
							<div class="card flex-fill w-100">
								<div class="card-header">
									<div class="row">
										<div class="col-12">
											<form action="" id="get_year-graph" class="">
												@csrf
											<h5 class="card-title mt-1">Students per month for 
													<select name="year" class="get_select-graph" id="">
														@for ($i = 18; $i < 28; $i++)
														<option value="20{{$i}}" {{(date('Y',time()) == '20'.$i.'' )?'selected':''}}>20{{$i}}</option>
														@endfor
														
													</select>
												</h5>
											</form>
										</div>
									</div>
								</div>
								<div class="card-body py-3">
									<div class="chart chart-sm">
										<canvas id="chartjs-dashboard-line"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">

                        <div class="col-12 col-lg-4 d-flex">
							<div class="card flex-fill">
								<div class="card-header">

									<h5 class="card-title mb-0">Important alarms</h5>
								</div>
								<table class="table table-hover my-0">
									<thead>
										<tr>
											<th scope="col">#</th>
												<th scope="col">Date</th>
												<th scope="col">Time</th>
												<th scope="col">Added by</th>
												<th scope="col">Family name</th>
												
										</tr>
									</thead>
									<tbody>
										@php
												$counter = 1;
										@endphp
										@forelse ($remember as $user)
												<tr>
														<td class="">{{$counter++}}</td>
														<td class="">
														{{$user->date}}
														</td>
														
														<td class="">
														{{$user->time}}
														</td>
														<td class="">
																<a href="{{url('/history?type=user&id='.$user->admin->id.'')}}">
																{{$user->admin->name}}
																</a>
														</td>
														<td class="">
																<a href="{{route('students.show',$user->students_remember->id)}}">
																{{$user->students_remember->parent_name}}
																</a>
														</td>
														
														</tr>  
										@empty
														<div class="alert mx-2 alert-danger">No alarms today</div>
										@endforelse
										
										
									</tbody>
								</table>
							</div>
						</div>

                        <div class="col-12 col-lg-8  d-flex">
							<div class="card flex-fill w-100">
								<div class="card-header">

									<h5 class="card-title mb-0">Teachers analytics <br><sub>(teachers with students)</sub></h5>
								</div>
								<div class="card-body d-flex w-100">
									<div class="align-self-center chart chart-lg">
										<canvas id="chartjs-dashboard-bar"></canvas>
									</div>
								</div>
							</div>
						</div>
						
						
					</div>

@endsection



@section('scripts')
	<script>
		var obj =  {!!$userArr!!};
		// document.addEventListener("DOMContentLoaded", function() {
			var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
			var gradient = ctx.createLinearGradient(0, 0, 0, 225);
			gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
			gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
			// Line chart
			var mychart = new Chart(document.getElementById("chartjs-dashboard-line"), {
				type: "line",
				data: {
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
					datasets: [{
						label: "Students",
						fill: true,
						backgroundColor: gradient,
						borderColor: window.theme.primary,
						data: obj
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					tooltips: {
						intersect: false
					},
					hover: {
						intersect: true
					},
					plugins: {
						filler: {
							propagate: false
						}
					},
					scales: {
						xAxes: [{
							reverse: true,
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}],
						yAxes: [{
							ticks: {
								stepSize: 1000
							},
							display: true,
							borderDash: [3, 3],
							gridLines: {
								color: "rgba(0,0,0,0.0)"
							}
						}]
					}
				}
			});
			
		// });

		
		
	</script>
	
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			// Bar chart
			new Chart(document.getElementById("chartjs-dashboard-bar"), {
				type: "bar",
				data: {
					labels: {!! $teacher_name !!},
					datasets: [{
						label: "Students",
						backgroundColor: window.theme.primary,
						borderColor: window.theme.primary,
						hoverBackgroundColor: window.theme.primary,
						hoverBorderColor: window.theme.primary,
						data: {!! $teacher_count !!},
						barPercentage: .75,
						categoryPercentage: .5
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false
					},
					scales: {
						yAxes: [{
							gridLines: {
								display: false
							},
							stacked: false,
							ticks: {
								stepSize: 20
							}
						}],
						xAxes: [{
							stacked: false,
							gridLines: {
								color: "transparent"
							}
						}]
					}
				}
			});
		});
	</script>
	
	
@endsection

@endpermission