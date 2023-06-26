@extends('layouts.master')
@section('page_title', 'Manage Classes')
@section('content')
<style>
    .box {
        display: flex;
        flex-wrap: wrap;
        margin:auto;
        width: 50%;
    }


    tbody>tr>td {
        font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 1rem;
        font-style: normal;
        font-weight: 400;
        line-height: 1.5;
        padding: 0.1rem 0.5rem !important;
    }

    td>a {
        font-size: 0.925rem;
        line-height: 1.35px;
    }

    tbody tr:nth-child(odd) {
        background-color: white;
        color: #000;
    }

    tbody {
        font-size: 10px !important;

    }

    .card {
        margin-top: 50px;
        overflow: hidden;
    }

    .cardpos {
        position: fixed;
        width: 100%;
        z-index: 10;
    }

    .tabpos {
        margin-top: 70px;
    }

    .cardpos>li {
        width: 180px;
    }

    .cardpos>li>a {
        text-align: center;
        padding: 5px 10px;
    }
</style>
<style>
    /* width */
    ::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: rgb(21, 20, 20);
        border-radius: 10px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #3a3939;
    }

    #table_myclasses td {
        font-size: 15px;
        padding: 0px;
        margin: 0px
    }

    #all-classes td {
        font-size: 15px;
        padding: 0px;
        margin: 0px
    }
</style>
<div class="card" style="background-color:whitesmoke; font-family: 'Times New Roman', Times, serif;">

    <div class="card-body" style="padding:0px">
        <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-22px);">
            @if ($types=="student" || $types == "staff" || $types == "teacher")
            <li><a href="#my-classes" class="nav-link active" data-toggle="tab" onclick="showMyClass();">My Classes</a></li>
            @else
            <li><a href="#my-classes" class="nav-link active" data-toggle="tab" onclick="showMyClass();">My Classes</a></li>
            <li><a href="#all-classes" class="nav-link" data-toggle="tab">Manage Classes</a></li>
            <li><a href="#add-class" class="nav-link" data-toggle="tab">Add New Class</a></li>
            @endif

        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active tabpos" id="my-classes">
                @if($is_check_having_subject_teacher>0)
                <div class="row">
                    <div class="col-12" style="padding:0px">
                        <div class="card p-2" style="margin-top:10px">
                            <div class="form-group">
                                <h3 style="font-weight: 700;text-align:left">Subject Classes</h3>
                                <hr style="background-color: whitesmoke">
                                <table class="table table-striped table-bordered table-sm table-hover mb-0" id='table_myclasses'>
                                    <thead>
                                        <tr class="text-center" style="line-height:0.8">
                                            <th style="width: 5%;">#</th>
                                            <th style="width: 65%;text-align:center">Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num = 0; ?>

                                        @if ($types=="student" || $types == "staff" || $types == "teacher" || $types == "admin")
                                        @foreach ($all_streams as $val)
                                        @if ($teacher!=null && $val->teacher_id ==$teacher->id)
                                        @foreach ($all_myclasses as $item)
                                        @if ($item->id ==$val->my_class_id)
                                        <tr>
                                            <td style="font-family:'Times New Roman', Times, serif;padding:5px"><?php echo ++$num; ?></td>
                                            <td style="text-align: left;font-family:'Times New Roman', Times, serif;padding:5px"> Form {{ $item->form->name }} {{ $item->stream }} - {{ $val->subject->title }} </td>
                                            <td class="d-flex" style="font-family:'Times New Roman', Times, serif;padding:5px">
                                                <div class="col-6 border-right">
                                                    <a class="btn p-2" style="background-color:#192B49 ;color:white" href="{{ route('class_manage1', $val->my_class->form_id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" style="float:left;margin-top:3px;margin-left:3px;color:white;margin-right:10px" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                                            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                                                        </svg> Manage
                                                    </a>
                                                </div>
                                                {{-- &nbsp;&nbsp; --}}
                                                <div class="col-6">
                                                    <a class="btn btn-success p-2" href="{{ route('class_list2', $val->my_class->id) }}"><i class="icofont-list"></i> Class list </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @else
                                        @foreach ($all_streams as $val)
                                        @foreach ($all_myclasses as $item)
                                        @isset($item->teacher->user->name)
                                        <tr>
                                            <td><?php echo ++$num; ?></td>
                                            <td style="text-align: left"> Form {{ $item->form->name }} {{ $item->stream }} - {{ $val->subject->title }} - {{ $item->teacher->user->name }} </td>
                                            <td class="d-flex">
                                                <div class="col-6">
                                                    <a class="btn" style="background-color:#192B49;color:white;width:140px;border-radius: 8px;padding:5px" href="{{ route('class_manage1', $val->my_class->form_id) }}"> <svg xmlns="http://www.w3.org/2000/svg" style="float:left;margin-top:3px;margin-left:5px" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                                            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                                                        </svg> Manage </a>
                                                </div>
                                                <div class="col-6">
                                                    {{-- &nbsp;&nbsp; --}}
                                                    <a class="btn btn-success" href="{{ route('class_list2', $val->my_class->id) }}" style="color:white;width:140px;border-radius: 8px;padding:5px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="float:left;margin-left:5px;margin-top:3px" class="bi bi-list-columns" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />
                                                        </svg> Class list </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endisset
                                        @endforeach
                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <?php $count = 0; ?>
                @if ($types=="student" || $types == "staff" || $types == "teacher" || $types=="admin")
                @foreach ($all_myclasses as $item)
                @foreach ($all_forms as $form)
                @if ($item->teacher_id ==$teacher->id )
                <?php ++$count; ?>
                @endif
                @endforeach
                @endforeach
                @endif
                @if ($count>0)
                <div class="row">
                    <div class="col-12" style="padding-left:20px;padding-right:20px;">
                        <div class="card p-2">
                            <div class="form-group">
                                <h2 style="font-weight: 700;text-align: left">Streams</h2>
                                <hr>
                                <table class="table  table-bordered table-sm">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 10%">*</th>
                                            <th style="width: 50%;text-align:left">Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num = 0; ?>
                                        @if ($types=="student" || $types == "staff" || $types == "teacher" || $types=="admin")
                                        @foreach ($all_myclasses as $item)
                                        @foreach ($all_forms as $form)
                                        @if ($item->teacher_id ==$teacher->id && $form->id == $item->form_id)
                                        <tr>
                                            <td style="font-family:'Times New Roman', Times, serif"><?php echo ++$num; ?></td>
                                            <td style="text-align: left;font-family:'Times New Roman', Times, serif"> Form {{ $item->form->name }} {{ $item->stream }}</td>
                                            <td class="d-flex">
                                                <div class="col-4 border-right">
                                                    <a class="btn btn-primary p-2" style="font-family:'Times New Roman', Times, serif" href="{{ route('class_subject_manage', $item->id) }}"><i class="icofont-settings"></i> Manage </a>
                                                </div>
                                                {{-- &nbsp;&nbsp; --}}
                                                <div class="col-4 border-right">
                                                    <a class="btn btn-secondary p-2" style="font-family:'Times New Roman', Times, serif" href="/"><i class="icofont-list"></i> Attendance </a>
                                                </div>
                                                {{-- &nbsp;&nbsp; --}}
                                                <div class="col-4">
                                                    <a class="btn btn-success p-2" style="font-family:'Times New Roman', Times, serif" href="{{ route('class_list2', $item->id) }}"><i class="icofont-list"></i> Class list </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endforeach
                                        @else
                                        @foreach ($all_myclasses as $item)
                                        <tr>
                                            <td>{{ ++$num }}</td>
                                            <td style="text-align: left"> Form {{ $item->form->name }} {{ $item->stream }} </td>
                                            <td class="d-flex">
                                                <div class="col-4 border-right">
                                                    <a class="btn btn-primary p-2" href="{{ route('class_subject_manage', $item->id) }}"><i class="icofont-settings"></i> Manage </a>
                                                </div>
                                                {{-- &nbsp;&nbsp; --}}
                                                <div class="col-4 border-right">
                                                    <a class="btn btn-secondary p-2" href="/"><i class="icofont-list"></i> Attendance </a>
                                                </div>
                                                {{-- &nbsp;&nbsp; --}}
                                                <div class="col-4 border-right">
                                                    <a class="btn btn-success p-2" href="{{ route('class_list2', $item->id) }}"><i class="icofont-list"></i> Class list </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <?php $count = 0; ?>
                @if ($types=="student" || $types == "staff" || $types == "teacher" || $types=="admin")
                {{-- @foreach ($all_myclasses as $item) --}}
                @foreach ($all_forms as $form)
                @if ($form->teacher_id == $teacher->id)
                <?php ++$count; ?>
                @endif
                @endforeach
                {{-- @endforeach --}}
                @endif
                @if ($count>0)
                <div class="row">
                    <div class="col-12" style="padding-left:20px;padding-right:20px;">
                        <div class="card p-2">
                            <div class="form-group">
                                <h2 style="font-weight: 700;text-align: left;">Classes Supervised</h2>
                                <hr>
                                <table class="table  table-bordered table-sm">
                                    <thead>
                                        <tr class="text-center">
                                            <th style="width: 10%">*</th>
                                            <th style="width: 60%;text-align:left">Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $num = 0; ?>
                                        @if ($types=="student" || $types == "staff" || $types == "teacher" || $types=="admin")
                                        @foreach ($all_forms as $form)
                                        @if ($form->teacher_id == $teacher->id)
                                        <tr>
                                            <td style="font-family:'Times New Roman', Times, serif"><?php echo ++$num; ?></td>
                                            <td style="text-align: left;font-family:'Times New Roman', Times, serif"> Form {{ $form->name }}</td>
                                            <td style="font-family:'Times New Roman', Times, serif">
                                                <a class="btn btn-success p-2" href="{{ route('class_list3', $form->id) }}"><i class="icofont-list"></i> Class list </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="tab-pane fade tabpos" id="all-classes" style="background-color:white;padding-top:15px;padding-left: 30px;padding-right:30px;padding-bottom:30px;margin-top:50px;margin-bottom:0px">
                <h3 style="font-weight: 700;text-align:left;margin-bottom:5px">Classes</h3>
                <table class="table  table-bordered table-sm">
                    <thead style="line-height:0.8">
                        <tr>
                            <th style="width:5%">Form</th>
                            <th style="width:3%">Students</th>
                            <th>Class Supervisor</th>
                            <th colspan="2">Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_forms as $val)
                        <tr>
                            <td style="text-align:left">{{$val->name}}</td>
                            <td style="text-align:left">
                                <?php $total_students_cnt = 0; ?>
                                @foreach($val->my_classes as $key)
                                <?php $total_students_cnt += count($key->students) ?>
                                @endforeach
                                {{$total_students_cnt}}
                            </td>
                            <td>
                                @if ($val->teacher_id != 0 && $val->teacher_id != null && $val->teacher_id != '0')
                                <div class="d-flex align-items-center justify-content-between">
                                    <p style="margin: 0;">
                                        @if ($val->teacher != null)
                                        {{$val->teacher->user->name}}
                                    </p>
                                    @endif
                                    <button class="btn" title="Delete this user" style="background:transparent;line-height: 7px;margin:0;font-size: 10px;height:auto" onclick="deleteSupervisor('{{ $val->id }}', this);">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="color:red" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </button>
                                </div>
                                @else
                                <select required data-placeholder="Assign" class="form-control" onchange="assignSupervisor({{ $val->id }}, this)" data-id="{{ $val->id }}">
                                    <option value="">Assign</option>
                                    @foreach($all_teachers as $value)
                                    <option value="{{$value->id}}">{{$value->user->name}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </td>
                            <td><a class="btn " href="{{ route('class_manage', $val->id) }}" style="background-color:#192B49;padding:5px;color:white;width:140px;border-radius: 8px;"> <svg xmlns="http://www.w3.org/2000/svg" style="float:left;margin-top:3px;margin-left:5px" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                        <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
                                    </svg> Manage</a></td>
                            <td><a class="btn btn-success" href="{{ route('class_list', $val->id) }} " style="padding:5px;width:140px;border-radius: 8px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="float:left;margin-left:5px;margin-top:3px" class="bi bi-list-columns" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M0 .5A.5.5 0 0 1 .5 0h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 0 .5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 2h8a.5.5 0 0 1 0 1h-8a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 4h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 6h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2A.5.5 0 0 1 .5 8h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-13 2a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H.5a.5.5 0 0 1-.5-.5Zm13 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z" />
                                    </svg>
                                    Class List</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade tabpos" id="add-class" style="margin-top:100px">
                <form class="ajax-store" method="post" action="{{ route('classes.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="form_id" class="col-lg-3 col-form-label font-weight-semibold" style="float:left;margin-left:15px">Form</label>
                                <div class="col-lg-11" style="float:right">
                                    <select required data-placeholder="Select Form" class="form-control select" name="form_id" id="form_id">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-lg-3 col-form-label font-weight-semibold" style="float:left;margin-left:15px">Stream Name</label>
                                <div class="col-lg-11" style="float:right">
                                    <input name="stream" id="stream" value="{{ old('stream') }}" style="font-size:15px;padding:5px" required type="text" class="form-control" placeholder="Stream Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:60px">
                        <?php $cnt = 0; ?>
                        @for($i=1;$i<7;$i++) @foreach ($all_subjects as $subject) @if($i==$subject->subject_type_id)
                            @if($cnt==0)
                            <div class="col-md-3">
                                <h3 style="text-align:left;padding-left:100px">{{$subject->subject_type->name}}</h3>
                                @endif
                                <div class="box" >
                                    <input type="checkbox" style="margin-left:0px" id="{{$subject->subject_type->name.$subject->title}}" name="{{$subject->subject_type->name.$subject->title}}" value="{{$subject->id}}">
                                    <label for="{{$subject->subject_type->name.$subject->title}}" style="margin-left:20px;margin-top:6px">{{$subject->title}}</label>
                                </div>

                                <?php switch ($i) {
                                    case 1:
                                        if ($cnt == 1) {
                                            echo "</div>";
                                        }
                                        break;
                                    case 2:
                                        if ($cnt == 0) {
                                            echo "</div>";
                                        }
                                        break;
                                    case 3:
                                        if ($cnt == 2) {
                                            echo "</div>";
                                        }
                                        break;
                                    case 4:
                                        if ($cnt == 4) {
                                            echo "</div>";
                                        }
                                        break;
                                    case 5:
                                        if ($cnt == 12) {
                                            echo "</div>";
                                        }
                                        break;
                                    case 6:
                                        if ($cnt == 16) {
                                            echo "</div>";
                                        }
                                        break;
                                } ?>
                                <?php $cnt++ ?>
                                @endif
                                @endforeach
                                <?php $cnt = 0; ?>
                                @endfor
                            </div>
                            <div class="text-right">
                                <button id="ajax-btn" type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                            </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{--Class List Ends--}}
@include('partials.js.class_index')
<script>
    $(document).ready(function() {
        $("tr:odd").css({
            "background-color": "#F2F2F2",
            "color": "#000"
        });
    });
</script>
@endsection