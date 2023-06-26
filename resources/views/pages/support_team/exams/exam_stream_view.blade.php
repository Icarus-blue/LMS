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

<body onload="selectExam()" style="background-color:whitesmoke; font-family: 'Times New Roman', Times, serif;">
    <div class="card" style="background: whitesmoke">
        <div class="card-body" style="padding:1.25rem 0 0 0 !important">
            <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-22px);">
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
            @if($types=="student" || $types=="teacher" || $types=="staff")
            <div class="tab-content tabpos" style="margin-top: 50px;">
                <p style="font-family: 'Times New Roman', Times, serif;font-size:18px;margin-left:20px;margin-bottom:0px;text-align:left">Exam Publishing-{{$myclass->stream}}</p>
                <div class="tab-pane fade  show active" id="my_classes_pane" style="text-align: left;padding:2px;background:white;margin-top:5px">
                    <div class="row" style="width:97%;margin:auto;margin-bottom:40px">
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="font-family: 'Times New Roman', Times, serif;font-size:18px">Exam Publishing-{{$myclass->stream}}</label>
                                <table class="table table-bordered table-striped" style="text-align: left">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Class</th>
                                            <th style="width: 8%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject</th>
                                            <th style="width: 20%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject Teacher</th>
                                            <th style="width:15%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Students Without Marks</th>
                                            <th style="width: 25%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Status</th>
                                            <th style="text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Action</th>
                                        </tr>
                                    </thead>
                                    <!-- <h4>myclass</h4>{{$myclass}}<br>
                                    <h4>teacher</h4>{{$myclass->teacher}}<br>
                                    <h4>class_subject</h4>{{count($myclass->class_subject)}}<br>
                                    <h4>students</h4>{{$myclass->students}}<br>
                                    <h4>form</h4>{{$myclass->class_subject[0]->subject}}<br> -->
                                    <tbody id="exam_class_tbody">
                                        @foreach($myclass->class_subject as $classsubject)
                                        <div style="display:none">{{$k=0, $p=0}}</div>
                                        @foreach($classsubject->subject->exam_record as $examrecord)
                                        @if($examrecord->exam_id == $exam_id && $examrecord->my_class_id == $myclass_id)
                                        @if($examrecord->pos==NULL)<div style="display:none">{{$k++;}}</div>
                                        @elseif($examrecord->pos!=NULL)<div style="display:none">{{$p++;}}</div>
                                        @else <h1>Erorr</h1>
                                        @endif
                                        @endif
                                        @endforeach
                                        @if($p>0)
                                        <tr>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">Form {{$myclass->form->name}} {{$myclass->stream}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->title}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->class_subject->teacher}}</td>
                                            @if($k==0)<td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">All the students have marks.</td>
                                            @else <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$k}}/{{count($myclass->students)}} Don't have marks.</td>
                                            @endif
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;"> <span style="color:red"> @if($examrecord->flag==1) Pending publishing by Class teacher
                                                    @elseif($examrecord->flag==2)Pending publishing by Class supervisor
                                                    @elseif($examrecord->flag==3)Pending publishing by Dean
                                                    @elseif($examrecord->flag==null) Uploaded but not published yet
                                                    @else Published
                                                    @endif
                                                </span> </td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;"><a href="/exam_class_upload/publish/{{$classsubject->id}}/{{$classsubject->subject->exam_record[0]->exam_id}}/{{$classsubject->teacher_id}}/{{$classsubject->subject_id}}" class="btn btn-secondary" style="color:white">view</a></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="font-family: 'Times New Roman', Times, serif;;font-size:18px">Subject without results</label>
                                <table class="table table-bordered table-stream">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width:10%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Class</th>
                                            <th style="width: 10%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject</th>
                                            <th style="width: 20%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject Teacher</th>
                                            <th style="width: 25%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Students</th>
                                            <th style="text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam_class_tbody_stream">
                                        @foreach($myclass->class_subject as $classsubject)
                                        <div style="display:none">{{$i=0}}</div>
                                        @foreach($exam_records as $exam_rec)
                                        @if( $exam_rec->af == $classsubject->subject_id)
                                        <div style="display:none"> {{$i++}}</div>
                                        @endif
                                        @endforeach
                                        @if($i==0)
                                        <tr>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">Form {{$myclass->form->name}} {{$myclass->stream}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->title}}</td>
                                            @if($classsubject->subject->class_subject->teacher_id == null)
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">Not assigned yet</td>
                                            @else
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->class_subject->teacher->user->name}}</td>
                                            @endif
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{count($myclass->students)}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;"><a class="btn" href="/exam_class/upload/{{$classsubject->id}}/{{$exam_id}}/{{$classsubject->teacher_id}}/{{$classsubject->subject_id}}" style="background-color:#bbc1d2;color:black">Upload Results</a></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12" style="margin-top:30px">
                            <a class="btn" href="#" style="font-size:16px;background-color:#b7c2D0;color:black;border-radius:6px;font-family: 'Times New Roman', Times, serif;">Back</a>
                            <a class="btn" href="#" style="font-size:16px;background-color:#45AB48;color:white;border-radius:6px;font-family: 'Times New Roman', Times, serif;">Download Results</a>
                            <a class="btn" onclick="stream_publish({{$exam_id}},{{$myclass_id}})" style="font-size:16px;background-color:#45AB48;color:white;border-radius:6px;font-family: 'Times New Roman', Times, serif;float:right">Publish results</a>

                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="tab-content tabpos" style="margin-top: 50px;">
                <p style="font-family: 'Times New Roman', Times, serif;font-size:18px;margin-left:20px;margin-bottom:0px;text-align:left">Exam Publishing-{{$myclass->stream}}</p>
                <div class="tab-pane fade  show active" id="my_classes_pane" style="text-align: left;padding:2px;background:white;margin-top:5px">
                    <div class="row" style="width:97%;margin:auto;margin-bottom:40px">
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="font-family: 'Times New Roman', Times, serif;font-size:18px">Exam Publishing-{{$myclass->stream}}</label>
                                <table class="table table-bordered table-striped" style="text-align: left">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Class</th>
                                            <th style="width: 8%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject</th>
                                            <th style="width: 20%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject Teacher</th>
                                            <th style="width:15%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Students Without Marks</th>
                                            <th style="width: 25%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Status</th>
                                            <th style="text-align:right;padding:6px;font-family: 'Times New Roman', Times, serif;" id="check_all"><p>Action</p></th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam_class_tbody">
                                        @foreach($myclass->class_subject as $classsubject)
                                        <div style="display:none">{{$k=0, $p=0}}</div>
                                        @foreach($classsubject->subject->exam_record as $examrecord)
                                        @if($examrecord->exam_id==$exam_id && $myclass_id==$examrecord->my_class_id)
                                        @if($examrecord->pos==NULL)<div style="display:none">{{$k++;}}</div>
                                        @elseif($examrecord->pos!=NULL)<div style="display:none">{{$p++;}}</div>
                                        @else <h1>Erorr</h1>
                                        @endif
                                        @endif
                                        @endforeach
                                        @if($p>0)
                                        <tr>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">Form {{$myclass->form->name}} {{$myclass->stream}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->title}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->class_subject->teacher->user->name}}</td>
                                            @if($k==0)<td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">All the students have marks.</td>
                                            @else <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$k}}/{{count($myclass->students)}} Don't have marks.</td>
                                            @endif
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;"><span style="color:red"> @if($examrecord->flag==1) Pending publishing by Class teacher
                                                    @elseif($examrecord->flag==2)Pending publishing by Class supervisor
                                                    @elseif($examrecord->flag==3)Pending publishing by Dean
                                                    @elseif($examrecord->flag==null) Uploaded but not published yet
                                                    @else Published
                                                    @endif
                                                </span> </td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;text-align:right;" id="class_subject_td{{$classsubject->subject_id}}" class="class_subject_td" data-id="{{$classsubject->subject_id}},{{$exam_id}},{{$myclass_id}},{{$classsubject->subject->class_subject->teacher->id}}">
                                                <a id="class_subject_view{{$classsubject->subject_id}}" href="/exam_class_upload/publish/{{$classsubject->id}}/{{$classsubject->subject->exam_record[0]->exam_id}}/{{$classsubject->teacher_id}}/{{$classsubject->subject_id}}"
                                                    class="btn btn-secondary" style="color:white">
                                                    view
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label style="font-family: 'Times New Roman', Times, serif;;font-size:18px">Subject without results</label>
                                <table class="table table-bordered table-stream">
                                    <thead class="text-center">
                                        <tr>
                                            <th style="width:10%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Class</th>
                                            <th style="width: 10%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject</th>
                                            <th style="width: 20%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Subject Teacher</th>
                                            <th style="width: 25%;text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Students</th>
                                            <th style="text-align:left;padding:6px;font-family: 'Times New Roman', Times, serif;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="exam_class_tbody_stream">
                                        @foreach($myclass->class_subject as $classsubject)
                                        <div style="display:none">{{$i=0}}</div>
                                        @foreach($exam_records as $exam_rec)
                                        @if( $exam_rec->af == $classsubject->subject_id)
                                        <div style="display:none"> {{$i++}}</div>
                                        @endif
                                        @endforeach
                                        @if($i==0)
                                        <tr>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">Form {{$myclass->form->name}} {{$myclass->stream}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->title}}</td>
                                            @if($classsubject->subject->class_subject->teacher_id == null)
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">Not assigned yet</td>
                                            @else
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{$classsubject->subject->class_subject->teacher->user->name}}</td>
                                            @endif
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;">{{count($myclass->students)}}</td>
                                            <td style="font-size:16px;font-family: 'Times New Roman', Times, serif;"><a class="btn" href="/exam_class/upload/{{$classsubject->id}}/{{$exam_id}}/{{$classsubject->teacher_id}}/{{$classsubject->subject_id}}" style="background-color:#bbc1d2;color:black">Upload Results</a></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12" style="margin-top:30px">
                            <a class="btn" href="#" style="font-size:16px;background-color:#b7c2D0;color:black;border-radius:6px;font-family: 'Times New Roman', Times, serif;">Back</a>
                            <a class="btn" href="#" style="font-size:16px;background-color:#45AB48;color:white;border-radius:6px;font-family: 'Times New Roman', Times, serif;">Download Results</a>
                            <div style="display:none">{{$i=0}}</div>
                            @foreach($exam_records as $exam_rec)
                            @if($exam_rec->flag>1)
                            <div style="display:none">{{$i++}}</div>
                            @endif
                            @endforeach
                            @if($i>0)
                            <a class="btn" onclick="grant_access_to_subject(event)" style="font-size:16px;background-color:#31A4dd;color:white;border-radius:6px;font-family: 'Times New Roman', Times, serif;float:right">Grant access to subject teachers</a>
                            <a class="btn" onclick="grant_access()" id='grant_access_btn' style="display:none;font-size:16px;background-color:#31dd44;color:white;border-radius:6px;font-family: 'Times New Roman', Times, serif;float:right">Grant access</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</body>


@include('partials.js.exam_js')
@endsection