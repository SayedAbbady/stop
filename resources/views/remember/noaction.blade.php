@extends('layouts.app')
@permission('display-alarms')
@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">
          <h4 class="title">
            All alarms
          </h4>
          <div class="card ">
            <div class="card-body">
              <div class="mb-2">
                <a href="{{route('alarms.index')}}" class="btn btn-primary">Show all</a>
                <a href="{{route('alarms.gotit')}}" class="btn btn-success">Got it only</a>
                <a href="{{route('alarms.noaction')}}" class="btn btn-danger">No action only</a>
              </div>
              @php
                $counter=1;
              @endphp
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover ">
                  <thead>
                  <tr class="border-bottom">
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Added by</th>
                    <th scope="col">Family name</th>
                    <th scope="col">Note</th>
                    <th scope="col">Status</th>
                    <th scope="col">Settings</th>
                  </tr>
                  </thead>
                  <tbody class="bg-white">
                  @foreach ($remember as $user)
                    @isset($user->students_remember->id)
                    <tr>
                      <td class="">{{$counter++}}</td>
                      <td class="">
                        {{$user->date}}
                      </td>

                      <td class="">
                        {{ Carbon\Carbon::parse($user->time)->isoFormat('hh:mm A')}}
                      </td>
                      <td class="">
                        <a href="{{url('/history?type=user&id='.$user->admin->id)}}">
                          {{$user->admin->name}}
                        </a>
                      </td>
                      <td class="">
                        <a href="{{route('students.show',$user->students_remember->id)}}">
                          {{$user->students_remember->parent_name}}
                        </a>
                      </td>
                      <td class="">
                        {{$user->note}}
                      </td>

                      <td class="" id="gotit{{$user->id}}">
                        {!!is_null($user->action)?"<span class='badge badge-danger'>No Action taken</span>":"<span class='badge badge-success'>$user->action</span>"!!}
                      </td>
                      <td class="">
                        <button class="btn btn-success gotit" data-token="{{csrf_token()}}" data-id="{{$user->id}}">Got it</button>
                      </td>
                    </tr>
                    @endisset
                  @endforeach
                  </tbody>
                </table>
                <div class="float-right mt-5">
                  {{$remember->links()}}
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