@extends('layouts.app')
@permission('add-students')
@section('content')
  <div class="row">
    <div class="col-lg-10 offset-lg-1">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Add new Student 
          </h4>
          <div class="card ">
            <div div class="card-body">
              {{-- Form to add users  --}}
              <form class="form" method="post" id="add-new_student">
                @csrf
                <input type="hidden" name="countChoosew" value="1" id="countChoosew">
                  <div class="form-group">
                    <label for=""><b> Category</b></label>
                    <select name="category" class="form-control user_ad" id="">
                      @foreach ($cat as $item)
                          <option value="{{$item->id}}">{{$item->name}}</option>
                      @endforeach
                    </select>
                  <small id="categoryErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Parent Name</b></label>
                    <input type="text" name="parent_name" class="user_ad form-control" id="" >
                    <small id="parent_nameErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label for="" class="col-12"><b>Children</b></label>
                      <div class="col-md-4">
                        <input type="text" name="student[]" placeholder="Child name" class="user_ad form-control" id="" >
                        <small id="student.0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-4">
                        <select name="teacher[]" id="teacher_selecet" class="user_ad form-control" title="Select Teacher ">
                          
                          @foreach ($teachers as $teacher)
                              <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                          @endforeach
                        </select>
                        <small id="teacher.0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-4">
                        <input type="text" name="resone[]" placeholder="Stop resone" class="user_ad form-control" id="" >
                        <small id="resone.0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-3 mt-2"><label for=""><b>Hours rate</b></label></div>
                          <div class="col-9">
                            <input type="text" name="hourrate[]" placeholder="Hour rate" class="user_ad form-control" id="" >
                            <small id="hourrate.0Errors" class="form-text text-muted errorClass"></small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-3 mt-2"><label for=""><b>last session</b></label></div>
                          <div class="col-9">
                            <input type="date" name="lastdate[]" class="user_ad form-control" id="" >
                            <small id="lastdate.0Errors" class="form-text text-muted errorClass"></small>
                          </div>
                        </div>
                      </div>

                    </div>
                    
                    <div class="addChooseQuestionWord col-12" data-toggle="tooltip" data-placement="bottom" title="Add new question">
                      <i data-feather="plus"></i>
                    </div>
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
                  <div class="form-group">
                    <label for=""><b>Date</b></label>
                    <input type="date" name="date" class="form-control" value="{{date('Y-m-d',time())}}">
                    <small id="dateErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Additional information</b></label>
                    <textarea type="text" rows="5" name="Additional_info" class=" user_ad form-control" id=""></textarea>
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