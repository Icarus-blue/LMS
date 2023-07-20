<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
<script>
$(".up_arrow_leave").hide()
$(".down_arrow_leave").show()
$("#leave_certificate").hide()
$(".up_arrow_leave").on("click", () => {
    $(".down_arrow_leave").show()
    $(".up_arrow_leave").hide()
    $("#leave_certificate").hide(300)
})
$(".down_arrow_leave").on("click", () => {
    $(".down_arrow_leave").hide()
    $(".up_arrow_leave").show()
    $("#leave_certificate").show(300)
})

$("#select_form_leave").on("click", (e) => {
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
            $("#select_stream_leave").children().remove();
            $("#select_stream_leave").append(option_arr);
        })
    }
})

function validateInput(input) {
    if (!input.checkValidity()) {
        input.classList.add('is-invalid');
    } else {
        input.classList.remove('is-invalid');
    }
}

$("#search_certificate").on("click", () => {
    const input1 = document.getElementById('select_form_leave');
    const input2 = document.getElementById('select_stream_leave');
    stream_id = input2.value;
    form_id = input1.value;
    input1.addEventListener('blur', function() {
        validateInput(input1);
    });

    input2.addEventListener('blur', function() {
        validateInput(input2);
    });
    validateInput(input1);
    validateInput(input2);
    if (form_id.trim() !== '' && stream_id.trim() !== '') {
        $("#leave_certificate").hide()

        $.post("{{route('search_stream_certificate')}}", {
            stream_id: stream_id,
            form_id: form_id
        }, (res) => {
            res = JSON.parse(res);
            console.log(res);
            $("#studentlist_panel").show(600);
            disStudentList(res.data, res.streamname)
        })
    }
})

const disStudentList = (data, streamname) => {
    header = [{
        title: "No",
        data: "No",
        "width": "10%"
    }, {
        title: "AdmNo",
        data: "AdmNo",
        "width": "15%"
    }, {
        title: "Name",
        data: "Name",
        "width": "50%"
    }, {
        title: "Stream",
        data: "Stream",
        "width": "15%"
    }, {
        title: "Action",
        data: "Action",
        className: "text-center",
        "width": "20%"
    }]
    str = "";
    i = 1;
    object_arr = [];
    for (row of data) {
        newobj = {}
        newobj.No = i;
        newobj.AdmNo = row.adm_no;
        newobj.Name = titleCase(row.user.name);
        newobj.Stream = titleCase(streamname);
        newobj.Action =
            `<button style="border:none;background-color:#E4E6EF" onClick="getCertificateDetail(${row.id})">View  Certificate</button>`;
        object_arr
            .push(newobj);
        i++;
    }
    $('#studentlist_leave').DataTable({
        dom: "<'row'<'col-sm-6'l><'col-sm-6'>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        bAutoWidth: false,
        lengthChange: false,
        "ordering": false,
        data: object_arr,
        columns: header,
        "dom": '<"top"i>rt<"bottom"p><"clear">',
        "pagingType": "simple",
        "language": {
            "paginate": {
                "next": "&gt;", // Use a custom forward arrow symbol
                "previous": "&lt;" // Use a custom backward arrow symbol
            }
        }

    });

}
// viewcertificate/${row.id}
function getCertificateDetail(id) {
    $.ajax({
        url: '/viewcertificate',
        method: 'POST',
        data: {
            id: id,
        },
        success: function(response) {
            let res = JSON.parse(response);
            let userdata = res.data.user
            let newarr = [];
            newarr.push([userdata.birthdate, "Birthdate"], [userdata.addmissiondate,
                "Admission Date"
            ], [
                userdata.generalcomment, "General Commment"
            ])
            let str = `<ul style='padding:0px 100px;margin-bottom:30px'>`;
            for (each of newarr) {
                if (each[0] == null || each[0] == '') {
                    str += `<li style="font-weight:bold">${each[1]}</li>`
                }
            }
            str += `</ul>`;
            if ((userdata.addmissiondate == null || userdata.addmissiondate == "") || (userdata
                    .birthdate == null || userdata.birthdate == "") || (userdata
                    .generalcomment == null || userdata.generalcomment == '')) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'confirmbtn',
                        cancelButton: 'cancelbtn'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                        title: "Failed to view Certificate!",
                        html: `<p>The following information is not provided:</p>${str}<p>Proceed to add the information?</p>`,
                        icon: "warning",
                        showCancelButton: true,
                        icon: "error",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            // User clicked the "Yes" button
                            window.location.href = '/editprofile/' + res.data.id;
                        } else {
                            // User clicked the "No" button

                        }
                    });
            } else {
                window.location.href = '/editstudentprofile/' + res.data.id;
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
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


function fnPrintReport_Certificate(e) {
    e.preventDefault();
    var mywindow = window.open('', 'PRINT', 'height=800,width=1024');
    mywindow.document.write('<html><head><title>' + " " + '</title>');
    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write(`<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">`);
    mywindow.document.write('</head><body >');
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('certificate_download_area').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();
    return true;
}
</script>

<style>
.text-center {
    text-align: center;
}

.dataTables_paginate .paginate_button:hover {
    background-color: green;
    color: white;
}

.dataTables_paginate .paginate_button {
    background-color: #2EA5DE;
    color: white;
}

.dataTables_wrapper .dataTables_paginate {
    margin-top: 30px;
}

.dataTables_wrapper .dataTables_info {
    text-align: center;
}
</style>