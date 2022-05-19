@extends('layouts.app')
@permission('edit-students')
@section('content')
  <div class="row">
    <div class="col-lg-10 offset-lg-1 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Edit <b>{{$user->parent_name}}</b>'s family 
          </h4>
          <div class="card ">
            <div div class="card-body">
              {{-- Form to add users  --}}
              <form class="form" method="post" id="edit_new_student">
                @csrf
                <input type="hidden" name="countChoosew" value="1" id="countChoosew">
                <input type="hidden" name="parent_id" value="{{$user->id}}" >
                  <div class="form-group">
                    <label for=""><b> Category</b></label>
                    <select name="category" class="form-control user_ad" id="">
                      @foreach ($cat as $item)
                          <option value="{{$item->id}}" {{($user->type == $item->id)?"selected":""}}>{{$item->name}}</option>
                      @endforeach
                    </select>
                  <small id="categoryErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Parent Name</b> </label>
                    <input type="text" name="parent_name" class="user_ad form-control" id="" value="{{$user->parent_name}}">
                    <small id="parent_nameErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for="" class="col-12"><b>Children</b></label>
                    @foreach ($user->children as $item)
                    <div class="row QDnDDeletew">
                      <hr class="col-8 offset-2">
                      <botton class="iconDelete" data-toggle="tooltip" data-placement="bottom" title="Delete">x</botton>

                      <div class="col-md-4">
                        <input type="text" name="student[]" placeholder="Child name" class="user_ad form-control" value="{{$item->name}}" >
                        <small id="student0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-4">
                        <select name="teacher[]" id="teacher_selecet" class="user_ad form-control" title="Select Teacher ">

                          @foreach ($teachers as $teacher)
                              <option value="{{$teacher->id}}" {{($teacher->id == $item->teacher_id)?'selected':''}}>{{$teacher->name}}</option>
                          @endforeach
                        </select>
                        <small id="teacher0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-4">
                        <input type="text" name="resone[]" placeholder="Stop resone" class="user_ad form-control" id="" value="{{$item->resone}}">
                        <small id="resone0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-3 mt-2"><label for=""><b> last session</b></label></div>
                          <div class="col-9">
                            <input type="date" name="lastdate[]" class="user_ad form-control" id="" value="{{$item->lastsession}}">
                            <small id="lastdate.0Errors" class="form-text text-muted errorClass"></small>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-3 mt-2"><label for=""><b>Hour rate</b></label></div>
                          <div class="col-9">
                            <input type="text" name="hourrate[]" placeholder="Hour rate" class="user_ad form-control" id="" value="{{$item->hourrate}}">
                            <small id="hourrate.0Errors" class="form-text text-muted errorClass"></small>
                          </div>
                        </div>
                      </div>

                    </div>
                    @endforeach

                    <div class="addChooseQuestionWord col-12" data-toggle="tooltip" data-placement="bottom" title="Add new question">
                      <i data-feather="plus"></i>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Status</b></label>
                    <select name="status" id="status_input" class="form-control">
                      <option value="1" {{($user->status == "1")?'selected':''}}>No contact</option>
                      <option value="2" {{($user->status == "2")?'selected':''}}>Contact & answer</option>
                      <option value="3" {{($user->status == "3")?'selected':''}}>Alarm</option>
                      <option value="4" {{($user->status == "4")?'selected':''}}>Contact & no answer</option>
                    </select>
                    <small id="statusErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group" id="status_div">
                    @if ($user->status == '3')                        
                    <div class='row'>
                      <div class="col-12">
                        <label for=""><b>Alarm</b></label>
                      </div>
                      @foreach ($user->remember_students as $alarm)
                          
                      
                      <div class="col-6 mb-1">
                        <input type="date" name="alarm_date" value="{{$alarm->date}}" class=" form-control" >
                      </div>
                      <div class="col-6 mb-1">
                        <input type="time" name="alarm_time" class=" form-control" value="{{$alarm->time}}">
                      </div>
                      <div class="col-12 mb-1">
                        <input type="text" name="note" class=" form-control" value="{{$alarm->note}}" placeholder="Add note to alarm">
                      </div>
                      @endforeach
                    </div>
                    @endif
                    @if ($user->status == '2')                        
                    <label for=""><b>Result</b></label>
                    <textarea type="text" rows="5" name="result_info" class=" user_ad form-control" >
                      {!! $user->responce !!}
                    </textarea>
                    <script>
                        CKEDITOR.replace('result_info');
                    </script>
                    @endif
                    
                  </div>
                  <div class="form-group">
                    <label for=""><b>Email address</b></label>
                    <input type="email" name="email" class="user_ad form-control" id="" value="{{$user->email}}">
                    <small id="emailErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Phone</b></label>
                    <input type="text" name="phone" class="user_ad form-control" id="" value="{{$user->phone}}">
                    <small id="phoneErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Date</b></label>
                    <input type="date" name="date" class="user_ad form-control" id="" value="{{$user->date}}">
                    <small id="dateErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Additional information</b></label>
                    <textarea type="text" rows="3" name="Additional_info" class="editor user_ad form-control" >
                     {!! $user->add_info !!}
                    </textarea>
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


@section('scripts')
  <script>
      $(".iconDelete").on("click",function () {

          $(this).parent().fadeOut(500, function(){
              $(this).remove()
          });
      });
  </script>
@endsection
@endpermission