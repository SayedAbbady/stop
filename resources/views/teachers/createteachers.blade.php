@extends('layouts.app')
@permission('add-teacher')
@section('content')
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Add new Teacher 
          </h4>
          <div class="card ">
            <div div class="card-body">
              {{-- Form to add users  --}}
              <form class="form" method="post" id="add-new_teacher">
                @csrf
                
                  <div class="form-group">
                    <label for=""><b>Full name</b></label>
                    <input type="text" name="name" class="user_ad form-control" id="" >
                    <small id="nameErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Email address</b></label>
                    <input type="email" name="email" class="user_ad form-control" id="" >
                    <small id="emailErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Phone</b></label>
                    <input type="text" name="phone" class="user_ad form-control" id="">
                    <small id="phoneErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  
                  <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@endpermission