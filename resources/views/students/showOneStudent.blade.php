@extends('layouts.app')
@permission('display-student')
@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            <b>{{$user->parent_name}}'s</b> Family 
            
          </h4>
          <div class="card ">
            <div class="card-body ">
               
              <div class="row">
                  <div class="col-md-6">
                    <div class="row">
                      <h3><b>Basic information</b></h3>
                      <div class="col-md-12"> <b> Category Name </b> </div>
                      <div class="col-md-9"> {{$user->category->name}} <hr></div>

                      <div class="col-md-12"> <b> Parent name  </b> </div>
                      <div class="col-md-9"> {{$user->parent_name }} <hr></div>
                      
                      <div class="col-md-12"> <b> Email </b> </div>
                      <div class="col-md-9"> {{$user->email }} <hr></div>

                      <div class="col-md-12"> <b> Phone Number </b> </div>
                      <div class="col-md-9"> {{$user->phone }} <hr></div>

                      <div class="col-md-12"> <b> Date </b> </div>
                      <div class="col-md-9"> {{$user->date }} <hr></div>

                      <div class="col-md-12"> <b> Current Status </b> </div>
                      <div class="col-md-9"> 
                        @if ($user->status == '1')
                          <a href="javascript:;" class="btn btn-danger" style="padding:6px 60px;font-weight:bold"> <i class="align-middle" data-feather="x"></i> No contact</a> 

                        @elseif ($user->status == '3')
                          <a href="javascript:;" class="btn btn-warning" style="padding:6px 60px;"> <i class="align-middle" data-feather="clock"></i> Set Alarm </a>
                        @elseif ($user->status == '4')
                          <a href="javascript:;" class="btn btn-dark" style="padding:6px 60px;"> <i class="align-middle" data-feather="wifi-off"></i> Contact and no answer </a>
                        @else
                          <a href="javascript:;" class="btn btn-success" style="padding:6px 60px;"> <i class="align-middle" data-feather="check"></i> Contacted</a> 

                        @endif
                        <hr>
                      </div>

                      <div class="col-md-12"> <b> Resutl of contact </b> </div>
                      <div class="col-md-9"> {!! (is_null($user->responce))?'No data':$user->responce !!} <hr></div>
                      
                      <div class="col-md-12"> <b> Additional information </b> </div>
                      <div class="col-md-9"> {!! (is_null($user->add_info))?'No data':$user->add_info !!} </div>

                    </div>
                  </div>

                  <div class="col-md-6">
                    <h3><b>Children information</b></h3>
                    @foreach ($user->children as $item)
                        <div class="row">
                          <div class="col-md-6">
                            <b>Student name</b>: {{$item->name}}
                          </div>
                          <div class="col-md-6">
                            <b>Teacher name</b>: {{App\Models\Teacher::select('name')->where('id',$item->teacher_id)->first()->name}}
                          </div>
                          <div class="col-md-6">
                            <b>Last session</b>: {{$item->lastsession}}
                          </div>
                          <div class="col-md-6">
                            <b>Stop resone</b>: {{$item->resone}}
                          </div>
                          <div class="col-md-12">
                            <b>Hour rate</b>: {{$item->hourrate}}
                          </div>

                          <div class="col-12"><hr></div>
                        </div>
                    @endforeach
                    <br>
                    <br>
                    @forelse ($user->remember_students as $item)
                    <h3><b>Remember information</b></h3>
                    
                        <div class="row">
                          <div class="col-md-6">
                            <b>Date</b>: {{$item->date}}
                          </div>
                          <div class="col-md-6">
                            <b>Time</b>: {{$item->time}}
                          </div>
                          <div class="col-md-6">
                            <b>Added By</b>: {{App\User::select('name')->where('id',$item->admin_id)->first()->name}}
                          </div>
                          <div class="col-md-12">
                            <b>Note </b>: {{is_null($item->note)?'No note added':$item->note}}
                          </div>
                          <div class="col-md-12">
                            <b>Action taken</b>: {{is_null($item->action)?'No action yet':$item->action}}
                          </div>
                          <div class="col-12"><hr></div>
                        </div>
                    @empty

                    @endforelse

                    @if (!is_null($user->deleted_at))
                    <div class="alert alert-danger">This user is deleted at {{ Carbon\Carbon::parse($user->deleted_at)->toFormattedDateString()}}</div>
                     <button type='button' class='btn btn-success restorDa ' data-id="{{$user->id}}"> 
                                Restore
                            </button>       
                            <a href="{{url('/history?type=Students&id='.$user->id.'')}}" class="btn btn-info">History</a>
                    @else
                        
                    <a href="{{url('/history?type=Students&id='.$user->id.'')}}" class="btn btn-info">History</a>
                    <a href="{{route('students.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                    <a href="javascript:;" class="btn btn-danger deleteStudent_i" data-token="{{csrf_token()}}" data-id="{{$user->id}}">Delete</a>
                    @endif
                  </div>
                  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@endpermission