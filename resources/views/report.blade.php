@extends('layouts.app')
@permission('make-reports')
@section('styles')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css" integrity="sha512-OtwMKauYE8gmoXusoKzA/wzQoh7WThXJcJVkA29fHP58hBF7osfY0WLCIZbwkeL9OgRCxtAfy17Pn3mndQ4PZQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
      .form-control:disabled, .form-control[readonly] {
          background-color: #fff!important;
          opacity: 1;
      }
      label {
          font-weight: bold;
      }
  </style>

@endsection
@section('content')
  <div class="row">
    <div class="col-lg-12 ">
      <div class="content-section ">
        <div class="card-my-owen">
          <h4 class="title">
            Reports
          </h4>
          <div class="card ">
            <div class="card-body">
              <form class="row" id="form-to-get-report-data">
                @csrf
                <div class="form-group col-md-3 mb-2">
                  <label for="datePick" >Select duration</label>
                  <input type="date" name="duration" class="form-control" id="datePick" placeholder="Select duration">
                  <small id="durationErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group col-md-3 mb-2">
                  <label for="user" >Select User</label>
                  <select name="user" id="" class="form-control">
                    @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                  </select>
                  <small id="userErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group col-md-3 mb-2">
                  <label >Select Status</label>
                  <select name="status" id="" class="form-control">
                    <option value="created">created</option>
                    <option value="restored">restored</option>
                    <option value="updated">updated</option>
                    <option value="deleted">deleted</option>
                  </select>
                  <small id="statusErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="form-group col-md-3 mb-2">
                  <label >Select Object</label>
                  <select name="object" id="" class="form-control">
                    <option value="Students">Students</option>
                    <option value="Category">Category</option>
                  </select>
                  <small id="objectErrors" class="form-text text-muted errorClass"></small>
                </div>
                <div class="col-4 ">
                  <button type="submit" class="btn btn-block btn-primary mb-2">Get report</button>
                </div>
              </form>
            </div>
          </div>

          <div class="card" >
            <div class="card-body" id="report-result-fetch-data"></div>
          </div>


        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $("#datePick").flatpickr({
      mode: "range",
      dateFormat: "Y-m-d",

      // disable: [
      //     function(date) {
      //         // disable every multiple of 8
      //         return !(date.getDate() % 7);
      //     }
      // ]
    });
  </script>
@endsection
@endpermission