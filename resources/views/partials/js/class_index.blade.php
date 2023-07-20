<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});



function deleteSupervisor(formId, myObj) {

    var div1 = myObj.parentNode.parentNode;

    let form1 = new FormData();
    form1.append("formId", formId);

    var ajaxOptions = {
        url: '/classes/delete_supervisor',
        type: 'POST',
        cache: false,
        processData: false,
        dataType: 'json',
        contentType: false,
        data: form1,
    };

    var req = $.ajax(ajaxOptions);

    req.done(function(resp) {

        let all_teachers = resp.all_teachers;
        let div2 = '';
        for (let i = 0; i < all_teachers.length; i++) {
            div2 += `<option value="` + all_teachers[i].id + `">` + all_teachers[i].name + `</option>`;
        }
        div1.innerHTML =
            `<select required data-placeholder="Assign" class="form-control " onchange="assignSupervisor(` +
            formId + `, this)" data-id="` + formId + `">
                                                     <option value="">Assign</option>
                                                     ` + div2 + `
                                                  </select>`;
        resp.ok && resp.msg ?
            flash({
                msg: resp.msg,
                type: 'success'
            }) :
            flash({
                msg: resp.msg,
                type: 'danger'
            });
        hideAjaxAlert();
        return resp;
    });
    req.fail(function(e) {
        if (e.status == 422) {
            var errors = e.responseJSON.errors;
            displayAjaxErr(errors);
        }
        if (e.status == 500) {
            displayAjaxErr([e.status + ' ' + e.statusText +
                ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'
            ])
        }
        if (e.status == 404) {
            displayAjaxErr([e.status + ' ' + e.statusText + ' - Requested Resource or Record Not Found'])
        }
        return e.status;
    });
}

function assignSupervisor(formId, myObj) {

    let td1 = myObj.parentNode;
    var teacher_id = myObj.options[myObj.selectedIndex].value;

    let form1 = new FormData();
    form1.append("formId", formId);
    form1.append("teacher_id", teacher_id);
    var ajaxOptions = {
        url: '/classes/assign_supervisor',
        type: 'POST',
        cache: false,
        processData: false,
        dataType: 'json',
        contentType: false,
        data: form1,
    };

    var req = $.ajax(ajaxOptions);

    req.done(function(resp) {

        let teacher_name = resp.teacher_name;
        td1.innerHTML = `<div class="d-flex align-items-center justify-content-between">
                                <p style="margin: 0;">` + teacher_name +
            `</p>
                                <button class="btn" style="background:transparent;line-height: 7px;margin:0;font-size: 10px;height:auto" title="Delete this user" onclick="deleteSupervisor(` +
            formId + `, this);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color:red" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
</svg>
                                </button>
                            </div>`;
        resp.ok && resp.msg ?
            flash({
                msg: resp.msg,
                type: 'success'
            }) :
            flash({
                msg: resp.msg,
                type: 'danger'
            });
        hideAjaxAlert();
        return resp;
    });
    req.fail(function(e) {
        if (e.status == 422) {
            var errors = e.responseJSON.errors;
            displayAjaxErr(errors);
        }
        if (e.status == 500) {
            displayAjaxErr([e.status + ' ' + e.statusText +
                ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'
            ])
        }
        if (e.status == 404) {
            displayAjaxErr([e.status + ' ' + e.statusText + ' - Requested Resource or Record Not Found'])
        }
        return e.status;
    });
}

function showMyClass() {
    // alert('ok');
    // history.go('/classes');
}

function showRadio(myObj) {
    var detail = document.querySelector('#detail');
    var detailContent = document.querySelector('#detail-content');
    var detailPrint = document.querySelector('#detail-print');
    if (myObj.value == "Custom") {
        detail.classList.remove('active-state');
        detailContent.classList.add('active-state');
        detailPrint.classList.add('active-state');
    } else {
        detail.classList.add('active-state');
        detailContent.classList.remove('active-state');
        detailPrint.classList.remove('active-state');
    }
}

function showPrint() {
    $('.basic').addClass('active-state');
    $('.print').removeClass('active-state');
}

function showManageTeacher() {
    $('.basic').removeClass('active-state');
    $('.print').addClass('active-state');
}
$("#example-search-input").on("keyup", function() {
    var count = $('.teacher_count').text();
    var value = $(this).val().toLowerCase();
    for (let index = 0; index < 18; index++) {
        var label = $('#item' + index).attr('aria-label')
        console.log(label.toLowerCase(), label.toLowerCase().indexOf(value) > -1)
        if (label.toLowerCase().indexOf(value) < 0) {
            if (!$('#item' + index).hasClass('active-state')) {
                $('#item' + index).addClass('active-state')
            }
            // console.log($('#item'+index).hasClass('active-state'))
        } else {
            if ($('#item' + index).hasClass('active-state')) {
                $('#item' + index).removeClass('active-state')
            }
        }

    }
});

function phoneCheck() {
    if ($('#phone').is(":checked")) {
        $('#phone').prop('checked', true);
        $('.phone').removeClass('active-state');
    } else {
        $('#phone').prop('checked', false);
        $('.phone').addClass('active-state');
    }

}

function emailCheck() {
    if ($('#username').is(":checked")) {
        $('#username').prop('checked', true);
        $('.email').removeClass('active-state');
    } else {
        $('#username').prop('checked', false);
        $('.email').addClass('active-state');
    }

}

function nationCheck() {
    if ($('#national').is(":checked")) {
        $('#national').prop('checked', true);
        $('.nation').removeClass('active-state');
    } else {
        $('#national').prop('checked', false);
        $('.nation').addClass('active-state');
    }

}

function genderCheck() {
    if ($('#gender').is(":checked")) {
        $('#gender').prop('checked', true);
        $('.gender').removeClass('active-state');
    } else {
        $('#gender').prop('checked', false);
        $('.gender').addClass('active-state');
    }

}

function tscCheck() {
    if ($('#tsc').is(":checked")) {
        $('#tsc').prop('checked', true);
        $('.tsc').removeClass('active-state');
    } else {
        $('#tsc').prop('checked', false);
        $('.tsc').addClass('active-state');
    }

}

function groupCheck() {
    if ($('#group').is(":checked")) {
        $('#group').prop('checked', true);
        $('.group').removeClass('active-state');
    } else {
        $('#group').prop('checked', false);
        $('.group').addClass('active-state');
    }

}

function fnExcelReport() {
    var tab_text = document.getElementById('printView').innerHTML;
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    window.focus();
}

function fnPrintReport(e) {
    e.preventDefault();
    var mywindow = window.open('', 'PRINT', 'height=800,width=1024');
    mywindow.document.write('<html><head><title>' + " " + '</title>');
    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('printView').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();
    return true;
}


function fnPrintReport_new(e) {
    e.preventDefault();
    var mywindow = window.open('', 'PRINT', 'height=1800,width=1500');
    mywindow.document.write(`<html><head><title>' + " " + '</title><style type="text/css"> table thead th, table tbody td {border:1px solid black;border-collapse: collapse;padding:3px;}
       </style>`);
    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write(
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
    );
    mywindow.document.write('</head><body >');
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('preview_new').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();
    return true;
}

function fnPrintReport_new_more(e) {
    e.preventDefault();
    var dataUrl = document.getElementById('performance').toDataURL();
    var dataUrl1 = document.getElementById('classsubjectmeans').toDataURL();
    var dataUrl2 = document.getElementById('overallclassstatistics').toDataURL();
    var dataUrl3 = document.getElementById('performanceovertime').toDataURL();
    var mywindow = window.open('', 'PRINT', 'height=1200,width=1700');
    mywindow.document.write('<html><head><title>' + " " + '</title>');
    mywindow.document.write(
        '<style>.customtable,th {    border: 2px solid black !important;font-size:15px;    border-collapse: collapse !important; }.customtable,td { border: 2px solid black !important;font-size:15px; border-collapse: collapse !important},img{width:500px;height:300px}</style>'
    );
    mywindow.document.write(
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
    );
    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');

    document.getElementById('test').innerHTML = '<img src="' + dataUrl + '">';
    document.getElementById('test1').innerHTML = '<img src="' + dataUrl1 + '" style="height:300px">';
    document.getElementById('test2').innerHTML = '<img src="' + dataUrl2 + '" style="height:300px">';
    document.getElementById('test3').innerHTML = '<img src="' + dataUrl3 + '">';
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('preview_new_report').innerHTML);
    // mywindow.document.write('<img src="' + dataUrl + '">');
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();
    return true;
}

function checkListType() {
    if ($('#listType').hasClass('active-state')) {
        $('#listType').removeClass('active-state');
    } else {
        $('#listType').addClass('active-state');
    }

}

function checkClassType() {
    if ($('#classType').hasClass('active-state')) {
        $('#classType').removeClass('active-state');
    } else {
        $('#classType').addClass('active-state');
    }

}
$('#select_by_key').on('click', function() {
    if (!$('.select_file').hasClass('active-state')) {
        $('.select_file').addClass('active-state');
    }
    if ($('.select_key').hasClass('active-state')) {
        $('.select_key').removeClass('active-state');
    }
});
$('#select_by_file').on('click', function() {
    if (!$('.select_key').hasClass('active-state')) {
        $('.select_key').addClass('active-state');
    }
    if ($('.select_file').hasClass('active-state')) {
        $('.select_file').removeClass('active-state');
    }
});

function uploadFile_onChange(input, sort) {
    var files = document.getElementById('file_upload').files;
    if (files.length == 0) {
        alert("Please choose any file...");
        return;
    }
    var filename = files[0].name;
    var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
    if (extension == '.XLS' || extension == '.XLSX') {
        //Here calling another method to read excel file into json
        excelFileToJSON(files[0], sort);
    } else {
        // alert("Please select a valid excel file.");
        $('#display_excel_data').removeClass('active-state');
        var table = document.getElementById("display_excel_data");
        var htmlData = '<tr><th>#</th><th>Name</th><th>Title</th><th>National Id No</th><th>Group</th></tr>';
        table.innerHTML = htmlData;
    }
}

function excelFileToJSON(file, sort) {
    try {
        var reader = new FileReader();
        reader.readAsBinaryString(file);
        reader.onload = function(e) {

            var data = e.target.result;
            var workbook = XLSX.read(data, {
                type: 'binary'
            });
            var result = {};
            var firstSheetName = workbook.SheetNames[0];
            //reading only first sheet data
            var jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[firstSheetName]);
            // alert(JSON.stringify(jsonData));
            //displaying the json result into HTML table
            displayJsonToHtmlTable(jsonData, sort);
        }
    } catch (e) {
        console.error(e);
    }
}

function displayJsonToHtmlTable(jsonData, sort) {
    $('#display_excel_data').removeClass('active-state');
    var table = document.getElementById("display_excel_data");
    if (jsonData.length > 0) {
        if (sort == 1) {
            var htmlData =
                '<tr><th>#</th><th>Name</th><th>Phone</th><th>TSC NO</th><th>National Id No</th><th>Gender</th><th>Group</th></tr>';

            for (var i = 0; i < jsonData.length; i++) {
                var row = jsonData[i];
                htmlData += '<tr><td>' + Number(i + 1) + '</td><td>' + row["NAME"] + '</td><td>' + row['PHONE'] +
                    '</td><td>' + row['TSC_NO'] + '</td><td>' + row["NATIONAL_ID_NO"] + '</td><td>' + row['GENDER'] +
                    '</td><td>' + row["GROUP"] + '</td></tr>';
            }
        } else {
            var htmlData = '<tr><th>#</th><th>Name</th><th>Title</th><th>National Id No</th><th>Group</th></tr>';
            for (var i = 0; i < jsonData.length; i++) {
                var row = jsonData[i];
                htmlData += '<tr><td>' + Number(i + 1) + '</td><td>' + row["NAME"] + '</td><td>' + row['TITLE'] +
                    '</td><td>' + row["NATIONAL_ID_NO"] + '</td><td>' + row["GROUP"] + '</td></tr>';
            }
        }
        table.innerHTML = htmlData;
    } else {

        // table.innerHTML='There is no data in Excel';
        if (sort == 1) {
            var htmlData =
                '<tr><th>#</th><th>Name</th><th>Phone</th><th>TSC NO</th><th>National Id No</th><th>Gender</th><th>Group</th></tr>';
        } else {
            var htmlData = '<tr><th>#</th><th>Name</th><th>Title</th><th>National Id No</th><th>Group</th></tr>';
        }
        table.innerHTML = htmlData;
    }
}
var create_exam_submit_btn = document.querySelector('#create-staff-btn');
$('#create_staff_form').on('submit', function(e) {
    e.preventDefault();
    let form1 = new FormData();
    form1.append("full_name", $('#full_name').val());
    form1.append("email", $('#email').val());
    form1.append("phone_number", $('#phone_number').val());
    form1.append("tsc_no", $('#tsc_no').val());
    form1.append("gender", $('#gender').val());
    form1.append("national_id_no", $('#national_id_no').val());
    form1.append("group", $('#group').val());
    var ajaxOptions = {
        url: $('#create_staff_form').attr('action'),
        type: 'POST',
        cache: false,
        processData: false,
        dataType: 'json',
        contentType: false,
        data: form1,
    };
    var req = $.ajax(ajaxOptions);
    req.done(function(resp) {
            console.log('======= residences ===============');
            console.log(resp);
            resp.ok && resp.msg ?
                flash({
                    msg: resp.msg,
                    type: 'success'
                }) :
                flash({
                    msg: resp.msg,
                    type: 'danger'
                });
            hideAjaxAlert();
            // enableBtn($(create_exam_submit_btn));
            // window.location.href="/exams";
            // return resp;
            $('#staff_name_helper').text('');
            $('#staff_email_helper').text('');

        })
        .fail(function(e) {
            if (e.status == 422) {
                var errors = e.responseJSON.errors;
                console.log(errors)
                errors.forEach(error => {
                    if (error == "The full name field is required.") {
                        $('#staff_name_helper').text(error);
                    }
                    if (error == "The email field is required.") {
                        $('#staff_email_helper').text(error);
                    }
                })
            }
            if (e.status == 500) {
                displayAjaxErr([e.status + ' ' + e.statusText +
                    ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'
                ])
            }
            if (e.status == 404) {
                displayAjaxErr([e.status + ' ' + e.statusText +
                    ' - Requested Resource or Record Not Found'
                ])
            }
            enableBtn($(create_exam_submit_btn));
        });
});
(() => {
    $("#clickable_arr_up").hide()
    $("#clickable_arr_down").show()
    $("#input_area").hide()
    $("#clickable_arr_up").on("click", () => {
        $("#clickable_arr_down").show()
        $("#clickable_arr_up").hide()
        $("#input_area").hide(300)
    })
    $("#clickable_arr_down").on("click", () => {
        $("#clickable_arr_down").hide()
        $("#clickable_arr_up").show()
        $("#input_area").show(300)
    })
    $("#select_form").on("click", (e) => {
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
                $("#select_stream").children().remove();
                $("#select_stream").append(option_arr);
            })
        }

    })

    $(".select_form_metalist").on("click", (e) => {
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
                $(".select_stream_metalist").children().remove();
                $(".select_stream_metalist").append(option_arr);
            })
        }

    })

    $(".select_stream_metalist").on("click", (e) => {
        stream_id = e.target.value;
        console.log(stream_id)
        if (stream_id != "") {
            console.log("this is testing")
            $("#exam_area_metalist").hide();
            $(".spinner-square").show();
            setTimeout(() => {
                $(".spinner-square").hide();
                $("#exam_area_metalist").show(600);
            }, 3000);
        }

    })
    $("#select_stream").on("click", (e) => {
        stream_id = e.target.value;
        console.log(stream_id)
        if (stream_id != "") {
            console.log("this is testing")
            $("#exam_area").hide();
            $(".spinner-square").show();
            setTimeout(() => {
                $(".spinner-square").hide();
                $("#exam_area").show(600);
            }, 3000);
        }

    })

    $("#get_metalist_meta").click(() => {
        $("#input_area").hide()
        str =
            '<div class="spinner-square" style="margin:auto"><div class="square-1 square"></div><div class="square-2 square"></div><div class="square-3 square"></div></div>'
        $("#elem_down").append(str)
        setTimeout(() => {
            $(".spinner-square").hide();
            $("#print_arr_meta").show(600);
        }, 3000);
        stream_id = $(".select_stream_metalist").val();
        exam_id = $("#select_exam_metalist").val();
        form_id = $(".select_form_metalist").val();
        $.post("get_meta_list", {
            stream_id: stream_id,
            exam_id: exam_id,
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res);
            $(".form_name").text(res.form_name[0].name)
            $(".stream_name").text(res.stream_name[0].stream)
            $(".exam_name").text(res.exam_name[0].name)
            $(".term").text(res.exam_name[0].term)
            $(".year").text(res.exam_name[0].year)
            // console.log(res);
            display_other(res)
            display_metalist(res)
        })
    })


    $("#get_metalist").click(() => {
        $("#input_area").hide()
        str =
            '<div class="spinner-square" style="margin:auto"><div class="square-1 square"></div><div class="square-2 square"></div><div class="square-3 square"></div></div>'
        $("#elem_down").append(str)
        setTimeout(() => {
            $(".spinner-square").hide();
            $("#print_arr").show(600);
        }, 3000);
        stream_id = $("#select_stream").val();
        exam_id = $("#select_exam").val();
        form_id = $("#select_form").val();
        $.post("get_meta_list", {
            stream_id: stream_id,
            exam_id: exam_id,
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res);
            // console.log("res", res);

            display_metalist(res)

        })
    })


    function display_metalist(data) {
        header =
            "<tr><th colspan='26' style='text-align:center'>FORM 1 west - second,2023-(2023 Term 1)</th></tr><tr><th >ADMNO</th><th style='width:270px !important'>NAME</th><th style='width:70px !important'>STR</th>";
        tbody = "";
        let subject_list_field = "";
        for (subject of data.data.subjectlist) {
            header += `<th style='width:50px'>${subject.subject.title.slice(0, 3).toUpperCase()}</th>`
            subject_list_field += subject.subject.title.slice(0, 3).toUpperCase() + ',';
        }
        header +=
            "<th >SBJ</th><th >KCPE</th><th >VAP</th><th >MNMKS</th><th >DEV</th><th >GR</th><th >TTMKS</th><th  >TTPTS</th><th >STRPOS</th><th >OVERPOS</th></tr>"
        $(".meta_thead").html(header);
        //    End of creating header
        let ordering_arr = array_order(data);
        // console.log("ordering_arr", ordering_arr)
        let i = 1;
        for (stu_lis of ordering_arr) {
            let j = 0;
            name = stu_lis[0].Name.toLowerCase();
            newarr = name.split(" ");
            str = '';
            for (pop of newarr) {
                str += pop[0].toUpperCase() + pop.slice(1).toLowerCase() + " ";
            }
            other_name = stu_lis[0].stream_name;
            other_name = other_name.charAt(0) + other_name.slice(1);
            tbody +=
                `<tr><td>${stu_lis[0].adm_no}</td><td style="text-align:left">${str}</td><td>${other_name}</td>`;
            for (mark of stu_lis[0].marks_new) {
                if (mark == '') {
                    tbody += `<td></td>`;
                    j++;
                } else {
                    tbody += `<td>${mark}</td>`;
                }
            }
            let total_mark = 0;
            let Total_pts = 0;
            let overal_grading_sys = stu_lis[0].overal_grading_sys;
            for (mark of stu_lis[0].marks) {
                // console.log(mark);
                total_mark += Number(mark);
                for (val of overal_grading_sys) {
                    if (mark != "") {
                        if (mark >= val.mark_from && mark <= val.mark_to) {
                            Total_pts += Number(val.remark);
                        }
                    }
                }
            }
            let order_form;
            let cnt = 1;
            let ordered_marks_form = form_order_array(stu_lis[0]["student_marks_form"]);
            // console.log(ordered_marks_form);
            for (child_val of ordered_marks_form) {
                if (stu_lis[0]['student_id'] == child_val[0].student_id) {
                    order_form = cnt;
                }
                cnt++;
            }
            let over_grad = '';
            let kcpe = Math.floor(Math.random() * (500 - 200 + 1) + 200)
            let sbj = stu_lis[0].marks_new.length - j;
            let mn_mks = total_mark / sbj;
            mn_mks = mn_mks.toFixed(2);
            for (val of overal_grading_sys) {
                if (mn_mks >= val.mark_from && mn_mks <= val.mark_to) {
                    over_grad = val.name;
                }
            }
            let vap = (mn_mks - (kcpe / 5)).toFixed(2);
            let dev = (mn_mks - stu_lis[0].pre_mean_mark / stu_lis[0].marks.length).toFixed(2);
            tbody +=
                `<td>${sbj}</td><td>${kcpe}</td><td>${vap}</td><td>${mn_mks}</td><td>${dev}</td><td>${over_grad}</td><td>${total_mark}</td><td>${Total_pts}</td><td>${i}</td><td>${order_form}</td></tr>`;
            i++;
            stream_id = $(".select_stream_metalist").val();
            exam_id = $("#select_exam_metalist").val();
            form_id = $(".select_form_metalist").val();
            data = {
                stream_id: stream_id,
                exam_id: exam_id,
                adm_no: stu_lis[0].adm_no,
                Name: stu_lis[0].Name,
                stream_name: stu_lis[0].stream_name,
                subject_list_field: subject_list_field,
                marks_new: stu_lis[0].marks_new,
                sbj: sbj,
                kcpe: kcpe,
                vap: vap,
                mn_mks: mn_mks,
                dev: dev,
                over_grad: over_grad,
                total_mark: total_mark,
                Total_pts: Total_pts,
                stream_order: i,
                order_form: order_form
            }
            $.post("{{route('adding_metalist_table')}}", {
                data
            }, () => {

            })
        }
        $(".meta_tbody").html(tbody);
    }

    function display_other(data) {
        console.log("thjioasdfasdfasdf")
        header = [{
            title: "No",
            data: "No"
        }, {
            title: "ADMNO",
            data: "ADMNO"
        }, {
            title: "NAME",
            data: "NAME"
        }, {
            title: "STR",
            data: "STR"
        }]
        header_one = [];
        for (subject of data.data.subjectlist) {
            obj = {
                title: subject.subject.title.slice(0, 3).toUpperCase(),
                data: subject.subject.title.slice(0, 3).toUpperCase()
            }
            header.push(obj);
            header_one.push(subject.subject.title.slice(0, 3).toUpperCase());
        }
        header.push({
            title: "SBJ",
            data: "SBJ"
        }, {
            title: "KCPE",
            data: "KCPE"
        }, {
            title: "VAP",
            data: "VAP"
        }, {
            title: "MNMKS",
            data: "MNMKS"
        }, {
            title: "DEV",
            data: "DEV"
        }, {
            title: "GR",
            data: "GR"
        }, {
            title: "TTMKS",
            data: "TTMKS"
        }, {
            title: "TTPTS",
            data: "TTPTS"
        }, {
            title: "STRPOS",
            data: "STRPOS"
        }, {
            title: "OVERPOS",
            data: "OVERPOS"
        })
        console.log(header)
        let ordering_arr = array_order(data);
        body = [];
        obj_for_body = [];
        // console.log(ordering_arr)
        k = 1;
        for (each_val of ordering_arr) {
            newobj = {}
            name = each_val[0].Name.toLowerCase();
            newarr = name.split(" ");
            str = '';
            for (pop of newarr) {
                str += pop[0].toUpperCase() + pop.slice(1).toLowerCase() + " ";
            }
            newobj.No = k;
            newobj.ADMNO = each_val[0].adm_no;
            newobj.NAME = str;
            str.charAt(0).toUpperCase() + str.slice(1);
            stream_name = each_val[0].stream_name
            stream_name = stream_name.charAt(0).toUpperCase() + stream_name.slice(1)
            newobj.STR = stream_name;
            j = 0;
            for (i = 0; i < each_val[0].marks_new.length; i++) {
                if (each_val[0].marks_new[i] == '') {
                    newobj[header_one[i]] = "";
                    j++;
                } else {
                    newobj[header_one[i]] = each_val[0].marks_new[i];
                }
            }

            newobj.SBJ = each_val[0].marks_new.length;
            let total_mark = 0;
            let Total_pts = 0;
            let overal_grading_sys = each_val[0].overal_grading_sys;
            for (mark of each_val[0].marks) {
                // console.log(mark);
                total_mark += Number(mark);
                for (val of overal_grading_sys) {
                    if (mark != "") {
                        if (mark >= val.mark_from && mark <= val.mark_to) {
                            Total_pts += Number(val.remark);
                        }
                    }
                }
            }
            let order_form;
            let cnt = 1;
            let ordered_marks_form = form_order_array(each_val[0]["student_marks_form"]);
            for (child_val of ordered_marks_form) {
                if (each_val[0]['student_id'] == child_val[0].student_id) {
                    order_form = cnt;
                }
                cnt++;
            }
            let over_grad = '';
            let kcpe = Math.floor(Math.random() * (500 - 200 + 1) + 200)
            let mn_mks = total_mark / each_val[0].marks_new.length;
            mn_mks = mn_mks.toFixed(2);
            console.log(mn_mks)
            for (val of overal_grading_sys) {
                if (mn_mks >= val.mark_from && mn_mks <= val.mark_to) {
                    over_grad = val.name;
                }
            }
            let vap = (mn_mks - (kcpe / 5)).toFixed(2);
            let dev = (mn_mks - each_val[0].pre_mean_mark / each_val[0].marks.length).toFixed(2);
            newobj.KCPE = kcpe;
            newobj.VAP = vap;
            newobj.MNMKS = mn_mks;
            newobj.DEV = dev;
            newobj.GR = over_grad;
            newobj.TTMKS = total_mark;
            newobj.TTPTS = Total_pts;
            newobj.STRPOS = k;
            newobj.OVERPOS = order_form;
            obj_for_body.push(newobj);
            k++;

        }
        console.log(obj_for_body)
        $('#datatable').DataTable({
            bAutoWidth: false,
            "ordering": false,
            data: obj_for_body,
            columns: header
        });
        // table.buttons('.buttonsToHide').nodes().addClass('hidden');
        // console.log(document.getElementById("datatable").childNodes[1].childNodes[0].childNodes);
        // elements = document.getElementById("datatable").childNodes[1].childNodes[0].childNodes;
        // elements[0].classList.remove("sorting_asc");
        // // elements[2].style.width="500px !important";
        // for(i=0;i<elements.length;i++){
        //     elements[i].classList.remove("sorting")
        // }
    }

    // $('#datatable >thead>th').removeClass("sorting")
    console.log(document.getElementById("datatable").childNodes[1]);

    function array_order(data) {
        var ordering_arr = [];
        if (data.student_list) {
            ordering_arr = data.student_list;
        } else {
            ordering_arr = data;
        }

        // console.log("step 1 :", ordering_arr)
        let temp = [];
        for (val of ordering_arr) {
            let total_mark = 0;
            for (mark of val[0].marks) {
                // console.log(mark);
                total_mark += Number(mark);
            }

            val.push(total_mark)
        }
        for (i = 0; i < ordering_arr.length; i++) {
            for (j = 0; j < ordering_arr.length; j++) {
                if (i == j) {
                    continue;
                } else {
                    if (ordering_arr[i][1] > ordering_arr[j][1]) {
                        temp = ordering_arr[j];
                        ordering_arr[j] = ordering_arr[i];
                        ordering_arr[i] = temp
                    } else {
                        continue
                    }
                }
            }
        }
        return ordering_arr;
    }

    function array_order_analy(data) {
        ordering_arr = data;
        let temp = [];
        for (i = 0; i < ordering_arr.length; i++) {
            for (j = 0; j < ordering_arr.length; j++) {
                if (i == j) {
                    continue;
                } else {
                    if (ordering_arr[i][5] > ordering_arr[j][5]) {
                        temp = ordering_arr[j];
                        ordering_arr[j] = ordering_arr[i];
                        ordering_arr[i] = temp
                    } else {
                        continue
                    }
                }
            }
        }
        return ordering_arr;
    }

    function array_order_for_fourthtable(data) {
        ordering_arr = data;
        let temp = [];
        for (i = 0; i < ordering_arr.length; i++) {
            for (j = 0; j < ordering_arr.length; j++) {
                if (i == j) {
                    continue;
                } else {
                    if (ordering_arr[i][3] > ordering_arr[j][3]) {
                        temp = ordering_arr[j];
                        ordering_arr[j] = ordering_arr[i];
                        ordering_arr[i] = temp
                    } else {
                        continue
                    }
                }
            }
        }
        return ordering_arr;
    }

    function form_order_array_analy(data) {
        ordering_arr = data;
        let temp = [];
        for (i = 0; i < ordering_arr.length; i++) {
            for (j = 0; j < ordering_arr.length; j++) {
                if (i == j) {
                    continue;
                } else {
                    if (ordering_arr[i][0] > ordering_arr[j][0]) {
                        temp = ordering_arr[j];
                        ordering_arr[j] = ordering_arr[i];
                        ordering_arr[i] = temp
                    } else {
                        continue
                    }
                }
            }
        }
        return ordering_arr;
    }

    function form_order_array(data) {
        var ordering_arr = [];
        if (data.student_list) {
            ordering_arr = data.student_list;
        } else {
            ordering_arr = data;
        }

        // console.log("step 1 :", ordering_arr)
        let temp = [];
        for (val of ordering_arr) {
            let total_mark = 0;
            for (mark of val[0].marks) {
                // console.log(mark);
                total_mark += Number(mark);
            }

            val.push(total_mark / val[0].marks.length)
        }
        for (i = 0; i < ordering_arr.length; i++) {
            for (j = 0; j < ordering_arr.length; j++) {
                if (i == j) {
                    continue;
                } else {
                    if (ordering_arr[i][1] > ordering_arr[j][1]) {
                        temp = ordering_arr[j];
                        ordering_arr[j] = ordering_arr[i];
                        ordering_arr[i] = temp
                    } else {
                        continue
                    }
                }
            }
        }
        return ordering_arr;
    }

    $("#spreedsheet_meta").click(() => {
        stream_id = $(".select_stream_metalist").val();
        exam_id = $("#select_exam_metalist").val();
        form_id = $(".select_form_metalist").val();
        $.ajax({
            xhrFields: {
                responseType: 'blob',
            },
            type: 'get',
            url: "{{route('download_metalist_excel')}}",
            data: {
                stream_id: stream_id,
                exam_id: exam_id,
                form_id: form_id
            },
            success: function(result, status, xhr) {

                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'salary.xlsx');

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
    })

    $("#spreedsheet").click(() => {
        stream_id = $("#select_stream").val();
        exam_id = $("#select_exam").val();
        form_id = $("#select_form").val();
        $.ajax({
            xhrFields: {
                responseType: 'blob',
            },
            type: 'get',
            url: "{{route('download_metalist_excel')}}",
            data: {
                stream_id: stream_id,
                exam_id: exam_id,
                form_id: form_id
            },
            success: function(result, status, xhr) {

                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                var filename = (matches != null && matches[1] ? matches[1] : 'salary.xlsx');

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
    })



    $("#pdf_meta").click(() => {
        stream_id = $(".select_stream_metalist").val();
        exam_id = $("#select_exam_metalist").val();
        form_id = $(".select_form_metalist").val();
        $.ajax({
            type: 'GET',
            url: "{{route('download_metalist_pdf')}}",
            data: {
                stream_id: stream_id,
                exam_id: exam_id,
                form_id: form_id
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    text: "Granting success",
                    showConfirmButton: false,
                    timer: 1000,
                })
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "techsolutionstuff.pdf";
                link.click();
            },
            error: function(blob) {
                console.log(blob);
            }
        });
    })

    $("#pdf").click(() => {
        stream_id = $("#select_stream").val();
        exam_id = $("#select_exam").val();
        form_id = $("#select_form").val();
        $.ajax({
            type: 'GET',
            url: "{{route('download_metalist_pdf')}}",
            data: {
                stream_id: stream_id,
                exam_id: exam_id,
                form_id: form_id
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                Swal.fire({
                    icon: "success",
                    text: "Granting success",
                    showConfirmButton: false,
                    timer: 1000,
                })
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "techsolutionstuff.pdf";
                link.click();
            },
            error: function(blob) {
                console.log(blob);
            }
        });
    })

    $("#printtype_meta").click(() => {
        $('#printtype_area_meta').show(1000);
        stream_id = $(".select_stream_metalist").val();
        exam_id = $("#select_exam_metalist").val();
        form_id = $(".select_form_metalist").val();
        $.post("get_meta_list", {
            stream_id: stream_id,
            exam_id: exam_id,
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res);
            console.log("++++++++++++++++++++", res)
            exam_name = res.exam_name[0].name;
            term = res.exam_name[0].term;
            year = res.exam_name[0].year;
            stream_name = res.stream_name[0].stream;
            form_name = res.form_name[0].name;
            $(".form_name").html(form_name);
            $(".stream_name").html(stream_name);
            $(".exam_name").html(exam_name);
            $(".year").html(year);
            $(".term").html(term);
            display_metalist(res)
            let second_table = res.second_table;
            let third_table = res.third_table;
            let second_table_body = '';
            let a = b = c = d = e = f = g = h = i = j = k = l = m = n = o = p = q = r = 0;
            let stream_arr = [];
            for (each_val of second_table) {

                second_table_body +=
                    `<tr><td>Form ${form_name} ${each_val[0].charAt(0).toUpperCase() + each_val[0].slice(1)}</td><td>${each_val[4].filter(str => str  === 'A').length}</td><td>${each_val[4].filter(str => str  === 'A-').length}</td><td>${each_val[4].filter(str => str  === 'B+').length}</td><td>${each_val[4].filter(str => str  === 'B').length}</td><td>${each_val[4].filter(str => str  === 'B-').length}</td><td>${each_val[4].filter(str => str  === 'C').length}</td><td>${each_val[4].filter(str => str  ==='C+').length}</td><td>${each_val[4].filter(str => str  ==='C-').length}</td>
                    <td>${each_val[4].filter(str => str  === 'D+').length}</td><td>${each_val[4].filter(str => str  === 'D').length}</td><td>${each_val[4].filter(str => str  === 'D-').length}</td><td>${each_val[4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${each_val[1]}</td><td>${each_val[2]}</td><td>${each_val[5]}</td><td>${each_val[3]}</td></tr>`;
                a += each_val[4].filter(str => str === 'A').length;
                b += each_val[4].filter(str => str === 'A-').length;
                c += each_val[4].filter(str => str === 'B').length;
                d += each_val[4].filter(str => str === 'B+').length;
                e += each_val[4].filter(str => str === 'B-').length;
                f += each_val[4].filter(str => str === 'C+').length;
                g += each_val[4].filter(str => str === 'C').length;
                h += each_val[4].filter(str => str === 'C-').length;
                i += each_val[4].filter(str => str === 'D+').length;
                j += each_val[4].filter(str => str === 'D').length;
                k += each_val[4].filter(str => str === 'D-').length;
                l += each_val[4].filter(str => str === 'E').length;
                o += each_val[1];
                p += each_val[2];
                q += each_val[5];
                if (each_val[0] == stream_name) {
                    stream_arr = each_val;
                }
            }
            second_table_body +=
                `<tr><td>Form ${form_name}</td><td>${a}</td><td>${b}</td><td>${c}</td><td>${d}</td><td>${e}</td><td>${f}</td><td>${g}</td><td>${h}</td><td>${i}</td>
                <td>${j}</td><td>${k}</td><td>${l}</td><td>0</td><td>1</td><td>${o}</td><td>${p/second_table.length}</td><td>${q/second_table.length}</td><td>${second_table[0][3]}</td></tr>`
            $(".second_body").html(second_table_body);
            third_table_body =
                `<tr><td>Form ${form_name} ${stream_name}</td><td>${stream_arr[4].filter(str => str  === 'A').length}</td><td>${stream_arr[4].filter(str => str  === 'A-').length}</td><td>${stream_arr[4].filter(str => str  === 'B+').length}</td>
                <td>${stream_arr[4].filter(str => str  === 'B').length}</td><td>${stream_arr[4].filter(str => str  === 'B-').length}</td><td>${stream_arr[4].filter(str => str  === 'C+').length}</td><td>${stream_arr[4].filter(str => str  === 'C').length}</td>
                <td>${stream_arr[4].filter(str => str  === 'C-').length}</td><td>${stream_arr[4].filter(str => str  === 'D+').length}</td><td>${stream_arr[4].filter(str => str  === 'D').length}</td><td>${stream_arr[4].filter(str => str  === 'D-').length}</td>
                <td>${stream_arr[4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${stream_arr[1]}</td><td>${stream_arr[2]}</td><td>${stream_arr[5]}</td><td>${stream_arr[3]}</td></tr>`;
            for (each_val of third_table) {
                third_table_body +=
                    `<tr><td>${each_val[0]}</td><td>${each_val[4].filter(str => str  === 'A').length}</td><td>${each_val[4].filter(str => str  === 'A-').length}</td><td>${each_val[4].filter(str => str  === 'B+').length}</td><td>${each_val[4].filter(str => str  === 'B').length}</td><td>${each_val[4].filter(str => str  === 'B-').length}</td><td>${each_val[4].filter(str => str  === 'C').length}</td><td>${each_val[4].filter(str => str  ==='C+').length}</td><td>${each_val[4].filter(str => str  ==='C-').length}</td>
                    <td>${each_val[4].filter(str => str  === 'D+').length}</td><td>${each_val[4].filter(str => str  === 'D').length}</td><td>${each_val[4].filter(str => str  === 'D-').length}</td><td>${each_val[4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${each_val[1]}</td><td>${each_val[2]}</td><td>${each_val[5]}</td><td>${each_val[3]}</td></tr>`;
            }
            $(".third_body").html(third_table_body);
        })

    })

    $("#printtype").click(() => {
        $('#printtype_area').show(1000);
        stream_id = $("#select_stream").val();
        exam_id = $("#select_exam").val();
        form_id = $(".select_form_metalist").val();
        $.post("get_meta_list", {
            stream_id: stream_id,
            exam_id: exam_id,
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res);
            console.log("++++++++++++++++++++", res)
            exam_name = res.exam_name[0].name;
            term = res.exam_name[0].term;
            year = res.exam_name[0].year;
            stream_name = res.stream_name[0].stream;
            form_name = res.form_name[0].name;
            $(".form_name").html(form_name);
            $(".stream_name").html(stream_name);
            $(".exam_name").html(exam_name);
            $(".year").html(year);
            $(".term").html(term);
            let second_table = res.second_table;
            let third_table = res.third_table;
            let second_table_body = '';
            let a = b = c = d = e = f = g = h = i = j = k = l = m = n = o = p = q = r = 0;
            let stream_arr = [];
            for (each_val of second_table) {
                second_table_body +=
                    `<tr><td>Form ${form_name} ${each_val[0]}</td><td>${each_val[4].filter(str => str  === 'A').length}</td><td>${each_val[4].filter(str => str  === 'A-').length}</td><td>${each_val[4].filter(str => str  === 'B+').length}</td><td>${each_val[4].filter(str => str  === 'B').length}</td><td>${each_val[4].filter(str => str  === 'B-').length}</td><td>${each_val[4].filter(str => str  === 'C').length}</td><td>${each_val[4].filter(str => str  ==='C+').length}</td><td>${each_val[4].filter(str => str  ==='C-').length}</td>
                    <td>${each_val[4].filter(str => str  === 'D+').length}</td><td>${each_val[4].filter(str => str  === 'D').length}</td><td>${each_val[4].filter(str => str  === 'D-').length}</td><td>${each_val[4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${each_val[1]}</td><td>${each_val[2]}</td><td>${each_val[5]}</td><td>${each_val[3]}</td></tr>`;
                a += each_val[4].filter(str => str === 'A').length;
                b += each_val[4].filter(str => str === 'A-').length;
                c += each_val[4].filter(str => str === 'B').length;
                d += each_val[4].filter(str => str === 'B+').length;
                e += each_val[4].filter(str => str === 'B-').length;
                f += each_val[4].filter(str => str === 'C+').length;
                g += each_val[4].filter(str => str === 'C').length;
                h += each_val[4].filter(str => str === 'C-').length;
                i += each_val[4].filter(str => str === 'D+').length;
                j += each_val[4].filter(str => str === 'D').length;
                k += each_val[4].filter(str => str === 'D-').length;
                l += each_val[4].filter(str => str === 'E').length;
                o += each_val[1];
                p += each_val[2];
                q += each_val[5];
                if (each_val[0] == stream_name) {
                    stream_arr = each_val;
                }
            }
            second_table_body +=
                `<tr><td>Form ${form_name}</td><td>${a}</td><td>${b}</td><td>${c}</td><td>${d}</td><td>${e}</td><td>${f}</td><td>${g}</td><td>${h}</td><td>${i}</td>
                <td>${j}</td><td>${k}</td><td>${l}</td><td>0</td><td>1</td><td>${o}</td><td>${p/second_table.length}</td><td>${q/second_table.length}</td><td>${second_table[0][3]}</td></tr>`
            $(".second_body").html(second_table_body);
            third_table_body =
                `<tr><td>Form ${form_name} ${stream_name}</td><td>${stream_arr[4].filter(str => str  === 'A').length}</td><td>${stream_arr[4].filter(str => str  === 'A-').length}</td><td>${stream_arr[4].filter(str => str  === 'B+').length}</td>
                <td>${stream_arr[4].filter(str => str  === 'B').length}</td><td>${stream_arr[4].filter(str => str  === 'B-').length}</td><td>${stream_arr[4].filter(str => str  === 'C+').length}</td><td>${stream_arr[4].filter(str => str  === 'C').length}</td>
                <td>${stream_arr[4].filter(str => str  === 'C-').length}</td><td>${stream_arr[4].filter(str => str  === 'D+').length}</td><td>${stream_arr[4].filter(str => str  === 'D').length}</td><td>${stream_arr[4].filter(str => str  === 'D-').length}</td>
                <td>${stream_arr[4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${each_val[1]}</td><td>${each_val[2]}</td><td>${each_val[5]}</td><td>${each_val[3]}</td></tr>`;
            for (each_val of third_table) {
                third_table_body +=
                    `<tr><td>${each_val[0]}</td><td>${each_val[4].filter(str => str  === 'A').length}</td><td>${each_val[4].filter(str => str  === 'A-').length}</td><td>${each_val[4].filter(str => str  === 'B+').length}</td><td>${each_val[4].filter(str => str  === 'B').length}</td><td>${each_val[4].filter(str => str  === 'B-').length}</td><td>${each_val[4].filter(str => str  === 'C').length}</td><td>${each_val[4].filter(str => str  ==='C+').length}</td><td>${each_val[4].filter(str => str  ==='C-').length}</td>
                    <td>${each_val[4].filter(str => str  === 'D+').length}</td><td>${each_val[4].filter(str => str  === 'D').length}</td><td>${each_val[4].filter(str => str  === 'D-').length}</td><td>${each_val[4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${each_val[1]}</td><td>${each_val[2]}</td><td>${each_val[5]}</td><td>${each_val[3]}</td></tr>`;
            }
            $(".third_body").html(third_table_body);
        })

    })

    $("#hideprint").click(() => {
        $('#printtype_area').hide(500);
    })

    $(".first_up").hide()
    $(".first_down").show()
    $("input_area_first").hide()
    $(".first_up").on("click", () => {
        console.log("this is okay]");
        $(".first_down").show()
        $(".first_up").hide()
        $("#input_area_first").hide(300)
    })
    $(".first_down").on("click", () => {
        $(".first_down").hide()
        $(".first_up").show()
        $("#input_area_first").show(300)
    })

    $(".first_up").hide()
    $(".first_down").show()
    $("#form_area").hide()
    $(".first_up").on("click", () => {
        console.log("this is okay]");
        $(".first_down").show()
        $(".first_up").hide()
        $("#form_area").hide(300)
    })
    $(".first_down").on("click", () => {
        $(".first_down").hide()
        $(".first_up").show()
        $("#form_area").show(300)
    })



    $(".second_up").hide()
    $(".second_down").show()
    $("#option_elem").show()
    $(".second_up").on("click", () => {
        console.log("this is okay]");
        $(".second_down").show()
        $(".second_up").hide()
        $("#option_elem").hide(300)
    })
    $(".second_down").on("click", () => {
        $(".second_down").hide()
        $(".second_up").show()
        $("#option_elem").show(300)
    })


    $("#get_analysis").on("click", () => {
        $("#input_area_first").hide()
        str =
            '<div class="spinner-square" style="margin:auto"><div class="square-1 square"></div><div class="square-2 square"></div><div class="square-3 square"></div></div>'
        $("#elem_down").append(str)
        setTimeout(() => {
            $(".spinner-square").hide();
            $("#print_arr").show(600);
        }, 3000);
        stream_id = $("#select_stream").val();
        exam_id = $("#select_exam").val();
        form_id = $("#select_form").val();
        $.post("get_analysis_data", {
            stream_id: stream_id,
            exam_id: exam_id,
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res);
            console.log(res);
            (async function() {
                new Chart(
                    document.getElementById('classsubjectmeans'), {
                        type: 'bar',
                        data: {
                            labels: res.firth_table.map(row => row[0].substring(0, 3)
                                .toUpperCase()),
                            datasets: [{
                                label: "",
                                // res.third_table.map(row => row[5])
                                data: res.firth_table.map(row => row[3]),
                                barThickness: 15
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: false // This hides all text in the legend and also the labels.
                                }
                            },
                            scales: {
                                y: {
                                    suggestedMin: 6,
                                    suggestedMax: 6,
                                    ticks: {
                                        // forces step size to be 50 units
                                        stepSize: 1
                                    },
                                    title: {
                                        display: true,
                                        text: 'Points'
                                    },

                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                        }
                    }
                );
                const labelarr = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D',
                    'D-', 'E'
                ];
                const dataarr = [];
                for (dataval of res.sixth_table) {
                    if (dataval[0] == res.stream_name[0].stream) {
                        for (pp of labelarr) {
                            dataarr.push(dataval[4].filter(str => str === pp).length)
                        }
                    }
                }


                new Chart(
                    document.getElementById('overallclassstatistics'), {
                        type: 'bar',
                        data: {
                            labels: labelarr.map(row => row),
                            datasets: [{
                                data: dataarr.map(row => row),
                                barThickness: 15
                            }],
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: false // This hides all text in the legend and also the labels.
                                }
                            },
                            scales: {
                                y: {
                                    suggestedMin: 12,
                                    suggestedMax: 12,
                                    title: {
                                        display: true,
                                        text: 'Number of students'
                                    },
                                    ticks: {
                                        stepSize: 2
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    }
                );



                const datafirst = {
                    labels: res.sixth_table.map(row => row[0]),
                    datasets: [{
                        backgroundColor: '#90DE8F',
                        borderColor: '#90DE8F',
                        data: res.sixth_table.map(row => row[5]),
                        fill: true,
                    }]
                };
                new Chart(
                    document.getElementById('performance'), {
                        type: 'line',
                        data: datafirst,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                title: {
                                    display: false,
                                    text: 'Chart.js Line Chart'
                                },
                                legend: {
                                    display: false // This hides all text in the legend and also the labels.
                                }
                            },
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: false,
                                        text: 'Month'
                                    }
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: false,
                                        text: 'Value'
                                    },
                                    ticks: {
                                        // forces step size to be 50 units
                                        stepSize: 0.5
                                    }
                                }
                            }
                        },
                    }
                );


                const lastlabels = ["first_test 2023", "second 2023", "3rd 2023",
                    "4th 2023"
                ]
                const data = {
                    labels: lastlabels,
                    datasets: [{
                            label: 'Form 1',
                            data: [4.1, 2.3, 3.4, 2.3],
                            backgroundColor: "#FFBF75",
                            borderColor: "#FFBF75",
                            yAxisID: 'y',
                        },
                        {
                            label: 'Form 1 west',
                            data: [3.2, 2.4, 2.3, 4.5],
                            backgroundColor: "#ABFF9A",
                            borderColor: "#ABFF9A",
                            yAxisID: 'y',
                        },
                        {
                            label: 'Form 1 east',
                            data: [2.1, 3.5, 1.2, 1.3],
                            backgroundColor: "#655C6A",
                            borderColor: "#655C6A",
                            yAxisID: 'y',
                        }
                    ]
                };
                new Chart(
                    document.getElementById('performanceovertime'), {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            stacked: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Chart.js Line Chart - Multi Axis'
                                }
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',

                                    // grid line settings
                                    grid: {
                                        drawOnChartArea: false, // only want the grid lines for one axis to show up
                                    },
                                },
                            }
                        },
                    }
                );
            })();
            display_analysis(res)
        })
    })

    function display_analysis(data) {
        exam_name = data.exam_name[0].name;
        term = data.exam_name[0].term;
        year = data.exam_name[0].year;
        stream_name = data.stream_name[0].stream;
        form_name = data.form_name[0].name;
        $(".form_name").html(form_name);
        $(".stream_name").html(stream_name);
        $(".exam_name").html(exam_name);
        $(".year").html(year);
        $(".term").html(term);
        first_tbody = "";
        odered_fourth_table = array_order_for_fourthtable(data.firth_table);
        for (i = 0; i < odered_fourth_table.length; i++) {
            if (odered_fourth_table[i][5] > 0) {
                pointval = "+" + odered_fourth_table[i][5];
            } else {
                pointval = odered_fourth_table[i][5];
            }
            first_tbody +=
                `<tr><td>${odered_fourth_table[i][0]}</td><td>${odered_fourth_table[i][3]}</td><td>${pointval}</td>`;
            if (odered_fourth_table[i][5] > 0) {
                first_tbody +=
                    ` <td>
                    <svg xmlns="http://www.w3.org/2000/svg" style='width:20px;height:25px' version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8000000000000009,-9.797174393178837e-17,-9.797174393178837e-17,-0.8000000000000009,1.5999999999999925,14.400000000000006)"><path fill="#056b08" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg></td>`
            } else if (odered_fourth_table[i][5] == 0) {
                first_tbody +=
                    ` <td><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512;width:25px;height:25px" xml:space="preserve" class=""><g transform="matrix(0.9299999999999996,0,0,0.9299999999999996,1.1224774932861408,1.1204790496826256)"><path fill="#38a9ff" d="m29.778 15.293-9.071-9.071A1.01 1.01 0 0 0 19 6.929V11H3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h16v4.071q.18.978 1 1a.999.999 0 0 0 .707-.293l9.071-9.071a1 1 0 0 0 0-1.414z" data-name="01 Right" data-original="#ff3c38" class=""></path></g></svg></td>`
            } else {
                first_tbody +=
                    ` <td>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" style='width:20px;height:30px' xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8000000000000009,0,0,0.8000000000000009,1.5999999999999917,1.5999999999999917)"><path fill="#dd790b" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg></td>`
            }
            first_tbody += `<td>${odered_fourth_table[i][1]}</td></tr>`;
        }
        $(".first_table_tbody").html(first_tbody);

        ///second_table_body_analy start
        second_tbody_analy = '';
        a = data.overgrade_arr.filter(str => str === 'A').length;
        b = data.overgrade_arr.filter(str => str === 'A-').length;
        c = data.overgrade_arr.filter(str => str === 'B').length;
        d = data.overgrade_arr.filter(str => str === 'B').length;
        e = data.overgrade_arr.filter(str => str === 'B-').length;
        f = data.overgrade_arr.filter(str => str === 'C').length;
        g = data.overgrade_arr.filter(str => str === 'C').length;
        h = data.overgrade_arr.filter(str => str === 'C-').length;
        t = data.overgrade_arr.filter(str => str === 'D').length;
        j = data.overgrade_arr.filter(str => str === 'D').length;
        k = data.overgrade_arr.filter(str => str === 'D-').length;
        l = data.overgrade_arr.filter(str => str === 'E').length;
        o = data.firth_table[0][7];

        second_tbody_analy +=
            `<tr><td>Form ${form_name }  ${ data.stream_name[0].stream.charAt(0).toUpperCase() + data.stream_name[0].stream.slice(1)}</td><td>${a}</td><td>${b}</td><td>${c}</td><td>${d}</td><td>${e}</td><td>${f}</td><td>${g}</td><td>${h}</td><td>${t}</td>
                <td>${j}</td><td>${k}</td><td>${l}</td><td>0</td><td>1</td><td>${o}</td><td>${data.sixth_table[0][2]}</td><td>${data.sixth_table[0][6]}</td><td>${data.sixth_table[0][5]}</td><td>${data.sixth_table[0][7]}</td><td>${data.sixth_table[0][3]}</td><td>${data.sixth_table[0][8]}</td></tr>`
        for (i = 0; i < data.firth_table.length; i++) {
            second_tbody_analy +=
                `<tr><td>${data.firth_table[i][0]}</td><td>${data.firth_table[i][2].filter(str => str  === 'A').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'A-').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'B+').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'B').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'B-').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'C').length}</td><td>${data.firth_table[i][2].filter(str => str  ==='C+').length}</td><td>${data.firth_table[i][2].filter(str => str  ==='C-').length}</td>
                    <td>${data.firth_table[i][2].filter(str => str  === 'D+').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'D').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'D-').length}</td><td>${data.firth_table[i][2].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${data.firth_table[i][7]}</td><td>${data.firth_table[i][4]}</td><td>${data.firth_table[i][6]}</td><td>${data.firth_table[i][3]}</td><td>${data.firth_table[i][5]}</td><td>${data.firth_table[i][1]}</td><td>${data.firth_table[i][8]}</td></tr>`;
        }
        $(".second_body_analy").html(second_tbody_analy);
        ///third_table_body_analy start
        third_body_analy = "";
        let aa = bb = cc = dd = ee = ff = gg = hh = ii = jj = kk = ll = mm = nn = oo = pp = qq = rr = ss = tt = 0;
        for (i = 0; i < data.sixth_table.length; i++) {
            if (data.sixth_table[i][9] == stream_id) {
                $('.meanpoints').text(data.sixth_table[i][5])
                meanpoisnts_dev = check_biger(data.sixth_table[i][7]);
                meanmark_dev = check_biger(data.sixth_table[i][6]);
                $('.meanpoints_dev').html(meanpoisnts_dev);
                $('.meanmark').text(data.sixth_table[i][2] + "%")
                $('.meanmark_dev').html(meanmark_dev)
                $('.meangrade').text(data.sixth_table[i][3])
                $('#howmany').text(data.sixth_table[i][1])
                uppercased_str = data.sixth_table[i][0].charAt(0).toUpperCase() + data.sixth_table[i][0].slice(1)
                third_body_analy +=
                    `<tr style="color:green;background-color:#DDFFDD;font-weight:bold"><td>Form 2  ${uppercased_str}</td><td>${data.sixth_table[i][4].filter(str => str  === 'A').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'A-').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'B+').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'B').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'B-').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'C').length}</td><td>${data.sixth_table[i][4].filter(str => str  ==='C+').length}</td><td>${data.sixth_table[i][4].filter(str => str  ==='C-').length}</td>
                    <td>${data.sixth_table[i][4].filter(str => str  === 'D+').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'D').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'D-').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${data.sixth_table[i][1]}</td><td>${data.sixth_table[i][2]}</td><td>${data.sixth_table[i][6]}</td><td>${data.sixth_table[i][5]}</td><td>${data.sixth_table[i][7]}</td><td>${data.sixth_table[i][3]}</td><td>${data.sixth_table[i][8]}</td></tr>`;
            } else {
                uppercased_str = data.sixth_table[i][0].charAt(0).toUpperCase() + data.sixth_table[i][0].slice(1)
                third_body_analy +=
                    `<tr><td>Form 2 ${uppercased_str}</td><td>${data.sixth_table[i][4].filter(str => str  === 'A').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'A-').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'B+').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'B').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'B-').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'C').length}</td><td>${data.sixth_table[i][4].filter(str => str  ==='C+').length}</td><td>${data.sixth_table[i][4].filter(str => str  ==='C-').length}</td>
                    <td>${data.sixth_table[i][4].filter(str => str  === 'D+').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'D').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'D-').length}</td><td>${data.sixth_table[i][4].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${data.sixth_table[i][1]}</td><td>${data.sixth_table[i][2]}</td><td>${data.sixth_table[i][6]}</td><td>${data.sixth_table[i][5]}</td><td>${data.sixth_table[i][7]}</td><td>${data.sixth_table[i][3]}</td><td>${data.sixth_table[i][8]}</td></tr>`;
            }

            aa += data.sixth_table[i][4].filter(str => str === 'A').length;
            bb += data.sixth_table[i][4].filter(str => str === 'A-').length;
            cc += data.sixth_table[i][4].filter(str => str === 'B+').length;
            dd += data.sixth_table[i][4].filter(str => str === 'B').length;
            ee += data.sixth_table[i][4].filter(str => str === 'B-').length;
            ff += data.sixth_table[i][4].filter(str => str === 'C+').length;
            gg += data.sixth_table[i][4].filter(str => str === 'C').length;
            hh += data.sixth_table[i][4].filter(str => str === 'C-').length;
            tt += data.sixth_table[i][4].filter(str => str === 'D+').length;
            jj += data.sixth_table[i][4].filter(str => str === 'D').length;
            kk += data.sixth_table[i][4].filter(str => str === 'D-').length;
            ll += data.sixth_table[i][4].filter(str => str === 'E').length;
            oo += data.sixth_table[i][1];
            pp += data.sixth_table[i][2];
            qq += data.sixth_table[i][5];
            rr += data.sixth_table[i][6];
            ss += data.sixth_table[i][7];
        }
        third_body_analy +=
            `<tr><td>Form ${form_name}</td><td>${aa}</td><td>${bb}</td><td>${cc}</td><td>${dd}</td><td>${ee}</td><td>${ff}</td><td>${gg}</td><td>${hh}</td><td>${tt}</td>
                <td>${jj}</td><td>${kk}</td><td>${ll}</td><td>0</td><td>1</td><td>${oo}</td><td>${(pp/data.sixth_table.length).toFixed(2)}</td><td>${(rr/data.sixth_table.length).toFixed(2)}</td><td>${qq/data.sixth_table.length}</td><td>${ss/data.sixth_table.length}</td><td>${data.sixth_table[0][3]}</td><td></td></tr>`
        $(".third_body_analy").html(third_body_analy);
        /// third_table end
        /// fourth _table start
        let ordering_arr = array_order_analy(data.student_arr);
        fourth_body_analy = '';
        k = 0;
        for (student_value of ordering_arr) {
            if (k > 2) {
                continue;
            } else {
                Upper = student_value[2].charAt(0).toUpperCase() + student_value[2].slice(1)

                fourth_body_analy +=
                    `<tr><td>${student_value[0]}</td><td>${UpperWithCycle(student_value[1])}</td><td>${Upper}</td>`;
            }
            let order_form;
            let cnt = 1;
            var ordered_marks_form = [];
            for (i = 0; i < data.student_arr_new.length; i++) {
                ordered_marks_form = ordered_marks_form.concat(data.student_arr_new[i])
            }
            var ordered_marks_form = ordered_marks_form;
            ordered_marks_form = form_order_array_analy(ordered_marks_form)
            for (child_val of ordered_marks_form) {
                if (student_value[8] == child_val[1]) {
                    order_form = cnt;
                }
                cnt++;
            }
            fourth_body_analy +=
                `<td>${k+1}/${ordering_arr.length}</td><td>${order_form}/${ordered_marks_form.length}</td><td>${student_value[3]}</td><td>${student_value[4]}</td><td>${student_value[5]}</td><td>${student_value[6]}</td><td>${student_value[7]}</td></tr>`;
            k++;
        }
        $(".fourth_body_analy").html(fourth_body_analy);
        /// fourth _table end
        ///fifth start
        seven = data.seventh_table;
        divval = '';
        for (sevenval of seven) {
            divval += ` <div class="col-12" style="margin-bottom:30px"><p class="firstone" style="font-size:20px;text-align:left;padding:3px 10px;font-weight:bold;margin-bottom:0px;background-color: gainsboro;">${sevenval[0][0]}</p>
                                                    <table class="table table-striped  firstone customtable" style="margin-bottom:30px;border:3px solid black !important;;font-weight:bold;padding:3px !important">
                                                        <P style="font-size:20px;text-align:left;font-weight:bold;margin-bottom:0px;margin-left:7px" class="firstone"> Grade Summary ${sevenval[0][0]}</P>
                                                        <thead class="third_head_analy" style="">
                                                            <tr>
                                                                <th style="width:150px">Form</th>
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
                                                                <th>Subject Teacher</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody  style="">
                                                    `;

            let aa = bb = cc = dd = ee = ff = gg = hh = ii = jj = kk = ll = mm = nn = oo = pp = qq = rr = ss = tt =
                ww = 0;
            console.log(sevenval);
            for (i = 0; i < sevenval.length - 2; i++) {
                if (stream_id == sevenval[i][1]) {
                    if (sevenval[i][3] == 0) {
                        uppercased_str = sevenval[i][2].charAt(0).toUpperCase() + sevenval[i][2].slice(1)
                        divval += `<tr style="color:green;background-color:#DDFFDD;font-weight:bold"><td>Form ${form_name} - ${uppercased_str}</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td></td><td></td><td</td><td></td><td></td></tr>`;
                    } else {
                        uppercased_str_other = sevenval[i][2].charAt(0).toUpperCase() + sevenval[i][2].slice(1)
                        divval +=
                            `<tr style="font-weight:bold;color:green;background-color:#DDFFDD;"><td>Form ${form_name}  ${uppercased_str_other}</td><td>${sevenval[i][3].filter(str => str  === 'A').length}</td><td>${sevenval[i][3].filter(str => str  === 'A-').length}</td><td>${sevenval[i][3].filter(str => str  === 'B+').length}</td><td>${sevenval[i][3].filter(str => str  === 'B').length}</td><td>${sevenval[i][3].filter(str => str  === 'B-').length}</td><td>${sevenval[i][3].filter(str => str  === 'C+').length}</td><td>${sevenval[i][3].filter(str => str  ==='C').length}</td><td>${sevenval[i][3].filter(str => str  ==='C-').length}</td>
                    <td>${sevenval[i][3].filter(str => str  === 'D+').length}</td><td>${sevenval[i][3].filter(str => str  === 'D').length}</td><td>${sevenval[i][3].filter(str => str  === 'D-').length}</td><td>${sevenval[i][3].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${sevenval[i][4]}</td><td>${sevenval[i][5]}</td>
                    <td>${sevenval[i][6].toFixed(2)}</td><td>${sevenval[i][7].toFixed(2)}</td><td>${sevenval[i][8].toFixed(2)}</td><td>${sevenval[i][9]}</td><td>${sevenval[i][10]}</td></tr>`;
                        aa += sevenval[i][3].filter(str => str === 'A').length;
                        bb += sevenval[i][3].filter(str => str === 'A-').length;
                        cc += sevenval[i][3].filter(str => str === 'B+').length;
                        dd += sevenval[i][3].filter(str => str === 'B').length;
                        ee += sevenval[i][3].filter(str => str === 'B-').length;
                        ff += sevenval[i][3].filter(str => str === 'C+').length;
                        gg += sevenval[i][3].filter(str => str === 'C').length;
                        hh += sevenval[i][3].filter(str => str === 'C-').length;
                        tt += sevenval[i][3].filter(str => str === 'D+').length;
                        jj += sevenval[i][3].filter(str => str === 'D').length;
                        kk += sevenval[i][3].filter(str => str === 'D-').length;
                        ll += sevenval[i][3].filter(str => str === 'E').length;
                        oo += sevenval[i][4];
                        pp += sevenval[i][5];
                        qq += sevenval[i][6];
                        rr += sevenval[i][7];
                        ww += sevenval[i][8];
                        ss = sevenval[i][9];
                    }

                } else {
                    if (sevenval[i][3] == 0) {
                        if (sevenval[i][2] == 0) {
                            uppercased_str = "";
                        } else {
                            stream_name_str = sevenval[i][2];
                            uppercased_str = stream_name_str.charAt(0).toUpperCase() + stream_name_str.slice(1)
                        }

                        divval += `<tr ><td>Form ${form_name} - ${uppercased_str}</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                    <td></td><td></td><td</td><td></td><td></td></tr>`;
                    } else {
                        if (sevenval[i][2] == 0) {
                            uppercased_str = "";
                        } else {
                            stream_name_str = sevenval[i][2];
                            uppercased_str = stream_name_str.charAt(0).toUpperCase() + stream_name_str.slice(1)
                        }

                        divval +=
                            `<tr><td>Form ${form_name}  ${uppercased_str}</td><td>${sevenval[i][3].filter(str => str  === 'A').length}</td><td>${sevenval[i][3].filter(str => str  === 'A-').length}</td><td>${sevenval[i][3].filter(str => str  === 'B+').length}</td><td>${sevenval[i][3].filter(str => str  === 'B').length}</td><td>${sevenval[i][3].filter(str => str  === 'B-').length}</td><td>${sevenval[i][3].filter(str => str  === 'C+').length}</td><td>${sevenval[i][3].filter(str => str  ==='C').length}</td><td>${sevenval[i][3].filter(str => str  ==='C-').length}</td>
                    <td>${sevenval[i][3].filter(str => str  === 'D+').length}</td><td>${sevenval[i][3].filter(str => str  === 'D').length}</td><td>${sevenval[i][3].filter(str => str  === 'D-').length}</td><td>${sevenval[i][3].filter(str => str  === 'E').length}</td><td>0</td><td>0</td><td>${sevenval[i][4]}</td><td>${sevenval[i][5]}</td>
                    <td>${sevenval[i][6].toFixed(2)}</td><td>${sevenval[i][7].toFixed(2)}</td><td>${sevenval[i][8].toFixed(2)}</td><td>${sevenval[i][9]}</td><td>${sevenval[i][10]}</td></tr>`;
                        aa += sevenval[i][3].filter(str => str === 'A').length;
                        bb += sevenval[i][3].filter(str => str === 'A-').length;
                        cc += sevenval[i][3].filter(str => str === 'B+').length;
                        dd += sevenval[i][3].filter(str => str === 'B').length;
                        ee += sevenval[i][3].filter(str => str === 'B-').length;
                        ff += sevenval[i][3].filter(str => str === 'C+').length;
                        gg += sevenval[i][3].filter(str => str === 'C').length;
                        hh += sevenval[i][3].filter(str => str === 'C-').length;
                        tt += sevenval[i][3].filter(str => str === 'D+').length;
                        jj += sevenval[i][3].filter(str => str === 'D').length;
                        kk += sevenval[i][3].filter(str => str === 'D-').length;
                        ll += sevenval[i][3].filter(str => str === 'E').length;
                        oo += sevenval[i][4];
                        pp += sevenval[i][5];
                        qq += sevenval[i][6];
                        rr += sevenval[i][7];
                        ww += sevenval[i][8];
                        ss = sevenval[i][9];
                    }

                }

            }
            divval +=
                `<tr><td>Form ${form_name}</td><td>${aa}</td><td>${bb}</td><td>${cc}</td><td>${dd}</td><td>${ee}</td><td>${ff}</td><td>${gg}</td><td>${hh}</td><td>${tt}</td>
                <td>${jj}</td><td>${kk}</td><td>${ll}</td><td>0</td><td>1</td><td>${oo}</td><td>${(pp/sevenval.length-2).toFixed(2)}</td><td>${(qq/sevenval.length-2).toFixed(2)}</td><td>${(rr/sevenval.length-2).toFixed(2)}</td><td>${(ww/sevenval.length-2).toFixed(2)}</td><td>${ss}</td><td></td></tr></tbody></table>`
            divval += ` <div class="topstudent_table" style="display:none;margin-top:30px"><table class="table table-striped  customtable" style="margin-bottom:10px;border:3px solid black !important;font-weight:bold;padding:3px !important" >
                                                        <P style="font-size:20px;text-align:left;font-weight:bold;margin-bottom:2px">Top Students - ${sevenval[0][0]}</P>
                                                        <thead class="fourth_head_analy" style="">
                                                            <tr>
                                                                <th>Admno</th>
                                                                <th>Name</th>
                                                                <th>Stream</th>
                                                                <th>Strm Rank</th>
                                                                <th>Ovrl Rank</th>
                                                                <th>Score</th>
                                                                <th>Grade</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="fourth_body_analy" style="">
                                                    `;


            ordered_arr = array_order_custom(sevenval[sevenval.length - 2]);
            form_ordered_arr = array_order_custom_form(sevenval[sevenval.length - 1]);
            pl = 1;
            for (val_order of ordered_arr) {
                if (pl > 3) {
                    continue;
                } else {
                    let countx = 1;
                    for (perarr of form_ordered_arr) {
                        if (perarr[1] == val_order[5]) {
                            break
                        }
                        countx++;
                    }
                    erpdpa = UpperWithCycle(val_order[1])
                    divval +=
                        `<tr><td>${val_order[0]}</td><td>${erpdpa}</td><td>${val_order[2].charAt(0).toUpperCase() + val_order[2].slice(1)}</td><td>${pl}/${ordered_arr.length}</td>
                            <td>${countx}/${form_ordered_arr.length}</td><td>${val_order[3]}</td><td>${val_order[4]}</td></tr>`;
                }
                pl++;
            }


            divval += `</tbody></table></div></div>`

        }
        $(".lasttable").html(divval);
        ///fifth end
    }

    function check_biger(data) {
        if (Number(data) < 0) {
            return data + ` <icon style="float:right;margin-left:10px;margin-top:4px">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:25px;height:25px" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8000000000000009,0,0,0.8000000000000009,1.5999999999999917,1.5999999999999917)"><path fill="#dd790b" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg>
                                                                </icon>`;
        } else {
            return data + `<icon style="float:right;margin-left:10px;margin-top:4px">
                <svg xmlns="http://www.w3.org/2000/svg" style="width:25px;height:25px" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g transform="matrix(0.8900000000000007,-1.0899356512411454e-16,-1.0899356512411454e-16,-0.8900000000000007,0.8799999999999937,15.120000000000005)"><path fill="#e18306" d="m9 16 4-7h-3V0H3l2 3h2v6H4z" data-original="#444444" class=""></path></g></svg>
                                                                </icon>`;
        }
    }

    function array_order_custom(data) {
        let temp = [];
        for (i = 0; i < data.length; i++) {
            for (j = 0; j < data.length; j++) {
                if (i == j) {
                    continue;
                } else {
                    if (data[i][3] > data[j][3]) {
                        temp = data[j];
                        data[j] = data[i];
                        data[i] = temp
                    } else {
                        continue
                    }
                }
            }
        }
        return data;
    }


    function array_order_custom_form(data) {
        let temp = [];
        for (i = 0; i < data.length; i++) {
            for (j = 0; j < data.length; j++) {
                if (i == j) {
                    continue;
                } else {
                    if (data[i][0] > data[j][0]) {
                        temp = data[j];
                        data[j] = data[i];
                        data[i] = temp
                    } else {
                        continue
                    }
                }
            }
        }
        return data;
    }


    const checkboxes = document.querySelectorAll('.checkbox');

    // Attach event listeners to the checkboxes
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('click', function() {
            console.log(this.checked);
            // If both checkboxes are unchecked and the lower checkbox is checked,
            // check both checkboxes
            if (checkboxes[0].checked === false && checkboxes[1].checked === true &&
                checkbox === checkboxes[1]) {
                console.log("ok");
                checkboxes[0].checked = true;
                checkboxes[1].checked = true;
                $(".firstone").hide()
                $(".topstudent_table").show()
            }
            // If both checkboxes are checked and the upper checkbox is unchecked,
            // uncheck both checkboxes
            else if (checkboxes[0].checked === false && checkboxes[1].checked &&
                checkbox === checkboxes[0]) {
                console.log("thanks ");
                checkboxes[0].checked = false;
                checkboxes[1].checked = false;
                $(".topstudent_table").hide()
                $(".firstone").show()
            } else if (checkboxes[0].checked && checkbox === checkboxes[0]) {
                $(".topstudent_table").show()
                $(".firstone").show()
                console.log("hi");
            } else if (checkboxes[0].checked === false && checkbox === checkboxes[0]) {
                console.log("bi");
                $(".firstone").show()
                $(".topstudent_table").hide()
            } else if (checkboxes[1].checked && checkbox === checkboxes[1]) {
                console.log("there");
                $(".firstone").hide()
                $(".topstudent_table").show()
            }
            // If both checkboxes are checked and the lower checkbox is unchecked,
            // uncheck only the lower checkbox
            else if (checkboxes[0].checked && checkboxes[1].checked === false &&
                checkbox.checked === false) {
                console.log("12");
                checkboxes[1].checked = false;
                $(".firstone").show()
                $(".topstudent_table").show()
            }
        });
    });


})()

function UpperWithCycle(str) {
    str = str.split(' ');

    for (let i = 0; i < str.length; i++) {
        str[i] = str[i].substring(0, 1).toUpperCase() +
            str[i].substring(1).toLowerCase();
    }
    return str.join(' ');
}
$("#stream_sub").click(() => {
    let formname = $(".select_form_metalist").val()
    let streamname = $("#stream_sub").val()
    $.post('getsubjectlists', {
        form: formname,
        stream: streamname
    }, (res) => {
        res = JSON.parse(res);
        console.log(res)
        let selectoptions = '';
        for (eachval of res.subjects) {
            selectoptions += `<option value=${eachval[1]}>${eachval[0]} </option>`;
        }
        $("#select_subject").html(selectoptions);
    })
})

$("#get_class_list").click(() => {
    console.log("test");
    let form_name = (".select_form_metalist").val;
    let stream_name = ("#stream_sub").val;
    let subject_name = ("#select_subject").val;
    $("#middlepart").show()
    console.log("=>:", form_name);
})
</script>

<style>
.confirmbtn {
    background-color: #3C9A42;
    color: white;
    border-radius: 6px;
    border: #3C9A42 1px solid;
    width: 100px;
    font-size: 16px;
    height: 40px;
    margin-right: 10px;
    margin-top: 50px
}

.cancelbtn {
    background-color: white;
    color: green;
    border-radius: 6px;
    border: 1px solid #3C9A42;
    width: 100px;
    font-size: 16px;
    height: 40px;
    float: left;
    margin-top: 50px
}

#swal2-html-container {
    height: 185px;

    font-size: 20px;
    padding: 0px 20px;
    margin-top: 10px
}

.swal2-icon {
    margin-top: 20px
}

.swal2-actions {
    margin-top: 0px
}

#swal2-title {
    padding-top: 0px;

}

.swal2-html-container {
    height: 30px;
    margin: 0px;
    overflow: hidden;

}
</style>