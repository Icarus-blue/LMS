@extends('layouts.master')
@section('page_title', 'Manage Exams')
@section('content')

<style>
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 20px;
    border: 3px solid #f1f1f1;
}


ul {
    list-style-type: none;
}

.un_publish_result {
    background-color: white;
    color: #CBAB89;
    border: 1px solid #CBAB89;
    border-radius: 8px;
    width: 140px;
    height: 50px;
    padding: 0px 15px;
    font-size: 16px;
    margin-bottom: 2px;
    display: flex;
    flex-direction: row;
}

.un_publish_result:hover {
    background-color: #ED7F02;
    color: white
}

.send_result {
    margin-top: 2px;
    margin-bottom: 2px;
    border-radius: 7px;
    margin-left: 0px;
    font-size: 16px;
    background: white;
    color: #0092D3;
    border: 1px solid #0092D3;
    width: 130px;
    display: flex;
    flex-direction: row;
}

.send_result:hover {
    background-color: #0092D3;
    color: white;
}

.delete_btn {
    border-radius: 7px;
    font-size: 14px;
    background: #ff562f;
    color: white;
    width: 140px;
    display: flex;
    flex-direction: row;
    padding: 2px 20px
}

.forms_sitting_exam {
    margin: 1rem;
    padding: 0;
}

.one-sitting {
    border-top: 1px solid #00000042;
    border-bottom: 1px solid #00000042;
}

.one-sitting.odd {
    background: rgb(227 225 225 / 50%);
}

.active-state {
    display: none;
}

.mouse_hover {
    background-color: #F2F2F2;
}

.mouse_hover:hover {
    background-color: #F0F9FD;
}

.card {
    margin-top: 50px;
    overflow: hidden;
    border: none;
    box-shadow: none;
}

.cardpos {
    position: fixed;
    width: 100%;
    z-index: 10;
}

.tabpos {
    margin-top: 60px;
}

.cardpos>li {
    width: 200px;
}

.cardpos>li>a {
    text-align: center;
    padding: 5px 10px;
}

.ratio {
    text-align: left;
}

.ratio>tbody>tr>td {
    font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 1rem;
    font-style: normal;
    font-weight: 400;
    line-height: 1.5;
    padding: 0.1rem 0.5rem !important;
}

#ajax-alert {
    display: none !important;
}

.exclaimation {
    background: url('global_assets/images/exclaimation.svg');
    background-repeat: no-repeat;
    background-position: right calc(.375em + .1875rem) center;
}

.exclaimation-sel {
    background: url('global_assets/images/exclaimation.svg');
    background-repeat: no-repeat;
    background-position: right 1.75rem center, center right 2.25rem;
}

input,
.select2-selection {
    background-color: #f1fcf1 !important;
    height: 35px;
    font-size: 15px;
}

#create-exam-btn {
    line-height: 1.35;
    font-size: 0.875rem;
    padding: 0.2rem 0.5rem;
    background-color: #2ea5de;
    border-color: #2ea5de;
    color: white;
}

#select2-exam_manage_academic-container {
    margin-top: 3px;
}

.table td {
    padding: 0 1.25rem !important;
}

#exam_class_select {
    font-family: 'Times New Roman', Times, serif;
    font-size: 2px
}

optgroup {
    font-size: 10px;
}
</style>

<body onload="selectExam()" style="background-color:whitesmoke; font-family: 'Times New Roman', Times, serif;">
    <div class="card" style="background: #F7FBEF;">
        <div class="card-body" style="padding:1.25rem 0 0 0 !important">
            <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-22px);">
                @if ($types=="student" || $types=="teacher" || $types=="staff")
                <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link"
                        data-toggle="tab"><i class="icofont-home"></i> My Classes</a></li>
                @else
                <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;"
                        class="nav-link active" data-toggle="tab" onclick="selectExam()"><i class="icofont-home"></i> My
                        Classes</a></li>
                <li><a href="#all_exams_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link"
                        data-toggle="tab" onclick="getInitExam()"><i class="icofont-gears"></i> Manage Exams</a></li>
                <li><a href="#new_exam_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link"
                        data-toggle="tab"><i class="icon-plus2"></i> Create Exam</a></li>
                <li><a href="#grading_systems_pane" style="font-family: 'Times New Roman', Times, serif;"
                        class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Grading Systems</a></li>
                <li><a href="#subject_paper_ratios" style="font-family: 'Times New Roman', Times, serif;"
                        class="nav-link" data-toggle="tab"><i class="icofont-network"></i> Subject Paper Ratios</a></li>
                <li><a href="#student-residences" style="font-family: 'Times New Roman', Times, serif;" class="nav-link"
                        data-toggle="tab"><i class="icofont-trash"></i> Deleted Exams</a></li>
                @endif
            </ul>
            <div class="tab-content tabpos" style="margin-top: 0px;">
                <div class="tab-pane fade  show active" id="my_classes_pane"
                    style="text-align: left;padding:2px;background:white;">
                    <div class="row" style="width:97%;margin:auto;margin-bottom:40px">
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label for="exam_class"
                                    style="font-family: 'Times New Roman', Times, serif;font-size:18px">Exam</label>
                                <select class="select form-control" id="exam_class_select" name="exam_class_select"
                                    style="font-family: 'Times New Roman', Times, serif;padding:0px;font-size:10px"
                                    onchange="selectExam();" data-fouc data-placeholder="Select ....">
                                    <option value=""></option>
                                    @for ($i = 1; $i < 4; $i++) <optgroup label="Term{{ $i }}" style="font-size:12px">
                                        @foreach ($exams as $exam)
                                        @if ($exam->term == $i)
                                        <option value={{ $exam->id }} @if ($exam->id == $last)
                                            selected
                                            @endif>{{ $exam->name }}</option>
                                        @endif
                                        @endforeach
                                        </optgroup>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        @if($hasmyownsubjectclass>0)
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="font-family: 'Times New Roman', Times, serif;font-size:18px">Subject
                                    Classes</label>
                                <table class="table table-bordered table-striped" style="text-align: left">
                                    <thead>
                                        <tr>
                                            <th
                                                style="width:3%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                #</th>
                                            <th
                                                style="width:30%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                Name</th>
                                            <th
                                                style="width: 30%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                Status</th>
                                            <th
                                                style="text-align:right;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                Action</th>
                                            <th class="d-none">ClassSubjectID</th>
                                            <th class="d-none">ExamID</th>
                                            <th class="d-none">TeacherID</th>
                                            <th class="d-none">SubjectID</th>
                                            {{-- af-subject --}}
                                        </tr>
                                    </thead>
                                    <tbody id="exam_class_tbody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @if($hasmyownclass>0)
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label
                                    style="font-family: 'Times New Roman', Times, serif;;font-size:18px">Streams</label>
                                <table class="table table-bordered table-stream">
                                    <thead class="text-center">
                                        <tr>
                                            <th
                                                style="width:3%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                #</th>
                                            <th
                                                style="width:30%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                Name</th>
                                            <th
                                                style="width: 30%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                Status</th>
                                            <th
                                                style="text-align:right;padding:6px;font-family: 'Times New Roman', Times, serif;">
                                                Action</th>
                                            <th class="d-none">ExamID</th>
                                            <th class="d-none">TeacherID</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam_class_tbody_stream">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @if($hasmyownform>0)
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="font-family: 'Times New Roman', Times, serif;font-size:18px">Classes
                                    Supervised</label>
                                <table class="table table-bordered table-stream">
                                    <thead class="text-center">
                                        <tr>
                                            <th
                                                style="width:3%;text-align:left;padding:8px;font-family: 'Times New Roman', Times, serif;">
                                                #</th>
                                            <th
                                                style="width:30%;text-align:left;padding:8px;font-family: 'Times New Roman', Times, serif;">
                                                Name</th>
                                            <th
                                                style="width: 30%;text-align:left;padding:8px;font-family: 'Times New Roman', Times, serif;">
                                                Status</th>
                                            <th
                                                style="text-align:right;padding:8px;font-family: 'Times New Roman', Times, serif;">
                                                Action</th>
                                            <th class="d-none">ExamID</th>
                                            <th class="d-none">TeacherID</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam_class_tbody_super">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="tab-pane fade" id="all_exams_pane" style="background-color:#F5F5F5">
                    <div class="row" style="padding: 15px;  border-radius: 20px;margin: 0; height: 150px;">
                        <div class="col-12 mt-1">
                            <div class="form-group">
                                <label for="exam_class"
                                    style="font-family: 'Times New Roman', Times, serif;font-size:15px; float: left;">Academic
                                    Year</label>
                                <select class="select form-control" id="exam_manage_academic"
                                    name="exam_manage_academic" data-fouc data-placeholder="Select Year...."
                                    onchange="selectYear();">
                                    <option value=""></option>
                                    <option value="1">All</option>
                                    <option value={{ date("Y"); }} selected>{{ date("Y"); }}</option>
                                    <option value{{ date("Y") -1 }}>{{ date("Y") -1 }}</option>
                                    <option value={{ date("Y") -2 }}>{{ date("Y") -2 }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="exam_index_body" style="padding: 15px;  border-radius: 20px; margin-top: 10px;">

                    </div>
                </div>

                <div class="tab-pane fade" id="new_exam_pane" style="background:whitesmoke">
                    <div class="exam_type_pane" style="text-align: left">
                        <div class="mb-3" style="padding:15px;background: white">
                            <h6 id="search_title" style="font-weight: 600;font-family:'Times New Roman', Times, serif">
                                Exam Type</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex">
                                                <input type="radio" name="exam_type" id="Ordinary_Exam"
                                                    class="form-control" checked value="Ordinary_Exam"
                                                    style="width: 20px; height: 20px;">
                                                <label class="ml-2" for="Ordinary_Exam"
                                                    style="font-family:'Times New Roman', Times, serif">Ordinary
                                                    Exam</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex">
                                                <input type="radio" name="exam_type" id="Consolidated_Exam"
                                                    class="form-control" value="Consolidated_Exam"
                                                    style="width: 20px; height: 20px;">
                                                <label class="ml-2" for="Consolidated_Exam"
                                                    style="font-family:'Times New Roman', Times, serif">Consolidated
                                                    Exam</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex">
                                                <input type="radio" name="exam_type" id="Year_Average"
                                                    class="form-control" value="Year_Average"
                                                    style="width: 20px; height: 20px;">
                                                <label class="ml-2" for="Year_Average"
                                                    style="font-family:'Times New Roman', Times, serif">Year
                                                    Average</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex">
                                                <input type="radio" name="exam_type" id="KCSE" class="form-control"
                                                    value="KCSE" style="width: 20px; height: 20px;">
                                                <label class="ml-2" for="KCSE"
                                                    style="font-family:'Times New Roman', Times, serif">KCSE</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3" style="padding:15px;background: white">
                            <div id="ordinary_body">
                                <form id="create_exam_form" method="post" action="{{ route('exams.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12 mt-2">
                                            <div class="form-group">
                                                <label for="exam_name"
                                                    style="font-family:'Times New Roman', Times, serif">Exam
                                                    Name</label>
                                                <input class="form-control"
                                                    style="font-family:'Times New Roman', Times, serif" type="text"
                                                    id="exam_name" name="exam_name" oninvalid="examNameInvalid(event)"
                                                    placeholder="Mid Term">
                                                <span style="color: red;font-size:13px;" id="exam_name_helper"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-1">
                                            <div class="form-group">
                                                <label for="exam_term"
                                                    style="font-family:'Times New Roman', Times, serif">Term</label>
                                                <select class="select form-control" id="exam_term" name="exam_term"
                                                    oninvalid="examTermInvalid(event)" data-fouc
                                                    data-placeholder="Select Term">
                                                    <option value="">Select Term</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                                <span style="color: red;font-size:13px;" id="exam_term_helper"></span>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-1">
                                            <div class="form-group">
                                                <label for="exam_year"
                                                    style="font-family:'Times New Roman', Times, serif">Year</label>
                                                <select class="select form-control" id="exam_year" name="exam_r"
                                                    data-fouc data-placeholder="Select Year">
                                                    <option value="">Select Year</option>
                                                    <option value={{ date("Y"); }} selected>{{ date("Y"); }}</option>
                                                    <option value{{ date("Y") -1 }}>{{ date("Y") -1 }}</option>
                                                    <option value={{ date("Y") -2 }}>{{ date("Y") -2 }}</option>
                                                    <option value={{ date("Y") -3 }}>{{ date("Y") -3 }}</option>
                                                    <option value={{ date("Y") -4 }}>{{ date("Y") -4 }}</option>
                                                </select>
                                                <span style="color: red;font-size:13px" id="exam_year_helper"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mt-0">
                                            <label for="exam_year"
                                                style="font-weight: bolder;font-family:'Times New Roman', Times, serif">Forms
                                                sitting for the exam</label>
                                            <ul class="forms_sitting_exam">
                                                @foreach ($forms as $key => $val)
                                                <li class="row one-sitting @if($key % 2 == 0) odd @endif">
                                                    <div class="col-md-3">
                                                        <div class="row">
                                                            <input type="checkbox" class="exam_form my-2 mx-3"
                                                                name="exam_forms"
                                                                onchange="checkState({{$val->id}}, this, event)"
                                                                id="min_subject_id{{$val->id}}"
                                                                style="width: 20px; height: 20px;">
                                                            <p class="my-1 mx-3"
                                                                style="font-family:'Times New Roman', Times, serif">Form
                                                                {{$val->name}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9" style="transform:translateX(20px)">
                                                        <div class="col-md-12">
                                                            <input class="exam_form" type="number" name="exam_forms"
                                                                placeholder="Minimum Subject that can be taken"
                                                                oninput="hideSubject({{ $val->id }}, event)"
                                                                id="min_subject_cnt{{$val->id}}" min="0"
                                                                style="font-family:'Times New Roman', Times, serif;margin-top:1px;width: 100%;font-size:1rem;line-height:1.5;border-radius:5px;border-color:#86a4c3;box-shadow:none;border:1px solid #ced4da; "
                                                                oninvalid="examSubject({{ $val->id }}, event);" />
                                                        </div>
                                                        {{-- <br> --}}
                                                        <div class="col-md-12">
                                                            <span style="color: red;font-size:13px"
                                                                id="min_subject_helper{{ $val->id }}"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="text-right mr-1">
                                        <button class="btn btn-primary"
                                            style="font-family:'Times New Roman', Times, serif" id="create-exam-btn"><i
                                                class="icofont-save mr-1" style="font-size: 0.7rem"></i>Create</button>
                                    </div>
                                </form>
                            </div>
                            <div id="consolidated_body" class="active-state">
                                <form method="GET" action="">
                                    <div class="row">
                                        <div class="col-12 mt-3">
                                            <div class="form-group">
                                                <label for="exam_name">Exam Name</label>
                                                <input class="form-control" type="text" id="exam_name" name="exam_name"
                                                    required placeholder="Mid Term">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 mt-3">
                                            <div class="form-group">
                                                <label for="exam_term">Term</label>
                                                <select class="select form-control" id="exam_term" name="exam_term"
                                                    required data-fouc data-placeholder="Select Term">
                                                    <option value="">Select Term</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="form-group">
                                                <label for="exam_year">Year</label>
                                                <select class="select form-control" id="exam_year" name="exam_year"
                                                    data-fouc data-placeholder="Select Year">
                                                    <option value="">Select Year</option>
                                                    <option value={{ date("Y"); }} selected>{{ date("Y"); }}</option>
                                                    <option value{{ date("Y") -1 }}>{{ date("Y") -1 }}</option>
                                                    <option value={{ date("Y") -2 }}>{{ date("Y") -2 }}</option>
                                                    <option value={{ date("Y") -3 }}>{{ date("Y") -3 }}</option>
                                                    <option value={{ date("Y") -4 }}>{{ date("Y") -4 }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary" id="consolidated-exam-btn"><i
                                                class="icon-search4 mr-2"></i> Specifify Classes</button>
                                    </div>
                                </form>
                            </div>
                            <div id="year_body" class="active-state">
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <div class="form-group">
                                            <label for="exam_form">Form</label>
                                            <select class="select form-control" id="exam_form" name="exam_form"
                                                data-fouc data-placeholder="Select Form">
                                                <option value="">Select Form</option>
                                                @foreach ($forms as $item)
                                                <option value={{ $item->id }}>{{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="ksce_body" class="active-state">
                                <div class="row">
                                    <div class="col-12 mt-3">
                                        <div class="form-group">
                                            <label for="ksce_form">Form</label>
                                            <select class="select form-control" id="ksce_form" name="ksce_form"
                                                data-fouc data-placeholder="Select Form">
                                                <option value="">Select Form</option>
                                                @foreach ($forms as $item)
                                                <option value={{ $item->id }}>{{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="grading_systems_pane" style="padding:15px;background:white">
                    <div class="row" style="text-align: left">
                        <div class="col-6">
                            <h4 style="font-weight: 700;font-family:'Times New Roman', Times, serif">Grading Systems
                            </h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="exam_grading/add" class="btn"
                                style="background: #2ea5de;color:white;border-radius:5px;font-family:'Times New Roman', Times, serif">Create
                                Grading System</a>
                        </div>
                        <hr width="100%">
                    </div>
                    <div class="row pl-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr style="line-height: 0.5rem">
                                    <th class="col-8 text-left" style="font-family:'Times New Roman', Times, serif">Name
                                    </th>
                                    <th class="col-4" style="font-family:'Times New Roman', Times, serif">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grades as $grade)
                                <tr style="line-height: 1rem" class="mouse_hover">
                                    <td class="col-9 text-left "
                                        style="height:40px;font-family:'Times New Roman', Times, serif">
                                        {{ $grade->name }}</td>
                                    <td class="col-3 py-1 ">
                                        <div class="row text-center ">
                                            <div class="col-6 border-right">
                                                <a href="{{ route('exam_grading_view', $grade->id) }}"
                                                    class="btn btn-secondary"
                                                    style="font-family:'Times New Roman', Times, serif;background: #B7C1D1;color:#172b4c;border-radius:5px;"><i
                                                        class="icon-eye-open" style="padding-right:5px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <path
                                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                            <path
                                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                        </svg></i> View</a>
                                            </div>
                                            <div class="col-6">
                                                <button onclick="deleteGrade({{ $grade->id }});" class="btn btn-danger"
                                                    style="font-family:'Times New Roman', Times, serif;background: #ff562f;color:white;border-radius:5px;"><i
                                                        class="icon-trach" style="padding-right:5px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                            <path fill-rule="evenodd"
                                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                        </svg></i> Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane fade" id="subject_paper_ratios" style="padding:15px 30px 0 30px;background:white">
                    <div class="row">
                        <h4 style="font-weight: 700;font-family:'Times New Roman', Times, serif">Subject Paper Ratios
                        </h4>
                    </div>

                    <div class="row">
                        <table class="table table-bordered ratio">
                            <thead style="font-weight: 400">
                                <tr>
                                    <th rowspan="2" class="active-state"
                                        style="font-family:'Times New Roman', Times, serif">#</th>
                                    <th rowspan="2" style="font-family:'Times New Roman', Times, serif">Subject</th>
                                    <th colspan="3" style="font-family:'Times New Roman', Times, serif">Paper Out Of
                                    </th>
                                    <th colspan="3" style="font-family:'Times New Roman', Times, serif">Paper
                                        Contribution percentage</th>
                                    <th rowspan="2" style="font-family:'Times New Roman', Times, serif">Action</th>
                                    <th rowspan="2" class="d-none">ID</th>
                                </tr>
                                <tr>
                                    <th style="font-family:'Times New Roman', Times, serif">Paper 1 (Out of X)</th>
                                    <th style="font-family:'Times New Roman', Times, serif">Paper 2 (Out of Y)</th>
                                    <th style="font-family:'Times New Roman', Times, serif">Paper 3 (Out of Z)</th>
                                    <th style="font-family:'Times New Roman', Times, serif">Paper 1 (%)</th>
                                    <th style="font-family:'Times New Roman', Times, serif">Paper 2 (%)</th>
                                    <th style="font-family:'Times New Roman', Times, serif">Paper 3 (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $len = count($subjects);
                                $i = 0; ?>
                                @for ($i = 0; $i < $len; $i++) <tr style="line-height:1.5">
                                    <td class="active-state" style="font-family:'Times New Roman', Times, serif">
                                        {{ $i + 1 }}</td>
                                    <td style="font-family:'Times New Roman', Times, serif">{{ $subjects[$i]->title }}
                                    </td>
                                    @if ($subjects[$i]->out_x>0 || $subjects[$i]->out_y>0 || $subjects[$i]->out_z>0 ||
                                    $subjects[$i]->con_x>0 || $subjects[$i]->con_y>0 || $subjects[$i]->con_z>0)
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="out_x" placeholder="{{ $subjects[$i]->out_x }}"
                                            disabled style="width: 100%;" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="out_y" placeholder="{{ $subjects[$i]->out_y }}"
                                            disabled style="width:100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="out_z" placeholder="{{ $subjects[$i]->out_z }}"
                                            disabled style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="con_x" placeholder="{{ $subjects[$i]->con_x }}"
                                            disabled style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="con_y" placeholder="{{ $subjects[$i]->con_y }}"
                                            disabled style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="con_z" placeholder="{{ $subjects[$i]->con_z }}"
                                            disabled style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <button class="btn btn-secondary px-4" disabled
                                                onclick="editSubjectRatio('{{ $subjects[$i]->id }}', this);">Edit</button>
                                        </div>
                                    </td>
                                    @else
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="out_x" placeholder="{{ $subjects[$i]->out_x }}"
                                            style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="out_y" placeholder="{{ $subjects[$i]->out_y }}"
                                            style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="out_z" placeholder="{{ $subjects[$i]->out_z }}"
                                            style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="con_x" placeholder="{{ $subjects[$i]->con_x }}"
                                            style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="con_y" placeholder="{{ $subjects[$i]->con_y }}"
                                            style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <input type="number" name="con_z" placeholder="{{ $subjects[$i]->con_z }}"
                                            style="width: 100%" min="0" max="100" />
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <button class="btn btn-secondary px-4"
                                                onclick="editSubjectRatio('{{ $subjects[$i]->id }}', this);">Edit</button>
                                        </div>
                                    </td>
                                    @endif

                                    <td class="d-none"> {{ $subjects[$i]->id }}</td>
                                    </tr>
                                    @endfor
                                    {{-- @foreach ($subjects as $subject)

                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade text-left" id="student-residences" style="padding:15px;background:white">
                    <div class="row border-bottom">
                        <div class="col-12">
                            <h3 style="font-weight: 600;font-family:'Times New Roman', Times, serif">Deleted Exam</h3>
                        </div>

                    </div>
                    <div class="row pl-3">
                        <table class="table table-bordered ratio">
                            <thead class="text-center">
                                <tr>
                                    <th rowspan="2" style="font-family:'Times New Roman', Times, serif">Name</th>
                                    <th rowspan="2" style="font-family:'Times New Roman', Times, serif">Academic Year
                                    </th>
                                    <th rowspan="2" style="font-family:'Times New Roman', Times, serif">Term</th>
                                    <th colspan="5" style="font-family:'Times New Roman', Times, serif">
                                        Offered in 2022
                                    </th>
                                </tr>
                                <tr>
                                    <th style="font-family:'Times New Roman', Times, serif">Class</th>
                                    <th style="font-family:'Times New Roman', Times, serif">Deleted by</th>
                                    <th style="font-family:'Times New Roman', Times, serif">Deletion Date</th>
                                    <th colspan="2" style="font-family:'Times New Roman', Times, serif">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deleteds as $deleted)
                                <tr>
                                    <td style="font-family:'Times New Roman', Times, serif">{{ $deleted->exam->name }}
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">{{ $deleted->exam->year }}
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">{{ $deleted->exam->term }}
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">Form
                                        {{ $deleted->form->name }}</td>
                                    <td style="font-family:'Times New Roman', Times, serif">{{ $user}}</td>
                                    <td style="font-family:'Times New Roman', Times, serif">{{ $deleted->updated_at }}
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <button class="btn btn-primary"
                                            onclick="recoverFinal({{ $deleted->exam_id }},{{ $deleted->form_id }}, this);">Recover</button>
                                    </td>
                                    <td style="font-family:'Times New Roman', Times, serif">
                                        <button class="btn btn-danger"
                                            onclick="deleteFinal({{ $deleted->exam_id }}, {{ $deleted->form_id }}, this);">
                                            <i class="icofont-trash"></i>Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row pl-3">
                        <table class="table table-bordered">
                            <thead class="bg-secondary">
                                <tr>
                                    <th style="font-family:'Times New Roman', Times, serif">KCSE Exam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-family:'Times New Roman', Times, serif">No KCPE exams found</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</body>



@include('partials.js.exam_js')

@endsection