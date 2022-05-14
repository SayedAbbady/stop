@extends('layouts.app')
@permission('convert-old-students-to-new')
@section('content')
  <div class="row">
    <div class="col-lg-8 ">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Convert Student to new version 
          </h4>
          <div class="card ">
            <div  class="card-body">
              {{-- Form to add users  --}}
              <form class="form" method="post" id="convert-to-new_student">
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
                    <input type="text" name="parent_name" class="user_ad form-control" id="" value="{{$user->name}}">
                    <small id="parent_nameErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <label for="" class="col-12"><b>Children</b></label>
                      <div class="col-md-4">
                        <input type="text" name="student[]" placeholder="Child name" class="user_ad form-control" id="" >
                        <small id="student0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-4">
                        <select name="teacher[]" id="teacher_selecet" class="user_ad form-control" title="Select Teacher ">
                          
                          @foreach ($teachers as $teacher)
                              <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                          @endforeach
                        </select>
                        <small id="teacher0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-4">
                        <input type="text" name="resone[]" placeholder="Stop resone" class="user_ad form-control" id="" >
                        <small id="resone0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-6">
                        <input type="text" name="hourrate[]" placeholder="Hour rate" class="user_ad form-control" id="" >
                        <small id="hourrate0Errors" class="form-text text-muted errorClass"></small>
                      </div>
                      <div class="col-md-6">
                        <input type="date" name="lastdate[]" class="user_ad form-control" id="" >
                        <small id="lastdate0Errors" class="form-text text-muted errorClass"></small>
                      </div>

                    </div>
                    
                    <div class="addChooseQuestionWord col-12" data-toggle="tooltip" data-placement="bottom" title="Add new question">
                      <i data-feather="plus"></i>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for=""><b>Status</b></label>
                    <select name="status" id="status_input" class="form-control">
                      <option value="1">No contact</option>
                      <option value="2">Contact</option>
                      <option value="3">Alarm</option>
                      <option value="4">Contact and no answer</option>

                    </select>
                    <small id="emailErrors" class="form-text text-muted errorClass"></small>
                  </div>
                  <div class="form-group" id="status_div"></div>
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
    <div class="col-lg-4">
      <div class="content-section ">
        <div class="card-my-owen">  
          <h4 class="title">
            Old Data 
          </h4>
          <div class="card ">
            <div div class="card-body">
              <div class="row">
                  <div class="col-md-12"> <b> اسم القسم </b> </div>
                  <div class="col-md-12"> {{$user->category->name}} 
                    <hr>
                  </div>

                  <div class="col-md-12"> <b> اسم الطالب </b> </div>
                  <div class="col-md-12 "> 
                  <?php 
                    $arr = explode(',',$user->name);
                    $x = 0;
                    foreach ($arr as $a) {
                        $x++;
                        $a =  str_replace( array(']' , '[', ',', '"','-' ), ' ', $a);
                        echo '
                        <div class="form-control bg-dark mb-1" style="color:#fff;" dir="ltr"> 
                        &nbsp;&nbsp;&nbsp; '.$x.' - '.$a.'
                        </div>'
                        ;
                        
                    }
                  ?> 
                    <hr>
                  </div>

                  <div class="col-md-12"> <b> المعلم </b> </div>
                  <div class="col-md-12"> <?php echo $user->teacher ;?> 
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> البريد الالكتروني </b> </div>
                  <div class="col-md-12"> <?php echo $user->email ;?> 
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> التليفون </b> </div>
                  <div class="col-md-12"> <?php echo $user->phone ;?> 
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> تاريخ الاضافه </b> </div>
                  <div class="col-md-12"> <?php echo $user->date ;?> 
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> سبب التوقف </b> </div>
                  <div class="col-md-12"> <?php echo $user->reson ;?> 
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> حالة الاتصال </b> </div>
                  <div class="col-md-12">
                    @if ($user->status == 'تم الاتصال')
                      <a href="javascript:;" class="btn btn-success" style="padding:6px 60px;"> <i class="align-middle" data-feather="check"></i> تم الاتصال </a> 
                    @elseif ($user->status == 'مؤجل')
                      <a href="javascript:;" class="btn btn-warning" style="padding:6px 60px;"> <i class="align-middle" data-feather="clock"></i> مؤجل </a> 
                    @else
                      <a href="javascript:;" class="btn btn-danger" style="padding:6px 60px;font-weight:bold"> <i class="align-middle" data-feather="x"></i> لم يتم الاتصال </a> 
                    @endif  
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> نتيجة الاتصال </b> </div>
                  <div class="col-md-12"> <?php echo $user->result ;?>
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> الواجبات </b> </div>
                  <div class="col-md-12"> <?php echo $user->day ;?> 
                    <hr>
                  </div>
                  <div class="col-md-12"> <b> معلومات اضافيه </b> </div>
                  <div class="col-md-12"> <?php echo $user->add ;?> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@endpermission