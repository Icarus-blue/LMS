<script>
var checkbox1 = document.getElementById('classteacherremark');
var checkbox2 = document.getElementById('principaremark');
var checkbox3 = document.getElementById('overallstudentrank');
var checkbox4 = document.getElementById('streamstudentrank');
var checkbox5 = document.getElementById('classteachersig');
var checkbox6 = document.getElementById('principalsig');
var checkbox7 = document.getElementById('parentsig');
var checkbox8 = document.getElementById('credential');
// Check the first three checkboxes
checkbox1.checked = true;
checkbox2.checked = true;
checkbox3.checked = true;
checkbox4.checked = true;
checkbox5.checked = true;
checkbox6.checked = true;
checkbox7.checked = true;
checkbox8.checked = true;

var numarr = 0;
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

const downloadTemplate = () => {
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        type: 'get',
        url: "{{route('download_template_excel')}}",
        data: {

        },
        success: function(result, status, xhr) {

            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);
            var filename = (matches != null && matches[1] ? matches[1] : 'template.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        }
    });
}

function generateData() {
    var data = [];
    for (var i = 1; i <= 4; i++) {
        data.push(Math.floor(Math.random() * 100));
    }
    return data;
}
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

function check_biger(data) {
    if (Number(data) < 0) {
        return ` <icon >
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:25px" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8000000000000009,0,0,0.8000000000000009,1.5999999999999917,1.5999999999999917)"><path fill="#dd790b" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg>
                                                                </icon>`;
    } else if (Number(data) > 0) {
        return `<icon >
        <svg xmlns="http://www.w3.org/2000/svg" style='width:17px;height:23px' version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8000000000000009,-9.797174393178837e-17,-9.797174393178837e-17,-0.8000000000000009,1.5999999999999925,14.400000000000006)"><path fill="#056b08" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg>
                                                                </icon>`;
    } else {
        return `<icon >
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512;width:15px;height:25px" xml:space="preserve" class=""><g transform="matrix(0.9299999999999996,0,0,0.9299999999999996,1.1224774932861408,1.1204790496826256)"><path fill="#38a9ff" d="m29.778 15.293-9.071-9.071A1.01 1.01 0 0 0 19 6.929V11H3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h16v4.071q.18.978 1 1a.999.999 0 0 0 .707-.293l9.071-9.071a1 1 0 0 0 0-1.414z" data-name="01 Right" data-original="#ff3c38" class=""></path></g></svg>
                                                                </icon>`;
    }
}

function check_biger_new(data) {
    if (Number(data) < 0) {
        return ` <icon style="float:right">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:18px;height:25px" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8000000000000009,0,0,0.8000000000000009,1.5999999999999917,1.5999999999999917)"><path fill="#dd790b" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg>
                                                                </icon>`;
    } else if (Number(data) > 0) {
        return `<icon style="float:right">
        <svg xmlns="http://www.w3.org/2000/svg" style='width:17px;height:23px' version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8000000000000009,-9.797174393178837e-17,-9.797174393178837e-17,-0.8000000000000009,1.5999999999999925,14.400000000000006)"><path fill="#056b08" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg>
                                                                </icon>`;
    } else {
        return `<icon style="float:right">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512;width:15px;height:25px" xml:space="preserve" class=""><g transform="matrix(0.9299999999999996,0,0,0.9299999999999996,1.1224774932861408,1.1204790496826256)"><path fill="#38a9ff" d="m29.778 15.293-9.071-9.071A1.01 1.01 0 0 0 19 6.929V11H3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h16v4.071q.18.978 1 1a.999.999 0 0 0 .707-.293l9.071-9.071a1 1 0 0 0 0-1.414z" data-name="01 Right" data-original="#ff3c38" class=""></path></g></svg>
                                                                </icon>`;
    }
}

// $("#select_stream_report_form").on("click", (e) => {
//     stream_id = e.target.value;
//     if (stream_id != "") {
//         $("#exam_area_report_form").hide();
//         $(".spinner-square").show();
//         setTimeout(() => {
//             $(".spinner-square").hide();
//             $("#exam_area_report_form").show(600);
//         }, 3000);
//     }

// })

function validateInput(input) {
    if (!input.checkValidity()) {
        input.classList.add('is-invalid');
    } else {
        input.classList.remove('is-invalid');
    }
}

$("#get_report_form").on("click", () => {
    const input1 = document.getElementById('select_form_report_form');
    const input2 = document.getElementById('select_stream_report_form');
    const input3 = document.getElementById('select_exam_report_form');
    stream_id = input2.value;
    exam_id = input3.value;
    form_id = input1.value;
    input1.addEventListener('blur', function() {
        validateInput(input1);
    });

    input2.addEventListener('blur', function() {
        validateInput(input2);
    });

    input3.addEventListener('blur', function() {
        validateInput(input3);
    });

    validateInput(input1);
    validateInput(input2);
    validateInput(input3);
    if (form_id.trim() !== '' && exam_id.trim() !== '' && stream_id.trim() !== '') {
        $("#report_form_first").hide()
        str =
            '<div class="col-12" id="spinner_area" style="margin-top:70px"><p stye="font-size:25px;">Generating Report Forms , Please wait ....</p><div class="spinner-square" style="margin:auto"><div class="square-1 square"></div><div class="square-2 square"></div><div class="square-3 square"></div></div></div>'
        $("#spin-div").append(str)
        setTimeout(() => {
            $("#spinner_area").hide();
            $("#print_arr").show(600);
        }, 3000);

        $.post("get_meta_data_for_report_form", {
            stream_id: stream_id,
            exam_id: exam_id,
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res);
            $("#student_card_panel").show();
            showDataOn(res.data);
            showDataOn_orssa(res.data);
            numarr = res.data.length;
        })
    }

})

const showDataOn = (data) => {
    str = "";
    i = 0;
    for (studentdata of data) {
        str +=
            ` <div class="row" ">
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
                                                <img src="{{asset('assets/images/school.png')}}" style="float:right"
                                                    width="150" height="150">
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
                                                        <p style="text-align:left;margin-left:40px;font-size:14px;margin-top:20px;font-weight:bold">Name:${titleCase(studentdata.name)}</p>
                                                        <p style="text-align:left;margin-left:40px;font-size:14px;font-weight:bold">Admission Number:${studentdata.admno}</p>
                                                        <p style="text-align:left;margin-left:40px;font-size:14px;font-weight:bold">${titleCase(studentdata.stream_name)}</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div style="float:left">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.8">Total Marks</p>
                                                                    <p style="font-size:20px;line-height:0.8"><span style="color:green">${studentdata.Total_got_marks}</span>/${studentdata.current_total_maxmarks}</p>
                                                                    <div style="padding:0px 20px"><span style="font-size:16px;font-weight:bold;line-height:0.8">${studentdata.deviation_marks}</span>`
        let middlepart = check_biger_new(studentdata.deviation_marks);
        str += middlepart +
            `</div></div>
                                                                <div>
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.8">Mean Marks</p>
                                                                    <p style="font-size:20px;color:green;line-height:0.8">${getInt(1,70)}%</p>
                                                                    <div  style="float:left;margin-left:60px"><span style="font-size:16px;font-weight:bold;line-height:0.8">5.2</span>`
        let middlepart2 = check_biger_new(5.2);
        str += middlepart2 +
            `</div>
                                                                </div></div>
                                                                <div class="col-12" style="padding:0px"><hr style='margin:10px'></div>
                                                                <div class="col-12">
                                                                <div style="float:left">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.8">Total Points</p>
                                                                    <p style="font-size:20px;line-height:0.8"><span style="color:green">${studentdata.totalpoint}</span>/84</p>
                                                                    <div style="padding:0px 30px"><span style="font-size:16px;font-weight:bold;line-height:0.8">${studentdata.dev_point}</span>`
        let middlepart0 = check_biger_new(studentdata.dev_point);
        str += middlepart0 +
            `</div>
                                                                </div>
                                                                <div>
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.8">Mean Grade</p>
                                                                    <p style="font-size:20px;line-height:0.8">${ran()}</p>
                                                                </div>
                                                                </div>
                                                                <div class="col-12" style="padding:0px"><hr style='margin:10px'></div>
                                                            <div class="col-12">
                                                            <div class="overpos" style="float:left">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.8">Overall Position</p>
                                                                    <p style="font-size:20px;line-height:0.8"><span style="color:green">${studentdata.over_order}</span>/${studentdata.total_memeber_form}</p>
                                                                    <div style="padding:0px 50px"><span style="font-size:16px;font-weight:bold;line-height:0.8">2</span>`
        let middlepart1 = check_biger_new(2);
        str += middlepart1 +
            `</div>
                                                                </div>
                                                                <div class="streampos" style="float:right">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.8">Stream Position</p>
                                                                    <p style="font-size:20px;line-height:0.8"><span style="color:green">${studentdata.streamorder}</span>/${studentdata.total_member_stream}</p>
                                                                    <div style="padding:0px 50px"><span style="font-size:16px;font-weight:bold;line-height:0.8">6</span>`
        let middlepart33 = check_biger_new(2);
        str += middlepart33 +
            `</div>
                                                                </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        style="margin-left:100px;float:left;margin-top:3px" width="16"
                                                        height="16" fill="currentColor" class="bi bi-bar-chart-steps"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z">
                                                        </path>
                                                    </svg>
                                                    Subject Performance - Student vs Class
                                                </p>
                                                <div >
                                                    <canvas id="subject_performance${i}" style="display: inline;"></canvas>
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
            str += `<tr><td>${eachtable.subjectName}</td><td>${eachtable.mark}</td><td>${eachtable.dev}`
            let middlepart3 = check_biger_new(Number(eachtable.dev));
            str += middlepart3 + `
            </td><td>${eachtable.grade}</td>
            <td>${eachtable.rank}</td><td>${eachtable.comment}</td><td>${eachtable.teachername}</td></tr>`
        }
        str += ` </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12" style="margin-top:20px;margin-bottom:40px">
                                                <p style="text-align: left;">Muinui Simon Ndimi's Performance Over Time
                                                </p>
                                                <div class="col-7" >
                                                    <canvas id="performance_overtime${i}" >
                                                </div>
                                            </div>
                                            <div class="col-12 " style="margin-bottom:40px">
                                                <div style=" display: flex;  justify-content: space-between;">
                                                    <div style=" margin-right: auto;font-weight:bold" >Class Teacher
                                                        Remarks - Maina</div>
                                                    <div style="margin-left: auto;font-weight:bold" >Signature</div>
                                                </div>
                                                <p style="text-align: left;"  class="class_teacher_remark">Aim higher, you are capable of doing much
                                                </p>
                                            </div>
                                            <div class="col-12 " style="margin-bottom:40px">
                                                <div style=" display: flex;  justify-content: space-between;">
                                                    <div style=" margin-right: auto;font-weight:bold" >Principal's
                                                        Remarks - Mr.Marcheria</div>
                                                    <div style="margin-left: auto;font-weight:bold;">Signature</div>
                                                </div>
                                                <p style="text-align: left;" class="principal_remark">Good work but aim higher, you have the
                                                    potential to do better</p>
                                            </div>
                                            <div class="col-12" style="margin-top:20px;margin-bottom:40px">
                                                <p style="font-weight:bold">Download Zeraki Analytics for detailed
                                                    academic report and
                                                    Zeraki Learning to improve your child's grades.
                                                    Zeraki Analytics and Learning Username:1205@bibirionihigh
                                                </p>
                                                <div style="margin-top:100px;text-align:right;display:none" class="parentsig">
                                                    <p>Parent's Signature:.......................</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
        i++;
    }

    $(".insert_container").append(str);
    i = 0;
    for (studentdata of data) {
        var canvas = document.getElementById("subject_performance" + i);
        // Create a new chart object

        var chart = new Chart(canvas, {
            type: "line",
            data: {
                labels: studentdata.subjectNameArr,
                datasets: [{
                    label: "Grades",
                    data: studentdata.subjectMarkArr,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "rgba(75,192,192,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(75,192,192,1)",
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "Grades for English and Mathematics"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        i++;
    }

    j = 0;
    for (studentdata of data) {
        // Data for the chart
        var data = {
            labels: ['Form 1,Term 1,2022', 'Form 1,Term 2,2022', 'Form 1,Term 3,2022', 'Form 2,Term 1,2023'],
            datasets: [{
                label: 'Data',
                data: generateData(),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                barThickness: 60
            }]
        };

        // Options for the chart
        var options = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legend: {
                display: false
            }
        };
        var ctx = document.getElementById('performance_overtime' + j).getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
        j++
    }

}
const showDataOn_orssa = (data) => {
    str = "";
    i = 0;
    for (studentdata of data) {
        str +=
            `<div class="container-fluid" style="padding:25px"> <div class="row">
                                    <div class="col-12">
                                        <div class="row" style="border-bottom:1px solid green;padding-bottom:15px">
                                            <div class="col-9">
                                                <p style="font-size:30px;text-align:left;margin-bottom:20px;">
                                                    {{$schoolname->school_name}}-{{$schoolname->school_postal}}
                                                </p>
                                                <p style="text-align:left;font-size:16px;">
                                                    {{$schoolname->school_postal}}
                                                </p>
                                                <p style="text-align:left;font-size:16px;">
                                                    {{$schoolname->school_phone}}
                                                </p>
                                                <p style="text-align:left;font-size:16px;">
                                                    {{$schoolname->school_email}}
                                                </p>
                                            </div>
                                            <div class="col-3">
                                                <img src="{{asset('assets/images/school.png')}}" style="float:right"
                                                    width="150" height="150">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top:20px">
                                            <div class="col-6">
                                                <p style="font-size:18px">Academic Report Form - Form 2 CAT 1 - (2023-Term 1)</p>
                                                <div class="row">
                                                    <div class="col-5" style="padding-top:15px">
                                                        <img style="display:inline-block;border-radius:5px"
                                                            src="{{asset('assets/images/avatar_blue.png')}}"
                                                            style="float:left" width="150" height="150">
                                                        <p style="text-align:left;font-size:14px;margin-top:20px;font-weight:bold;line-height:0.8">Name:${titleCase(studentdata.name)}</p>
                                                        <p style="text-align:left;font-size:14px;font-weight:bold;line-height:0.8">Admission Number:${studentdata.admno}</p>
                                                        <p style="text-align:left;font-size:14px;font-weight:bold;line-height:0.8">${titleCase(studentdata.stream_name)}</p>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div style="float:left">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.4">Total Marks</p>
                                                                    <p style="font-size:20px;line-height:0.4;margin-bottom:11px"><span style="color:green">${studentdata.Total_got_marks}</span>/${studentdata.current_total_maxmarks}</p>
                                                                    <div style="padding:0px 20px"><span style="font-size:16px;font-weight:bold;line-height:0.8">${studentdata.deviation_marks}</span>`
        let middlepart = check_biger(studentdata.deviation_marks);
        str += middlepart +
            `</div></div>
                                                                <div style="float:right">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.4">Mean Marks</p>
                                                                    <p style="font-size:20px;color:green;line-height:0.4;padding-left:20px;margin-bottom:11px">${getInt(1,70)}%</p>
                                                                    <div  style="float:left;padding-left:20px"><span style="font-size:16px;font-weight:bold;line-height:0.8">5.2</span>`
        let middlepart2 = check_biger(5.2);
        str += middlepart2 +
            `</div>
                                                                </div></div>
                                                              <div class="col-12" style="padding:0px"><hr style='margin:10px'></div>
                                                                <div class="col-12">
                                                                <div style="float:left">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.4">Total Points</p>
                                                                    <p style="font-size:20px;line-height:0.4;padding-left:20px;margin-bottom:11px"><span style="color:green">${studentdata.totalpoint}</span>/84</p>
                                                                    <div style="padding:0px 30px"><span style="font-size:16px;font-weight:bold;line-height:0.8">${studentdata.dev_point}</span>`
        let middlepart0 = check_biger(studentdata.dev_point);
        str += middlepart0 +
            `</div>
                                                                </div>
                                                                <div style="float:right">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.4">Mean Grade</p>
                                                                    <p style="font-size:20px;line-height:0.4;padding-left:25px">${ran()}</p>
                                                                </div>
                                                                </div>
                                                                <div class="col-12" style="padding:0px"><hr style='margin:10px'></div>
                                                            <div class="col-12" style='padding:0px'>
                                                            <div class="overpos" style="float:left">
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.4">Overall Position</p>
                                                                    <p style="font-size:20px;line-height:0.4;padding-left:30px;margin-bottom:11px"><span style="color:green">${studentdata.over_order}</span>/${studentdata.total_memeber_form}</p>
                                                                    <div style="padding:0px 50px"><span style="font-size:16px;font-weight:bold;line-height:0.8">${getInt(1,35)}</span>`
        let middlepart1 = check_biger(2);
        str += middlepart1 +
            `</div>
                                                                </div>
                                                                <div class="streampos" style="float:right" >
                                                                    <p style="font-size:16px;font-weight:bold;line-height:0.4">Stream Position</p>
                                                                    <p style="font-size:20px;line-height:0.4;padding-left:30px;margin-bottom:10px"><span style="color:green">${studentdata.streamorder}</span>/${studentdata.total_member_stream}</p>
                                                                    <div style="padding:0px 50px"><span style="font-size:16px;font-weight:bold;line-height:0.8">${getInt(1,20)}</span>`
        let middlepart11 = check_biger(2);
        str += middlepart11 + `</div>
                                                                    </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        style="margin-left:100px;float:left;margin-top:3px" width="16"
                                                        height="16" fill="currentColor" class="bi bi-bar-chart-steps"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z">
                                                        </path>
                                                    </svg>
                                                    Subject Performance - Student vs Class
                                                </p>
                                                <div id="subject_performance_div${i}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <table class="table">
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
            str += `<tr><td>${eachtable.subjectName}</td><td>${eachtable.mark}</td><td>${eachtable.dev}`
            let middlepart3 = check_biger_new(Number(eachtable.dev));
            str += middlepart3 + `
            </td><td>${eachtable.grade}</td>
            <td>${eachtable.rank}</td><td>${eachtable.comment}</td><td>${eachtable.teachername}</td></tr>`
        }
        str += ` </tbody>
                                                </table>
                                            </div>
                                            <div class="col-12" style="margin-top:0px;margin-bottom:20px">
                                                <p style="text-align: left;">Muinui Simon Ndimi's Performance Over Time
                                                </p>
                                                <div class="col-7" id="performance_overtime_div${i}">

                                                </div>
                                            </div>
                                            <div class="col-12 " style="margin-bottom:10px">
                                                <div style=" display: flex;  justify-content: space-between;">
                                                    <div style=" margin-right: auto;font-weight:bold" >Class Teacher
                                                        Remarks - Maina</div>
                                                    <div style="margin-left: auto;font-weight:bold" >Signature</div>
                                                </div>
                                                <p style="text-align: left;"  class="class_teacher_remark">Aim higher, you are capable of doing much
                                                </p>
                                            </div>
                                            <div class="col-12 " style="margin-bottom:10px">
                                                <div style=" display: flex;  justify-content: space-between;">
                                                    <div style=" margin-right: auto;font-weight:bold" >Principal's
                                                        Remarks - Mr.Marcheria</div>
                                                    <div style="margin-left: auto;font-weight:bold;">Signature</div>
                                                </div>
                                                <p style="text-align: left;" class="principal_remark">Good work but aim higher, you have the
                                                    potential to do better</p>
                                            </div>
                                            <div class="col-12" style="margin-top:20px;margin-bottom:40px">
                                                <p style="font-weight:bold">Download Zeraki Analytics for detailed
                                                    academic report and
                                                    Zeraki Learning to improve your child's grades.
                                                    Zeraki Analytics and Learning Username:1205@bibirionihigh
                                                </p>
                                                <div style="margin-top:100px;text-align:right;display:none" class="parentsig">
                                                    <p>Parent's Signature:.......................</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div></div>`;
        i++;
    }

    $("#printing_card_panel").append(str);

}
var toggleCheckbox = document.getElementById('classteacherremark');
var toggleableElement = document.getElementsByClassName('class_teacher_remark');
if (toggleableElement) {
    toggleCheckbox.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement.length; index++) {
                const element = toggleableElement[index];
                element.style.display = 'block';

            }
        } else {
            for (let index = 0; index < toggleableElement.length; index++) {
                const element = toggleableElement[index];
                element.style.display = 'none';

            }
        }
    });
}
var toggleCheckbox1 = document.getElementById('principaremark');
var toggleableElement1 = document.getElementsByClassName('principal_remark');
if (toggleableElement1) {
    toggleCheckbox1.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement1.length; index++) {
                const element = toggleableElement1[index];
                element.style.display = 'block';

            }
        } else {
            for (let index = 0; index < toggleableElement1.length; index++) {
                const element = toggleableElement1[index];
                element.style.display = 'none';

            }
        }
    });
}

var toggleCheckbox2 = document.getElementById('classteachersig');
var toggleableElement2 = document.getElementsByClassName('class_teacher_sig');
if (toggleableElement2) {
    toggleCheckbox2.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement2.length; index++) {
                const element = toggleableElement2[index];
                element.style.display = 'block';

            }
        } else {
            for (let index = 0; index < toggleableElement2.length; index++) {
                const element = toggleableElement2[index];
                element.style.display = 'none';

            }
        }
    });
}

var toggleCheckbox3 = document.getElementById('principalsig');
var toggleableElement3 = document.getElementsByClassName('principal_sig');
if (toggleableElement3) {
    toggleCheckbox3.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement3.length; index++) {
                const element = toggleableElement3[index];
                element.style.display = 'block';

            }
        } else {
            for (let index = 0; index < toggleableElement3.length; index++) {
                const element = toggleableElement3[index];
                element.style.display = 'none';

            }
        }
    });
}

var toggleCheckbox4 = document.getElementById('parentsig');
var toggleableElement4 = document.getElementsByClassName('parentsig');
if (toggleableElement4) {
    toggleCheckbox4.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement4.length; index++) {
                const element = toggleableElement4[index];
                element.style.display = 'block';

            }
        } else {
            for (let index = 0; index < toggleableElement4.length; index++) {
                const element = toggleableElement4[index];
                element.style.display = 'none';

            }
        }
    });
}

var toggleCheckbox5 = document.getElementById('overallstudentrank');
var toggleableElement5 = document.getElementsByClassName('overpos');
if (toggleableElement5) {
    toggleCheckbox5.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement5.length; index++) {
                const element = toggleableElement5[index];
                element.style.display = 'block';

            }
        } else {
            for (let index = 0; index < toggleableElement5.length; index++) {
                const element = toggleableElement5[index];
                element.style.display = 'none';

            }
        }
    });
}

var toggleCheckbox6 = document.getElementById('streamstudentrank');
var toggleableElement6 = document.getElementsByClassName('streampos');
if (toggleableElement6) {
    toggleCheckbox6.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement6.length; index++) {
                const element = toggleableElement6[index];
                element.style.display = 'block';

            }
        } else {
            for (let index = 0; index < toggleableElement6.length; index++) {
                const element = toggleableElement6[index];
                element.style.display = 'none';

            }
        }
    });
}

function fnPrintReport_StudentCard(e) {
    e.preventDefault();
    console.log("numarr", numarr);
    let imgarr_one = [];
    let imgarr_two = [];
    for (i = 0; i < numarr; i++) {
        var dataUrl = document.getElementById('subject_performance' + i).toDataURL();
        var dataUrl1 = document.getElementById('performance_overtime' + i).toDataURL();
        imgarr_one.push(dataUrl)
        imgarr_two.push(dataUrl1)
    }
    var mywindow = window.open('', 'PRINT', 'height=800,width=1024');
    mywindow.document.write('<html><head><title>' + " " + '</title>');
    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write(
        '<style>table,td {border:2px solid black !important;border-collapse:collapse !important; padding:4px !important} table,th {border:2px solid black !important ;border-collapse:collapse !important; padding:4px !important}</style>'
    );
    mywindow.document.write(
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
    );
    mywindow.document.write('</head><body >');
    for (i = 0; i < numarr; i++) {
        document.getElementById('subject_performance_div' + i).innerHTML = '<img src="' + imgarr_one[i] +
            '" style="height:240px">';
        document.getElementById('performance_overtime_div' + i).innerHTML = '<img src="' + imgarr_two[i] +
            '" style="height:280px">';
    }
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('printing_card_panel').innerHTML);
    console.log(document.getElementById('subject_performance_div0'));
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();
    return true;
}

function titleCase(str) {
    var words = str.toLowerCase().split(" ");
    for (var i = 0; i < words.length; i++) {
        var firstLetter = words[i].charAt(0).toUpperCase();
        var restOfWord = words[i].slice(1);
        words[i] = firstLetter + restOfWord;
    }
    return words.join(" ");
}

function getInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function ran() {
    var letters = ['A', 'B', 'C', 'D', 'E', "D-", "D+", "C-", "C+", "B-", "B+", "A-"];
    var l = letters[Math.floor(Math.random() * letters.length)];
    return l;
}
</script>