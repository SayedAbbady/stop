@extends('layouts.app')

@permission('add-category')
@section('content')
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Add new category 
          </h4>
          <div class="card ">
            <div div class="card-body">
              
              {{-- Form to add users  --}}
              <form action="" id="add_category_form" method="POST">
                @csrf
                <div class="form-group">
                  <label for="">Category name</label>
                  <input type="text" class="form-control user_ad" name="name" aria-describedby="">
                  <small id="nameErrors" class="form-text text-muted errorClass"></small>
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
