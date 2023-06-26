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
        overflow: hidden;
        text-align: left !important;
        box-shadow: none !important;
    }

    input,
    .select2-selection {
        background-color: #f1fcf1 !important;
        height: 35px;
        font-size: 15px;
    }
</style>
<div class="card" style="background: whitesmoke;border:none;margin-top:50px">
    <div div class="card" style="background: whitesmoke;margin-top:0px">
        <ul class="nav nav-tabs nav-tabs-highlight cardpos">
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
        <div class="row">
            <div class="col-12 pl-4" style="margin-left:20px">
                <p style="font-family: 'Times New Roman', Times, serif;font-size:20px"> Upload Results - Form -{{ $class_subject->my_class->form->name }} {{ $class_subject->my_class->stream }} - {{ $class_subject->subject->title  }}</p>
            </div>
            <div class="col-12 " style="padding:0px 40px">

                    <div class="card p-3" style="background: white;margin-top:0 !important">
                        <div class="row">
                            <div class="col-12" style="padding:0px 20px">
                                <p style="font-family: 'Times New Roman', Times, serif;font-size:18px">Upload Type</p>
                                <div class="d-flex" style="float:left;margin-right:100px">
                                    <input type="radio" name="exam_class_upload_type" id="exam_class_upload_key" class="form-control" checked value="1" style="width: 20px; height: 20px;">
                                    <label class="ml-2" for="exam_class_upload_key" style="font-family: 'Times New Roman', Times, serif;font-size:17px">Key in marks</label>
                                </div>
                                <div class="d-flex">
                                    <input type="radio" name="exam_class_upload_type" id="exam_class_upload_mark" class="form-control" value="1" style="width: 20px; height: 20px;">
                                    <label class="ml-2" for="exam_class_upload_mark" style="font-family: 'Times New Roman', Times, serif;font-size:17px">Upload results from a spreadsheet</label>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-6">
                                <label for="exam_class_upload_exam" style="font-family: 'Times New Roman', Times, serif;font-size:18px">Exam </label>
                                <select class="select form-control" id="exam_class_upload_exam" name="exam_class_upload_exam">
                                    <option value=""></option>
                                    <option value="0">All</option>
                                    @foreach ($exams as $item)
                                    @if ($exam->name == $item->name)
                                    <option value={{ $item->id }} selected>{{ $item->name }}</option>
                                    @else
                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="exam_class_upload_max" style="font-family: 'Times New Roman', Times, serif;font-size:18px">Maximum Marks*</label>
                                <input type="number" name="exam_class_upload_max" class="form-control" id="exam_class_upload_max" style="font-family: 'Times New Roman', Times, serif;" placeholder="'out of' value e.g. 30">
                            </div>
                        </div>
                        <br>
                        <input type="text" id="class_exam_count" value="{{ count($class_subject->my_class->students) }}" class="d-none">
                        <input type="text" id="subjectID" value="{{ $subject_id }}" class="d-none">
                        <input type="text" id="MyClassID" value="{{ $class_subject->my_class_id  }}" class="d-none">
                        <input type="text" id="ExamID" value="{{ $exam_id }}" class="d-none">
                        <input type="text" id="TeacherID" value="{{ $teacher_id }}" class="d-none">
                        <div class="row" style="margin:0;">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:10%;font-family: 'Times New Roman', Times, serif;padding:5px 15px">Admission No</th>
                                        <th style="width:15%;font-family: 'Times New Roman', Times, serif;padding:5px 15px">Name</th>
                                        <th style="font-family: 'Times New Roman', Times, serif;padding:5px 15px">Marks</th>
                                        <th class="d-none">StudentID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $len = count($class_subject->my_class->students); ?>
                                    @for ($i = 0; $i < $len; $i++) <tr style="line-height:0.5">
                                        <td style="font-family: 'Times New Roman', Times, serif;padding:5px 15px">{{ $class_subject->my_class->students[$i]->adm_no }}</td>
                                        {{-- <td><input type="text" name="admno{{ $i }}" value="{{ $class_subject->my_class->students[$i]->adm_no }}" disabled/></td> --}}
                                        <td style="font-family: 'Times New Roman', Times, serif;padding:5px 15px">{{ $class_subject->my_class->students[$i]->user->name }}</td>
                                        <td style="padding:0 2px;">
                                            <div class="input-group m-1">
                                                <input type="number" style="border-radius: 5px;" class="form-control" step="0.1" id="mark{{ $i }}" name="mark{{ $i }}" onchange="validate({{ $i }}, this)">
                                                <span class="input-group-text" id="btn_gear_trash{{ $i }}" style="background: #43AB49;width:35px;margin-right:5px;">
                                                    <div class="dropdown">
                                                        <i id="mark_gear{{ $i }}" data-toggle="dropdown" style="cursor: pointer;color:white;margin-left:1px">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                                                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                                                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
                                                            </svg></i>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="#" onclick="addX({{ $i }})">Grade X</a>
                                                            <a class="dropdown-item" href="#" onclick="addY({{ $i }})">Grade Y</a>
                                                        </div>
                                                        <i  id="mark_trash{{ $i }}" onclick="removeContent({{ $i }})" style="cursor: pointer;display:none;margin:auto">
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
                                        </tr>
                                        @endfor
                                </tbody>
                            </table>

                        </div>
                        <div class="row align-items-center" style="margin-top:30px">
                            <div class="col-6 text-left pt-2">
                                <a href="/exams" class="btn btn-secondary" style="font-family: 'Times New Roman', Times, serif;padding:5px 15px;font-size:15px">Back</a>
                            </div>
                            <div class="col-6 text-right pt-2">
                                <button onclick="upload_result()" class="btn btn-primary" style="font-family: 'Times New Roman', Times, serif;padding:5px 15px;font-size:15px">Upload Subject Results</button>
                            </div>
                        </div>
                    </div>
            </div>

        </div>

    </div>
</div>
@include('partials.js.exam_js')
@endsection