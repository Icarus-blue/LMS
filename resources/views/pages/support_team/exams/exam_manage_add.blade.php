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
        text-align: left;
    }
</style>
<div class="card">
    <ul class="nav nav-tabs nav-tabs-highlight cardpos">
        @if ($types=="student" || $types=="teacher" || $types=="staff")
        <li class="nav-item"><a href="#my_classes_pane" class="nav-link" data-toggle="tab" style="font-family:'Times New Roman', Times, serif" onclick="selectExam()"><i class="icofont-gear"></i> Edit Exam</a></li>
        @else
        <li class="nav-item"><a href="#my_classes_pane" class="nav-link active" style="font-family:'Times New Roman', Times, serif" data-toggle="tab" onclick="selectExam()"><i class="icofont-gear"></i> Edit Exam</a></li>
        @endif
    </ul>
    <div class="card-body" style="background-color:#F5F5F5">
        <div class="row" style="background-color:white;padding:20px;margin:10px">
            <div class="col-12">
                <h4 style="font-family:'Times New Roman', Times, serif">Add Form To This Exam</h4>
            </div>
            <div class="col-12">
                <hr>
                @if (count($exam_forms)>0 && count($exam_forms)<4 ) <h4 id="exam_add_title" style="font-family:'Times New Roman', Times, serif">Add classes that sat for the exam</h4>
                    @else
                    <p style="font-family:'Times New Roman', Times, serif"> All forms are taking this exam</p>
                    @endif
            </div>
            <div class="col-12">
                <input type="hidden" name="exam_id" value={{ $exam_id }}>
                <table class="table table-striped table-bordered">
                    <tbody>
                        @foreach ($exam_forms as $key => $val)
                        <li class="row one-sitting @if($key % 2 == 0) odd @endif">
                            <div class="col-md-3">
                                <div class="row">
                                    <input type="checkbox" class="exam_form my-2 mx-3" name="exam_forms" onchange="checkState({{ $val['id'] }}, this, event)" id={{"chk".$val['id']}} style="width: 20px; height: 20px;">
                                    <p class="my-1 mx-3" style="font-family:'Times New Roman', Times, serif">Form {{$val['name']}}</p>
                                </div>
                            </div>
                            <div class="col-md-9" style="transform:translateX(20px)">
                                <div class="col-md-12">
                                    <input class="exam_form" type="number" name="exam_forms" placeholder="Minimum Subject that can be taken" oninput="hideSubject({{  $val['id']  }}, event)" id={{ "form".$val['id'] }} min="0" style="font-family:'Times New Roman', Times, serif;margin-top:1px;width: 100%;font-size:1rem;line-height:1.5;border-radius:5px;border-color:#86a4c3;box-shadow:none;border:1px solid #ced4da; " oninvalid="examSubject({{  $val['id'] }}, event);" />
                                </div>
                                {{-- <br> --}}
                                <div class="col-md-12">
                                    <span style="color: red;font-size:13px" id="min_subject_helper{{ $val['id'] }}"></span>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </tbody>
                </table>

                <div class="row align-items-center ml-1">
                    <div class="col-6 text-left pt-2">
                        <a href="/exams/{{ $exam_id }}" style="font-family:'Times New Roman', Times, serif" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="col-6 text-right pt-2 pr-3">
                        <button onclick="addSelected({{ $exam_id }});" style="font-family:'Times New Roman', Times, serif" class="btn btn-info">Add Selected</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@include('partials.js.exam_js')
@endsection