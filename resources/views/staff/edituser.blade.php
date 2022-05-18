@extends('layouts.app')
@permission('edit-staff-member')
@section('content')
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Edit member 
          </h4>
          <div class="card ">
            <div div class="card-body">
              
              {{-- Form to add users  --}}
              <form action="" id="edit_user_form" method="POST">
                @csrf
                <div class="form-group">
                  <label for="">Full name</label>
                  <input type="hidden" class="" name="i_df" value="{{$user[0]->id}}" aria-describedby="">
                  <input type="text" class="form-control user_ad" name="name" value="{{$user[0]->name}}" aria-describedby="">
                  <small id="nameErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control user_ad" id="exampleInputEmail1" value="{{$user[0]->email}}" name="email" aria-describedby="emailHelp">
                  <small id="emailErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group">
                  <label for="">Old Password</label>
                  <input id="" type="password" class="user_ad form-control" name="old_password"  >
                  <small id="old_passwordErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group">
                  <label for="">New Password</label>
                  <input id="" type="password" class="user_ad form-control" name="new_password" >
                  <small id="new_passwordErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group">
                  <label for="" class=" col-form-label text-md-right">Confirm Password</label>
                  <input id="" type="password" class="user_ad form-control " name="new_password_confirmation" >
                </div>
                <hr class="mt-4 mb-3 d-block">
                 
                <label for=""><b>Select Permission</b></label>
                <div class="row">
                  @foreach ($roles as $key=>$item)
                    <div class="col-md-3">
                    <div class="form-group form-check">
                      <input type="checkbox" value="{{$item->name}}"
                      @php
                          if ($user[0]->isAbleTo($item->name)) {echo 'checked';} else {echo "";}
                      @endphp
                      class="form-check-input" name="role[]" id="exampleCheck{{$key}}">
                      <label class="form-check-label" for="exampleCheck{{$key}}">{!! $item->display_name !!}</label>

                    </div>
                  </div>
                @endforeach
                </div>
                <button type="submit" class="mt-3 btn btn-primary">Submit</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@endpermission