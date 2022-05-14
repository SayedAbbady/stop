@extends('layouts.app')
@permission('show-teacher')
@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">
          <h4 class="title">
            Teachers


          </h4>
          <div class="card ">
            <div class="card-body">
              @permission('add-teacher')
              <a href="{{route('createteachers')}}" class="btn btn-primary">Create new teacher</a>
              <form
              action="{{ route('teacher.import') }}"
              method="POST"
              style="position: relative;display:inline-block"
              enctype="multipart/form-data"
              id="form_as-ddd">
                @csrf
                <input
                  id="upload-teacher-form"
                  type="file"
                  name="file"
                  style="position: absolute;opacity:0;width:100%;height:100%"
                  class="" >

                <button class="btn btn-success">Import teachers Data</button>

            </form>
              @endpermission
              @php
                  $counter=1;
              @endphp
                  @if (session()->has('msg'))
                  <div class="col-12">
                    <div class="alert alert-success">
                      {{ session()->get('msg') }}
                    </div>
                  </div>
                @endif
                @if (session()->has('error'))
                  <div class="col-12">
                    <div class="alert alert-danger">
                      {{ session()->get('error') }}
                    </div>
                  </div>
                @endif
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
                <div class="float-right mt-5">
                  {{$teachers->links()}}
                </div>
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
    </div>
  </div>
@endsection
@endpermission