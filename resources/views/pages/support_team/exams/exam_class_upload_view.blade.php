@extends('layouts.master')
@section('page_title', 'Manage Exams')
@section('content')
<style>
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
        margin-top: 90px;
        text-align: left;
        margin-left: 10px;
        margin-right: 10px;
    }

    #ajax-alert {
        display: none;
    }

    table,
    th,
    td {
        border: 1px solid;
        padding: 0.2rem 1.25rem !important
    }
</style>
<ul class="nav nav-tabs nav-tabs-highlight cardpos" style="margin-top:50px">
    @if ($types=="student" || $types=="teacher" || $types=="staff")
    <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icofont-home"></i> My Classes</a></li>
    @else
    <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link active" data-toggle="tab" onclick="selectExam()"><i class="icofont-home"></i> My Classes</a></li>
    <li><a href="#all_exams_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab" onclick="getInitExam()"><i class="icofont-gears"></i> Manage Exams</a></li>
    <li><a href="#new_exam_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Create Exam</a></li>
    <li><a href="#grading_systems_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Grading Systems</a></li>
    <li><a href="#subject_paper_ratios" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icofont-network"></i> Subject Paper Ratios</a></li>
    <li><a href="#student-residences" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icofont-trash"></i> Deleted Exams</a></li>
    @endif
</ul>
<div class="card" style="background-color:whitesmoke;padding:20px 20px;margin:0px">
    <div class="row">
        <div class="col-12">
            <p style=" font-family: 'Times New Roman', Times, serif;font-size:22px">Edit Results - Form -{{ $class_subject->my_class->form->name }} {{ $class_subject->my_class->stream }} - {{ $class_subject->subject->title  }}</p>
        </div>
    </div>
    <div class="card-body" style="background-color: white;">
        <div class="row">
            <div class="col-6">
                <label for="exam_class_upload_exam" style=" font-family: 'Times New Roman', Times, serif;font-size:20px">Exam</label>
                <input type="text" name="exam_class_upload_exam" style=" font-family: 'Times New Roman', Times, serif;font-size:18px" class="form-control" id="exam_class_upload_exam" placeholder="{{ $exam->name }}" disabled>
            </div>

            <div class="col-6">
                <label for="exam_class_upload_max" style=" font-family: 'Times New Roman', Times, serif;font-size:20px">Maximum Marks*</label>
                <div class="input-group">
                    <input type="number" style=" font-family: 'Times New Roman', Times, serif;font-size:18px" name="exam_class_upload_max" class="form-control" id="exam_class_upload_max" value="{{$max_mark}}" disabled>
                   @if($marks[0]->is_upload==1)
                   <button id="update_mark" style=" font-family: 'Times New Roman', Times, serif;font-size:16px" class="input-group-text bg-secondary"  style="cursor: pointer">
                        Edit
                    </button>
                   @else
                   <button id="update_mark" style=" font-family: 'Times New Roman', Times, serif;font-size:16px" class="input-group-text bg-secondary" onclick="updateMaxMark(event)" style="cursor: pointer">
                        Edit
                    </button>
                   @endif
                    <button id="cancel_mark" style=" font-family: 'Times New Roman', Times, serif;font-size:16px" class="input-group-text active-state bg-secondary" onclick="cancelMaxMark(event)" style="cursor: pointer">
                        Cancel
                    </button>
                    <button id="save_mark" style=" font-family: 'Times New Roman', Times, serif;font-size:16px" class="input-group-text active-state bg-success" onclick="saveMaxMark(event,  {{ $exam_id}})" style="cursor: pointer">
                        Save
                    </button>
                </div>
            </div>
        </div>
        <br>
        <input type="text" id="formteacherID" value="{{ $class_subject->my_class->form->teacher_id }}" class="d-none">
        <input type="text" id="class_exam_count" value="{{ count($class_subject->my_class->students) }}" class="d-none">
        <input type="text" id="subjectID" value="{{ $subject_id }}" class="d-none">
        <input type="text" id="examID" value="{{ $exam_id }}" class="d-none">
        <input type="text" id="classID" value="{{ $class_subject->my_class_id }}" class="d-none">
        <input type="text" id="teacherID" value="{{ $teacher_id }}" class="d-none">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:5%;font-family: 'Times New Roman', Times, serif;font-size:20px">#</th>
                        <th style="width:15%;font-family: 'Times New Roman', Times, serif;font-size:20px">Admission Number</th>
                        <th style="width:15%;font-family: 'Times New Roman', Times, serif;font-size:20px">Name</th>
                        <th style="width:20%;font-family: 'Times New Roman', Times, serif;font-size:20px">Score</th>
                        <th class="d-none">StudentID</th>
                        <th style="width:5%;font-family: 'Times New Roman', Times, serif;font-size:20px">%</th>
                        <th class="editCtrl"></th>
                        <th class="deleteCtrl active-state">
                            <input type="checkbox" name="chkes" id="chkes" onclick="selectAll()">
                        </th>
                    </tr>
                </thead>
                <tbody id="publish_tbody">
                    <?php $len = count($class_subject->my_class->students);
                    $num = 1; ?>
                    @for ($i = 0; $i < $len; $i++) @foreach ($marks as $mark) @if (($mark->student_id == $class_subject->my_class->students[$i]->id))
                        <tr style="line-height: 0.7">
                            <td style="font-family: 'Times New Roman', Times, serif;font-size:17px">{{ $num++ }}</td>
                            <td style="font-family: 'Times New Roman', Times, serif;font-size:17px">{{ $class_subject->my_class->students[$i]->adm_no }}</td>
                            <td style="font-family: 'Times New Roman', Times, serif;font-size:17px">{{ $class_subject->my_class->students[$i]->user->name }}</td>
                            <td style="font-family: 'Times New Roman', Times, serif;font-size:17px">
                                <span id="mark_dactive_pos{{ $i }}">{{ $mark->pos }}</span>
                                <div id="mark_active_pos{{ $i }}" class="input-group active-state">
                                    <input type="number" step="0.1" name="mark{{ $i }}" style="font-size:16px" class="form-control" id="mark{{ $i }}" value={{ $mark->pos }}>
                                    <span class="input-group-text" style="background-color: #43AB49;">
                                        <div class="dropdown">
                                            <i id="mark_gear{{ $i }}" data-toggle="dropdown" style="cursor: pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="color:white" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
                                                </svg></i>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" onclick="addX({{ $i }})">Grade X</a>
                                                <a class="dropdown-item" href="#" onclick="addY({{ $i }})">Grade Y</a>
                                            </div>
                                            <i id="mark_trash{{ $i }}" onclick="removeContent({{ $i }}, {{ $mark->pos }})" style="cursor: pointer;display:none">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="color:white" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                            </i>
                                        </div>
                                    </span>
                                </div>
                            </td>
                            <td class="d-none"><input type="text" id="student{{ $i }}" value="{{ $class_subject->my_class->students[$i]->id }}"></td>
                            <td style="font-family: 'Times New Roman', Times, serif;font-size:17px">{{ ceil(($mark->pos/$max_mark)*100) }}</td>
                            <td class="editCtrl">
                                @if($mark->is_upload==1)
                                <button id="update_mark{{ $i }}" style="font-family: 'Times New Roman', Times, serif;font-size:16px" class="btn btn-secondary" >Edit</button>
                                @else
                                <button id="update_mark{{ $i }}" style="font-family: 'Times New Roman', Times, serif;font-size:16px" class="btn btn-secondary" onclick="updateMark(event, {{ $i }})">Edit</button>
                                @endif
                                <button id="cancel_mark{{ $i }}" style="font-family: 'Times New Roman', Times, serif;font-size:16px" class="btn btn-secondary active-state" onclick="cancelMark(event, {{ $i }})">Cancel</button>
                                <button id="save_mark{{ $i }}" style="font-family: 'Times New Roman', Times, serif;font-size:16px" class="btn btn-primary active-state" onclick="saveMark(event, {{ $i }}, {{ $exam_id }},{{$class_subject->subject->id}}, {{ $class_subject->my_class->students[$i]->id }}, {{ $class_subject->my_class_id }})">Save</button>
                            </td>
                            <td class="deleteCtrl active-state">
                                <input type="checkbox" class="chk_boxes1" name="chk{{ $i }}" id="chk{{ $i }}" value="{{ $mark->id }}">
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endfor
                </tbody>
            </table>

        </div>
        <br>
        <div class="row active-state" id="tableForNew">
            <h3>New Results</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:20%">Admission Number</th>
                        <th>Name</th>
                        <th style="width:20%">Score</th>
                        <th style="width:20%"></th>
                    </tr>
                </thead>
                <tbody id="tbodyRow">
                </tbody>
            </table>
        </div>
        <div class="row align-items-center ml-1">
            <div class="col-12 text-left pt-2">
                <div class="dropdown" id="actionForResults">
                    <button class="btn btn-primary" style="font-family: 'Times New Roman', Times, serif;font-size:16px" data-toggle="dropdown">
                        Action
                    </button>
                    @if($is_upload!=1)
                    <button class="btn btn-primary" style="font-family: 'Times New Roman', Times, serif;font-size:16px;float:right" onclick="edit_on_view()" >
                        publish
                    </button>
                    @endif
                    <ul class="dropdown-menu" style="z-index:1100;border-radius:5px;">
                        <li><a href="#" class="dropdown-item" onclick="addMarkItem(event)">Add Results</a></li>
                        <li><button class="dropdown-item" onclick="download(event)">Download Results</button></li>
                        <li><button class="dropdown-item" onclick="showCheckbox(event)">Delete results</button></li>
                    </ul>
                </div>
                <button class="btn btn-primary active-state" id="addForResults" onclick="addMarkItem(event)">Add Results</button>
                <button class="btn btn-success active-state" id="cancelForResults" onclick="cancelMarkItem(event)">Cancel Delete</button>
            </div>
            <div class="col-12 text-right pt-2">
                <button type="button" class="btn btn-success active-state" id="new_save" onclick="newSave(event);">Save new results</button>
                <button type="button" class="btn btn-danger active-state" id="delete_save" onclick="deleteSave(event);">Delete Selected</button>
            </div>
        </div>

    </div>
</div>
<script>
    function selectAll() {
        if ($('.chk_boxes1:checked').length == $('.chk_boxes1').length) {
            $('.chk_boxes1').prop('checked', false);
        } else {
            $('.chk_boxes1').prop('checked', true);
        }
    }
</script>
@include('partials.js.exam_js')
@endsection