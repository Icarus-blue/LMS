@extends('layouts.master')
@section('page_title', 'Manage Exams')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<style>
    ul {
        list-style-type: none;
    }
    .swal2-confirm {
        color:black
    }
    .modify_table {
        font-size: 14px
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

    .card {
        margin-top: 20px;
        overflow: hidden;
    }

    thead th {
        font-size: 18px;
        padding: 1px !important;
        height: 26px;
    }

    #grade-tbody>tr>td {
        font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 1rem;
        font-style: normal;
        font-weight: 400;
        line-height: 1;
        padding: 0.1rem 0.5rem !important;
        vertical-align: 0%;
    }

    ul {
        list-style-type: none;
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
        width: 200;
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

    /* .table td{
        padding:0.3rem;
        vertical-align:middle;
    } */
</style>
<div class="card" style="text-align: left; background-color:whitesmoke;font-family:'Times New Roman', Times, serif">
    <ul class="nav nav-tabs nav-tabs-highlight cardpos">
        @if ($types=="student" || $types=="teacher" || $types=="staff")
        <li class="nav-item"><a href="#my_classes_pane" class="nav-link" data-toggle="tab" onclick="selectExam()"><i class="icofont-home"></i> My Classes</a></li>
        @else
        <li class="nav-item"><a href="#my_classes_pane" class="nav-link active" data-toggle="tab" onclick="selectExam()"><i class="icofont-home"></i> My Classes</a></li>
        <li class="nav-item"><a href="#all_exams_pane" class="nav-link" data-toggle="tab" onclick="getInitExam()"><i class="icofont-gears"></i> Manage Exams</a></li>
        <li class="nav-item"><a href="#new_exam_pane" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Create Exam</a></li>
        <li class="nav-item"><a href="#grading_systems_pane" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Grading Systems</a></li>
        <li class="nav-item"><a href="#subject_paper_ratios" class="nav-link" data-toggle="tab"><i class="icofont-network"></i> Subject Paper Ratios</a></li>
        <li class="nav-item"><a href="#student-residences" class="nav-link" data-toggle="tab"><i class="icofont-trash"></i> Deleted Exams</a></li>
        @endif

        {{-- <li class="nav-item dropdown">

                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">More</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#student-residences" class="dropdown-item" data-toggle="tab">Deleted Exams</a>
                    </div>
                </li> --}}
    </ul>
    <div class="card-body m-4 mt-5" style="background-color:white">
        <div class="row">
            <div class="col-6">
                <h4 style="font-weight:700">Grading Systems</h4>
            </div>
            <div class="col-6 text-right" style="display: flex; justify-content: flex-end;">
                <a href="/exams" class=" p-2 d-flex flex-row" style="background-color:#234173;color:white;font-size:13px ;border-radius:5px;align-items: center;"><i _ngcontent-esy-c161=""><svg _ngcontent-esy-c161="" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="bi bi-arrow-left-short">
                            <path _ngcontent-esy-c161="" fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                        </svg></i> <span>Close</span></a>
            </div>

        </div>
        <hr>
        <div>
            {{-- @csrf action="{{ route('exams.grade_store') }}" method="post"--}}
            <div class="row">
                <div class="col-12" style="margin-bottom: 0;">
                    <p id="exam_add_title" style="margin-bottom: 0;font-size:15px">Grading System Name</p>
                </div>
                <div class="col-12">
                    <input type="text" class="form-control" id="exam-grading-name" placeholder="Name" onblur="validateName();" onchange="validateName();">
                    <span id="exam-grade-name-error" class="text-danger"></span>
                </div>
            </div>
            <br>
            <p style="font-size:12px;margin-bottom:0">Grading Grid (Start with the lowest)</p>
            <table class="table table-bordered">
                <thead>
                    <tr style="font-size:13px">
                        <th class="d-none">ID</th>
                        <th style="width:50px">#</th>
                        <th>Low</th>
                        <th>High</th>
                        <th>Grade</th>
                        <th>Points</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="grade-tbody">
                    <span class="d-none">{{ $k=0 }}</span>
                    @foreach ($grades as $grade)
                    @if($k%2==0)
                    <tr class="exam-row{{ ++$k }}" style="background-color:whitesmoke">
                        @else
                    <tr class="exam-row{{ ++$k }}" style="background-color:white">
                        @endif
                        <td class="d-none exam-grade{{ $k }}">{{ $grade->id }}</td>
                        <td style="font-family:'Times New Roman', Times, serif">{{ $k }}</td>
                        <td><input type="number" style="height:30px" class="form-control" oninput="validateMin({{ $k }}, event)" id="exam-grade-table-low{{ $k }}">
                            <div id="exam-grade-table-low-error{{ $k }}" class="text-danger d-none"></div>
                        </td>
                        <td><input type="number" style="height:30px" class="form-control" oninput="validateMax({{ $k }}, event)" id="exam-grade-table-high{{ $k }}">
                            <div id="exam-grade-table-high-error{{ $k }}" class="text-danger d-none"></div>
                        </td>
                        <td><input type="text" style="height:30px" id="exam-grade-table-name{{ $k }}" class="form-control exam-grade-table-name{{ $k }}" oninput="validateGrade({{ $k }}, event)">
                            <div id="exam-grade-table-name-error{{ $k }}" class="text-danger d-none"></div>
                        </td>
                        <td><input type="number" style="height:30px" id="exam-grade-table-mark{{ $k }}" class="form-control exam-grade-table-mark{{ $k }}" oninput="validateMark({{ $k }}, event)">
                            <div id="exam-grade-table-mark-error{{ $k }}" class="text-danger d-none"></div>
                        </td>
                        <td>
                            <div class="row text-center">
                                <div class="col-6 border-right">
                                    <button class="btn" style="background-color:#A1AFC0;color:white;font-family:'Times New Roman', Times, serif" onclick="gradeAdd({{ $k }}, {{ $grades_max }})"><span style="margin-left:5px;margin-right:10px">+</span> Add</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-danger" style="background-color:#FF562F;font-family:'Times New Roman', Times, serif" onclick="gradeRemove({{ $k }})"><i style="float:left;margin-right:5px;padding-top:3px"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg></i>Remove</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <span style="font-size:13px;font-style:italic">Add marks upto 100</span>
            <div class="row align-items-center">
                <div class="col-6 text-left pt-2">
                    <span class="show-container" style="cursor: pointer;font-size:15px;font-weight:bold">Show Sample
                    </span>
                    <i class="icofont-arrow-down"></i>
                    <i class="icofont-arrow-up active-state"></i>
                </div>
                <div class="col-6 text-right pt-2 pr-3">
                    <button id="save_grading_system_btn"  class="btn btn-info save-container" disabled>Save Grading System</button>
                </div>
            </div>
            <br>
            <div class="active-state sample-container table-responsive-sm">
                <table class="table table-bordered table-striped modify_table">
                    <thead>
                        <tr>
                            <!-- <th class="d-none">#<th> -->
                            <th style="font-size:17px">Low</th>
                            <th style="font-size:17px">High</th>
                            <th style="font-size:17px">Grade</th>
                            <th style="font-size:17px">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <span class="d-none">{{ $k=0 }}</span>
                        @foreach ($grades as $grade)
                        <tr id="grade{{ $grade->id }}" style="height:15px">
                            <!-- <td>{{ ++$k }}</td> -->
                            <td class="exam-grade-low{{ $k }}" style="padding:5px; margin:5px;">{{ $grade->mark_from }}</td>
                            <td class="exam-grade-high{{ $k }}" style="padding:5px; margin:5px;">{{ $grade->mark_to }}</td>
                            <td class="exam-grade-name{{ $k }}" style="padding:0px; margin:0px;">{{ $grade->name }}</td>
                            <td class="exam-grade-mark{{ $k }}" style="padding:0px; margin:0px;">{{ $grade->remark }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12 text-right pt-2 pr-3">
                    <span class="sample d-none">{{ count($grades) }}</span>
                    <button class="btn auto-fill" style="background-color:#234173;color:white"><i style="float:left;margin-right:5px"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16">
                                <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z" />
                                <path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z" />
                            </svg></i>AutoFill With Sample</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {});
</script>
@include('partials.js.grade_js')
@endsection