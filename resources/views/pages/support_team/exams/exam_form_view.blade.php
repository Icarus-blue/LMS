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

<body onload="selectExam_Test()" style="background-color:whitesmoke; font-family: 'Times New Roman', Times, serif;">
    <div class="card" style="background: whitesmoke">
        <div class="card-body" style="padding:1.25rem 0 0 0 !important">
            <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-22px);">
                @if ($types=="student" || $types=="teacher" || $types=="staff")
                <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icofont-home"></i> My Classes</a></li>
                @else
                <li><a href="#my_classes_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link active" data-toggle="tab" onclick="selectExam_Test()"><i class="icofont-home"></i> My Classes</a></li>
                <li><a href="#all_exams_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab" onclick="getInitExam()"><i class="icofont-gears"></i> Manage Exams</a></li>
                <li><a href="#new_exam_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Create Exam</a></li>
                <li><a href="#grading_systems_pane" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icon-plus2"></i> Grading Systems</a></li>
                <li><a href="#subject_paper_ratios" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icofont-network"></i> Subject Paper Ratios</a></li>
                <li><a href="#student-residences" style="font-family: 'Times New Roman', Times, serif;" class="nav-link" data-toggle="tab"><i class="icofont-trash"></i> Deleted Exams</a></li>
                @endif
            </ul>
            <div class="tab-content tabpos" style="margin-top: 50px;">
                <div class="tab-pane fade  show active" id="my_classes_pane" style="text-align: left;padding:2px;background:white;margin-top:5px">
                    <p style="font-family: 'Times New Roman', Times, serif;font-size:18px;margin-left:20px;margin-bottom:0px;text-align:left">Publish Results-Form {{$form->name}} </p>
                    <div class="col-12 mt-3" style="margin:auto;padding-left:30px">
                        <div class="form-group">
                            <label for="exam_class" style="font-family: 'Times New Roman', Times, serif;font-size:18px">Exam</label>
                            <select class="select form-control" id="exam_class_select" name="exam_class_select" style="font-family: 'Times New Roman', Times, serif;padding:0px;font-size:10px" onchange="selectExam_Test()" data-fouc data-placeholder="Select ....">
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
                    <input type="hidden" id="form_id" value={{$form_id}}>
                    <div class="col-12 mt-3" style="margin:auto;padding-left:30px">
                        <label for="exam_class" style="font-family: 'Times New Roman', Times, serif;font-size:18px">Stream</label>
                        <table class="table table-bordered table-striped" style="text-align: left">
                            <thead>
                                <tr>
                                    <th style="width:20%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Class</th>
                                    <th style="width: 25%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Status</th>
                                    <th style="text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="exam_class_tbody">
                            </tbody>
                        </table>
                    </div>
                    <div class="row" style="width:97%;margin:auto;margin-bottom:40px">
                        <div class="col-12" style="margin-top:30px">
                            <a class="btn" href="#" style="font-size:16px;background-color:#b7c2D0;color:black;border-radius:6px;font-family:'Times New Roman', Times, serif">Back</a>
                            <a class="btn" href="#" style="font-size:16px;background-color:#45AB48;color:white;border-radius:6px;font-family:'Times New Roman', Times, serif">Download Results</a>
                            <a class="btn" onclick="publish_supervisor({{$form_id}})" style="float:right;font-size:16px;background-color:#45AB48;color:white;border-radius:6px;font-family:'Times New Roman', Times, serif">Publish results</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


@include('partials.js.exam_js_new')
@endsection