<script>
$("#pdfdownloading_area").hide()
$('#basictype').change(function() {
    console.log("basictype");
    if ($(this).is(':checked')) {
        $('#pdfdownloading_area').show();
        $('#custome').hide();
        $('#customtype').prop('checked', false);
    } else {
        $('#pdfdownloading_area').hide();
    }
});

$('#custom_excel').click(() => {
    var checkedValues = $('.testclass:checked').map(function() {
        return this.value;
    }).get();
    let form_id = $("#select_form_classlist").val();
    let stream_id = $("#select_stream_classlist").val();
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        type: 'get',
        url: "{{route('download_classlist_excel')}}",
        data: {
            stream_id: stream_id,
            form_id: form_id,
            values: checkedValues
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



$('#customtype').change(function() {
    console.log("customtype");
    if ($(this).is(':checked')) {
        $('#custome').show();
        $('#pdfdownloading_area').hide();
        $('#basictype').prop('checked', false);
    } else {
        $('#custome').hide();
    }
});

$("#class_list_asexcel").click(() => {
    let form_id = $("#select_form_classlist").val();
    let stream_id = $("#select_stream_classlist").val();
    $.ajax({
        xhrFields: {
            responseType: 'blob',
        },
        type: 'get',
        url: "{{route('download_classlist_excel')}}",
        data: {
            stream_id: stream_id,
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

var checkboxes = document.querySelectorAll(".testclass");
for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = true;
}

$("#select_form_classlist").on("click", (e) => {
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
            $("#select_stream_classlist").children().remove();
            $("#select_stream_classlist").append(option_arr);
        })
    }

})

$("#select_stream_classlist").click(() => {
    let formname = $("#select_form_classlist").val()
    let streamname = $("#select_stream_classlist").val()
    $.post('getsubjectlists', {
        form: formname,
        stream: streamname
    }, (res) => {
        res = JSON.parse(res);
        console.log(res)
        let selectoptions = '<option>Select Subject(Optional)</option>';

        for (eachval of res.subjects) {
            selectoptions += `<option value=${eachval[1]}>${eachval[0]} </option>`;
        }
        $("#select_subject").html(selectoptions);
    })
})


$("#get_class_list").click(() => {
    let form_name = $("#select_form_classlist").val()
    let stream_name = $("#select_stream_classlist").val()
    let subject_name = $("#select_subject").val();
    $.post('get_stream_stu_marks', {
        form: form_name,
        stream: stream_name,
        subject_id: subject_name
    }, (res) => {
        res = JSON.parse(res);
        let stu_data = res.data
        if (res.code == 1) {
            let class_list_table = '';
            console.log(stu_data[0].user);
            let i = 1
            for (eachval of stu_data) {
                class_list_table +=
                    `<tr class="class_list_tr"><td style="padding:0px 5px !important">${i}</td><td style="text-align:center;padding:0px 5px !important"> <img style="display:inline-block;border-radius:30px" src="{{asset('assets/images/avatar_blue.png')}}" style="float:left" width="50" height="50"
                                ></td><td style="padding:0px 5px !important">${eachval.adm_no}</td><td style="padding:0px 5px !important">${capitalizeEveryWord(eachval.user.name)}</td><td style="padding:0px 5px !important">${eachval.kcpe}</td></tr>`;
                i++;
            }

            $(".class_list_tbody").html(class_list_table);

        }
        $("#pdfdownloading_area").show()
        $("#form_area").hide()
        $(".class_list_up").hide()
        $(".class_list_down").show()
        $("#class_list_option").show()
    })
})

function capitalizeEveryWord(str) {
    var words = str.split(' ');
    for (var i = 0; i < words.length; i++) {
        words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
    }
    return words.join(' ');
}
$("#class_list_aspdf").click(() => {
    let form_id = $("#select_form_classlist").val();
    let stream_id = $("#select_stream_classlist").val();
    $.ajax({
        type: 'GET',
        url: "{{route('download_class_list_pdf')}}",
        data: {
            stream_id: stream_id,
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
            link.download = "download_class_list_pdf.pdf";
            link.click();
        },
        error: function(blob) {
            console.log(blob);
        }
    });
})




$(".class_list_up").hide()
$(".class_list_down").show()
$("#class_list_option").hide()
$(".class_list_up").on("click", () => {
    console.log("this is okay]");
    $(".class_list_down").show()
    $(".class_list_up").hide()
    $("#class_list_option").show(300)
})
$(".class_list_down").on("click", () => {
    $(".class_list_down").hide()
    $(".class_list_up").show()
    $("#class_list_option").hide(300)
})


function fnPrintReport_class_list(e) {
    e.preventDefault();
    let form_name = $("#select_form_classlist").val()
    let stream_name = $("#select_stream_classlist").val()
    let subject_name = $("#select_subject").val();
    $.post('get_stream_stu_marks', {
        form: form_name,
        stream: stream_name,
        subject_id: subject_name
    }, (res) => {
        res = JSON.parse(res);
        let stu_data = res.data
        if (res.code == 1) {
            let class_list_table = '';
            console.log(stu_data[0].user);
            let i = 1
            for (eachval of stu_data) {
                class_list_table +=
                    `<tr class="class_list_tr" ><td style="padding:0px 5px">${i}</td><td style="padding:0px 5px">${eachval.adm_no}</td><td style="padding:0px 5px">${capitalizeEveryWord(eachval.user.name)}</td><td style="padding:0px 5px">${eachval.kcpe}</td><td></td><td></td><td></td><td></td></tr>`;
                i++;
            }

            $(".class_list_tbody_pdf").html(class_list_table);

        }
    })
    var mywindow = window.open('', 'PRINT', 'height=1800,width=1500');
    mywindow.document.write(`<html><head><title>' + " " + '</title><style type="text/css"> table thead th, table tbody td {border:1px solid black;border-collapse: collapse;padding:3px;}
       </style>`);
    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write(
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
    );
    mywindow.document.write(
        '<style>.customtable,th {    border: 2px solid black !important;font-size:15px;    border-collapse: collapse !important; }.customtable,td { border: 2px solid black !important;font-size:15px; border-collapse: collapse !important}</style>'
    );
    mywindow.document.write(
        '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">'
    );
    mywindow.document.write('</head><body >');
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('class_list_download').innerHTML);
    mywindow.document.write(
        '</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();
    return true;
}
</script>

<style>
.class_list_tr>td {
    padding: 15px !important;
}
</style>