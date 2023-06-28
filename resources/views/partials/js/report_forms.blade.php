<script>
$(".up_arrow_report_form").hide()
$(".down_arrow_report_form").show()
$("#report_form_first").hide()
$(".up_arrow_report_form").on("click", () => {
    console.log("this is okay]");
    $(".down_arrow_report_form").show()
    $(".up_arrow_report_form").hide()
    $("#report_form_first").hide(300)
})
$(".down_arrow_report_form").on("click", () => {
    $(".down_arrow_report_form").hide()
    $(".up_arrow_report_form").show()
    $("#report_form_first").show(300)
})


$(".up_arrow_option_div").hide()
$(".down_arrow_option_div").show()
$("#option-panel").hide()
$(".up_arrow_option_div").on("click", () => {
    $(".down_arrow_option_div").show()
    $(".up_arrow_option_div").hide()
    $("#option-panel").hide(300)
})
$(".down_arrow_option_div").on("click", () => {
    $(".down_arrow_option_div").hide()
    $(".up_arrow_option_div").show()
    $("#option-panel").show(300)
})


$("#select_form_report_form").on("click", (e) => {
    form_id = e.target.value;
    if (form_id != "") {
        $.post("get_stream_according_to_form", {
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res)
            streams_arr = res.streams
            option_arr = "<option>Select Stream</option>";
            for (streams_arr_entity of streams_arr) {
                option_arr +=
                    `<option value="${streams_arr_entity.id}">${streams_arr_entity.stream}</option>`
            }
            $("#select_stream_report_form").children().remove();
            $("#select_stream_report_form").append(option_arr);
        })
    }
})

$("#select_stream_report_form").on("click", (e) => {
    stream_id = e.target.value;
    if (stream_id != "") {
        $("#exam_area_report_form").hide();
        $(".spinner-square").show();
        setTimeout(() => {
            $(".spinner-square").hide();
            $("#exam_area_report_form").show(600);
        }, 3000);
    }

})

$("#get_report_form").on("click", () => {
    $("#report_form_first").hide()
    str =
        '<div class="col-12" id="spinner_area" style="margin-top:70px"><p stye="font-size:25px;">Generating Report Forms , Please wait ....</p><div class="spinner-square" style="margin:auto"><div class="square-1 square"></div><div class="square-2 square"></div><div class="square-3 square"></div></div></div>'
    $("#spin-div").append(str)
    setTimeout(() => {
        $("#spinner_area").hide();
        $("#print_arr").show(600);
    }, 3000);
    stream_id = $("#select_stream_report_form").val();
    exam_id = $("#select_exam_report_form").val();
    form_id = $("#select_form_report_form").val();
    $.post("get_meta_data_for_report_form", {
        stream_id: stream_id,
        exam_id: exam_id,
        form_id: form_id
    }, (res) => {
        res = JSON.parse(res);
        console.log(res.data);
        showDataOn(res.data);
    })
})

const showDataOn = (data) => {
    str = "";
    for (studentdata of data) {
        str += ` <div class="row">
                                    <div class="col-12">
                                        <div class="row" style="border-bottom:1px solid green;padding-bottom:15px">
                                            <div class="col-9">
                                                <p style="font-size:30px;text-align:left;margin-bottom:20px">
                                                    {{$schoolname->school_name}}-{{$schoolname->school_postal}}
                                                </p>
                                                <p style="text-align:left;font-size:16px;line-height:0.8">
                                                    {{$schoolname->school_postal}}
                                                </p>
                                                <p style="text-align:left;font-size:16px;line-height:0.8">
                                                    {{$schoolname->school_phone}}
                                                </p>
                                                <p style="text-align:left;font-size:16px;line-height:0.8">
                                                    {{$schoolname->school_email}}
                                                </p>
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('assets/images/school.png')}}" style="float:left"
                                                    width="250" height="150">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:20px">
                                            <div class="col-6">
                                                <p style="font-size:18px">Academic Report Form - Form 2 CAT 1 - (2023-Term 1)</p>
                                                <div class="row">
                                                    <div class="col-6" style="padding-top:15px">
                                                        <img style="display:inline-block;border-radius:5px"
                                                            src="{{asset('assets/images/avatar_blue.png')}}"
                                                            style="float:left" width="150" height="150">
                                                        <p style="text-align:left;margin-left:40px;font-size:16px">NAME:${studentdata.name}</p>
                                                        <p style="text-align:left;margin-left:40px;font-size:16px">ADMNO:${studentdata.admno}</p>
                                                        <p style="text-align:left;margin-left:40px;font-size:16px">${studentdata.stream_name}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div>
                                                                    <p style="font-size:16px">Total Marks</p>
                                                                    <p style="font-size:20px"><span style="color:green">${studentdata.Total_got_marks}</span>/${studentdata.current_total_maxmarks}</p>
                                                                    <p style="font-size:16px">${studentdata.deviation_marks}</p>
                                                                </div>
                                                                <div>
                                                                    <p style="font-size:16px">Total Points</p>
                                                                    <p style="font-size:20px"><span style="color:green">${studentdata.totalpoint}</span>/84</p>
                                                                    <p style="font-size:16px">${studentdata.dev_point}</p>
                                                                </div>
                                                                <div>
                                                                    <p style="font-size:16px">Overall Position</p>
                                                                    <p style="font-size:20px"><span style="color:green">${studentdata.over_order}</span>/${studentdata.total_memeber_form}</p>
                                                                    <p style="font-size:16px">2</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div>
                                                                    <p style="font-size:16px">Mean Marks</p>
                                                                    <p style="font-size:20px;color:green">60%</p>
                                                                    <p style="font-size:16px">5.2</p>
                                                                </div>
                                                                <div>
                                                                    <p style="font-size:16px">Mean Grade</p>
                                                                    <p style="font-size:20px">${studentdata.meangrade}</p>
                                                                </div>
                                                                <div>
                                                                    <p style="font-size:16px">Stream Position</p>
                                                                    <p style="font-size:20px"><span style="color:green">${studentdata.streamorder}</span>/${studentdata.total_member_stream}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        style="margin-left:220px;float:left;margin-top:3px" width="16"
                                                        height="16" fill="currentColor" class="bi bi-bar-chart-steps"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z">
                                                        </path>
                                                    </svg>
                                                    Subject Performance - Student vs Class
                                                </p>
                                                <div>
                                                    <canvas id="subject_performance" style="display: inline;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>SUBJECT</th>
                                                            <th>MARKS</th>
                                                            <th>DEV.</th>
                                                            <th>GRADE</th>
                                                            <th>RANK</th>
                                                            <th>COMMENT</th>
                                                            <th>TEACHER</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>`
        for (eachtable of studentdata.tabledata) {
            str += `<tr><td>${eachtable.subjectName}</td><td>${eachtable.mark}</td><td>${eachtable.dev}</td><td>${eachtable.grade}</td>
            <td>${eachtable.rank}</td><td>${eachtable.comment}</td><td>${eachtable.teachername}</td></tr>`
        }
        str += ` </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12" style="margin-top:20px">
                                                <p style="text-align: left;">Muinui Simon Ndimi's Performance Over Time
                                                </p>
                                                <div>
                                                    <canvas id="performance_overtime">
                                                </div>
                                            </div>
                                            <div class="col-12" id="class_teacher_remark">
                                                <div style=" display: flex;  justify-content: space-between;">
                                                    <div style=" margin-right: auto;font-weight:bold">Class Teacher
                                                        Remarks - Maina</div>
                                                    <div style="margin-left: auto;font-weight:bold">Signature</div>
                                                </div>
                                                <p style="text-align: left;">Aim higher, you are capable of doing much
                                                </p>
                                            </div>
                                            <div class="col-12" id="principal_remark">
                                                <div style=" display: flex;  justify-content: space-between;">
                                                    <div style=" margin-right: auto;font-weight:bold">Principal's
                                                        Remarks - Mr.Marcheria</div>
                                                    <div style="margin-left: auto;font-weight:bold">Signature</div>
                                                </div>
                                                <p style="text-align: left;">Good work but aim higher, you have the
                                                    potential to do better</p>
                                            </div>
                                            <div class="col-12" style="margin-top:20px">
                                                <p style="font-weight:bold">Download Zeraki Analytics for detailed
                                                    academic report and
                                                    Zeraki Learning to improve your child's grades.
                                                    Zeraki Analytics and Learning Username:1205@bibirionihigh
                                                </p>
                                                <div style="margin-top:100px;text-align:right">
                                                    <p>Parent's Signature:.......................</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
    }
    $(".insert_container").append(str);
}
</script>