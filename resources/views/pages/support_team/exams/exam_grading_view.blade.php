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
    .card{
        margin-top:90px;overflow:hidden;
    }
    #table_exam  td {
        font-size:16px;
        padding:5px
    }
    #table_exam  th {
        font-size:16px;
        padding:5px
    }
</style>
<div class="card" style="font-family:'Times New Roman', Times, serif">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h4>Grading Systems</h4>
            </div>
            <div class="col-6 text-right">
                <a href="/exam_grading/add" class="btn btn-primary">Create Grading System</a>
            </div>
            <hr>

        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <h5 id="exam_add_title">{{ $class_type_name->name}}</h5>
            </div>
            <div class="col-6 text-right">
                <a href="/exams" class="btn btn-primary">Close</a>
            </div>
        </div>
        <br>
        <h6 style="float:left">Grading Grid (Start with the lowest)</h6>
        <table class="table table-bordered table-striped " id="table_exam">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Low</th>
                    <th>High</th>
                    <th>Grade</th>
                    <th>Points</th>
                </tr>
            </thead>
            <tbody>
                <span class="d-none">{{ $k =0; }}</span>
                @foreach ($grade as $item)
                    <tr>
                        <td>{{ ++$k }}</td>
                        <td>{{ $item->mark_from }}</td>
                        <td>{{ $item->mark_to }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->remark }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- @include('partials.js.exam_js') --}}
@endsection
