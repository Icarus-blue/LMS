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
<div class="card" style="background-color: #F5F5F5; margin-bottom: 0px;margin-left:20px">
    <ul class="nav nav-tabs nav-tabs-highlight cardpos">
        @if ($types=="student" || $types=="teacher" || $types=="staff")
        <li class="nav-item"><a href="#my_classes_pane" class="nav-link" data-toggle="tab" style="font-family:'Times New Roman', Times, serif" onclick="selectExam()"><i class="icofont-gear"></i> Edit Exam</a></li>
        @else
        <li class="nav-item"><a href="#my_classes_pane" style="font-family:'Times New Roman', Times, serif" class="nav-link active" data-toggle="tab" onclick="selectExam()"><i class="icofont-gear"></i> Edit Exam</a></li>
        @endif

    </ul>
    <div class="card-body" style="background-color: white;margin: 1rem;">
        <div class="row ml-1">
            <div class="col-6 text-left">
                <h3 style="font-family:'Times New Roman', Times, serif">Edit Exam</h3>
            </div>
            <div class="col-6 text-right">
                <a href="/exam_manage/add/{{ $exam->id }}" class="bg-success py-2 px-3" style="border-radius: 5px;font-family:'Times New Roman', Times, serif">Add form</a>
            </div>
        </div>
        <!-- @csrf @method('PUT') -->
        <div class="col-12">
            <hr>
            <p style="font-family:'Times New Roman', Times, serif">Exam Name</p>
            <input class="form-control" type="text" name="exam_name" id="input_area" disabled value={{ str_replace(' ', '-', $exam->name) }}>
        </div>
        <div class="row">
            <div class="col-6 text-left pt-2 pl-3">
                <a href="/exams2" class="btn btn-secondary" style="color:black"><svg xmlns="http://www.w3.org/2000/svg" style="float:left;margin-top:3px;color:black;margin-right:5px" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>Back</a>
            </div>
            <div class="col-6 text-right pt-2 pr-3" id="btn_Div">
                <button class="btn btn-info" style="background-color:#B0BACF;color:black" id="edit_exam_update_name">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="float:left;margin-top:3px;margin-right:5px" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                    Update Name
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {
        $("#edit_exam_update_name").click(() => {
            $("#input_area").prop("disabled", false);
            $("#edit_exam_update_name").hide();
            $("#btn_Div").append("<button style='background-color:#B0BACF;color:black;border-radius:3px;padding:3px;padding-right:7px;border:none;background-color:#00B6FF;color:white' id='update_btn'><svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' style='float:left;margin-right:5px;margin-left:5px;margin-top:8px' fill='currentColor' class='bi bi-check-circle' viewBox='0 0 16 16'><path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/><path d='M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z'/></svg>update</button>");
            $("#update_btn").click(() => {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        exam_name: $("#input_area").val(),
                        _method: 'PUT'
                    },
                    url: "{{ route('exams.update', $exam->id) }}",
                    success: function(data) {

                    }
                });
            })
        })





    })
</script>
@include('partials.js.exam_js')
@endsection