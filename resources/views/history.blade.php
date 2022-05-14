@extends('layouts.app')
@permission('show-history')
@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            {{-- History of <b>{{$activity->subject->parent_name}}</b>. --}}
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
                          <th style="">Name of object</th>
                          
                          <th scope="col">description</th>
                          <th scope="col">Settings</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white">
                    @foreach ($activity as $item)
                     
                        <tr >
                          <td class="">{{$counter++}}</td>
                          <td class="">
                          {{-- {{$item->created_at}} --}}
                          {{ Carbon\Carbon::parse($item->created_at)->isoFormat('dddd, MMMM Do YYYY, hh:mm A')}}
                          </td>
                          
                          <td style="font-size:15px">
                            <p class="badge badge-dark d-block text-left ">
                              {{ (isset($item->subject->parent_name)) ? $item->subject->parent_name : $item->subject->name}}
                            </p>
                          </td>
                          
                          <td class="">
                            <p> <a href="{{url('/history?type=user&id='.$item->causer->id.'')}}">{{$item->causer->name}}</a> {{$item->description}} => {{$item->log_name}}</p>
                          </td>
                          
                          <td class="">
                            @if ($item->log_name == 'Category' and $item->description == 'created')
                            <a  class="btn btn-primary " href="{{route('cat.show',$item->properties['attributes']['id'])}}"> Show details </a>
                           
                            @elseif ($item->log_name == 'Students' and $item->description == 'created')
                            <a  class="btn btn-primary " href="{{route('students.show',$item->properties['attributes']['id'])}}"> Show details </a>
                           
                            @elseif ($item->log_name == 'Students' and $item->description == 'restored')
                            <a  class="btn btn-primary " href="{{route('students.show',$item->properties['attributes']['id'])}}"> Show details </a>
                           
                            @elseif ($item->log_name == 'Category' and $item->description == 'deleted')
                            <button type="button" class="btn btn-primary getDetaislData" data-type="delete_category" data-id="{{$item->id}}" data-token="{{csrf_token()}}" data-toggle="modal" data-target="#exampleModal">
                            Show details
                            </button>
                           
                            @elseif ($item->log_name == 'Students' and $item->description == 'deleted')
                            <button type="button" class="btn btn-primary getDetaislData" data-type="delete_students" data-id="{{$item->id}}" data-token="{{csrf_token()}}" data-toggle="modal" data-target="#exampleModal">
                            Show details
                            </button>
                           
                            @elseif ( $item->description == 'updated')
                            <button type="button" class="btn btn-primary getDetaislData" data-type="updated" data-id="{{$item->id}}" data-token="{{csrf_token()}}" data-toggle="modal" data-target="#exampleModal">
                            Show details
                            </button>
                           
                            
                            @else
                            
                            There is a new input 

                            @endif
                            
                          </td>
                        </tr>
                       
                    @endforeach
                  </tbody>
                </table>
                <div class="float-right mt-5">
                  {{$activity->withQueryString()->links()}}
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                  <div class="modal-dialog" style="max-width: 642px">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="backData">
                        ...
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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