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
    }

    .cardpos {
        position: fixed;
        width: 100%;
        z-index: 10;
    }



    .cardpos>li {
        width: 200px;
    }

    .cardpos>li>a {
        text-align: center;
        padding: 5px 10px;
    }
</style>
<div class="card" style="background-color:whitesmoke; font-family: 'Times New Roman', Times, serif;">
    <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-22px);">
        @if ($types=="student" || $types=="teacher" || $types=="staff")
        <li><a href="#my_classes_pane" class="nav-link" data-toggle="tab" onclick="selectExam()"><i class="icofont-home"></i> My Classes</a></li>
        @else
        <li><a href="#my_classes_pane" class="nav-link active" data-toggle="tab" onclick="selectExam()"><i class="icofont-home"></i> My Classes</a></li>
        <li><a href="#all_exams_pane" class="nav-link" data-toggle="tab" onclick="getInitExam()"><i class="icofont-gears"></i> Manage Exams</a></li>
        <li><a href="#new_exam_pane" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Create Exam</a></li>
        <li><a href="#grading_systems_pane" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Grading Systems</a></li>
        <li><a href="#subject_paper_ratios" class="nav-link" data-toggle="tab"><i class="icofont-network"></i> Subject Paper Ratios</a></li>
        <li><a href="#student-residences" class="nav-link" data-toggle="tab"><i class="icofont-trash"></i> Deleted Exams</a></li>
        @endif
    </ul>
    <h4 style="text-align:left;margin-left:30px;margin-top:30px;font-size:20px">Publish Results form 1</h4>
    <div class="card-body" style="background-color: white; margin:0px 30px;border-radius:10px;padding:30px">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="exam_manage_term" style="float:left;font-size:20px">Exam</label>
                    <!-- <select class="select form-control" id="exam_manage_term" style="line-height:3  " name="exam_manage_term" data-fouc data-placeholder="Select Term...">
                        <option value="">Select ...</option>
                        <option value="1">Form {{$forms->id}} - Term {{$exams->term}} ({{$exams->year}})</option>
                        <option value="2"></option>
                    </select> -->
                    <input class="form-control" style="padding:5px;font-size:15px" value={{$exams->name}} disabled>
                </div>
            </div>

            <div class="col-12" style="margin-top:50px">
                <h4 style="text-align:left">Status of class results</h4>
                <table class="table table-striped table-bordered">
                    <thead style="padding:0px">
                        <tr>
                            <th style="padding:5px;width:60%">Class</th>
                            <th colspan="2" style="padding:0px;width:40%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($forms['my_classes'] as $key => $val)
                        <tr style="padding:0px">
                            <td style="padding:0px;padding-left:20px;">Form {{$forms->id}} {{$val->stream}}</td>
                            <td align="center" style="padding:0px ">
                                @if($check_arr[$key]==1)
                                <i class="icofont-check" style="color: #0cef0c; font-size: 25px;"></i>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" style="color:red;" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                </svg>
                                @endif
                            </td>
                            <td style="padding:0px;text-align:center">
                                <a href="./../../../exam_stream_view/{{$val->teacher_id}}/{{$val->id}}/{{$exams->id}}" class="btn btn-secondary" style="color:black">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="col-12" style="margin-top:50px">
                <h4 style="float:left;display:block">Ranking Criteria</h4><br>
                <div class="row" style="margin-top:30px">

                    <div class="col-md-2">
                        <div class="d-flex">
                            <input type="radio" name="exam_manage_raking" id="rank_mean_marks" class="form-control" checked value="1" style="width: 20px; height: 20px;">
                            <label class="ml-2" for="rank_mean_marks">Rank by Mean marks</label>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex">
                            <input type="radio" name="exam_manage_raking" id="rank_kcpe" class="form-control" value="2" style="width: 20px; height: 20px;">
                            <label class="ml-2" for="rank_kcpe">Rank by KCPE points</label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex">
                            <input type="radio" name="exam_manage_raking" id="rank_mean_points" class="form-control" value="3" style="width: 20px; height: 20px;">
                            <label class="ml-2" for="rank_mean_points">Rank by Mean points </label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-12" style="margin-top:50px">
                <div class="form-group">
                    <label for="exam_manage_mini_subjects" style="float:left;font-size:18px">Minimum number of subjects that can be taken</label>
                    <input type="number" name="exam_manage_mini_subjects" style="padding:5px;font-size:15px" id="exam_manage_mini_subjects" class="form-control" value={{$exam[0]->min_subject_cnt}}>

                </div>

                <div class="form-group">
                    <label for="exam_manage_mini_subjects" style="float:left;font-size:18px">Overall grading system</label>
                    <select name="exam_manage_grading" class="form-control select" id="overal_grading_sys" data-fouc data-placeholder="Select Grading System">
                        @foreach($grades as $grade) <option value="{{$grade->id}}">{{$grade->name}}</option> @endforeach
                    </select>

                </div>
            </div>

            <div class="col-12" style="margin-top:50px">
                <p style="float:left;font-size:18px">Subject Grading System</p>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="padding:5px">Subject</th>
                            <th style="padding:5px">Grading System</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" value={{$forms->id}} id="form_id">
                        <input type="hidden" value={{$exam_id}} id="exam_id">
                        @foreach(array_unique($subjects_for_Form) as $key=>$sub)
                        @if($key%2==0)
                        <tr>
                            <td style="padding:5px"><input type="hidden" class="subject_title_id" value={{$subjects_for_Form[$key+1]}}>{{$sub}}</td>
                            <td class="p-0" style="padding:5px">
                                <div class="col-12">
                                    <select name="exam_manage_grading" class="form-control select grading_system_id" id="exam_manage_grading" data-fouc data-placeholder="Select Grading System">
                                        @foreach($grades as $grade) <option value="{{$grade->id}}">{{$grade->name}}</option> @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="col-12 " style="margin-top: 30px;">
                <div class="col-6 " style="float:left">
                    <div class="row">
                        <a href="/exams" class="btn btn-primary mr-1">Back</a>
                        <div class="dropup ml-1">
                            <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">Action
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" style="display: block; padding: 10px; text-align: center;">Download Results</a></li>
                                <li><a href="#" style="display: block; padding: 10px; text-align: center;">Send Reminders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="exam_id" value={{$exams->id}}>
                <input type="hidden" id="form_id" value={{$forms->id}}>
                <div class="col-6" style="float:right">
                    <button onclick="publishResults();" style="float:right" id="publish_result" class="btn btn-info">Publish Results</button>
                </div>
            </div>
        </div>

    </div>
</div>
@include('partials.js.exam_publish_js')
@endsection