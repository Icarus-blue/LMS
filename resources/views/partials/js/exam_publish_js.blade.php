<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
});

function publishResults() {
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
                title: "Resutls Published Successfully",
                text: "These results has been successfully published!",
                showConfirmButton: false,
                timer: 1500,
            })
            let elemets_arr = $(".subject_title_id");
            let subject_id_arr = [];
            for (val of elemets_arr) {
                subject_id_arr.push(val.value)
            }
            let grading_system_id_elements = $(".grading_system_id");
            let grading_system_id_arr = [];
            for (val of grading_system_id_elements) {
                grading_system_id_arr.push(val.value)
            }
            let new_arr = [];
            for (i = 0; i < subject_id_arr.length; i++) {
                new_arr.push(subject_id_arr[i], grading_system_id_arr[i])
            }
            let form_id = $("#form_id").val();
            let exam_id = $("#exam_id").val();
            let overal_grading_sys = $("#overal_grading_sys").val();

            $.post("{{route('add_grading_system_id')}}", {
                new_arr: new_arr,
                form_id: form_id,
                exam_id: exam_id,
                overal_grading_sys: overal_grading_sys
            }, () => {

            })
            $.post('{{ route("admin_publish") }}', {
                exam_id: $("#exam_id").val(),
                form_id: $("#form_id").val()
            }, (res) => {
                window.location.href = 'http://localhost:8000/exams';
            })
        }
    })
}

function showMerit() {
    alert('show merit');
}

function showImproveList() {
    alert('show improve list');
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
    height: 150px;
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