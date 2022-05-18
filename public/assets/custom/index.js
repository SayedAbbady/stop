$(function () {
  'use strict';

  // add form to database ajax
  function saveWithAjax(route, form, element, input) {
    var formData = new FormData($('#' + form)[0]);
    Swal.fire({
      icon: 'question',
      title: "Do you want continue ?",
      showCancelButton: true,
      confirmButtonText: 'Yes',

    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: link + route,
          method: 'post',
          enctype: 'multipart/form-data',
          data: formData,
          processData: false,
          contentType: false,
          cache: false,
          beforeSend: function () {
            $('.loader').css({
              'opacity': '.9',
              'display': 'block'
            });
          }, // before
          success: function (data) {
            if (data.status == "1") {
              Swal.fire({
                title: 'Done !',
                text: data.msg,
                icon: 'success',
                padding: '2em'
              })
              $('.' + input).val('');
              $('.' + element).html('');
            } else if (data.status == "2") {
              Swal.fire({
                title: 'Error',
                text: data.msg,
                icon: 'error',
                padding: '2em'
              })
            } else {
              Swal.fire({
                title: 'Error',
                text: data.msg,
                icon: 'error',
                padding: '2em'
              })

            }
            $('.loader').css({
              'opacity': '.9',
              'display': 'none'
            });

          }, // success
          error: function (data) {
            $('.' + element).html('');
            var response = JSON.parse(data.responseText);

            Swal.fire({
              title: 'Error',
              text: response.errors.name,
              icon: 'error',
              padding: '2em'
            })
            $('.loader').css({
              'opacity': '.9',
              'display': 'none'
            });

            $.each(response.errors, function (key, val) {
              $("#" + key + "Errors").text(val);
            })

          }
        }); // ajax
      }
    });
    return true;
  }
  // end ajax function

  // function to Edit Slider ---------------------------------------
  function editWithAjax(route, form) {
    var formData = new FormData($('#' + form)[0]);
    Swal.fire({
      icon: 'question',
      title: "Do you want continue?",
      showCancelButton: true,
      confirmButtonText: 'Yes',

    }).then((result) => {
      if (result.isConfirmed) {
    $.ajax({
      url: link + route,
      method: 'post',
      enctype: 'multipart/form-data',
      data: formData,
      processData: false,
      contentType: false,
      cache: false,

      beforeSend: function () {
        $('.loader').css({
          'opacity': '.9',
          'display': 'block'
        });
      },

      success: function (data) {
        if (data.status == "1") {
          Swal.fire({
            title: 'Done !',
            text: data.msg,
            icon: 'success',
            padding: '2em'
          })

        } else if (data.status == "2") {
          Swal.fire({
            title: 'Error',
            text: data.msg,
            icon: 'error',
            padding: '2em'
          })

        } else if (data.status == "3") {
          Swal.fire({
            title: 'Error',
            text: data.msg,
            icon: 'error',
            padding: '2em'
          })
        }
        else {
          Swal.fire({
            title: 'Error',
            text: data.msg,
            icon: 'error',
            padding: '2em'
          })

        }
        $('.loader').css({
          'opacity': '.9',
          'display': 'none'
        });
      },

      error: function (data) {

        var response = JSON.parse(data.responseText);

        Swal.fire({
          title: 'Error',
          text: response.errors.name,
          icon: 'error',
          padding: '2em'
        })
        $('.loader').css({
          'opacity': '.9',
          'display': 'none'
        });

        $.each(response.errors, function (key, val) {
          $("#" + key + "Errors").text(val);
        })

      }

    });
  }

  });
  return true
  }

  // delete ajax
  function deleteWithAjax(route, id, token) {
  Swal.fire({
    icon: 'question',
    title: 'Are you sure ?',
    showCancelButton: true,
    confirmButtonText: 'Yes',

  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: link + route,
        method: 'post',
        data: {
          "_token": token,
          "id": id,
        },
        beforeSend: function () {
          $('.loader').css({
            'opacity': '.9',
            'display': 'block'
          });
        },
        success: function (data) {
          if (data.status == "1") {
            Swal.fire({
              title: 'Done',
              text: data.msg,
              icon: 'success',
              padding: '2em'
            })
            $('#' + id).fadeOut(1500);
          } else if (data.status == "2") {
            Swal.fire({
              title: 'Error',
              text: data.msg,
              icon: 'error',
              padding: '2em'
            })
          } else {
            Swal.fire({
              title: 'Error',
              text: data.msg,
              icon: 'error',
              padding: '2em'
            })

          }
          $('.loader').css({
            'opacity': '.9',
            'display': 'none'
          });
        },

      })
    }
  })

}


  // add new
  $("#add_user_form").on('submit',function (e) {
    e.preventDefault();
    saveWithAjax('/storeData', "add_user_form", 'errorClass','user_ad')
  })

  // edit one
  $("#edit_user_form").on('submit',function (e) {
    e.preventDefault();
    editWithAjax('/editUser','edit_user_form')
  })

  // delete user
  $('.deleteUser').on('click',function (e) {
    e.preventDefault();
    var token = $(this).data('token');
    var id = $(this).data('id');
    deleteWithAjax('/deleteuser',id,token);
  })
  //****************************************************************** */
  // end User

  // category
  $("#add_category_form").on('submit', function (e) {
    e.preventDefault();
    saveWithAjax('/save-cat', "add_category_form", 'errorClass', 'user_ad')
  })
  // edit
  // edit one
  $("#edit_category_form").on('submit', function (e) {
    e.preventDefault();
    editWithAjax('/edit-cat', 'edit_category_form')
  })
  // delete
  $('.deleteCategory').on('click', function (e) {
    e.preventDefault();
    var token = $(this).data('token');
    var id = $(this).data('id');
    deleteWithAjax('/delete-cat', id, token);
  })


  //***************************** */
  // add new teacher
  $("#add-new_teacher").on('submit', function (e) {
    e.preventDefault();
    saveWithAjax('/teachers/add-ajax', "add-new_teacher", 'errorClass', 'user_ad')
  })


  // Delete Teachers
  $('.deleteTeacher').on('click', function (e) {
    e.preventDefault();
    var token = $(this).data('token');
    var id = $(this).data('id');
    deleteWithAjax('/teachers/deleteTeacher', id, token);
  })
  /************************************** */

  // new student ajax
  $('#add-new_student').on('submit', function (e) {
    e.preventDefault();
    for (window.instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    }
    $("#countChoosew").val($(".QDnDDeletew").length + 1);
    if( saveWithAjax('/storeStudentsData', "add-new_student", 'errorClass', 'user_ad') ){
      CKEDITOR.instances[instance].setData('');
    }
  })

  // edit student ajax
  // edit one
  $('#edit_new_student').on('submit', function (e) {
    e.preventDefault();
    for (window.instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    }
    $("#countChoosew").val($(".QDnDDeletew").length );
    editWithAjax('/editStudents', 'edit_new_student')
  })

  // Delete student
  $('.deleteStudent_i').on('click', function (e) {
    e.preventDefault();
    var token = $(this).data('token');
    var id = $(this).data('id');
    deleteWithAjax('/deleteStudents', id, token);
  })
  $('.deleteStudent_i_force').on('click', function (e) {
    e.preventDefault();
    var token = $(this).data('token');
    var id = $(this).data('id');
    deleteWithAjax('/deleteStudentsForce', id, token);
  })

  /*************************************************************   */


  // submit form after converting
  $('#convert-to-new_student').on('submit', function (e) {
    e.preventDefault();
    for (window.instance in CKEDITOR.instances) {
      CKEDITOR.instances[instance].updateElement();
    }
    $("#countChoosew").val($(".QDnDDeletew").length + 1);
    saveWithAjax('/convertStudentsData', "convert-to-new_student", 'errorClass', 'user_ad')
  })
  ////////////////////////////////////////////////////////////////

  // submit form to get report data
  $('#form-to-get-report-data').on('submit',function (e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    Swal.fire({
      icon: 'question',
      title: "Do you want continue ?",
      showCancelButton: true,
      confirmButtonText: 'Yes',

    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: link +'/report/ajax-data',
          method: 'post',
          enctype: 'multipart/form-data',
          data: formData,
          processData: false,
          contentType: false,
          cache: false,
          beforeSend: function () {
            $('.loader').css({
              'opacity': '.9',
              'display': 'block'
            });
          }, // before
          success: function (data) {
            if (data.status == "1") {
              $('#report-result-fetch-data').html(`
              
              <div class="card" >
                <div class="card-body" id="">
              ` + data.msg + ` 
                </div>
              </div>
              
              `);
              $('#report-result-Static').html(`
              
              <div class="card" >
                <div class="card-body" id="">
              ` + data.total + ` 
                </div>
              </div>
              
              `);
            } else {
              Swal.fire({
                title: 'Error',
                text: data.msg,
                icon: 'error',
                padding: '2em'
              })

            }
            $('.loader').css({
              'opacity': '.9',
              'display': 'none'
            });

          }, // success
          error: function (data) {
            $('.errorClass').html('');
            var response = JSON.parse(data.responseText);

            Swal.fire({
              title: 'Error',
              text: response.errors,
              icon: 'error',
              padding: '2em'
            })
            $('.loader').css({
              'opacity': '.9',
              'display': 'none'
            });

            $.each(response.errors, function (key, val) {
              $("#" + key + "Errors").text(val);
            })
          }
        }); // ajax
      }
    });
  })






  // end ajax
  /************************************************* */

  // start js code
  var count = 2;
  $(".addChooseQuestionWord").on("click", function () {
    var teachers = $('#teacher_selecet').html();
    var cou = 1;

    $(this).before(`
    <div class="row QDnDDeletew mt-3">
    <hr class="col-8 offset-2">
      <botton class="iconDelete" data-toggle="tooltip" data-placement="bottom" title="Delete">x</botton>
        <div class="col-md-4">
          <input name="student[]" placeholder="Child name" type="text" class="user_ad form-control" id="" >
          <small id="student.`+ cou +`Errors" class="form-text text-muted errorClass"></small>
        </div>
        <div class="col-md-4">
          <select name="teacher[]" id="" class="user_ad form-control">
            `+
              teachers
            +`
          </select>
          <small id="teacher.`+ cou +`Errors" class="form-text text-muted errorClass"></small>
        </div>
        <div class="col-md-4">
          <input type="text" name="resone[]" placeholder="Stop resone" class="user_ad form-control" id="" >
          <small id="resone.`+ cou +`Errors" class="form-text text-muted errorClass"></small>
        </div>
        <div class="col-md-6">
          <input type="text" name="hourrate[]" placeholder="Hour rate" class="user_ad form-control" id="" >
          <small id="hourrate.`+ cou +`Errors" class="form-text text-muted errorClass"></small>
        </div>
        <div class="col-md-6">
          <input type="date" name="lastdate[]" class="user_ad form-control" id="" >
          <small id="lastdate.`+ cou +`Errors" class="form-text text-muted errorClass"></small>
        </div>
      </div>
      <script>
        $(".iconDelete").on("click",function () {
          $(this).parent().fadeOut(500, function(){
              $(this).remove()
            });
        });
      </script>
    `);
    count++;
    cou++;
  });


  // return inputs after change in status when convert from old version to new version
  $('#status_input').on('change',function (e) {
    e.preventDefault();
    var status = $(this).val();

    if (status == "2") {
      $('#status_div').html(`
        <label for=""><b>Result</b></label>
        <textarea type="text" rows="5" name="result_info" class=" user_ad form-control" >

        </textarea>
        <script>
          	CKEDITOR.replace('result_info');
        </script>
      `);
    } else if (status == '3') {
      $('#status_div').html(`
        <div class='row'>
        <div class="col-12">
          <label for=""><b>Alarm</b></label>
        </div>
        <div class="col-6">
          <input type="date" name="alarm_date" class=" form-control" >
        </div>
        <div class="col-6 ">
          <input type="time" name="alarm_time" class=" form-control" >
        </div>
        <div class="col-12 my-1">
            <input type="text" name="note" class=" form-control" placeholder="Add note to alarm">
          </div>
        </div>
      `);
    } else {
      $('#status_div').html('');
    }

  });


  // get data details with ajax to show activity
  $('.getDetaislData').on('click',function (e) {
    var token = $(this).data('token');
    var id = $(this).data('id');
    var type = $(this).data('type');
    $.ajax({
      url: link + '/history/details',
      method: 'post',
      data: {
        "_token": token,
        "id": id,
        "type": type,
      },

      beforeSend: function () {
        $('#backData').html('<div class="loader"></div>');
      },
      success: function (data) {
        if (data.status == '1'){
          console.log(data.msg);

          $('#backData').html(data.msg);
        }
      },

    })
  });


  // restore data from deleted student view
  $('.restorDa').on('click', function (e) {
    e.preventDefault();
    var val_id = $(this).data('id');

    Swal.fire({
      icon: 'question',
      title: 'Are you sure ?',
      showCancelButton: true,
      confirmButtonText: 'Yes',

    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: link + '/students/restore',
          method: 'get',
          data: {
            'id': val_id,
          },

          success: function (data) {
            if (data.status == '1') {
              Swal.fire({
                title: 'Done !',
                text: data.msg,
                icon: 'success',
                padding: '2em'
              })
              $('#'+val_id).fadeOut(1500);
            }
          },

        })
      }
    });

  });


  // get year graph
  $('.get_select-graph').on('change', function (e) {

    e.preventDefault();
    var formData = $(this).val();

    $.ajax({
      url: link + '/graph',
      method: 'get',
      data: {
        'year':formData
      },

      beforeSend: function () {

      },

      success: function (respo) {

        console.log(respo.msg);
        var mydata = {
          datasets: [{
            label: "Students",
            fill: true,
            backgroundColor: gradient,
            borderColor: window.theme.primary,
            data: respo.msg
          }]
        }
        mychart.data.datasets = mydata.datasets
        mychart.update()
      },


    })
  })


  // got it alarm
  $('.gotit').on('click',function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var token = $(this).data('token');


    Swal.fire({
      icon: 'question',
      title: 'Are you sure ?',
      showCancelButton: true,
      confirmButtonText: 'Yes',

    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: link + '/gotit',
          method: 'get',
          data: {
            'id': id,
            "_token": token
          },

          beforeSend: function () { },

          success: function (respo) {
            if (respo.status == '1') {
              Swal.fire({
                title: 'Done !',
                text: respo.msg,
                icon: 'success',
                padding: '2em'
              })
              $("#gotit" + id).html("<span class='badge badge-success'>Got it</span>");
            }
          },


        })
      }
    });

  })


    // click to get names of students with one of teacher
  $('.get_teacher_students_names').on('click',function (e) {
        var token = $(this).data('token');
        var id = $(this).data('id');

        $.ajax({
            url: link + '/teachers/get_students-names',
            method: 'post',
            data: {
                "_token": token,
                "id": id,
            },

            beforeSend: function () {
                $('#backData').html('<div class="loader"></div>');
            },
            success: function (data) {
                if (data.status == '1'){
                    console.log(data.msg);

                    $('#backData').html(data.msg);
                }
            },

        })
    });

});



























