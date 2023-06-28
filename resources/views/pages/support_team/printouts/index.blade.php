@extends('layouts.master')
@section('page_title', 'Manage Classes')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<style>
#class_list {

    border: 1px solid black
}

.label_report_form {
    font-size: 14px;
    float: left;
    margin-left: 7px;
    margin-top: 2px;
    font-weight: unset;
}

#option-div {
    background-color: white;
    margin-top: 20px;
    padding-top: 15px;
    padding-left: 30px;
    padding-right: 30px;
}

label {
    font-size: 16px;
    float: left;
    display: flex;
    font-weight: bold;
}

.dt-buttons {
    display: none;
}



.card {
    margin-top: 50px;
    overflow: hidden;

}

.scrollbar {
    background: white;
    overflow-y: auto;

}

.force-overflow {
    min-width: 1400px;
}

th {
    font-size: 15px;
    font-weight: revert !important;
    border-right: 1px solid black !important;
    border-bottom: 1px solid black !important;
    text-align: left;
    font-family: Arial, Helvetica, sans-serif;
}

td {
    font-size: 15px;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold;
    border-right: 1px solid black !important;
    text-align: left;
}

#wrapper {
    text-align: center;
    margin: auto;
}

.carpos {
    position: fixed;
    width: 100%;
    z-index: 10;
}


::-webkit-scrollbar-thumb:hover {
    background: #3a3939;
}

::-webkit-scrollbar-thumb {
    background: rgb(205 174 174);
}

::-webkit-scrollbar-thumb {
    background: rgb(21, 20, 20);
    border-radius: 0px;
}

.metalist_area,
th {
    margin-top: 40px;
    padding: 6px !important;
    border-right: 1px solid black;
    vertical-align: middle !important;
    font-size: 18px !important;
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold !important;

}

.metalist_area,
td {
    margin-top: 40px;
    padding: 6px !important;
    border-right: 1px solid black;
    vertical-align: middle !important;
    font-size: 17px !important;
    font-family: Arial, Helvetica, sans-serif;


}

.metalist_area {
    border: 3px solid black
}

.cardpos {
    position: fixed;
    width: 100%;
    z-index: 10;
}

.tabpos {
    margin-top: 70px;
}

.spinner-square {
    display: flex;
    flex-direction: row;
    width: 50px;
    height: 80px;
}

.spinner-square>.square {
    width: 12px;
    height: 10px;
    margin: auto auto;
    border-radius: 4px;
}

.square-1 {
    animation: square-anim 1200ms cubic-bezier(0.445, 0.05, 0.55, 0.95) 0s infinite;
}

.square-2 {
    animation: square-anim 1200ms cubic-bezier(0.445, 0.05, 0.55, 0.95) 200ms infinite;
}

.square-3 {
    animation: square-anim 1200ms cubic-bezier(0.445, 0.05, 0.55, 0.95) 400ms infinite;
}

@keyframes square-anim {
    0% {
        height: 0px;
        background-color: rgb(111, 163, 240);
    }

    20% {
        height: 20px;
    }

    40% {
        height: 40px;
        background-color: rgb(111, 200, 240);
    }

    80% {
        height: 60px;
    }

    100% {
        height: 80px;
        background-color: rgb(111, 163, 240);
    }
}
</style>


<div class="card" style="font-family:Arial, Helvetica, sans-serif">

    <div class="card-body" style="background-color: #F5F5F5">
        <ul class="nav nav-tabs nav-tabs-highlight cardpos" style=" transform:translateX(-22px);">
            <li class="nav-item"><a href="#class-lists" class="nav-link active" data-toggle="tab">Class Lists</a></li>
            <li class="nav-item"><a href="#analysis-report" class="nav-link" data-toggle="tab">Analysis Report</a></li>
            <li class="nav-item"><a href="#report-forms" class="nav-link" data-toggle="tab">Report Forms</a></li>
            <li class="nav-item"><a href="#merit-lists" class="nav-link" data-toggle="tab">Merit Lists</a></li>
            <li class="nav-item"><a href="#transcripts" class="nav-link" data-toggle="tab">Transcripts</a></li>
            <li class="nav-item"><a href="#leaving-certificates" class="nav-link" data-toggle="tab">Leaving
                    Certificates</a></li>
        </ul>
        <div class="tab-content " style="background-color: initial;margin:50px 10px">
            <div class="tab-pane fade show active" id="class-lists" style="padding:20px;">
                <div class="col-12" style="background-color:white;padding:20px 20px 0px 20px">
                    <div class="row">
                        <div class="col-12">
                            <h4 style="text-align: left;float:left">Class List</h4>
                            <icon class="first_up">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                                    <path fill-rule="evenodd"
                                        d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                </svg>
                            </icon>
                            <icon class="first_down">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    <path fill-rule="evenodd"
                                        d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </icon>

                        </div>

                    </div>
                    <hr style="margin:0px">
                </div>
                <div class="col-12" id="form_area"
                    style="padding-top:20px;background-color:white;padding-left:20px;padding-right:20px">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="select-form">Form</label>
                                <select name="select-form" class="form-control " id="select_form_classlist"
                                    style="font-size:16px;background-color:white !important;color:black;"
                                    data-placeholder="Select Form">
                                    <option value="">Select Form</option>
                                    @foreach($form as $val)
                                    <option value={{$val->id}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="select-form">Stream</label>
                                <select name="select-stream" class="form-control " id="select_stream_classlist"
                                    style="font-size:16px;background-color:white !important;color:black;"
                                    data-placeholder="Select Stream(Optional)">
                                    <option>Select Stream</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="select-subject">Subject</label>
                                <select name="select-subject" id="select_subject" class="form-control"
                                    style="font-size:16px;background-color:white !important;color:black;"
                                    data-placeholder="Select Subject(Optional)">
                                    <option>Select subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="button" id="get_class_list" class="btn btn-primary"
                                style="float:right;margin-top:30px;margin-bottom:10px;font-size:16px;border-radius:5px;">Get
                                Class List</button>
                        </div>
                    </div>

                </div>
                <div class="row" style="height: 30px;background-color:initial"></div>
                <div class="col-12" style="background-color:white;padding:20px 20px 0px 20px">
                    <div class="row">
                        <div class="col-12">
                            <h4 style="text-align: left;float:left">Options</h4>
                            <icon class="class_list_up">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                                    <path fill-rule="evenodd"
                                        d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                </svg>
                            </icon>
                            <icon class="class_list_down">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    <path fill-rule="evenodd"
                                        d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </icon>
                        </div>

                    </div>
                    <hr style="margin:0px">
                    <div class="row" id="class_list_option">
                        <div class="col-2"></div>
                        <div class="col-4">
                            <p style="margin-top:40px;text-align:left;font-size:18px;">List Type :</p>
                            <!-- <div style="display: -webkit-box;"> -->
                            <input type="radio" style="margin-left:0px;float:left;margin-top:4px" id="basictype"
                                checked>
                            <label style="font-size:16px;float:left;margin-left:7px">Basic</label>
                            <!-- </div> -->
                            <!-- <div> -->
                            <input type="radio" style="margin-left:20px;float:left;margin-top:4px" id="customtype">
                            <label style="font-size:16px;float:left;margin-left:7px">Custom</label>
                            <!-- </div> -->
                        </div>
                        <div class="col-6"></div>

                        <div class="col-12" style="margin-top:30px;margin-left:20px;display:none" id="custome">
                            <div class="row">
                                <div class="col-3">
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="admno"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">ADMNO</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Index Number"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Index Number</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="KCPE Score"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">KCPE Score</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Gender"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Gender</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Gurdain's Secondary"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Gurdain's Secondary
                                            Phone</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Is Day Scholar"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Is Day Scholar</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Name"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Name</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Primary School"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Primary School</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="British Certificate"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">British Certificate
                                            Number</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="House"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">House</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Gurdain's Email"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Gurdain's Email
                                        </label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Has Passport"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Has Passport
                                            Photo</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="UPI"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">UPI</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="KCPE Index"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">KCPE Index</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Date of Birth"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Date of Birth</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Gurdain's Name"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Gurdain's Name
                                        </label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Relation to"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Relation to
                                            Guardian</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Stream"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Stream</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="KCPE Year"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">KCPE Year</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Date of"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Date of
                                            Admission</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Gurdain's Primary"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Gurdain's Primary
                                            Phone</label>
                                    </div>
                                    <div style="display: -webkit-box;">
                                        <input type="checkbox" value="Home Address"
                                            style="margin-left:0px;float:left;margin-top:4px" class="testclass">
                                        <label style="font-size:16px;float:left;margin-left:7px">Home Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button id="custom_excel" class="btn btn-secondary " type="button"
                                        style="float:right;background-color:#32446B;width:140px">
                                        <icon style="float:left"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-filetype-xls"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM6.472 15.29a1.176 1.176 0 0 1-.111-.449h.765a.578.578 0 0 0 .254.384c.07.049.154.087.25.114.095.028.202.041.319.041.164 0 .302-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .085-.29.387.387 0 0 0-.153-.326c-.101-.08-.255-.144-.462-.193l-.619-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.351-.367 1.068 1.068 0 0 1-.123-.524c0-.244.063-.457.19-.639.127-.181.303-.322.527-.422.225-.1.484-.149.777-.149.305 0 .564.05.78.152.216.102.383.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.625.625 0 0 0-.247-.181.923.923 0 0 0-.369-.068c-.217 0-.388.05-.513.152a.472.472 0 0 0-.184.384c0 .121.048.22.143.3a.97.97 0 0 0 .405.175l.62.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94l1.274-2.007Zm2.727 3.325H4.557v-3.325h-.79v4h2.487v-.675Z" />
                                            </svg></icon>
                                        <span style="margin-left:10px;">Download Excel</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="middlepart"
                    style="margin-bottom:30px;background-color:initial;padding:30px;display:none">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle"
                            style="float:right;font-size:16px;background-color:#32446B" type="button" id="dropdownMenu2"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <!-- <button class="dropdown-item" id="class_list_aspdf" type="button">
                                    <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                            <path
                                                d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                            <path
                                                d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                                        </svg></icon>
                                    <span style="margin-left:10px;">As PDF</span>
                                </button> -->
                            <button class="dropdown-item" id="class_list_asexcel" type="button">
                                <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-filetype-xls" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM6.472 15.29a1.176 1.176 0 0 1-.111-.449h.765a.578.578 0 0 0 .254.384c.07.049.154.087.25.114.095.028.202.041.319.041.164 0 .302-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .085-.29.387.387 0 0 0-.153-.326c-.101-.08-.255-.144-.462-.193l-.619-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.351-.367 1.068 1.068 0 0 1-.123-.524c0-.244.063-.457.19-.639.127-.181.303-.322.527-.422.225-.1.484-.149.777-.149.305 0 .564.05.78.152.216.102.383.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.625.625 0 0 0-.247-.181.923.923 0 0 0-.369-.068c-.217 0-.388.05-.513.152a.472.472 0 0 0-.184.384c0 .121.048.22.143.3a.97.97 0 0 0 .405.175l.62.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94l1.274-2.007Zm2.727 3.325H4.557v-3.325h-.79v4h2.487v-.675Z" />
                                    </svg></icon>
                                <span style="margin-left:10px;">As Spreedsheet</span>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-secondary" onclick="fnPrintReport_class_list(event)"
                        style="margin-right:30px;float:right;;font-size:16px;background-color:#32446B" type="button"
                        aria-haspopup="true" aria-expanded="false">
                        Print
                    </button>
                </div>
                <div class="col-12" style="padding:45px;background-color:white" id="pdfdownloading_area">

                    <div class="col-12">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{asset('assets\images\school.png')}}" style="float:left" width="250"
                                    height="150">
                            </div>
                            <div class="col-8">
                                <p style="font-size: 45px;line-height:0.8">
                                    {{$schoolname->school_name}}-
                                </p>
                                <p style="font-size: 45px;">
                                    {{$schoolname->school_postal}}
                                </p>
                                <p style="font-size:27px;line-height:0.8">Class List</p>
                            </div>
                            <div class="col-2" style="padding-top:15px">
                                <p style="text-align:left;line-height:0.8;font-size:19px">
                                    {{$schoolname->school_postal}}
                                </p>
                                <p style="text-align:left;line-height:0.8;font-size:19px">
                                    {{$schoolname->school_phone}}
                                </p>
                                <p style="text-align:left;line-height:0.8;font-size:19px">
                                    {{$schoolname->school_email}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="style-default" style="margin-top: 20px;overflow:auto">

                        <table class=" table  table-striped" id="class_list">
                            <thead class="class_list_thead">
                                <tr>
                                    <td colspan="6" style="text-align: center;">
                                        Form 1 East - 2022
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align: center;">
                                        Class Teacher : Ann
                                    </td>
                                </tr>
                                <tr>
                                    <th>#
                                    </th>
                                    <th>IMAGE
                                    </th>
                                    <th>ADMNO
                                    </th>
                                    <th>NAME
                                    </th>

                                    <th>KCPE
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="class_list_tbody"></tbody>
                        </table>


                    </div>
                    <div class="col-12" id="class_list_download" style="display:none">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{asset('assets\images\school.png')}}" style="float:left" width="250"
                                        height="150">
                                </div>
                                <div class="col-8" style="padding-left:100px">
                                    <p style="font-size: 35px;text-align:center">
                                        {{$schoolname->school_name}}-{{$schoolname->school_postal}}
                                    </p>
                                    <p style="font-size:19px;text-align:center">Class List</p>
                                </div>
                                <div class="col-2" style="padding-top:15px">
                                    <p style="text-align:left;line-height:0.8;font-size:19px">
                                        {{$schoolname->school_postal}}
                                    </p>
                                    <p style="text-align:left;line-height:0.8;font-size:19px">
                                        {{$schoolname->school_phone}}
                                    </p>
                                    <p style="text-align:left;line-height:0.8;font-size:19px">
                                        {{$schoolname->school_email}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="style-default" style="margin-top: 20px;overflow:auto">

                            <table class=" table  table-striped" id="pdf_class_download">
                                <thead class="class_list_thead">
                                    <tr>
                                        <td colspan="9" style="text-align: center;">
                                            Form 1 East - 2022
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" style="text-align: center;">
                                            Class Teacher : Ann
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>#
                                        </th>

                                        <th>ADMNO
                                        </th>
                                        <th>NAME
                                        </th>

                                        <th>KCPE
                                        </th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="class_list_tbody_pdf"></tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade " id="analysis-report">
                <div class="row" style="margin-top: 50px;">
                    <div class="col-12" style="background-color:white;padding:20px 20px 0px 20px">
                        <div class="row">
                            <div class="col-12" style="padding:0px 20px">
                                <h4 style="text-align: left;margin-left:20px;float:left">Analysis Report</h4>
                                <icon class="first_up">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                        fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                                        <path fill-rule="evenodd"
                                            d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                    </svg>
                                </icon>
                                <icon class="first_down">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                        fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                        <path fill-rule="evenodd"
                                            d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </icon>

                            </div>

                        </div>
                        <hr style="margin:0px 20px">
                    </div>

                    <div class="col-12" style="background-color:white" id="elem_down">
                        <div class="row" id="input_area_first" style="margin-top:15px">
                            <div class="col-md-6" style="padding:0px 40px">
                                <div class="form-group">
                                    <label for="select-form" style="float:left;font-weight:bold">Form</label>
                                    <select name="select-form"
                                        style="font-size:16px;background-color:white !important;color:black;"
                                        id="select_form" class="form-control" data-placeholder="Select Form">
                                        <option value="">Select Form</option>
                                        @foreach($form as $val)
                                        <option value={{$val->id}}>{{$val->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding:0px 40px">
                                <div class="form-group">
                                    <label for="select-stream" style="float:left;font-weight:bold">Stream</label>
                                    <select name="select-stream"
                                        style="font-size:16px;background-color:white !important;" id="select_stream"
                                        class="form-control" data-placeholder="Select Stream(Optional)">
                                        <option>Select Stream</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="spinner-square"
                                    style="margin-top:40px;margin-bottom:30px;float:right;margin-right:20px;display:none">
                                    <div class="square-1 square"></div>
                                    <div class="square-2 square"></div>
                                    <div class="square-3 square"></div>
                                </div>
                            </div>


                            <div class="col-md-12" style="display:none;padding:0px 40px" id="exam_area">
                                <div class="form-group">
                                    <label for="select-exam" style="float:left;font-weight:bold">Exam</label>
                                    <select name="select-exam" style="background-color:white !important;font-size:16px"
                                        id="select_exam" class="form-control"
                                        data-placeholder="Select Stream(Optional)">
                                        <option value="">Select Exam</option>
                                        @foreach($exams as $exam)
                                        <option value={{$exam->id}}>{{$exam->name}}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="get_analysis" class="btn btn-primary"
                                        style="float:right;margin-top:30px;margin-bottom:10px;font-size:16px;border-radius:5px;">Get
                                        Analysis Reports</button>
                                </div>

                            </div>
                        </div>
                        <div class="row" id="print_arr" style="display:none;">
                            <div class="col-12" style="background-color:white;">
                                <div class="row" style="background-color:#F5F5F5;padding-top:54px;padding-bottom:0px">
                                    <div class="col-12">
                                        <h4 style="text-align: left;margin-left:20px;float:left">Options</h4>
                                        <icon class="second_up">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                style="float:right;margin-right:40px;color:#CE9178" width="16"
                                                height="16" fill="currentColor" class="bi bi-chevron-double-up"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                                                <path fill-rule="evenodd"
                                                    d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                            </svg>
                                        </icon>
                                        <icon class="second_down">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                style="float:right;margin-right:40px;color:#CE9178" width="16"
                                                height="16" fill="currentColor" class="bi bi-chevron-double-down"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                                <path fill-rule="evenodd"
                                                    d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                            </svg>
                                        </icon>
                                    </div>

                                </div>
                                <hr style="margin:0px">
                                <div class="row" id="option_elem">
                                    <div class="col-2"></div>
                                    <div class="col-4">
                                        <p style="margin-top:40px;text-align:left;font-size:18px;font-weight:bold">
                                            Top
                                            students :</p>
                                        <div style="display: -webkit-box;">
                                            <input type="checkbox"
                                                style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                class="checkbox">
                                            <label style="font-size:16px;float:left;margin-left:7px;margin-top:2px">Show
                                                subjects's
                                                top
                                                students</label>
                                        </div>
                                        <div>
                                            <input type="checkbox"
                                                style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                class="checkbox">
                                            <label style="font-size:16px;float:left;margin-left:7px;margin-top:2px">Show
                                                top
                                                students
                                                only</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12" style="background-color:#F5F5F5;padding:30px">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle"
                                        style="float:right;;font-size:16px;background-color:#32446B" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Download
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button class="dropdown-item" id="spreedsheet_analy" type="button">
                                            <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-filetype-xls" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM6.472 15.29a1.176 1.176 0 0 1-.111-.449h.765a.578.578 0 0 0 .254.384c.07.049.154.087.25.114.095.028.202.041.319.041.164 0 .302-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .085-.29.387.387 0 0 0-.153-.326c-.101-.08-.255-.144-.462-.193l-.619-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.351-.367 1.068 1.068 0 0 1-.123-.524c0-.244.063-.457.19-.639.127-.181.303-.322.527-.422.225-.1.484-.149.777-.149.305 0 .564.05.78.152.216.102.383.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.625.625 0 0 0-.247-.181.923.923 0 0 0-.369-.068c-.217 0-.388.05-.513.152a.472.472 0 0 0-.184.384c0 .121.048.22.143.3a.97.97 0 0 0 .405.175l.62.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94l1.274-2.007Zm2.727 3.325H4.557v-3.325h-.79v4h2.487v-.675Z" />
                                                </svg></icon>
                                            <span style="margin-left:10px;">As Spreedsheet</span>
                                        </button>
                                    </div>
                                </div>
                                <button class="btn btn-secondary" onclick="fnPrintReport_new_more(event)"
                                    style="margin-right:30px;float:right;;font-size:16px;background-color:#32446B"
                                    type="button" aria-haspopup="true" aria-expanded="false">
                                    Print Format
                                </button>
                            </div>
                            <div class="col-md-12">
                                <div class="row" style="margin-top:50px;" id="printtype_area">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row" style="padding:0px 50px">
                                                <div class="col-3">
                                                    <img src="{{asset('assets\images\school.png')}}" style="float:left"
                                                        width="250" height="150">
                                                </div>
                                                <div class="col-6" style="padding-left:80px">
                                                    <p style="font-size:50px;line-height:0.8">
                                                        {{$schoolname->school_name}}-
                                                    </p>
                                                    <p style="font-size:50px;line-height:1.5">
                                                        {{$schoolname->school_postal}}
                                                    </p>
                                                    <p style="font-size:20px;line-height:0.8"><span
                                                            class="exam_name"></span>,<span class="year"></span>-(<span
                                                            class="year"></span> Term
                                                        <span class="term"></span>)
                                                    </p>
                                                    <p style="font-size:20px">
                                                        FORM <span class="form_name"></span> <span
                                                            class="stream_name"></span> -
                                                    </p>
                                                </div>
                                                <div class="col-3" style="padding-top:17px">
                                                    <div style="float:right">
                                                        <p style="text-align:left;font-size:20px">
                                                            {{$schoolname->school_postal}}
                                                        </p>
                                                        <p style="text-align:left;font-size:20px">
                                                            {{$schoolname->school_phone}}
                                                        </p>
                                                        <p style="text-align:left;font-size:20px">
                                                            {{$schoolname->school_email}}
                                                        </p>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12" id="style-default" style="margin-top: 30px;">
                                            <h3 style="text-align:left;padding:5px 20px;font-weight:bold;margin:0px 20px;background-color:gainsboro"
                                                class="firstone">
                                                Form <span class="form_name"></span> <span class="stream_name"></span> -
                                                <span class="exam_name"></span>,<span class="year"></span>-(<span
                                                    class="year"></span> Term <span class="term"></span>)-REPORT
                                            </h3>
                                            <div class="row firstone">
                                                <div class="col-3">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p style="font-size:16px;font-weight:bold">Mean Points
                                                            </p>
                                                            <p style="font-size:25px;color:green;font-weight:bold"
                                                                class='meanpoints'></p>
                                                            <p style="font-weight: bold;float:left;margin-left:65px"
                                                                class="meanpoints_dev">

                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p style="font-size:16px;font-weight:bold">Mean Marks
                                                            </p>
                                                            <p style="font-size:25px;color:green;font-weight:bold"
                                                                class="meanmark"></p>
                                                            <p style="font-weight: bold;float:left;margin-left:60px"
                                                                class="meanmark_dev">

                                                            </p>
                                                        </div>
                                                        <div class="col-12">
                                                            <p style="font-size:16px;font-weight:bold">Mean Grade
                                                            </p>
                                                            <p style="font-size:19px;font-weight:bold"
                                                                class="meangrade">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <icon style="float:left;margin-left:40%;margin-top:5px">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-bar-chart-steps"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z" />
                                                        </svg>
                                                    </icon>
                                                    <p
                                                        style="float:left;margin-left:6px;font-size:20px;font-weight:bold">
                                                        Performance of Form streams
                                                    </p>
                                                    <div class="col-12">

                                                        <div style="height:200px;width:70%;margin:auto">
                                                            <canvas id="performance" style="display: inline;"></canvas>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <p style="font-size:20px;font-weight:bold">Students who sat for
                                                        the
                                                        exam</p>
                                                    <p style="font-size:25px;font-weight:bold">33</p>
                                                    <p style="font-size:25px;font-weight:bold">Students</p>
                                                </div>
                                            </div>
                                            <div class="force-overflow firstone" style="padding:30px">
                                                <P
                                                    style="font-size:25px;text-align:left;padding:0px 20px;background-color: gainsboro;font-weight:bold">
                                                    Subject Statistics</P>
                                                <table class="table table-striped table-bordered"
                                                    style="margin-bottom:40px;border:2px solid black;padding:3px !important">
                                                    <thead>
                                                        <th>Name</th>
                                                        <th>Points</th>
                                                        <th>Change</th>
                                                        <th>Trend</th>
                                                        <th>Grade</th>
                                                    </thead>
                                                    <tbody class="first_table_tbody"></tbody>
                                                </table>
                                                <table class=" table table-striped customtable"
                                                    style="margin-top:15px;border:2px solid black !important;padding:3px !important">
                                                    <P
                                                        style="font-size:25px;text-align:left;padding:0px 10px;background-color: gainsboro;font-weight:bold;margin-bottom:0px">
                                                        CLASS GRADE SUMMARY</P>
                                                    <thead class="second_head_analy">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>A</th>
                                                            <th>A-</th>
                                                            <th>B+</th>
                                                            <th>B</th>
                                                            <th>B-</th>
                                                            <th>C+</th>
                                                            <th>C</th>
                                                            <th>C-</th>
                                                            <th>D+</th>
                                                            <th>D</th>
                                                            <th>D-</th>
                                                            <th>E</th>
                                                            <th>X</th>
                                                            <th>Y</th>
                                                            <th>Entries</th>
                                                            <th>Mean Marks</th>
                                                            <th>MM Dev</th>
                                                            <th>Mean Points</th>
                                                            <th>MP Dev</th>
                                                            <th>Grade</th>
                                                            <th>Teacher</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="second_body_analy">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row firstone" style="padding:0px 30px">
                                                <div class="col-6">
                                                    <p
                                                        style="font-size:19px;text-align:left;padding:3px 20px;background-color: gainsboro;font-weight:bold">
                                                        CLASS SUBJECT MEANS</p>
                                                    <div style="width:60%;margin:auto">
                                                        <canvas id="classsubjectmeans" style="display:inline"></canvas>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <p
                                                        style="font-size:19px;text-align:left;padding:3px 20px;background-color: gainsboro;font-weight:bold">
                                                        OVERAL CLASS STATISTICS</p>
                                                    <div style="width:60%;margin:auto">
                                                        <canvas id="overallclassstatistics"
                                                            style="display:inline"></canvas>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row " style="padding:4px 40px">

                                                <div class="col-12">
                                                    <p
                                                        style="font-size:25px;text-align:left;padding:0px 10px;background-color: gainsboro;font-weight:bold;margin-bottom:0px">
                                                        OVERALL</p>
                                                    <table class="table table-striped  customtable firstone"
                                                        style="margin-bottom:0px;border:2px solid black !important;padding:3px !important">
                                                        <P class="firstone"
                                                            style="font-size:25px;text-align:left;margin-left:10px;font-weight:bold;margin-bottom:0px">
                                                            Grade Summary - Overall</P>
                                                        <thead class="third_head_analy">
                                                            <tr>
                                                                <th style="width:180px;line-height:80%">Form</th>
                                                                <th>A</th>
                                                                <th>A-</th>
                                                                <th>B+</th>
                                                                <th>B</th>
                                                                <th>B-</th>
                                                                <th>C+</th>
                                                                <th>C</th>
                                                                <th>C-</th>
                                                                <th>D+</th>
                                                                <th>D</th>
                                                                <th>D-</th>
                                                                <th>E</th>
                                                                <th>X</th>
                                                                <th>Y</th>
                                                                <th>Entries</th>
                                                                <th>Mean Marks</th>
                                                                <th>MM Dev</th>
                                                                <th>Mean Points</th>
                                                                <th>MP Dev</th>
                                                                <th>Grade</th>
                                                                <th>Teacher</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="third_body_analy">
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-striped customtable"
                                                        style="margin-bottom:0px;border:2px solid black !important;padding:3px !important">
                                                        <P
                                                            style="font-size:25px;text-align:left;font-weight:bold;margin-bottom:0px">
                                                            Top Students - Overall</P>
                                                        <thead class="fourth_head_analy">
                                                            <tr>
                                                                <th>Admno</th>
                                                                <th>Name</th>
                                                                <th>Stream</th>
                                                                <th>Strm Rank</th>
                                                                <th>Ovrl Rank</th>
                                                                <th>Mean Marks</th>
                                                                <th>MM DEV</th>
                                                                <th>Total Marks</th>
                                                                <th>Total Points</th>
                                                                <th>Grade</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fourth_body_analy">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row lasttable" style="margin-top:10px;padding:10px 40px">

                                            </div>
                                            <div class="row firstone">

                                                <div class="col-12">
                                                    <p
                                                        style="font-size:25px;text-align:left;margin-left:50px;font-weight:bold">
                                                        PERFORMANCE OVER TIME
                                                    </p>
                                                    <div style="width:80%;height:400px;margin-left:10%">
                                                        <canvas id="performanceovertime"
                                                            style="display: inline;"></canvas>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="preview_new_report" class="container-fluid"
                                        style="display: none;font-family:Arial, Helvetica, sans-serif">
                                        <div class="row" style="margin-top:10px">
                                            <div class="col-3">
                                                <img src="{{asset('assets\images\school.png')}}"
                                                    style="float:left;margin-top:0px;padding-left:10px" width="250"
                                                    height="150">
                                            </div>
                                            <div class="col-6">
                                                <p style="font-size:38px;line-height:0.8;font-weight:bold">
                                                    {{$schoolname->school_name}}-{{$schoolname->school_postal}}
                                                </p>
                                                <p style="font-size:28px;font-weight:bold;line-height:0.8">FORM
                                                    <span class="form_name"></span> <span class="stream_name"></span> -
                                                    <span class="exam_name"></span>,<span class="year"></span>-(<span
                                                        class="year"></span> Term
                                                    <span class="term"></span>)
                                                </p>
                                            </div>
                                            <div class="col-2">
                                                <p
                                                    style="text-align:left;font-size:20px;font-weight:bold;line-height:0.6;margin-left:20px">
                                                    {{$schoolname->school_postal}}
                                                </p>
                                                <p
                                                    style="text-align:left;font-size:20px;font-weight:bold;line-height:0.6;margin-left:20px">
                                                    {{$schoolname->school_phone}}
                                                </p>
                                                <p
                                                    style="text-align:left;font-size:20px;font-weight:bold;line-height:0.6;margin-left:20px">
                                                    {{$schoolname->school_email}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-12" id="style-default" style="margin-top: 30px;">
                                            <h3 style="text-align:left;padding:10px 20px;font-weight:bold;;"
                                                class="firstone">
                                                Form <span class="form_name"></span> <span class="stream_name"></span> -
                                                <span class="exam_name"></span>,<span class="year"></span>-(<span
                                                    class="year"></span> Term <span class="term"></span>)-REPORT
                                            </h3>
                                            <div class="row firstone">
                                                <div class="col-3" style="padding-left:50px">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p
                                                                style="font-weight:bold;text-align:center;font-size:20px">
                                                                Mean Points</p>
                                                            <p style="font-size:25px;color:green;font-weight:bold;text-align:center"
                                                                class='meanpoints'></p>
                                                            <p style="font-weight: bold;float:left;font-weight:bold;text-align:center;margin-left:30px;font-size:19px"
                                                                class="meanpoints_dev">

                                                            </p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p style="font-weight:bold;font-size:20px">Mean
                                                                Marks
                                                            </p>
                                                            <p style="font-size:25px;color:green;font-weight:bold;text-align:center"
                                                                class="meanmark"></p>
                                                            <p style="font-weight: bold;float:left;font-weight:bold;text-align:center;margin-left:30px;font-size:19px"
                                                                class="meanmark_dev">

                                                            </p>
                                                        </div>
                                                        <div class="col-12">
                                                            <p
                                                                style="font-weight:bold;text-align:center;font-size:20px">
                                                                Mean Grade</p>
                                                            <p style="font-size:19px;font-weight:bold;font-weight:bold;text-align:center"
                                                                class="meangrade"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <icon style="float:left;margin-left:40%;margin-top:5px">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-bar-chart-steps"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z" />
                                                        </svg>
                                                    </icon>
                                                    <p
                                                        style="float:left;margin-left:6px;font-weight:bold;font-size:20px">
                                                        Performance of Form streams
                                                    </p>
                                                    <div class="col-12">

                                                        <div style="height:200px;width:70%;margin:auto" id="test">
                                                            <canvas id="performance_new"
                                                                style="display: inline;"></canvas>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3" style="padding-left:20px">
                                                    <p style="font-weight:bold;font-size:20px;line-height:0.8">
                                                        Students
                                                        who sat for the exam</p>
                                                    <p style="font-size:28px;;font-weight:bold;line-height:0.8">
                                                        24
                                                    </p>
                                                    <p style="font-size:25px;;font-weight:bold;line-height:0.8">
                                                        Students
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="force-overflow firstone" style="padding:30px">
                                                <P
                                                    style="font-size:24px;text-align:left;padding:10px 20px;font-weight:bold;margin-bottom:4px">
                                                    Subject Statistics</P>
                                                <table class="table table-striped " id='ttt'
                                                    style="margin-bottom:40px;border:3px solid black !important;font-weight:bold;">
                                                    <thead>
                                                        <th style="padding:6px !important">Name</th>
                                                        <th style="padding:6px !important">Points</th>
                                                        <th style="padding:6px !important">Change</th>
                                                        <th style="padding:6px !important">Trend</th>
                                                        <th style="padding:6px !important">Grade</th>
                                                    </thead>
                                                    <tbody class="first_table_tbody" style="padding:5px">
                                                    </tbody>
                                                </table>
                                                <table class=" table table-striped customtable"
                                                    style="margin-top:5px;padding:6px !important;border:1px solid black !important;font-weight:bold">
                                                    <P
                                                        style="font-size:25px;text-align:left;padding:10px 20px;font-weight:bold;margin-bottom:0px">
                                                        CLASS GRADE SUMMARY</P>
                                                    <thead class="second_head_analy">
                                                        <tr>
                                                            <th>Subject</th>
                                                            <th>A</th>
                                                            <th>A-</th>
                                                            <th>B+</th>
                                                            <th>B</th>
                                                            <th>B-</th>
                                                            <th>C+</th>
                                                            <th>C</th>
                                                            <th>C-</th>
                                                            <th>D+</th>
                                                            <th>D</th>
                                                            <th>D-</th>
                                                            <th>E</th>
                                                            <th>X</th>
                                                            <th>Y</th>
                                                            <th>Entries</th>
                                                            <th>Mean Marks</th>
                                                            <th>MM Dev</th>
                                                            <th>Mean Points</th>
                                                            <th>MP Dev</th>
                                                            <th>Grade</th>
                                                            <th>Teacher</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="second_body_analy">
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row firstone" style="padding:30px">
                                                <div class="col-6">
                                                    <p
                                                        style="font-size:19px;text-align:left;padding:10px 20px;font-weight:bold">
                                                        CLASS SUBJECT MEANS</p>
                                                    <div id="test1">
                                                        <canvas id="classsubjectmeans_new"
                                                            style="display:inline"></canvas>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <p
                                                        style="font-size:19px;text-align:left;padding:10px 20px;font-weight:bold">
                                                        OVERAL CLASS STATISTICS</p>
                                                    <div id="test2">
                                                        <canvas id="overallclassstatistics_new"
                                                            style="display:inline"></canvas>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row firstone" style="padding:40px">

                                                <div class="col-12">
                                                    <p
                                                        style="font-size:20px;text-align:left;padding:0px 20px;font-weight:bold;margin-bottom:0px">
                                                        OVERALL</p>
                                                    <table class="table table-striped  customtable"
                                                        style="margin-bottom:40px;border:1px solid black !important;font-weight:bold;border-collapse:collapse;font-size:15px">
                                                        <P
                                                            style="font-size:20px;text-align:left;margin-bottom:3px;font-weight:bold;margin-left:13px">
                                                            Grad Summary - Overall</P>
                                                        <thead class="third_head_analy">
                                                            <tr>
                                                                <th style="width:180px">Form</th>
                                                                <th>A</th>
                                                                <th>A-</th>
                                                                <th>B+</th>
                                                                <th>B</th>
                                                                <th>B-</th>
                                                                <th>C+</th>
                                                                <th>C</th>
                                                                <th>C-</th>
                                                                <th>D+</th>
                                                                <th>D</th>
                                                                <th>D-</th>
                                                                <th>E</th>
                                                                <th>X</th>
                                                                <th>Y</th>
                                                                <th>Entries</th>
                                                                <th style="width:60px">MEAN MARKS</th>
                                                                <th>MM Dev</th>
                                                                <th style="width:60px">MEAN POINTS</th>
                                                                <th>MP Dev</th>
                                                                <th>Grade</th>
                                                                <th>Teacher</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="third_body_analy">
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-striped customtable"
                                                        style="margin-bottom:40px;border:1px solid black !important;font-weight:bold">
                                                        <P
                                                            style="font-size:20px;text-align:left;font-weight:bold;margin-bottom:3px">
                                                            TOP STUDENTS - OVERALL</P>
                                                        <thead class="fourth_head_analy">
                                                            <tr>
                                                                <th>Admno</th>
                                                                <th>Name</th>
                                                                <th>Stream</th>
                                                                <th>Strm Rank</th>
                                                                <th>Ovrl Rank</th>
                                                                <th>MEAN MARKS</th>
                                                                <th>MM DEV/th>
                                                                <th>Total Marks</th>
                                                                <th>TPTS</th>
                                                                <th>Grade</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fourth_body_analy">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row lasttable" style="padding:40px">

                                            </div>
                                            <div class="row firstone">

                                                <div class="col-12">
                                                    <p
                                                        style="font-size:20px;text-align:left;margin-left:50px;font-weight:bold;">
                                                        PERFORMANCE OVER TIME
                                                    </p>
                                                    <div style="height:400px;margin-left:20px" id='test3'>
                                                        <canvas id="performanceovertime_new"
                                                            style="display: inline;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="report-forms">
                <div class="col-12" style="background-color:white;padding:20px 20px 0px 20px">
                    <div class="row">
                        <div class="col-12" style="padding:0px 20px">
                            <h4 style="text-align: left;margin-left:20px;float:left">Report Forms </h4>
                            <icon class="up_arrow_report_form">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                                    <path fill-rule="evenodd"
                                        d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                </svg>
                            </icon>
                            <icon class="down_arrow_report_form">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    <path fill-rule="evenodd"
                                        d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </icon>

                        </div>

                    </div>
                    <hr style="margin:0px 20px">
                    <div class="row" id="report_form_first" style="margin-top:15px">
                        <div class="col-md-6" style="padding:0px 40px">
                            <div class="form-group">
                                <label for="select-form" style="float:left;font-weight:bold">Form</label>
                                <select name="select-form"
                                    style="font-size:16px;background-color:white !important;color:black;"
                                    id="select_form_report_form" class="form-control" data-placeholder="Select Form"
                                    required>
                                    <option value="">Select Form</option>
                                    @foreach($form as $val)
                                    <option value={{$val->id}}>{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="padding:0px 40px">
                            <div class="form-group">
                                <label for="select-stream" style="float:left;font-weight:bold">Stream</label>
                                <select name="select-stream" style="font-size:16px;background-color:white !important;"
                                    id="select_stream_report_form" class="form-control"
                                    data-placeholder="Select Stream(Optional)" required>
                                    <option>Select Stream</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="spinner-square"
                                style="margin-top:40px;margin-bottom:30px;float:right;margin-right:20px;display:none">
                                <div class="square-1 square"></div>
                                <div class="square-2 square"></div>
                                <div class="square-3 square"></div>
                            </div>
                        </div>
                        <div class="col-md-12" style="display:none;padding:0px 40px" id="exam_area_report_form">
                            <div class="form-group">
                                <label for="select-exam" style="float:left;font-weight:bold">Exam</label>
                                <select name="select-exam" style="background-color:white !important;font-size:16px"
                                    id="select_exam_report_form" class="form-control"
                                    data-placeholder="Select Stream(Optional)" required>
                                    <option value="">Select Exam</option>
                                    @foreach($exams as $exam)
                                    <option value={{$exam->id}}>{{$exam->name}}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="get_report_form" class="btn btn-primary"
                                    style="float:right;margin-top:30px;margin-bottom:10px;font-size:16px;border-radius:5px;">Get
                                    Report Forms
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12" id="report_form_panel" style="font-family: Arial, Helvetica, sans-serif;">
                    <div class="row ">
                        <div class="col-12" id="spin-div">
                        </div>
                        <div class="col-12" id="option-div">
                            <h4 style="text-align: left;margin-left:20px;float:left">Options </h4>
                            <icon class="up_arrow_option_div">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                                    <path fill-rule="evenodd"
                                        d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                </svg>
                            </icon>
                            <icon class="down_arrow_option_div">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:20px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    <path fill-rule="evenodd"
                                        d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </icon>
                        </div>
                        <div class="col-12">
                            <hr style="margin:0px 20px">
                        </div>
                        <div class="col-12" id="option-panel" style="background-color: white">
                            <div class="container" style="margin-top:50px">
                                <div class="row">
                                    <div class="col-12">
                                        <p style="text-align:left;">Fee Statesments</p>
                                        <p style="text-align: left;"><a
                                                style="color:blue;text-decoration:none;float:left;margin-right:20px">Download
                                            </a>
                                            <icon style="float:left;margin-right:20px"><svg style="color:blue"
                                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                    <path
                                                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                                                </svg>
                                            </icon>
                                            and fill the fees template then upload it below.(Please leave the others
                                            column headers intact )
                                            <span style="color:red">*</span>
                                        </p>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="file" class="form-control" id="customFile" />
                                            </div>
                                            <div class="col-6" style="margin-top:15px">
                                                <p style="text-align: left;">School Closed On:</p>
                                                <div class="md-form md-outline input-with-post-icon datepicker">
                                                    <input placeholder="Select date" type="date" id="example"
                                                        class="form-control">
                                                </div>
                                                <p style="text-align: left;margin-top:20px"> Remarks: </p>
                                                <div style="display: -webkit-box;margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Class Teacher's Remark</label>
                                                </div>
                                                <div style="display: -webkit-box;margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Principal's Remarks
                                                        Rank</label>
                                                </div>
                                                <div style="display: -webkit-box;margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Overall Student Rank</label>
                                                </div>
                                                <div style="margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Stream Student Rank</label>
                                                </div>
                                            </div>
                                            <div class="col-6" style="margin-top:15px">
                                                <p style="text-align: left;">Next Term Begins On:</p>
                                                <div class="md-form md-outline input-with-post-icon datepicker">
                                                    <input placeholder="Select date" type="date" id="example"
                                                        class="form-control">
                                                </div>
                                                <p style="text-align: left;margin-top:20px"> Signatures: </p>
                                                <div style="display: -webkit-box;margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Class Teacher's
                                                        Signatures</label>
                                                </div>
                                                <div style="display: -webkit-box;margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Principal's Signatures</label>
                                                </div>
                                                <div style="display: -webkit-box;margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Parent's signature slot
                                                        others</label>
                                                </div>
                                                <div style="margin-left:30px">
                                                    <input type="checkbox"
                                                        style="margin-left:0px;float:left;margin-top:4px;width:20px;height:20px"
                                                        class="checkbox">
                                                    <label class="label_report_form">Show Crednetials</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="student_card_panel" style="background-color: white;padding-top:30px">
                            <div class="col-12">
                                <div>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle"
                                            style="float:right;;font-size:16px;background-color:#32446B" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Download
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button class="dropdown-item" id="spreedsheet_analy" type="button">
                                                <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-filetype-xls"
                                                        viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM6.472 15.29a1.176 1.176 0 0 1-.111-.449h.765a.578.578 0 0 0 .254.384c.07.049.154.087.25.114.095.028.202.041.319.041.164 0 .302-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .085-.29.387.387 0 0 0-.153-.326c-.101-.08-.255-.144-.462-.193l-.619-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.351-.367 1.068 1.068 0 0 1-.123-.524c0-.244.063-.457.19-.639.127-.181.303-.322.527-.422.225-.1.484-.149.777-.149.305 0 .564.05.78.152.216.102.383.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.625.625 0 0 0-.247-.181.923.923 0 0 0-.369-.068c-.217 0-.388.05-.513.152a.472.472 0 0 0-.184.384c0 .121.048.22.143.3a.97.97 0 0 0 .405.175l.62.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94l1.274-2.007Zm2.727 3.325H4.557v-3.325h-.79v4h2.487v-.675Z" />
                                                    </svg></icon>
                                                <span style="margin-left:10px;">As Spreedsheet</span>
                                            </button>
                                        </div>
                                    </div>
                                    <button class="btn btn-secondary" onclick="fnPrintReport_new_more(event)"
                                        style="margin-right:30px;float:right;;font-size:16px;background-color:#32446B"
                                        type="button" aria-haspopup="true" aria-expanded="false">
                                        Print Format
                                    </button>
                                </div>
                            </div>
                            <div class="container insert_container" style="margin-top:50px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" tab-pane fade" id="merit-lists" style="margin-bottom:30px;margin-top:0px;padding-top:20px">
                <div class="row">
                    <div class="col-12" style="background-color:white;padding-top:35px">
                        <div>
                            <h4 style="text-align: left;margin-left:20px;float:left">
                                Merit List</h4>
                            <icon id="clickable_arr_up">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:33px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M7.646 2.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 3.707 2.354 9.354a.5.5 0 1 1-.708-.708l6-6z" />
                                    <path fill-rule="evenodd"
                                        d="M7.646 6.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 7.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                </svg>
                            </icon>
                            <icon id="clickable_arr_down">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    style="float:right;margin-right:33px;color:#CE9178" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-double-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                    <path fill-rule="evenodd"
                                        d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z" />
                                </svg>
                            </icon>
                        </div>
                        <hr style="margin-top:36px">
                    </div>

                    <div class="col-12" style="background-color:white" id="elem_down">
                        <div class="row" id="input_area">
                            <div class="col-md-6" style="padding-left:40px">
                                <div class="form-group">
                                    <label for="select-form" style="float:left;font-weight:bold">Form</label>
                                    <select name="select-form"
                                        style="font-size:16px;background-color:white !important;color:black;"
                                        class="form-control select_form_metalist" data-placeholder="Select Form">
                                        <option value="">Select Form</option>
                                        @foreach($form as $val)
                                        <option value={{$val->id}}>{{$val->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="padding-right:40px">
                                <div class="form-group">
                                    <label for="select-stream" style="float:left;font-weight:bold">Stream</label>
                                    <select name="select-stream"
                                        style="font-size:16px;background-color:white !important;"
                                        class="form-control select_stream_metalist"
                                        data-placeholder="Select Stream(Optional)">
                                        <option>Select Stream</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="spinner-square"
                                    style="margin-top:39px;margin-bottom:30px;display:none;float:right;margin-right:55px">
                                    <div class="square-1 square"></div>
                                    <div class="square-2 square"></div>
                                    <div class="square-3 square"></div>
                                </div>
                            </div>
                            <div class="col-12" style="display:none;padding:20px 40px" id="exam_area_metalist">
                                <div class="form-group">
                                    <label for="select-exam" style="float:left;font-weight:bold">Exam</label>
                                    <select name="select-exam" style="background-color:white !important;font-size:16px"
                                        id="select_exam_metalist" class="form-control"
                                        data-placeholder="Select Stream(Optional)">
                                        <option value="">Select Exam</option>
                                        @foreach($exams as $exam)
                                        <option value={{$exam->id}}>{{$exam->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="get_metalist_meta" class="btn btn-primary"
                                        style="float:right;margin-top:30px;margin-bottom:10px;font-size:16px;border-radius:5px;">Get
                                        Meta List</button>
                                </div>

                            </div>
                        </div>
                        <div class="row" id="print_arr_meta" style="display:none;margin-top:20px">
                            <div class="col-12" style="background-color:#F5F5F5;padding:30px">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle"
                                        style="float:right;;font-size:16px;background-color:#32446B" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Download
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button class="dropdown-item" id="spreedsheet_meta" type="button">
                                            <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-filetype-xls" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd"
                                                        d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM6.472 15.29a1.176 1.176 0 0 1-.111-.449h.765a.578.578 0 0 0 .254.384c.07.049.154.087.25.114.095.028.202.041.319.041.164 0 .302-.023.413-.07a.559.559 0 0 0 .255-.193.507.507 0 0 0 .085-.29.387.387 0 0 0-.153-.326c-.101-.08-.255-.144-.462-.193l-.619-.143a1.72 1.72 0 0 1-.539-.214 1.001 1.001 0 0 1-.351-.367 1.068 1.068 0 0 1-.123-.524c0-.244.063-.457.19-.639.127-.181.303-.322.527-.422.225-.1.484-.149.777-.149.305 0 .564.05.78.152.216.102.383.239.5.41.12.17.186.359.2.566h-.75a.56.56 0 0 0-.12-.258.625.625 0 0 0-.247-.181.923.923 0 0 0-.369-.068c-.217 0-.388.05-.513.152a.472.472 0 0 0-.184.384c0 .121.048.22.143.3a.97.97 0 0 0 .405.175l.62.143c.217.05.406.12.566.211a1 1 0 0 1 .375.358c.09.148.135.335.135.56 0 .247-.063.466-.188.656a1.216 1.216 0 0 1-.539.439c-.234.105-.52.158-.858.158-.254 0-.476-.03-.665-.09a1.404 1.404 0 0 1-.478-.252 1.13 1.13 0 0 1-.29-.375Zm-2.945-3.358h-.893L1.81 13.37h-.036l-.832-1.438h-.93l1.227 1.983L0 15.931h.861l.853-1.415h.035l.85 1.415h.908L2.253 13.94l1.274-2.007Zm2.727 3.325H4.557v-3.325h-.79v4h2.487v-.675Z" />
                                                </svg></icon>
                                            <span style="margin-left:10px;">As
                                                Spreedsheet</span>
                                        </button>
                                        <button class="dropdown-item" id="pdf_meta" type="button">
                                            <icon><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-file-earmark-pdf"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                                    <path
                                                        d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                                                </svg></icon>
                                            <span style="margin-left:10px;">As
                                                PDF</span>
                                        </button>
                                    </div>
                                </div>
                                <button class="btn btn-secondary" id="printtype_meta"
                                    style="margin-right:30px;float:right;;font-size:16px;background-color:#32446B"
                                    type="button" aria-haspopup="true" aria-expanded="false">
                                    Print Format
                                </button>
                            </div>
                            <div class="col-md-12">

                                <div class=" scrollbar " id="style-default">
                                    <!-- <div id="testtableshow"> -->
                                    <p style="margin-top:20px;text-align:left;font-size:18px">
                                        FORM <span class="form_name"></span>
                                        <span class="stream_name"></span> - <span class="exam_name"></span>,<span
                                            class="year"></span>-(<span class="year"></span>
                                        Term
                                        <span class="term"></span>)
                                    </p>
                                    <table style="width:1800px" id="datatable"
                                        class="metalist_area table table-striped">

                                    </table>
                                    <!-- </div> -->
                                </div>
                                <div class="row" style="margin-top:150px;display:none" id="printtype_area_meta">
                                    <div class="col-12" style="background-color:#F5F5F5; padding:30px;">
                                        <button class="btn btn-secondary" id="hideprint"
                                            style="margin-right:30px;float:left;;font-size:16px;background-color:#32446B"
                                            type="button" aria-haspopup="true" aria-expanded="false">
                                            Hide Print
                                        </button>
                                        <button class="btn btn-secondary" id="print" onclick="fnPrintReport_new(event)"
                                            style="float:right;;font-size:16px;background-color:#32446B" type="button"
                                            aria-haspopup="true" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                style="margin-top: 5px;float: left;margin-right: 6;"
                                                fill=" currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                                <path
                                                    d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                            </svg> Print
                                        </button>
                                    </div>
                                    <div class="row" style="padding:45px">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-4">
                                                    <img src="{{asset('assets\images\school.png')}}" style="float:left"
                                                        width="250" height="150">
                                                </div>
                                                <div class="col-5">
                                                    <h1>{{$schoolname->school_name}}-{{$schoolname->school_postal}}
                                                    </h1>
                                                    <p>FORM <span class="form_name"></span>
                                                        <span class="stream_name"></span>
                                                        - <span class="exam_name"></span>,<span
                                                            class="year"></span>-(<span class="year"></span>
                                                        Term
                                                        <span class="term"></span>)
                                                    </p>
                                                </div>
                                                <div class="col-2" style="padding-top:15px">
                                                    <p style="text-align:left;line-height:0.1">
                                                        {{$schoolname->school_postal}}
                                                    </p>
                                                    <p style="text-align:left;line-height:0.1">
                                                        {{$schoolname->school_phone}}
                                                    </p>
                                                    <p style="text-align:left;line-height:0.1">
                                                        {{$schoolname->school_email}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="style-default" style="margin-top: 20px;overflow:auto">

                                            <table class="metalist_area table  table-striped"
                                                style="padding:6px !important;">
                                                <thead class="meta_thead"></thead>
                                                <tbody class="meta_tbody"></tbody>
                                            </table>
                                            <table class="metalist_area table  table-striped"
                                                style="padding:6px !important">
                                                <thead class="second_head">
                                                    <tr>
                                                        <th colspan="19">Grade Break
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Form</th>
                                                        <th>A</th>
                                                        <th>A-</th>
                                                        <th>B+</th>
                                                        <th>B</th>
                                                        <th>B-</th>
                                                        <th>C+</th>
                                                        <th>C</th>
                                                        <th>C-</th>
                                                        <th>D+</th>
                                                        <th>D</th>
                                                        <th>D-</th>
                                                        <th>E</th>
                                                        <th>X</th>
                                                        <th>Y</th>
                                                        <th>Entries</th>
                                                        <th>Mean Marks</th>
                                                        <th>Mean Points</th>
                                                        <th>Grade</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="second_body">
                                                </tbody>
                                            </table>
                                            <table class="metalist_area table  table-striped"
                                                style="padding:6px !important">
                                                <thead class="third_head">

                                                    <tr>
                                                        <th>subject</th>
                                                        <th>A</th>
                                                        <th>A-</th>
                                                        <th>B+</th>
                                                        <th>B</th>
                                                        <th>B-</th>
                                                        <th>C+</th>
                                                        <th>C</th>
                                                        <th>C-</th>
                                                        <th>D+</th>
                                                        <th>D</th>
                                                        <th>D-</th>
                                                        <th>E</th>
                                                        <th>X</th>
                                                        <th>Y</th>
                                                        <th>Entries</th>
                                                        <th>Mean Marks</th>
                                                        <th>Mean Points</th>
                                                        <th>Grade</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="third_body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div id="preview_new" class="container-fluid"
                                        style="display: none;font-family:Arial, Helvetica, sans-serif">
                                        <div class="row" style="margin-top:10px">
                                            <div class="col-4">
                                                <img src="{{asset('assets\images\school.png')}}"
                                                    style="float:left;margin-top:0px;padding-left:10px" width="200"
                                                    height="120">
                                            </div>
                                            <div class="col-6">
                                                <p style="font-size:30px;font-weight:bold;line-height:0.8">
                                                    {{$schoolname->school_name}}-{{$schoolname->school_postal}}
                                                </p>
                                                <p style="font-size:19px;line-height:0.6">
                                                    FORM <span class="form_name"></span>
                                                    <span class="stream_name"></span>
                                                    -
                                                    <span class="exam_name"></span>,<span class="year"></span>-(<span
                                                        class="year"></span>
                                                    Term
                                                    <span class="term"></span>)
                                                </p>
                                            </div>
                                            <div class="col-2">
                                                <p
                                                    style="text-align:left;font-size:14px;font-weight:bold;line-height:0.6">
                                                    {{$schoolname->school_postal}}
                                                </p>
                                                <p
                                                    style="text-align:left;font-size:14px;font-weight:bold;line-height:0.6">
                                                    {{$schoolname->school_phone}}
                                                </p>
                                                <p
                                                    style="text-align:left;font-size:14px;font-weight:bold;line-height:0.6">
                                                    {{$schoolname->school_email}}
                                                </p>
                                            </div>
                                        </div>

                                        <div id="style-default" class="row" style="margin-top: 10px;">
                                            <div class="col-12">
                                                <table class="metalist_area table-striped"
                                                    style="padding:6px !important;border-collapse:collapse;font-weight:bold;font-size:12px">
                                                    <thead class="meta_thead" id="first_head"></thead>
                                                    <tbody class="meta_tbody" id="first_body"></tbody>
                                                </table>
                                                <table class="metalist_area table-striped"
                                                    style="padding:6px !important;width:100%;border-collapse:collapse;font-weight:bold;margin-top:10px;font-size:12px">
                                                    <thead class="second_head">
                                                        <tr>
                                                            <th colspan="19" style="text-align:center">
                                                                Grade
                                                                Break
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Form</th>
                                                            <th>A</th>
                                                            <th>A-</th>
                                                            <th>B+</th>
                                                            <th>B</th>
                                                            <th>B-</th>
                                                            <th>C+</th>
                                                            <th>C</th>
                                                            <th>C-</th>
                                                            <th>D+</th>
                                                            <th>D</th>
                                                            <th>D-</th>
                                                            <th>E</th>
                                                            <th>X</th>
                                                            <th>Y</th>
                                                            <th>Entries</th>
                                                            <th>Mean Marks</th>
                                                            <th>Mean Points</th>
                                                            <th>Grade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="second_body">
                                                    </tbody>
                                                </table>
                                                <table class="metalist_area table-striped"
                                                    style="padding:6px !important;font-size:12px;width:100%;margin-top:40px;border-collapse:collapse;font-weight:bold;margin-top:12px">
                                                    <thead class="third_head">
                                                        <tr>
                                                            <th colspan="19" style="text-align:center">
                                                                Class
                                                                Grade
                                                                Summary</th>
                                                        </tr>
                                                        <tr>
                                                            <th>subject</th>
                                                            <th>A</th>
                                                            <th>A-</th>
                                                            <th>B+</th>
                                                            <th>B</th>
                                                            <th>B-</th>
                                                            <th>C+</th>
                                                            <th>C</th>
                                                            <th>C-</th>
                                                            <th>D+</th>
                                                            <th>D</th>
                                                            <th>D-</th>
                                                            <th>E</th>
                                                            <th>X</th>
                                                            <th>Y</th>
                                                            <th>Entries</th>
                                                            <th>Mean Marks</th>
                                                            <th>Mean Points</th>
                                                            <th>Grade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="third_body">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="transcripts">

            </div>
            <div class="tab-pane fade" id="leaving-certificates">

            </div>
        </div>
    </div>
</div>
@include('partials.js.class_index')
@include('partials.js.class_list')
@include('partials.js.group_index')
@include('partials.js.report_forms')
@endsection