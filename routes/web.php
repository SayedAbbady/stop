<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Shared\OLE\PPS\Root;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {


    Route::get('/', 'HomeController@index')->name('home.al');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('staff', 'StaffController');
    // ajax Staff
    Route::post('/storeData',"StaffController@store");
    Route::post('/editUser',"StaffController@updateUser");
    Route::post('/deleteuser',"StaffController@deleteuser");
    // end ajax Staff

    // categories
    Route::get('/categories', 'CategoryController@index')->name('cat');
    Route::get('/category/{id}', 'CategoryController@show')->name('cat.show');
    Route::get('/add-category', 'CategoryController@categoryAdd')->name('cat.add');
    Route::get('/edit-category/{id}', 'CategoryController@categoryEdit')->name('cat.edit');
    Route::post('/save-cat', 'CategoryController@saveCat');
    Route::post('/edit-cat', 'CategoryController@editCat');
    Route::post('/delete-cat', 'CategoryController@categoryDelete');
    // End categories

    // route of students
    Route::get('/students/old-version', 'StudentsController@index');
    Route::get('/students/new-version', 'StudentsController@new_version')->name('students.new');
    Route::get('/students/new-version/category', 'StudentsController@getBycategory')->name('students.category.search');
    Route::get('/students/new-version/status', 'StudentsController@getBystatus')->name('students.status.search');
    Route::get('students/convert/{id}', 'StudentsController@convert')->name('convertUser');
    Route::get('students/restore', 'StudentsController@restore')->name('restoreUs');
    Route::get('students/deleted-students', 'StudentsController@deleted_students')->name('deleted_students');
    Route::resource('students', 'StudentsController');

    // ajax students
    Route::post('/storeStudentsData',"StudentsController@store_new_student");
    Route::post('/editStudents',"StudentsController@updateStudent");
    Route::post('/deleteStudents',"StudentsController@deletestudent");
    Route::post('/deleteStudentsForce',"StudentsController@force_Delete"); //
    Route::post('/convertStudentsData',"StudentsController@convert_new_student") ; // convert to new version of students
    // end ajax students


    Route::get('/teachers',"HomeController@teachers")->name('teachers.index');
    Route::get('/teachers/add-teachers',"HomeController@add_teachers")->name('createteachers');
    Route::post('/teachers/upload-file',"HomeController@upload_file")->name('teacher.import');
    Route::post('/teachers/deleteTeacher',"HomeController@deleteTeacher");
    Route::post('/teachers/add-ajax',"HomeController@add_teachers_ajax");
    Route::post('/teachers/get_students-names',"HomeController@teachers_get_students");

    // history logs
    Route::get('/history', 'HomeController@history')->name('get.history');
    Route::post('/history/details', 'HomeController@history_getdetails');


    // alarms routes
    Route::get('/alarms', 'RememberController@index')->name('alarms.index');
    Route::get('/alarms/got-it', 'RememberController@gotitshow')->name('alarms.gotit');
    Route::get('/alarms/no-action', 'RememberController@noaction')->name('alarms.noaction');
    Route::get('/gotit', 'RememberController@gotit');

    // get graph data
    Route::get('/graph', 'HomeController@get_graph');

    // search route
    Route::get('/search','HomeController@search')->name('search');

    Route::get('/report','HomeController@report')->name('report.index');
    Route::post('/report/ajax-data','HomeController@report_ajax');


    Route::get('/popup','HomeController@popup');


    Route::post('/settings/roles-assignment')->name('settings');

});


