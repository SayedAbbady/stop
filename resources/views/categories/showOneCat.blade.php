@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Students  
            <a href="{{route('students.create')}}" class="btn btn-success">Add new students</a>
          </h4>
          <div class="card ">
            <div class="card-body ">
              <div class="row">
                
                <form action="{{route('students.status.search')}}" method="GET" class="col-3 get_search">
                  <label for=""><b> Status</b></label>
                  <select name="status" class="form-control" id="">
                    <option value="all">All</option>
                    <option value="1" {{($status_id == "1")?'selected':''}}>No contact</option>
                    <option value="2" {{($status_id == "2")?'selected':''}}>Contact</option>
                    <option value="3" {{($status_id == "3")?'selected':''}}>Alarm</option>
                  </select>
                </form>
                
              </div>
              <hr>  
              @php 
              $counter=1; 
              $users = $data->newparent()->orderBy('date','DESC')->paginate(100);
              @endphp
              <div class="table-responsive">
                    <table class="table table-hover table-borderless ">
                      <thead>
                        <tr class="border-bottom">
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th style="width:15px">Name</th>
                          <th scope="col">Status</th>
                          <th scope="col">History</th>
                          <th scope="col">Category</th>
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
                            @else
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-success" style="padding:6px 60px;"> <i class="align-middle" data-feather="check"></i> Contacted</a> 

                            @endif
                            

                          </td>
                          <td class="">
                          <a href="{{url('/history?type=Students&id='.$user->id.'')}}">history</a>
                          </td>
                          <td class="">
                            <a href="{{route('cat.show',$user->category->id)}}">
                              <b> 
                                <span class="badge badge-primary">{{$user->category->name}}</span>
                              </b>
                            </a>
                          </td>
                          <td class="">
                            <a href="{{route('students.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                            <a href="javascript:;" class="btn btn-danger deleteUser" data-token="{{csrf_token()}}" data-id="{{$user->id}}">Delete</a>
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