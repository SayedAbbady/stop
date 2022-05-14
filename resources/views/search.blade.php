@extends('layouts.app')

@section('content')
  <div class="row">

    <div class="col-12">
      <h1 class="h3 mb-0">
        <strong>Result of</strong> search
      </h1>
      <div>
        Category <b>({{$category->count()}})</b> -
        Students <b>({{$students->count()}})</b> -
        Teachers <b>({{$teachers->count()}})</b>
      </div>
    </div>

    <div class="col-12 mt-3">
      <div class="card flex-fill w-100">
        <div class="card-header">
          <h5 class="card-title mb-0">Students</h5>
        </div>
        <div class="card-body py-3">
          {{-- Start students table --}}

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
                <th scope="col">Settings</th>
              </tr>
              </thead>
              <tbody class="bg-white">
              @foreach ($students as $user)

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
                  <td class="">
                    @permission('edit-students')
                    <a href="{{route('students.edit',$user->id)}}" class="btn btn-primary">Edit</a>
                    @endpermission
                    @permission('delete-student')
                    <a href="javascript:;" class="btn btn-danger deleteStudent_i" data-token="{{csrf_token()}}" data-id="{{$user->id}}">Delete</a>
                    @endpermission
                  </td>
                </tr>

              @endforeach
              </tbody>
            </table>
          </div>

          {{-- end students table --}}
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="col-12 col-lg-5 d-flex">
      <div class="card flex-fill">
        <div class="card-header">
          <h5 class="card-title mb-0">Categories</h5>
        </div>
        <div class="card-body py-3">
          @php
            $counter=1;
          @endphp
          <div class="table-responsive">
            <table class="table table-hover table-borderless ">
              <thead>
              <tr class="border-bottom">
                <th scope="col">#</th>
                <th scope="col">Created Date</th>
                <th scope="col">Category name</th>
                <th scope="col">Number of users</th>
                @permission('show-history')
                <th scope="col">History</th>
                @endpermission

                <th scope="col">Settings</th>

              </tr>
              </thead>
              <tbody class="bg-white">

              @for ($i = 0; $i < $category->count(); $i++)

                <tr id="{{$category[$i]->id}}">
                  <td class="">{{$counter++}}</td>
                  <td class="">
                    {{$category[$i]->created_at}}
                  </td>

                  <td class="">
                    <a href="{{route('cat.show',$category[$i]->id)}}">
                      {{$category[$i]->name}}
                    </a>
                  </td>
                  <td class="">
                    <span title="Students in Old version">{{$category[$i]->person->count()}}</span> //
                    <span title="Students in New version">{{$category[$i]->newparent->count()}}</span>
                  </td>
                  <td class="">
                    <a href="{{url('/history?type=Category&id='.$category[$i]->id.'')}}">history</a>
                  </td>

                  <td class="">
                    @permission('edit-category')
                    <a href="{{route('cat.edit',$category[$i]->id)}}" class="btn btn-primary">Edit</a>
                    @endpermission
                    @permission('delete-category')
                    <a href="javascript:;" class="btn btn-danger deleteCategory" data-token="{{csrf_token()}}" data-id="{{$category[$i]->id}}">Delete</a>
                    @endpermission
                  </td>
                </tr>

              @endfor
              </tbody>
            </table>

          </div>
        </div>

      </div>
    </div>

    <div class="col-12 col-lg-7  d-flex">
      <div class="card flex-fill w-100">
        <div class="card-header">

          <h5 class="card-title mb-0">Teachers </h5>
        </div>
        <div class="card-body d-flex w-100">
          <div class="table-responsive">
            <table class="table table-hover table-borderless ">
              <thead>
              <tr class="border-bottom">
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Students Number</th>
                @permission('delete-teacher')
                <th scope="col">Settings</th>
                @endpermission
              </tr>
              </thead>
              <tbody class="bg-white">
              @foreach ($teachers as $user)

                <tr id="{{$user->id}}">
                  <td class="">{{$counter++}}</td>
                  <td class="">
                    {{$user->created_at}}
                  </td>
                  <td style="font-size:14px">
                    {{$user->name}}
                  </td>
                  <td class="">
                    {{$user->email}}

                  </td>

                  <td class="">
                    {{$user->phone}}

                  </td>
                  <td class="">
                    <button
                            class="badge badge-success border-0 get_teacher_students_names"
                            data-toggle="modal"
                            data-target="#exampleModal"
                            data-token="{{csrf_token()}}"
                            data-id="{{$user->id}}"
                    > {{$user->students_count}} Student/s</button>

                  </td>
                  @permission('delete-teacher')
                  <td class="">

                    <a href="javascript:;" class="btn btn-danger deleteTeacher" data-token="{{csrf_token()}}" data-id="{{$user->id}}">Delete</a>
                  </td>
                  @endpermission
                </tr>

              @endforeach
              </tbody>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Students</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" id="backData">

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

@endsection

