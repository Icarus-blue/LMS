<script>
    function selectExam_Test() {

        var exam_class_tbody = document.getElementById('exam_class_tbody');
        var exam = document.getElementById('exam_class_select');
        var form_id = $("#form_id").val();
        let formData = new FormData();
        if (exam == null) {
            formData.append("exam", 0);
        } else {
            formData.append("exam", exam.value);
        }
        var ajaxOptions = {
            url: 'class_index',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(res) {
            console.log("after ajax ===> ", res);
            cc = '';
            // console.log('all_classes', res.all_myclasses);
            for (let myclass of res.all_myclasses) {
                console.log("myclass", myclass);
                if (myclass.form_id == form_id) {
                    cc += `
                <tr>
                    <td style="font-family: 'Times New Roman', Times, serif;">Form` + myclass.form.name + ` ` + myclass.stream + `</td>
                `;
                    cc += `<td class="text-danger" style="font-family: 'Times New Roman', Times, serif;">View Results</td>`;
                    cc += `<td class="text-right" style="padding-right:5px !important;font-family: 'Times New Roman', Times, serif;">`;
                    cc += `<a  href = "exam_stream_view/` + myclass.teacher_id + `/` + myclass.id + `/` + exam.value + `" class="btn btn-info" style="font-family: 'Times New Roman', Times, serif;background: #b7c1d1;color: #172b4c;margin-top:2px;margin-bottom:2px;padding-left:1.3rem;padding-right:1.3rem;border-radius:5px;">View</a>`
                    cc += "</td><td class='d-none'>" + myclass.id + "</td><td class='d-none'>" + myclass.teacher_id + "</td></tr>"
                }
            }
            exam_class_tbody.innerHTML = cc;
        }).fail(function(e) {
            if (e.status == 422) {
                var errors = e.responseJSON.errors;
                displayAjaxErr(errors);
            }
            if (e.status == 500) {
                displayAjaxErr([e.status + ' ' + e.statusText + ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'])
            }
            if (e.status == 404) {
                displayAjaxErr([e.status + ' ' + e.statusText + ' - Requested Resource or Record Not Found'])
            }
            return e.status;
        })

    }

    function publish_supervisor(form_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'confirmbtn',
                cancelButton: 'cancelbtn'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "Are you sure?",
            text: "After publishing the results the won't be able to the subject teacher for editing?",
            icon: "error",
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonColor: '#3C9A42',
            confirmButtonText: "Proceed",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    title: "Results Published Successfully",
                    text: "These results has been successfully published!",
                    showConfirmButton: false,
                    timer: 1500,
                })
                var exam_id = $("#exam_class_select").val();
                $.post('{{ route("supervisor_publish_mark") }}', {
                    exam_id: exam_id,
                    form_id: form_id
                }, (res) => {
                    window.location.href = 'http://localhost:8000/exams';
                })
            }
        })
    }
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
        height: 50px;
        font-family: 'Times New Roman', Times, serif;
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
        font-family: 'Times New Roman', Times, serif;
    }

    .swal2-html-container {
        height: 30px;
        margin: 0px;
        overflow: hidden;

    }
</style>