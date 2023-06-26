@extends('layouts.master')
@section('page_title', 'Manage Student')
@section('content')

<style>
    .search-items {
        display: none;
    }

    .search-pane .active {
        display: block;
    }

    .hide {
        display: none;
    }

    .pending-students-list,
    .destination_class_pane {
        margin-top: 10px;
        padding-top: 10px;
    }

    .plus {
        background: #58f35e;
        padding: 0px 9px;
        color: white;
        font-weight: bold;
        font-size: 20px;
    }

    .card {
        margin-top: 50px;
        overflow: hidden;
        text-align: left;
    }

    .cardpos {
        position: fixed;
        width: 100%;
        z-index: 10;
    }

    .tabpos {
        margin-top: 70px;
    }

    .cardpos>li {
        width: 180px;
    }

    .cardpos>li>a {
        text-align: center;
        padding: 5px 10px;
    }
</style>

<div class="card">
    <div class="card-body" style="background-color: #F2F2F2;padding-top:0px">
        <ul class="nav nav-tabs nav-tabs-highlight cardpos" style="transform:translateX(-22px);">
            @if ($types=="student" || $types == "staff" || $types=="teacher")
            <li><a href="#search-student" class="nav-link active" data-toggle="tab">Search Student</a></li>
            @else
            <li><a href="#search-student" class="nav-link active" data-toggle="tab">Search Student</a></li>
            <li><a href="#new-student" class="nav-link" data-toggle="tab">Add New Student</a></li>
            <li><a href="#update-profiles" class="nav-link" data-toggle="tab">Update Profiles</a></li>
            <li><a href="#update-photos" class="nav-link" data-toggle="tab">Update Photos</a></li>
            <li><a href="#move-students" class="nav-link" data-toggle="tab">Move Students</a></li>
            <li class=" dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">More</a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#upload-fee-statements" class="dropdown-item" data-toggle="tab">Upload Fee Statements</a>
                    <a href="#student-residences" class="dropdown-item" data-toggle="tab">Student Residences</a>
                </div>
            </li>
            @endif
        </ul>

        <div class="tab-content tabpos">
            <div class="tab-pane fade show active" id="search-student">
                <div class="search_condition">
                    <h6 id="search_title">Search By</h6>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <input type="radio" name="student_search" id="admission_number" class="form-control" checked value="admission_number" style="width: 20px; height: 20px;">
                                        <label class="ml-2" for="admission_number">Admission Number</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <input type="radio" name="student_search" id="name" class="form-control" value="name" style="width: 20px; height: 20px;">
                                        <label class="ml-2" for="name">Name</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <input type="radio" name="student_search" id="phone_number" class="form-control" value="phone_number" style="width: 20px; height: 20px;">
                                        <label class="ml-2" for="phone_number">Phone Number</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <input type="radio" name="student_search" id="upi" class="form-control" value="upi" style="width: 20px; height: 20px;">
                                        <label class="ml-2" for="upi">UPI</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="d-flex">
                                <input type="radio" name="student_search" id="index_number" class="form-control" value="index_number" style="width: 20px; height: 20px;">
                                <label class="ml-2" for="index_number">Index Number</label>
                            </div>
                        </div>
                    </div>

                    <div class="row search-pane">
                        <div class="col-12 mt-3 search-items active" id="here1">
                            <form class="std_search_adm_num" action="{{ route('std_search_adm_num') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="std_adm_num">Student Admission Number</label>
                                    <input class="form-control" type="number" id="std_adm_num" name="std_adm_num">
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mt-3 search-items " id="here2">
                            <form class="std_search_name" action="{{ route('std_search_name') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="std_name">Student Name</label>
                                            <input class="form-control" type="text" placeholder="John Doe" id="std_name" name="std_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="std_form_id">Form</label>
                                            <select required data-placeholder="Select Form" class="form-control select" name="std_form_id" id="std_form_id">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mt-3 search-items " id="here3">
                            <form class="std_search_phone" action="{{ route('std_search_phone') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="std_phone_num">Student Phone Number</label>
                                    <input class="form-control" type="text" id="std_phone_num" name="std_phone_num">
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mt-3 search-items " id="here4">
                            <form class="std_search_upi" action="{{ route('std_search_upi') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="std_upi">Student UPI</label>
                                    <input class="form-control" type="text" id="std_upi" name="std_upi">
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mt-3 search-items " id="here5">
                            <form class="std_search_index_num" action="{{ route('std_search_index_num') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="std_index_num">Student Index Number</label>
                                    <input class="form-control" type="number" id="std_index_num" name="std_index_num">
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Search <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="search_result"></div>
            </div>
            <div class="tab-pane fade" id="new-student" style="background-color: white;padding:30px">
                <form method="post" action="{{ route('students.store') }}">
                    @csrf
                    <h6 style="font-family: 'Times New Roman', Times, serif;font-size:18px;font-weight:bold">Options</h6>
                    <div class="row" style="margin-top:30px">

                        <div class="col-md-2">
                            <div class="d-flex">
                                <input type="radio" name="exam_manage_raking" id="key_in_student_details" class="form-control" checked value="1" style="width: 20px; height: 20px;">
                                <label class="ml-2" for="key_in_student_details" style="font-family: 'Times New Roman', Times, serif;">Key in student details</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="d-flex">
                                <input type="radio" name="exam_manage_raking" id="upload_from_sheet" class="form-control" value="2" style="width: 20px; height: 20px;">
                                <label class="ml-2" for="upload_from_sheet" style="font-family: 'Times New Roman', Times, serif;">upload students from a spreedsheet</label>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div id="first_panel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="admission_number" style="font-family: 'Times New Roman', Times, serif;font-weight:bold">Admission Number <span style="color:red">*</span></label>
                                    <input value="{{ old('admission_number') }}" required type="number" style="font-family: 'Times New Roman', Times, serif;" name="admission_number" id="admission_number_d" placeholder="Admission Number" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="full_name" style="font-family: 'Times New Roman', Times, serif;font-weight:bold">Full Name <span style="color:red">*</span></label>
                                    <input value="{{ old('full_name') }}" required type="text" style="font-family: 'Times New Roman', Times, serif;" name="full_name" id="full_name_d" placeholder="Full Name" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form" style="font-family: 'Times New Roman', Times, serif;font-weight:bold">Form <span style="color:red">*</span></label>
                                    <select class="select form-control" style="font-family: 'Times New Roman', Times, serif;" id="form" name="form" data-fouc data-placeholder="Select Form">
                                        @foreach ($form as $key => $f)
                                        <option value="{{$f->id}}" style="font-family: 'Times New Roman', Times, serif;">{{$f->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="student_create_stream">
                                    <label for="stream" style="font-family: 'Times New Roman', Times, serif;font-weight:bold">Stream <span style="color:red">*</span></label>
                                    <select class="select form-control" style="font-family: 'Times New Roman', Times, serif !important;" id="stream" name="stream" data-fouc data-placeholder="Select Stream">
                                        @foreach ($stream as $key => $s)
                                        <option value="{{$s->stream}}" style="font-family: 'Times New Roman', Times, serif;">{{$s->stream}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" id="student_gender">
                                    <label for="gender" style="font-family: 'Times New Roman', Times, serif;font-weight:bold">Gender <span style="color:red">*</span></label>
                                    <select class="select form-control" style="font-family: 'Times New Roman', Times, serif !important;" id="gender" name="gender" data-fouc data-placeholder="Select Gender">
                                        <option value="male" style="font-family: 'Times New Roman', Times, serif;">Male</option>
                                        <option value="female" style="font-family: 'Times New Roman', Times, serif;">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-12">
                                <div class="text-left">
                                    <button class="btn btn-dark" type="button" onclick="clear_field()" style="font-family: 'Times New Roman', Times, serif;">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="float:left;margin-right:10px;margin-top:4px" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                        </svg>Clear
                                    </button>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success" style="font-family: 'Times New Roman', Times, serif;">Add <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="second_panel" style="display:none">
                        <form action="{{ route('file-import2') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                            @csrf
                            <label class="row"><a href="{{ route('download_template') }}" style="font-family:'Times New Roman', Times, serif">Download </a> &nbsp;<p style="font-family:'Times New Roman', Times, serif"> and fill the template then upload it below.
                                    (Please leave the column headers intact)</p></label>
                            <div class="form-group">
                                <input class="form-control" type="file" name="profile" id="profile" onchange="submitFileImport(this);" />
                            </div>
                            <p style="font-family:'Times New Roman', Times, serif">Please ensure the Date of Birth and Date of Admission are in the format<code>DD/MM/YYYY</code></p>
                            <button type="button" class="btn btn-success" style="float: right; color: white;font-family:'Times New Roman', Times, serif">Upload</button>
                        </form>
                    </div>

                </form>
            </div>
            <div class="tab-pane fade" id="update-profiles">
                <form action="{{ route('file-import2') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                    @csrf
                    <label class="row"><a href="{{ route('download_template') }}" style="font-family:'Times New Roman', Times, serif">Download </a> &nbsp;<p style="font-family:'Times New Roman', Times, serif"> and fill the template then upload it below.
                            (Please leave the column headers intact)</p></label>
                    <div class="form-group">
                        <input class="form-control" type="file" name="profile" id="profile" onchange="submitFileImport(this);" />
                    </div>
                    <p style="font-family:'Times New Roman', Times, serif">Please ensure the Date of Birth and Date of Admission are in the format<code>DD/MM/YYYY</code></p>
                    <button type="button" class="btn btn-success" style="float: right; color: white;font-family:'Times New Roman', Times, serif">Upload</button>
                </form>
            </div>
            <div class="tab-pane fade" id="update-photos">
                <form action="{{ url('save-multiple-files') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="" class="row">
                            <p>Click the button below and select the images (Each file should be named after the respective student's admission number, index number or UPI number)</p>
                        </label>
                        <select required data-placeholder="Assign" class="form-control" name="photo_name_after" id="photo_name_after">
                            <option value="">Select an option</option>
                            <option value="admission_number">Images named after Admission Numbers</option>
                            <option value="index_number">Images named after Index Numbers</option>
                        </select>
                    </div>
                    <label for="profile-photos" class="btn btn-info">Select Images</label>
                    <input type="file" name="files[]" id="profile-photos" style="display: none;" multiple onchange="multiPhotoPrepaired();">
                    <div id="prepaired_files_show_pane"></div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary hide" id="submit-profile-photo">Submit</button>
                    </div>
                </form>

            </div>
            <div class="tab-pane fade" id="move-students">
                <form class="ajax-move-student" action="{{ route('move-students') }}" method="post">
                    @csrf
                    <div class="origin_class_pane">
                        <h6>Move Students</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="origin-form">Form</label>
                                    <select required data-placeholder="Choose" class="form-control" id="origin-form" name="origin-form">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="origin-form">Stream</label>
                                    <select required data-placeholder="Choose" class="form-control" id="origin-stream" name="origin-stream">
                                        <option value="">Select Stream</option>
                                        @foreach ($form1->my_classes as $val)
                                        <option value="{{$val->stream}}">{{$val->stream}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="students-list hide"></div>
                    <div class="approve-students-list hide">
                        <div class="row justify-content-between">
                            <h5 class="ml-2">Students Awaiting Approval</h5>
                            <button type="button" class="btn btn-info buttons3" style="float: right;" onclick="hidePending();">Back</button>
                        </div>
                    </div>
                    <div class="pending-students-list hide"></div>
                    <div class="destination_class_pane hide">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destination-form">Destination Form</label>
                                    <select required data-placeholder="Choose" class="form-control" id="destination-form" name="destination-form">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destination-stream">Destination Stream</label>
                                    <select required data-placeholder="Choose" class="form-control" id="destination-stream" name="destination-stream">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary hide" id="move-submit-btn" style="float: right;">Submit</button>
                </form>
            </div>
            <div class="tab-pane fade" id="upload-fee-statements">

                <h6>Upload Fee Balances/Statements</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="term">Term</label>
                            <select required data-placeholder="Choose" class="form-control" id="term" name="term">
                                <option value="">Select Term</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="year">Year</label>
                            <select required data-placeholder="Choose" class="form-control" id="year" name="year">
                                <option value="">Select Year</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Fee Summary As At</label>
                            <input type="datetime" id="fee-summary-as-at" name="fee-summary-as-at" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fee Options</label>
                            <div class="d-flex">
                                <input type="radio" class="form-control mr-2" name="current-fee" id="current-fee" style="width: 20px; height: 20px;" />
                                <label for="current-fee">Current fee balances</label>
                                <input type="radio" class="form-control ml-5 mr-2" name="upcoming-fee" id="upcoming-fee" style="width: 20px; height: 20px;" />
                                <label for="upcoming-fee">Upcoming term's fee statements</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Send Fee Summary Via SMS/Email</label>
                            <div class="d-flex">
                                <input type="checkbox" class="form-control" id="send-fees" name="send-fees" style="width: 20px; height: 20px;">
                                <label for="send-fees" class="ml-2">Send Fees</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="optional-message">Optional Message</label>
                        <textarea class="form-control" id="optional-message" name="optional-message"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label><a href="#">Download</a> &nbsp; and fill the fees template then upload it below. (Please leave the other column headers intact.) </label>
                        <div class="form-control">
                            <input type="file" id="" name="" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" style="color: white;">Submit</button>
            </div>
            <div class="tab-pane fade" id="student-residences">
                <div class="residences-list">

                    <table class="table residence_table @if(count($residence) == 0) hide @endif ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody class="table-residences-list">
                            <?php $len = count($residence) ?>
                            @foreach($residence as $key => $val)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$val->name}}</td>
                                <td>
                                    <a class="btn" title="Edit" onclick="editRow('{{$val->id}}' ,this)">
                                        <img src="/global_assets/images/icon/edit.png" width="20" height="20" />
                                    </a>
                                </td>
                                <td>
                                    <a class="btn" title="Delete" onclick="deleteRow('{{$val->id}}' ,this)">
                                        <img src="/global_assets/images/icon/delete.png" width="20" height="20" />
                                    </a>
                                    @if($len == ($key + 1))
                                    <a class="btn" title="Add" onclick="editingResidences();">
                                        <p class="plus">+</p>
                                    </a>
                                    @endif
                                </td>
                                <td style="display: none;">{{$val->id}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row justify-content-between residences-empty @if (count($residence) != 0) hide @endif ">
                        <h4>No Student residences found</h4>
                        <button type="button" class="btn btn-primary" onclick="editingResidences();">Add Residence </button>
                    </div>

                </div>
                <div class="residences-editing hide">
                    <form class="ajax-create-residences" action="{{ route('create-residences') }}" method="post">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-residences-editing">

                            </tbody>
                        </table>
                        <div class="row justify-content-between">
                            <button type="button" class="btn btn-info" onclick="showResidences();">Cancel</button>
                            <button type="submit" class="btn btn-success">Save New Residences</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@include('partials.js.student_js')

@endsection