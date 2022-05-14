@extends('layouts.app')
@permission('display-staff-members')
@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Staff members
            @permission('create-staff-member')
            <a href="{{route('staff.create')}}" class="btn btn-success">Add new members</a>
            @endpermission
          </h4>
          <div class="card ">
            <div  class="card-body">
              @php
                  $counter=1;
              @endphp
                  <div class="table-responsive">
                    <table class="table table-hover table-borderless ">
                      <thead>
                        <tr class="border-bottom">
                          <th scope="col">#</th>
                          <th scope="col">Created Date</th>
                          <th scope="col">Name</th>
                          <th scope="col">Email</th>
                          @permission('show-history')
                          <th scope="col">History</th>
                          @endpermission
                          <th scope="col">Settings</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white">
                    @foreach ($users as $user)

                        <tr id="{{$user->id}}">
                          <td class="">{{$counter++}}</td>
                          <td class="">
                          {{$user->created_at}}
                          </td>
                          
                          <td class="">
                          {{$user->name}}
                          </td>
                          <td class="">
                          {{$user->email}}
                          </td>
                          @permission('show-history')
                          <td class="">
                          <a href="{{url('/history?type=user&id='.$user->id.'')}}">What I do?</a>
                          </td>
                          @endpermission

                          <td class="">
                            @permission('edit-staff-member')
                            <a href="{{route('staff.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                            @endpermission
                            @permission('delete-staff-member')
                            <a href="javascript:;" class="btn btn-danger deleteUser" data-token="{{csrf_token()}}" data-id="{{$user->id}}">Delete</a>
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