@extends('layouts.master')
@section('page_title', 'User Profile - '.$user->user->name)
@section('content')
<style>
.body {
    color: #172b4c;
}

.title1 {
    font-size: 15px;
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
    margin-top: 30px;
}

.active-state {
    display: none;
}

.cardpos>li {
    width: 180px;
}

.cardpos>li>a {
    text-align: center;
    padding: 5px 10px;
}
</style>
<div class="card" style="font-family:Arial, Helvetica, sans-serif">

    <div class="card-body" style="background: whitesmoke">
        <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-40px);">
            <li class="nav-item"><a href="#new-user" class="nav-link active" data-toggle="tab">Student Profile</a></li>
        </ul>

        <div class="tab-content tabpos">
            <div class="tab-pane fade show active" id="new-user" style="padding:0px 50px;">

                <div class="row py-3" style="background: white;padding:40px">
                    <div class="col-md-12 m-0" style="text-align: left;">
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    Student Profile
                                </p>
                            </div>
                            <div class="col-6">
                                <img src="{{asset('assets\images\avatar_blue.png')}}"
                                    style="float:left;border-radius:100px" width="100" height="100">
                                <p style="font-size:30px;margin-top:25px;margin-left:120px;line-height:0.8">
                                    {{$user->user->name}}
                                </p>
                                <p style="padding-left: 145px;">{{$user->adm_no}},Class of 2022(East)</p>
                            </div>
                            <div class="col-6">
                                <ul class="nav nav-tabs " style="float: right;border-radius:10px">
                                    <li class="nav-item"><a class="nav-link active" style="background-color: #d9dff3"
                                            data-toggle="tab"><svg xmlns="http://www.w3.org/2000/svg"
                                                style="float:left;margin-top:5px;margin-right:5px" width="16"
                                                height="16" fill="currentColor" class="bi bi-bar-chart-line"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z" />
                                            </svg>Analytics</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link active" style="background-color: #d9dff3;"
                                            data-toggle="tab">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                style="float:left;margin-top:5px;margin-right:5px" width="16"
                                                height="16" fill="currentColor" class="bi bi-messenger"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M0 7.76C0 3.301 3.493 0 8 0s8 3.301 8 7.76-3.493 7.76-8 7.76c-.81 0-1.586-.107-2.316-.307a.639.639 0 0 0-.427.03l-1.588.702a.64.64 0 0 1-.898-.566l-.044-1.423a.639.639 0 0 0-.215-.456C.956 12.108 0 10.092 0 7.76zm5.546-1.459-2.35 3.728c-.225.358.214.761.551.506l2.525-1.916a.48.48 0 0 1 .578-.002l1.869 1.402a1.2 1.2 0 0 0 1.735-.32l2.35-3.728c.226-.358-.214-.761-.551-.506L9.728 7.381a.48.48 0 0 1-.578.002L7.281 5.98a1.2 1.2 0 0 0-1.735.32z" />
                                            </svg>Messages</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link active" style="background-color: #d9dff3;"
                                            data-toggle="tab">Notes<svg xmlns="http://www.w3.org/2000/svg"
                                                style="float:right;margin-top:5px;margin-left:5px   " width="16"
                                                height="16" fill="currentColor" class="bi bi-chevron-down"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                            </svg></a></li>
                                </ul>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>

                        </div>
                        <div class="row" style="height: 100%">
                            <div class="card col-12 px-4" style="margin-top:10px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="admno">Admission Number</label>
                                            <input value="{{ $user->adm_no }}" required type="text" name="name"
                                                id="admno" placeholder="Admission Number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="upi">UPI</label>
                                            <input value="{{ $user->name }}" required type="text" name="name" id="upi"
                                                placeholder="UPI" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="indexnum">Index Number</label>
                                            <input value="{{ $user->name }}" required type="text" name="name"
                                                id="indexnum" placeholder="Index Number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input value="{{ $user->user->name }}" required type="text" name="name"
                                                id="name" placeholder="Full Name" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dateofadm">Date of Admission-<em
                                                    style="color:#333333">DD/MM/YYYY</em>
                                            </label>
                                            <input value="{{ $user->user->addmissiondate }}" type="date"
                                                class="form-control" id="dateadm">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dateofbirthday">Date of Birthday-<em
                                                    style="color:#333333">DD/MM/YYYY</em>
                                            </label>
                                            <input value="{{ $user->user->birthdate}}" type="date" class="form-control"
                                                id="date-birth">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="birthcertificate">Birth Certificate Entry
                                                Number
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="birthcertificate"
                                                id="birthcertificate" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="prischoolname">Primary School Name
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="prischoolname"
                                                id="prischoolname" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kcpeindex">KCPE Index
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="kcpeindex"
                                                id="kcpeindex" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kcpescore">KCPE Score
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="kcpescore"
                                                id="kcpescore" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kcpeyear">KCPE Year
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="kcpeyear"
                                                id="kcpeyear" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guardianname">Guardian Name
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="guardianname"
                                                id="guardianname" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="primaryGP">Primary Guardian Phone
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="primaryGP"
                                                id="primaryGP" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="secondphone">Secondary Guardian Phone
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="secondphone"
                                                id="secondphone" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="guardianemail">Guardian Email
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="guardianemail"
                                                id="guardianemail" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="relation">Gurdain Relation to Student
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="relation"
                                                id="relation" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="homeaddress">Home Address
                                            </label>
                                            <input value="" class="form-control" placeholder="" name="homeaddress"
                                                id="homeaddress" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="gender">Gender</label>
                                        <select class="select form-control title1" id="gender" name="gender" data-fouc
                                            data-placeholder="Choose..">
                                            <option value="male" @if($user->gender == 'male') selected
                                                @endif
                                                >Male
                                            </option>
                                            <option value="female" @if($user->gender == 'female') selected
                                                @endif
                                                >Female
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="house">House</label>
                                        <select class="select form-control title1" id="house" name="house" data-fouc
                                            data-placeholder="Choose..">
                                            <option value="House1">House1
                                            </option>
                                            <option value="House2">House2
                                            </option>
                                        </select>
                                    </div>

                                </div>
                                <div class="row" style="margin-top:20px">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="bio">General Comments</label>
                                            <textarea class="form-control" style="height: calc(10rem - 48px);"
                                                id="generalcomment">Average Student </textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="photo">Photo:</label>
                                            <input type="file" id="photo" name="photo">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" style="margin-top:30px ;">
                                    <button class="btn btn-primary " style="float:right" id="save_profile">Save
                                        <i class="icon-paperplane ml-2"></i></button>
                                </div>
                                <br><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#save_profile").click(() => {
        let dateofadm = $("#dateadm").val();
        let dateofbirth = $("#date-birth").val();
        let generalcomment = $("#generalcomment").val();
        userdata = {
            addmissiondate: dateofadm,
            birthdate: dateofbirth,
            generalcomment: generalcomment
        }
        console.log(userdata);
        $.ajax({
            url: '/updatestudentprofile',
            method: 'POST',
            data: {
                userdata: userdata,
                studentid: "{{ $user->user->id }}"
            },
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    text: "Updating success",
                    showConfirmButton: false,
                    timer: 1000,
                })
            },
            error: function(xhr, status, error) {}
        });
    })
});
</script>

@endsection