@extends('layouts.app')
@permission('edit-category')
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
              <form action="" id="edit_category_form" method="POST">
                @csrf
                <div class="form-group">
                  <label for="">Category name</label>
                  <input type="hidden" class="form-control" name="i_d_Fname" value="{{$catOne[0]->id}}" aria-describedby="">
                  <input type="text" class="form-control user_ad" name="name" value="{{$catOne[0]->name}}" aria-describedby="">
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
