@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Students  
            
          </h4>
          <div class="card ">
            <div div class="card-body">
              @php
                  $counter=1;
              @endphp
                  <div class="alert alert-warning" role="alert">
                    You are using the old version, please switch to the new version
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover table-borderless ">
                      <thead>
                        <tr class="border-bottom">
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th style="width:15px">Name</th>
                          <th scope="col">Status</th>
                          <th scope="col">Category</th>
                          @permission('convert-old-students-to-new')
                          <th scope="col">Settings</th>
                          @endpermission

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
                            <?php
                                $arr = explode(',',$user->name);
                                $x = 0;
                                foreach ($arr as $a) {
                                  $a =  str_replace( array(']' , '[', ',', '"' ,'-'), ' ', $a);
                            ?>
                            
                            <a class="badge badge-dark d-block text-left my-1" target="_blank" href="{{route('students.show',$user->id)}}">{{++$x . ' - ' . $a}}</a>
                            <?php
                                }  
                            ?>

                          </td>
                          <td class="">
                          
                            @if ($user->status == 'تم الاتصال')
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-success" style="padding:6px 60px;"> <i class="align-middle" data-feather="check"></i> </a> 
                            @elseif ($user->status == 'مؤجل')
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-warning" style="padding:6px 60px;"> <i class="align-middle" data-feather="clock"></i> </a> 
                            @else
                              <a href="{{route('students.show',$user->id)}}" target="_blank" class="btn btn-danger" style="padding:6px 60px;font-weight:bold"> <i class="align-middle" data-feather="x"></i> </a> 
                            @endif
                            

                          </td>
                          
                          <td class="">
                            
                              <b> 
                                 <span class="badge badge-primary">{{$user->category->name}}</span>
                              </b>
                            
                          </td>
                          <td class="">
                            @permission('convert-old-students-to-new')
                            <a href="{{route('convertUser',["id"=>$user->id])}}" target="_blank" class="btn btn-success">Convert to new version</a>
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