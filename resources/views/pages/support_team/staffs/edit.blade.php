@extends('layouts.master')
@section('page_title', 'Manage Teacher')
@section('content')
    <style>
    .card{
        margin-top:50px;overflow:hidden;
    }
    .cardpos{
        position:fixed;width:100%;z-index:10;
    }
    .tabpos{
        margin-top: -65px;
    }
    .cardpos>li{
            width:180px;
        }
    .cardpos>li>a{
            text-align: center;
            padding:5px 10px;
        }
    .selcls {
        padding: 9px;
        border: solid 1px #517B97;
        outline: 0;
        background: -webkit-gradient(linear, left top, left 25, from(#FFFFFF), color-stop(4%, #CAD9E3), to(#FFFFFF));
        background: -moz-linear-gradient(top, #FFFFFF, #CAD9E3 1px, #FFFFFF 25px);
        box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
        -moz-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;
        -webkit-box-shadow: rgba(0,0,0, 0.1) 0px 0px 8px;

    }
    input, .select2-selection{
        background-color: #f1fcf1!important;
        /* height: 35px; */
        font-size: 15px;
    }
    </style>
    <div class="card" style="background: whitesmoke">

        <div class="card-body">
            <ul class="nav nav-tabs nav-tabs-highlight cardpos" style="transform:translateX(-22px);margin-top:-57px;">
                <li class="nav-item"><a href="#new-user" class="nav-link active" data-toggle="tab">Edit Teacher</a></li>
            </ul>

            <div class="tab-content tabpos">
                <div class="tab-pane fade show active" id="new-user">
                    <div class="row" style="background: whitesmoke">
                        <div class="col-md-4 mr-3" style="margin-left: -20px">
                            <div class="row">
                                <div class="card col-12 ml-2 p-4">
                                    <div class="d-flex flex-column align-items-center welcome-pane">
                                        <img class="mt-3 rounded-circle" src="/{{ $staff->user->photo_by }}/{{ $staff->user->photo }}" width="150" height="150"/>
                                        <div class="person d-none">
                                            <div class="d-flex flex-row">
                                                @if(Qs::userIsTeamSA())
                                                    <a href="{{ route('teachers.edit', $staff->id) }}" class="dropdown-item"><i class="icon-pencil"></i></a>
                                                @endif
                                                @if(Qs::userIsSuperAdmin())
                                                    <a id="{{ $staff->id }}" onclick="confirmDelete(this.id)" href="#" class="dropdown-item"><i class="icon-trash"></i></a>
                                                    <form method="post" id="item-delete-{{ $staff->id }}" action="{{ route('teachers.destroy', $staff->id) }}" class="hidden">@csrf @method('delete')</form>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="my-3 text-center">
                                            <h4><b>{{$staff->user->name}}</b></h4>
                                            <h5 style="color: #6c757d">{{$staff->user->email}}</h5>

                                        </div>
                                    </div>
                                    <div class="d-flex flex-column ml-3 m-1">
                                        <div class="d-flex flex-row">
                                            <label>Phone: </label> <b style="color: #2ea5de">{{$staff->user->phone}}</b>
                                        </div>
                                        <div class="row ml-1">
                                            <label class="form-label text-uppercase"> SIGNATURE</label>
                                        </div>
                                        <textarea name="signature" style="background:whitesmoke;width:200px" id="sigunature" cols="20"></textarea>
                                        <div style="text-align: right">
                                            {{-- @if(Qs::userIsSuperAdmin()) --}}
                                                <button id="{{ $staff->id }}" onclick="confirmDelete(this.id)" style="cursor: pointer;border-radius:5px;background:#ff562f;line-height:1.35;font-size:0.925rem"  class="btn-danger mt-3 px-2 py-1 border-0"><i class="icon-trash"></i> &nbsp; Delete</button>
                                                <form method="post" id="item-delete-{{ $staff->id }}" action="{{ route('staffs.destroy', $staff->id) }}" class="hidden">@csrf @method('delete')</form>
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" style="transform:translateX(10px)">
                            <div class="row">
                                <div class="card col-12 p-3" style="text-align: left">
                                    <form method="post" action="{{ route('staffs.update', $staff->id) }}">
                                        @csrf @method('PUT')
                                        <h4><b> Update details for {{ $staff->user->name }}</b></h4>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="full_name">Name</label>
                                                    <input value="{{ $staff->user->name }}" required type="text" name="full_name" id="full_name" placeholder="Full Name" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Personal Email</label>
                                                    <input value="{{ $staff->user->email }}" required type="text" name="email" id="email" placeholder="Email" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone_number">Phone Number</label>
                                                    <input value="{{ $staff->user->phone }}" class="form-control" placeholder="07## ### ###" name="phone_number" id="phone_number" type="text" >
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="gender">Gender</label>
                                                <select class="select form-control selcls" id="gender" name="gender" data-fouc data-placeholder="Choose..">
                                                    <option value="male" @if($staff->user->gender == 'male') selected @endif >Male</option>
                                                    <option value="female" @if($staff->user->gender == 'female') selected @endif >Female</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="national_id_no">ID Number</label>
                                                    <input value="{{ $staff->user->national_id_no }}" type="text" name="national_id_no" id="national_id_no" placeholder="####" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="group">Groups</label>
                                                    <?php $staffs = explode(",",$staff->group_id) ?>
                                                    <select class="select form-control selcls" id="group" name="group[]" multiple data-fouc data-placeholder="Choose..">
                                                        @foreach ($group as $key => $g)
                                                            @foreach ($staffs as $item)
                                                                <option value="{{$g->id}}"  @if($item== $g->id) selected @endif>{{$g->name}}</option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="bio">Bio</label>
                                                    <textarea name="bio" id="bio" cols="30" rows="3" class="form-control" style="background: whitesmoke"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right my-1">
                                            <a class="btn btn-warning" href="{{ route('staffs.index') }}" style="background: #b7c1d1;color: #172b4c;border-radius:5px;line-height:1.35;"><i class="icofont-close"></i> Close</a>
                                            <button type="submit" class="btn btn-primary" style="background:#2ea5de;line-height:1.35;border-radius:5px;"><i class="icofont-save mr-1" style="font-size: 0.7rem"></i> Save </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
