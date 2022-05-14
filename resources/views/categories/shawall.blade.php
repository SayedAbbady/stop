@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Categories
            @permission('add-category')
            <a href="{{route('cat.add')}}" class="btn btn-success">Add new Category</a>
            @endpermission

          </h4>
          <div class="card ">
            <div div class="card-body">
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
                          @permission('	show-history')
                          <th scope="col">History</th>
                          @endpermission

                          <th scope="col">Settings</th>
                        </tr>
                      </thead>
                      <tbody class="bg-white">

                    @for ($i = 0; $i < $cat->count(); $i++)
                      
                        <tr id="{{$cat[$i]->id}}">
                          <td class="">{{$counter++}}</td>
                          <td class="">
                          {{$cat[$i]->created_at}}
                          </td>
                          
                          <td class="">
                            <a href="{{route('cat.show',$cat[$i]->id)}}">
                              {{$cat[$i]->name}}
                            </a>
                          </td>
                          <td class="">
                          <span title="Students in Old version">{{$cat[$i]->person->count()}}</span> // 
                          <span title="Students in New version">{{$cat[$i]->newparent->count()}}</span>
                          </td>
                          @permission('	show-history')
                          <td class="">
                          <a href="{{url('/history?type=Category&id='.$cat[$i]->id.'')}}">history</a>
                          </td>
                          @endpermission

                          <td class="">
                            @permission('edit-category')
                            <a href="{{route('cat.edit',$cat[$i]->id)}}" class="btn btn-primary">Edit</a>
                            @endpermission
                            @permission('delete-category')
                            <a href="javascript:;" class="btn btn-danger deleteCategory" data-token="{{csrf_token()}}" data-id="{{$cat[$i]->id}}">Delete</a>
                            @endpermission

                          </td>
                        </tr>
                      
                    @endfor
                  </tbody>
                </table>
                <div class="float-right mt-5">
                  {{$cat->links()}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection