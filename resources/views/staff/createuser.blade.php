@extends('layouts.app')
@permission('create-staff-member')
@section('content')
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Add new Staff members 
          </h4>
          <div class="card ">
            <div div class="card-body">
              
              {{-- Form to add users  --}}
              <form action="" id="add_user_form" method="POST">
                @csrf
                <div class="form-group">
                  <label for=""><b>Full name</b></label>
                  <input type="text" class="form-control user_ad" name="name" aria-describedby="">
                  <small id="nameErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><b>Email address</b></label>
                  <input type="email" class="form-control user_ad" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                  <small id="emailErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group">
                  <label for=""><b>Password</b></label>
                  <input id="password" type="password" class="user_ad form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                  <small id="passwordErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group">
                  <label for="" class=" col-form-label text-md-right"><b>Confirm Password</b></label>
                  <input id="" type="password" class="user_ad form-control " name="password_confirmation" required autocomplete="new-password">
                </div>
                <hr class="mt-4 mb-3 d-block">
                <label for=""><b>Select Permission</b></label>
                  <div class="row">
                    @foreach ($roles as $key=>$item)
                      <div class="col-md-3">
                        <div class="form-group form-check">
                          <input type="checkbox" value="{{$item->name}}" class="form-check-input" name="role[]" id="exampleCheck{{$key}}">
                          <label class="form-check-label" for="exampleCheck{{$key}}">{{ucwords($item->display_name)}}</label>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  {{-- <input type="submit" value="click"> --}}
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