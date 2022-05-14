@extends('layouts.app')
@permission('deleted-students')
@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Deleted Students  
           
          </h4>
          <div class="card ">
            <div class="card-body ">
              
              @php $counter=1; @endphp
              <div class="table-responsive">
                    <table class="table table-hover table-borderless ">
                      <thead>
                        <tr class="border-bottom">
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th style="width:15px">Name</th>
                          <th scope="col">Status</th>
                          @permission('show-history')
                          <th scope="col">History</th>
                          @endpermission
                          <th scope="col">Category</th>
                          <th scope="col">Deleted at</th>
                          <th scope="col">Settings</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white">
                    @foreach ($users as $user)
                     
                        <tr id="{{$user->id}}">
                          <td class="">{{$counter++}}</td>
                          <td class="">
                          {{$user->date}}
                          </td>
                          
                          <td style="font-size:14px">
                            <a class="badge badge-dark d-block text-left my-1" target="_blank" href="{{route('students.show',$user->id)}}">{{$user->parent_name}}</a>
                          </td>
                          <td class="">

                            @if ($user->status == '1')
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-danger" style="padding:6px 60px;font-weight:bold"> <i class="align-middle" data-feather="x"></i> No contact</a>

                            @elseif ($user->status == '3')
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-warning" style="padding:6px 60px;"> <i class="align-middle" data-feather="clock"></i> Set Alarm </a>
                            @elseif ($user->status == '4')
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-secondary" style="padding:6px 60px;"> <i class="align-middle" data-feather="wifi-off"></i> Contact and no answer </a>
                            @else
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-success" style="padding:6px 60px;"> <i class="align-middle" data-feather="check"></i> Contacted</a>

                            @endif
                            

                          </td>
                          @permission('show-history')
                          <td class="">
                          <a href="{{url('/history?type=Students&id='.$user->id.'')}}">history</a>
                          </td>
                          @endpermission
                          <td class="">
                            <a href="{{route('cat.show',$user->category->id)}}">
                              <b> 
                                <span class="badge badge-primary">{{$user->category->name}}</span>
                              </b>
                            </a>
                          </td>
                          <td>
                            {{ Carbon\Carbon::parse($user->deleted_at)->toFormattedDateString()}}
                          </td>
                          <td class="">
                            @permission('restored-student')
                            <button type='button' class='btn btn-success restorDa ' data-id="{{$user->id}}"> 
                                Restore
                            </button>
                            @endpermission
                            @permission('force-delete')
                            <button type='button' class='btn btn-danger deleteStudent_i_force' data-token="{{csrf_token()}}" data-id="{{$user->id}}"> 
                                Delete for ever
                            </button>
                            @endpermission
                            
                          </td>
                        </tr>
                       
                    @endforeach
                  </tbody>
                </table>
                <div class="float-right mt-5">
                  {{$users->links()}}
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