<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    var exam_index_tbody = document.getElementById('exam_index_tbody');
    var tableDiv = document.getElementById('exam_index_body');
    // getInitExam();
    selectExam();
    var exam_type_elem = document.querySelectorAll('input[name=exam_type]');
    for (const radioButton of exam_type_elem) {
        radioButton.addEventListener('change', displayExamType);
    }
    var ordinary_body = document.querySelector('#ordinary_body');
    var consolidated_body = document.querySelector('#consolidated_body');
    var year_body = document.querySelector('#year_body');
    var ksce_body = document.querySelector('#ksce_body');

    function publish_mark() {
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
                var post_obj = {
                    class_exam_count: $("#class_exam_count").val(),
                    subjectID: $("#subjectID").val(),
                    classID: $("#classID").val(),
                    examID: $("#examID").val(),
                    teacherID: $("#teacherID").val(),
                    formteacherID: $("#formteacherID").val(),
                    exam_class_upload_max: $("#exam_class_upload_max").val(),

                };
                var len = $("#class_exam_count").val();
                for (var i = 0; i < len; i++) {
                    let val1 = $("#student" + i).val()
                    let val2 = $("#mark" + i).val();
                    post_obj["student" + i] = val1;
                    post_obj["mark" + i] = val2;

                }

                $.post('{{ route("exam_class_publish_mark") }}', post_obj, (res) => {
                    window.location.href = 'http://localhost:8000/exams';
                })
            }
        })
    }

    function stream_publish(exam_id, class_id) {
        let tbody = document.getElementById('exam_class_tbody_stream');
        tr_arr = tbody.getElementsByTagName("tr");
        if (tr_arr.length > 0) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'confirmbtn',
                    cancelButton: 'cancelbtn'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: "Publishing Fail",
                text: "Publishing not successful because some subjects don't have marks right now.",
                icon: "error",
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonColor: '#3C9A42',
                confirmButtonText: "OK",
            })
        } else {
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

                    $.post('{{ route("stream_publish") }}', {
                        exam_id: exam_id,
                        class_id: class_id
                    }, (res) => {
                        window.location.href = 'http://localhost:8000/exams';
                    })
                }
            })
        }
    }

    function edit_on_view() {
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
                window.location.href = 'http://localhost:8000/exams';

            }
        })
    }

    function upload_result() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'confirmbtn',
                cancelButton: 'cancelbtn'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "Upload of Results!",
            text: "Are you sure you'd like to upload these results?",
            icon: "error",
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonColor: '#3C9A42',
            confirmButtonText: "Proceed",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: "success",
                    text: "These results has been successfully uploaded!",
                    showConfirmButton: false,
                    timer: 4500,
                })
                var post_obj = {
                    class_exam_count: $("#class_exam_count").val(),
                    subjectID: $("#subjectID").val(),
                    MyClassID: $("#MyClassID").val(),
                    ExamID: $("#ExamID").val(),
                    TeacherID: $("#TeacherID").val(),
                    exam_class_upload_max: $("#exam_class_upload_max").val(),

                };
                var len = $("#class_exam_count").val();
                console.log(len);

                for (var i = 0; i < len; i++) {
                    let val1 = $("#student" + i).val()
                    let val2 = $("#mark" + i).val();
                    post_obj["student" + i] = val1;
                    post_obj["mark" + i] = val2;

                }

                $.post('{{route("exam_class_upload_mark")}}', post_obj, (res) => {
                    window.location.href = 'http://localhost:8000/exams';
                })
            }
        })
    }

    function grant_access() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'confirmbtn',
                cancelButton: 'cancelbtn'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "Granting access!",
            text: "Are you sure you'd like to grant access to subject teachers?",
            icon: "error",
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonColor: '#3C9A42',
            confirmButtonText: "Proceed",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({ 
                    icon: "success",
                    text: "Granting success",
                    showConfirmButton: false,
                    timer: 4500,
                })

                var checkedbox = document.getElementsByClassName('qwer');
                var arr = [];
                for (var i = 0; i < checkedbox.length; i++) {
                    var val_arr = checkedbox[i].value.split(",")
                    obj = {
                        "subject_id": val_arr[0],
                        "exam_id": val_arr[1],
                        "myclass_id": val_arr[2],
                        "teacher_id": val_arr[3],
                    }
                    arr.push(obj)
                }
                $.post('{{route("grant_access_to_subject_teachers")}}', {
                    arr: arr
                }, (res) => {
                    window.location.href = 'http://localhost:8000/exams';
                })
            }
        })
    }

    function grant_access_to_subject(event) {
        var class_subject_tds = document.getElementsByClassName('class_subject_td');
        for (let i = 0; i < class_subject_tds.length; i++) {
            dataId = $(class_subject_tds[i]).attr("data-id");
            console.log("dataId:", dataId);
            class_subject_tds[i].innerHTML = '<input type="checkbox" class="qwer" value=' + dataId + '>';
        }

        var check_all_th = document.getElementById('check_all');
        check_all_th.innerHTML = '<input type="checkbox"  onclick="check_all(this)" style="margin-right: 1rem;">';

        event.target.style.display = "none";
        document.getElementById('grant_access_btn').style.display = "block"
    }

    function check_all(myobasdf) {
        var qwer = document.getElementsByClassName('qwer');
        if (myobasdf.checked) {
            for (let i = 0; i < qwer.length; i++) {
                qwer[i].checked = true;
            }
        } else {
            for (let i = 0; i < qwer.length; i++) {
                qwer[i].checked = false;
            }
        }
    }

    function displayExamType(e) {
        if (e.target.value == "KCSE") {
            ordinary_body.classList.add('active-state');
            consolidated_body.classList.add('active-state');
            year_body.classList.add('active-state');
            ksce_body.classList.remove('active-state');
        } else if (e.target.value == "Consolidated_Exam") {
            ordinary_body.classList.add('active-state');
            consolidated_body.classList.remove('active-state');
            year_body.classList.add('active-state');
            ksce_body.classList.add('active-state');
        } else if (e.target.value == "Year_Average") {
            ordinary_body.classList.add('active-state');
            consolidated_body.classList.add('active-state');
            year_body.classList.remove('active-state');
            ksce_body.classList.add('active-state');
        } else {
            // if(e.target.value == "KCSE"){
            ordinary_body.classList.remove('active-state');
            consolidated_body.classList.add('active-state');
            year_body.classList.add('active-state');
            ksce_body.classList.add('active-state');
        }
    }
    // for manage exam tab
    function createHeadings(item_no) {
        const headings = [{
                label: "Exam",
                for: "name"
            },
            {
                label: "Class",
                for: "class"
            },
            {
                label: "Status",
                for: "status"
            },
            {
                label: "Update by",
                for: "Update by"
            },
            {
                label: "Update on",
                for: "Update on"
            },
            {
                label: "Action",
                for: "action"
            },
        ];
        let thead = document.createElement("thead"),
            trHeading = document.createElement("tr");
        thead.classList.add("text-center");
        headings.forEach(heading => {
            const th = document.createElement("th"),
                thContent = document.createTextNode(heading.label);
            th.style.padding = "5px";
            if (heading.label == "Action") {
                th.colSpan = 4;
            } else if (heading.label == "Update by") {
                th.style.width = "150px";
            } else if (heading.label == "Update on") {
                th.style.width = "150px";
            } else if (heading.label == "Class") {
                th.style.width = "300px";
            } else if (heading.label == "Exam") {
                th.style.width = "200px";
            } else if (heading.label == "Status") {
                th.style.width = "300px";
            }
            th.appendChild(thContent);
            trHeading.appendChild(th);
        });
        var tableClass = "." + "table" + item_no
        let table = document.querySelector(tableClass);
        table.appendChild(thead);
        thead.appendChild(trHeading);
    }
    var flag = false;

    function getInitExam(year = 1) {
        let formData = new FormData();
        formData.append("year", year);
        var ajaxOptions = {
            url: 'exam_index',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log(resp)
            tableDiv.innerHTML = '';
            for (let item of resp.terms) {
                let bb = '';
                let i = 0;
                let label = document.createElement("label");
                label.style.fontFamily = "'Times New Roman', Times, serif"
                label.style.fontSize = "18px"
                let table = document.createElement("table");
                table.style.fontFamily = "'Times New Roman', Times, serif"
                let tbody = document.createElement("tbody");
                for (let entry of resp.exams) {
                    if (item.term == entry.term) {
                        i++;
                        if (i == 1) {
                            console.log('term', item.term);
                            label.textContent = "Term" + item.term; // Term 1
                            label.style.cssFloat = "left"
                            tableDiv.appendChild(label);
                            table.classList.add("table");
                            table.classList.add("table-bordered");
                            table.classList.add("table" + item.term);
                            tableDiv.appendChild(table);
                            createHeadings(item.term);
                            table.appendChild(tbody);
                        }
                        let rr = 0;
                        for (let ef of resp.examforms) {
                            if (entry.id == ef.exam_id) { // exams.id == examforms.exam_id
                                rr++;
                            }
                        }
                        let flagexamname = false;
                        let flagexamedit = false;
                        for (let ef of resp.examforms) {
                            if (entry.id == ef.exam_id) { // exams.id == examforms.exam_id
                                bb += `<tr>`;
                                if (flagexamname == false) {
                                    bb += `<td rowspan="` + rr + `" style='height:55px;text-align:left'>` + entry.name + `</td>`; //exams.name
                                    flagexamname = true;
                                }
                                for (let f of resp.forms) {
                                    if (f.id == ef.form_id) bb += `<td style='height:55px ;text-align:left'>Form ` + f.name + `</td>`; // form.id == examforms.form_id
                                }
                                if (ef.flag) {
                                    bb += `<td style='height:55px;text-align:left'>Published</td>`;
                                } else {
                                    bb += `<td style='height:55px;text-align:left'>Results Not Uploaded</td>`;

                                }
                                bb += `<td style='height:55px'></td><td style='height:55px'></td>`;
                                if (flagexamedit == false) {
                                    bb += `<td class="d-none" >Term` + entry.term + `</td>
                                            <td class="d-none">` + entry.year + `</td>
                                            <td class="text-center" align="center" style='height:55px;padding:5px !important' rowspan="` + rr + `">
                                                <div class="col-2" display: flex;justify-content: space-around;>
                                                    <a class="btn d-flex flex-row" href='/exams/` + entry.id + `' style="color:#172b4c !important; background-color:#e6e6e6; border-color: #999; width: 83px;font-size:15px;border-radius:8px; height: 50px;">
                                                        <span>
                                                            <div class="d-flex">
                                                                <i _ngcontent-are-c166="" style="transform: translate(8px, -12px);"><svg _ngcontent-are-c166="" style="margin-right:10px;margin-top:15px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="bi bi-pen"><path _ngcontent-are-c166="" d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path></svg></i>
                                                                <p class="m-0">Edit</p>
                                                            </div>
                                                            <p class="m-0" style="transform: translate(10px, -14px);">Exam</p>
                                                        </span>
                                                    </a>
                                                </div>
                                            </td>`;
                                    flagexamedit = true;
                                }
                                if (ef.flag) {
                                    bb += `<td align="center" class=action` + ef.exam_id + ef.form_id + ` style='height:55px;padding:5px !important' >
                                                <a class="btn d-flex flex-row"  style="color:#B5ACBC !important; background-color:#F9F9FB; pointer-events: none; cursor: default; border-color: #999; width: 140px;padding:10px;font-size:16px;border-radius:10px" disabled>
                                                    <i _ngcontent-are-c166="">
                                                        <svg _ngcontent-are-c166="" style="margin-top:5px;margin-right:5px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="bi bi-diagram-3">
                                                            <path _ngcontent-are-c166="" fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z">
                                                            </path>
                                                        </svg>
                                                    </i>
                                                    Subject Papers
                                                </a>
                                            </td>`;
                                } else {
                                    bb += `<td align="center" class=action` + ef.exam_id + ef.form_id + ` style='height:55px;padding:5px !important'>
                                                <a class="btn d-flex flex-row" href="/exam_manage/config/` + ef.exam_id + `/` + ef.form_id + `" style="color:#172b4c !important; background-color:#e6e6e6; border-color: #999; width: 140px;padding:10px;font-size:16px;border-radius:10px">
                                                    <i _ngcontent-are-c166="">
                                                        <svg _ngcontent-are-c166=""  style="margin-right:5px;margin-top:5px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="bi bi-diagram-3"><path _ngcontent-are-c166="" fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z">
                                                        </path>
                                                        </svg>
                                                    </i>
                                                    Subject Papers
                                                </a>
                                            </td>`;
                                }
                                if (!ef.flag) {
                                    bb += `<td align="center" style='height:55px;padding:5px !important' class=action` + ef.exam_id + ef.form_id + `>
                                                        <a class="btn" href="/exam_manage/publish/` + ef.exam_id + `/` + ef.form_id + `"  style="font-size:13px;border-radius:7px;color:white; background-color:#152D4e; width: 140px; display: flex; flex-direction: row;padding:4px" >
                                                            <i _ngcontent-sdf-c166="" class="me-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right:8px" class="bi bi-upload" viewBox="0 0 16 16">
                                                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                                </svg>
                                                            </i>
                                                            <span> Uploade Results</span>
                                                        </a>
                                                        </td>`;
                                    // bb += `<td style='height:55px' class=action` + ef.exam_id + ef.form_id + `>
                                    //                     <a class="btn" onclick="Sendpublish(` + ef.id + `)"  style="color:white; background-color:#152D4e; width: 132px; display: flex; flex-direction: row;padding:8px">
                                    //                         <i _ngcontent-sdf-c166="" class="me-1">
                                    //                             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-right:5px" class="bi bi-upload" viewBox="0 0 16 16">
                                    //                                 <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                    //                                 <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                    //                             </svg>
                                    //                         </i>
                                    //                         <span> Publish Results</span>
                                    //                     </a>
                                    //         </td>`;
                                    bb += `<td class=action` + ef.exam_id + ef.form_id + ` style='height:55px;padding:5px !important'  align="center">
                                                <button type="button" class="btn delete_btn" onclick="onDeleteEachExam(` + ef.exam_id + `, ` + ef.form_id + `, this);"  >
                                                <i _ngcontent-qlf-c166="" class="me-1"><svg _ngcontent-qlf-c166="" xmlns="http://www.w3.org/2000/svg" style="margin-right:15px;margin-top:5px" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="bi bi-trash"><path _ngcontent-qlf-c166="" d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path><path _ngcontent-qlf-c166="" fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path></svg></i> Delete
                                                </button>
                                            </td>`;
                                } else {
                                    bb += `<td class=action` + ef.exam_id + ef.form_id + ` align="center" style='height:55px;padding:5px !important'>
                                                <a class="btn publish_btn" style="border-radius:7px;color:white; background-color:#00B6FF; width: 130px; display: flex; flex-direction: row;padding:1px 19px;font-size:16px; height: 50px;">
                                                    <span>
                                                        <div class="d-flex">
                                                            <i _ngcontent-sdf-c166="" class="me-1" style="transform: translate(8px, -13px);">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" style="margin-right:10px;margin-top:16px" class="bi bi-clipboard-data" viewBox="0 0 16 16">
                                                                    <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V7zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0V9z"/>
                                                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                                                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                                                                </svg>
                                                            </i>
                                                            <p class="m-0">Analyze</p>
                                                        </div>
                                                        <p class="m-0" style="transform: translate(4px, -13px);">Results</p>
                                                    </span>
                                                </a>
                                            </td>`;

                                    bb += `<td class=action` + ef.exam_id + ef.form_id + ` align="center" style='height:55px;padding:2px !important'>
                                                <button type="button" class="btn send_result" onclick="SendRequest(` + ef.exam_id + `, ` + ef.form_id + `);"  >
                                                    <i _ngcontent-qlf-c166="" class="me-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="margin-left:0px;margin-top:5px;margin-right:7px" class="bi bi-telegram" viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.287 5.906c-.778.324-2.334.994-4.666 2.01-.378.15-.577.298-.595.442-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294.26.006.549-.1.868-.32 2.179-1.471 3.304-2.214 3.374-2.23.05-.012.12-.026.166.016.047.041.042.12.037.141-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8.154 8.154 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629.093.06.183.125.27.187.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.426 1.426 0 0 0-.013-.315.337.337 0 0 0-.114-.217.526.526 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09z"/>
                                                        </svg>
                                                    </i>
                                                Send Results
                                                </button>
                                                <button type="button" class="btn un_publish_result" onclick="unpublish(` + ef.exam_id + `, ` + ef.form_id + `);" >
                                                    <span>
                                                        <div class="d-flex">
                                                            <i _ngcontent-qlf-c166="" class="me-1" style="transform: translate(8px, -4px);">
                                                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:8px;float:left;margin-right:10px" width="16" height="16"  fill="currentColor" class="bi bi-box-arrow-in-down" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1h-2z"/>
                                                                    <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                                </svg>
                                                            </i>
                                                            <p class="m-0" style="padding-top: 2px;">Unpublish</p>
                                                        </div>
                                                        <p class="m-0" style="transform: translate(6px, -7px);">Result</p>
                                                    </span>
                                                </button>
                                            </td>`;
                                }
                            }
                        }
                        bb += `</div></div></tr>`;

                    }
                }
                tbody.innerHTML = bb;
                let br = document.createElement("br");
                tableDiv.appendChild(br);
                // $(".publish_btn").click((e) => {

                // })
            }



            return resp;
        });
        req.fail(function(e) {
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
        });

    }
    let origin_type, origin_name, origin_term, origin_year, origin_i, origin_id, edit_status = false;
    let post_type, post_name, post_term, post_year, post_id;

    function onEditExam(i, id, type, name, term, year, myObj) {

        if (edit_status == true) {

            let origin_ss = exam_index_tbody.children[origin_i - 1].children;
            origin_ss[1].innerHTML = origin_type;
            origin_ss[2].innerHTML = origin_name;
            origin_ss[3].innerHTML = 'Term ' + origin_term;
            origin_ss[4].innerHTML = origin_year;
            origin_ss[5].innerHTML = `<button type="button" class="btn" onclick="onEditExam('` + origin_i + `', '` + origin_id + `', '` + origin_type + `', '` + origin_name + `', '` + origin_term + `', '` + origin_year + `', this);" style="background: white;">
                                <img src="global_assets/images/icon/edit.png" width=25 height=25 />
                            </button>
                            <button type="button" class="btn" onclick="onDeleteExam('` + origin_id + `', this);" style="background: white;" >
                                <img src="global_assets/images/icon/delete.png" width=25 height=25 />
                            </button>`;
            edit_status = false;
        }
        origin_i = i;
        origin_id = id;
        post_id = id;
        origin_name = name;
        post_name = name;
        origin_term = term;
        post_term = term;
        origin_type = type;
        post_type = type;
        origin_year = year;
        post_year = year;

        let ss = myObj.parentNode.parentNode.children;
        ss[1].innerHTML = `<select data-placeholder="Select Type" class="form-control" onchange="buffExamType(this);">
                            <option ` + (type == 'Ordinary_Exam' ? 'selected' : '') + ` value="Ordinary_Exam">Ordinary_Exam</option>
                            <option  ` + (type == 'Consolidated_Exam' ? 'selected' : '') + ` value="Consolidated_Exam">Consolidated_Exam</option>
                            <option  ` + (type == 'Year_Average' ? 'selected' : '') + ` value="Year_Average">Year_Average</option>
                            <option  ` + (type == 'KCSE' ? 'selected' : '') + ` value="KCSE">KCSE</option>
                        </select>`;
        ss[2].innerHTML = `<input type="text" value="` + name + `"  onchange="buffExamName(this);" />`;
        ss[3].innerHTML = `<select data-placeholder="Select Teacher" class="form-control" onchange="buffExamTerm(this);">
                                <option ` + (term == 1 ? 'selected' : '') + ` value="1">First Term</option>
                                <option ` + (term == 2 ? 'selected' : '') + ` value="2">Second Term</option>
                                <option ` + (term == 3 ? 'selected' : '') + ` value="3">Third Term</option>
                            </select>`;
        ss[4].innerHTML = `<select data-placeholder="Select Teacher" class="form-control" onchange="buffExamYear(this);">
                            <option ` + (year == 2022 ? 'selected' : '') + ` value="2022">2022</option>
                            <option ` + (year == 2021 ? 'selected' : '') + ` value="2021">2021</option>
                            <option ` + (year == 2020 ? 'selected' : '') + ` value="2020">2020</option>
                            <option ` + (year == 2019 ? 'selected' : '') + ` value="2019">2019</option>
                            <option ` + (year == 2018 ? 'selected' : '') + ` value="2018">2018</option>
                        </select>`;
        ss[5].innerHTML = `<button type="button" class="btn" onclick="onUpdate(this);" style="background: white;">
                            <img src="global_assets/images/icon/save.png" width=25 height=25 />
                        </button>
                        <button type="button" class="btn" onclick="onCancel(this);" style="background: white;" >
                            <img src="global_assets/images/icon/cancel.png" width=25 height=25 />
                        </button>`;
        edit_status = true;

    }

    function onCancel(myObj) {

        let ss = myObj.parentNode.parentNode.children;
        ss[1].innerHTML = origin_type;
        ss[2].innerHTML = origin_name;
        ss[3].innerHTML = 'Term ' + origin_term;
        ss[4].innerHTML = origin_year;
        ss[5].innerHTML = `<button type="button" class="btn" onclick="onEditExam('` + origin_i + `', '` + origin_id + `', '` + origin_type + `', '` + origin_name + `', '` + origin_term + `', '` + origin_year + `', this);" style="background: white;">
                            <img src="global_assets/images/icon/edit.png" width=25 height=25 />
                        </button>
                        <button type="button" class="btn" onclick="onDeleteExam('` + origin_id + `', this);" style="background: white;" >
                            <img src="global_assets/images/icon/delete.png" width=25 height=25 />
                        </button>`;
        1
        edit_status = false;
    }

    function Sendpublish(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'confirmbtn',
                cancelButton: 'cancelbtn'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "Exam publish",
            text: "This will be published . Are you sure you want to continue?",
            icon: "error",
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonColor: '#3C9A42',
            confirmButtonText: "Ok",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'top',
                    icon: "success",
                    text: "Exam has been successfully published!",
                    showConfirmButton: false,
                    width: '300px',
                    timer: 1500,
                })
                $.post('publish_result', {
                    id: id,
                    f: true
                }, (res) => {
                    getInitExam()
                })
            }

        })

    }

    function SendRequest(exam_id, form_id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'confirmbtn',
                cancelButton: 'cancelbtn'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "Request",
            text: "This request will be sent . Are you sure you want to continue?",
            icon: "warning",
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonColor: '#3C9A42',
            confirmButtonText: "Ok",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'top',
                    icon: "success",
                    text: "Request has been successfully sent!",
                    showConfirmButton: false,
                    width: '300px',
                    timer: 1500,
                })
                // $.post('publish_result', {
                //     id: id,
                //     f: true
                // }, (res) => {
                //     getInitExam()
                // })
            }

        })
    }


    function buffExamType(myObj) {
        console.log(myObj);
        post_type = myObj.options[myObj.selectedIndex].value;
        console.log('post_type ' + post_type);
    }

    function buffExamTerm(myObj) {
        console.log(myObj);
        post_term = myObj.options[myObj.selectedIndex].value;
        console.log('post_term ' + post_term);
    }

    function buffExamYear(myObj) {
        console.log(myObj);
        post_year = myObj.options[myObj.selectedIndex].value;
        console.log('post_year ' + post_year);
    }

    function buffExamName(myObj) {
        console.log(myObj);
        post_name = myObj.value;
        console.log('post_name ' + post_name);
    }

    function onUpdate(myObj) {
        let form1 = new FormData();
        form1.append("type", post_type);
        form1.append("name", post_name);
        form1.append("term", post_term);
        form1.append("year", post_year);
        form1.append("id", post_id);

        var ajaxOptions = {
            url: 'exam_update',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: form1
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log('======= response data ===============');
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
            let ss = myObj.parentNode.parentNode.children;

            ss[1].innerHTML = post_type;
            ss[2].innerHTML = post_name;
            ss[3].innerHTML = 'Term ' + post_term;
            ss[4].innerHTML = post_year;
            ss[5].innerHTML = `<button type="button" class="btn" onclick="onEditExam('` + origin_i + `', '` + post_id + `', '` + post_type + `', '` + post_name + `', '` + post_term + `', '` + post_year + `', this);" style="background: white;">
                                <img src="global_assets/images/icon/edit.png" width=25 height=25 />
                            </button>
                            <button type="button" class="btn" onclick="onDeleteExam('` + post_id + `', this);" style="background: white;" >
                                <img src="global_assets/images/icon/delete.png" width=25 height=25 />
                            </button>`;
            edit_status = false;

            return resp;
        });
        req.fail(function(e) {
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
        });
    }

    function unpublish(examid, formid, ) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'confirmbtn',
                cancelButton: 'cancelbtn'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "Unpublish Exam",
            text: "This will be Unpublished . Are you sure you want to continue?",
            icon: "error",
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonColor: '#3C9A42',
            confirmButtonText: "Proceed",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: 'top',
                    icon: "success",
                    text: "Exam has been unpublished sucessfully!",
                    showConfirmButton: false,
                    width: '300px',
                    timer: 1500,
                })
                $.post('unpublish_result', {
                    exam_id: examid,
                    form_id: formid
                }, (res) => {
                    getInitExam()
                })
            }

        })

    }

    function onDeleteEachExam(exam_id, form_id, myObj) {
        console.log(myObj);

        Swal.fire({
            title: "Delete Exam",
            text: "Are You sure you'd like to delete EXAM ",
            confirmButtonColor: 'green',
            confirmButtonText: "Okay",
            showCancelButton: true,
        }).then((res) => {
            if (res.isConfirmed) {
                let form1 = new FormData();
                form1.append("exam_id", exam_id);
                form1.append("form_id", form_id);
                var ajaxOptions = {
                    url: 'each_exam_delete',
                    type: 'POST',
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    data: form1
                };
                var req = $.ajax(ajaxOptions);
                req.done(function(resp) {
                    // console.log('======= response data ===============');
                    // console.log(resp);
                    resp.ok && resp.msg ?
                        flash({
                            msg: resp.msg,
                            type: 'success'
                        }) :
                        flash({
                            msg: resp.msg,
                            type: 'danger'
                        });
                    if (resp.ok == true) {
                        // myObj.parentNode.remove();
                        $('.action' + exam_id + form_id).remove();
                        // let ele =myObj.parentNode.parentNode.parentNode.parentNode.children;
                        // console.log(ele[1].children[0], ele[2].children[0], ele[3].children[0]);
                        // ele[1].deleteRow(exam_id);
                        // ele[2].deleteRow(exam_id);
                        // ele[3].deleteRow(exam_id);

                    }
                    // location.reload();
                    // return resp;
                });
                req.fail(function(e) {
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
                });
            }

        });
    }

    function examNameInvalid(e) {
        e.target.setCustomValidity("");
        if (!e.target.validity.valid) {
            e.target.setCustomValidity("Exam name is required");
        }
    }

    function examTermInvalid(e) {
        e.target.setCustomValidity("");
        if (!e.target.validity.valid) {
            e.target.setCustomValidity("Term is reqiuired");
        }
    }

    function checkState(id, myObj, e) {

        var subjectCountStr = "#min_subject_cnt" + id;
        var subjectErrorStr = "#min_subject_helper" + id;
        console.log(myObj.checked);
        if (myObj.checked) {
            $(subjectCountStr).prop('required', true);
            $(subjectErrorStr).text("Enter minimum number of exam for form" + id)
            $(subjectCountStr).addClass('exclaimation');
        } else {
            $(subjectCountStr).prop('required', false);
            $(subjectErrorStr).text('')
            $(subjectCountStr).removeClass('exclaimation');
        }
    }

    function examSubject(id, e) {
        e.target.setCustomValidity("");
        var subjectEleStr = "#min_subject_id" + id;
        var subjectCountStr = "#min_subject_cnt" + id;

        // console.log($(subjectEleStr).prop('checked'));

        if ($(subjectEleStr).prop('checked') && !e.target.validity.valid) {

            if ($(subjectCountStr).val() == '') {
                e.target.setCustomValidity('Enter minimum number of exams for form' + id);

            }
        }
    }

    function hideSubject(id, e) {
        var subjectEleStr = "#min_subject_id" + id;
        var subjectCountStr = "#min_subject_cnt" + id;
        var subjectErrorStr = "#min_subject_helper" + id;
        if ($(subjectEleStr).prop('checked')) {
            if ($(subjectCountStr).val() == '') {
                e.target.setCustomValidity('Enter minimum number of exams for form' + id);
                $(subjectErrorStr).text('Enter minimum number of exams for form' + id);
            } else {
                $(subjectErrorStr).text('')
            }
        }


    }

    function onDeleteExam(id, myObj) {
        console.log('id ' + id);
        console.log('myObj ' + myObj);
        Swal.fire({
            title: "Delete Exam",
            text: "Are You sure you'd like to delete TEST EXAM 2A",
            confirmButtonColor: 'green',
            confirmButtonText: "Okay",
            showCancelButton: true,
        }).then((res) => {
            let form1 = new FormData();
            form1.append("id", id);

            var ajaxOptions = {
                url: 'exam_delete',
                type: 'POST',
                cache: false,
                processData: false,
                dataType: 'json',
                contentType: false,
                data: form1
            };
            var req = $.ajax(ajaxOptions);
            req.done(function(resp) {
                console.log('======= response data ===============');
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
                if (resp.ok == true) myObj.parentNode.parentNode.remove();
                location.reload();
                // return resp;
            });
            req.fail(function(e) {
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
            });
        });
    }

    // for creating new exam
    var form = $(this);
    var exam_type_rad_elem = document.querySelectorAll('input[type=radio]');
    var exam_name_input_elem = document.querySelector('#exam_name');
    var exam_term_select_elem = document.querySelector('#exam_term');
    var exam_year_select_elem = document.querySelector('#exam_year');
    var exam_form = document.querySelectorAll('input[class="exam_form my-2 mx-3"]');
    var create_exam_submit_btn = document.querySelector('#create-exam-btn');
    $('#exam_publish_mark').on('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "After publishing the results they won't be available to the subject teacher for editing.",
            confirmButtonColor: 'green',
            confirmButtonText: "Okay",
            showCancelButton: true,
        }).then((res) => {
            if (res.isConfirmed) {
                let form1 = new FormData();
                form1.append("exam_id", $('input[name="examID"]').val());
                form1.append("ps", 1);
                form1.append("sort", 3);
                var ajaxOptions = {
                    url: $('#exam_publish_mark').attr('action'),
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
                    window.location.href = "/exams";
                    // return resp;
                })
                req.fail(function(e) {
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
                });
                // window.location.href = '/exams';
            }
        })
    });

    $('#create_exam_form').on('submit', function(e) {
        e.preventDefault();
        var exam_name = exam_name_input_elem.value;
        var exam_term = exam_term_select_elem.options[exam_term_select_elem.selectedIndex].value;
        var exam_year = exam_year_select_elem.options[exam_year_select_elem.selectedIndex].value;
        var exam_form = document.getElementsByClassName("exam_form")
        var num = 0;
        for (val of exam_form) {
            if (val.checked == true) {
                num++;
            }
        }
        if (exam_name == '') {
            $('#exam_name_helper').text("The exam name field is required.");
            $('#exam_name').addClass('exclaimation');
            $('#exam_name').css('border-color', 'red');
        } else {
            $('#exam_name_helper').text("");
            $('#exam_name').removeClass('exclaimation');
            $('#exam_name').css('border-color', '');
        }
        if (exam_term == '') {
            $('#exam_term_helper').text("The exam term field is required.");
            $('#select2-exam_term-container').addClass('exclaimation-sel');
            $('span[aria-labelledby="select2-exam_term-container"]').css('border', '1px solid red');
        } else {
            $('#exam_term_helper').text('');
            $('#select2-exam_term-container').removeClass('exclaimation-sel');
            $('span[aria-labelledby="select2-exam_term-container"]').css('border', '');
        }
        if (exam_year == '') {
            $('#exam_year_helper').text("The exam year field is required.");
            $('#exam_year').addClass('exclaimation');
        } else {
            $('#exam_year_helper').text("");
            $('#exam_year').removeClass('exclaimation');
        }

        if (exam_name != '' && exam_term != '' && exam_year != '') {
            if (num == 0) {
                Swal.fire({
                    position: 'top',
                    icon: "error",
                    text: "Select at least one form!",
                    showConfirmButton: false,
                    width: '300px',
                    timer: 1500,
                })
            } else {
                Swal.fire({
                    title: "Create Exam Success",
                    text: "Exam has been successfully created",
                    confirmButtonColor: 'green',
                    confirmButtonText: "Okay",
                    showCancelButton: true,
                }).then((res) => {
                    if (res.isConfirmed) {
                        let exam_type = '';
                        for (let entry of exam_type_rad_elem) {
                            if (entry.checked == true) {
                                exam_type = entry.value;
                                break;
                            }
                        }
                        var exam_name = exam_name_input_elem.value;
                        var exam_term = exam_term_select_elem.options[exam_term_select_elem.selectedIndex].value;
                        var exam_year = exam_year_select_elem.options[exam_year_select_elem.selectedIndex].value;

                        var exam_forms = [];

                        for (let entry of exam_form) {
                            if (entry.checked == true) {
                                console.log('entry', entry.id);
                                var str = entry.id;
                                eleID = str.substring(str.length - 1, str.length);
                                let min_subject_cnt_id = 'min_subject_cnt' + eleID;
                                let min_subject_cnt_elem = document.getElementById(min_subject_cnt_id);
                                exam_forms.push({
                                    'form_id': eleID,
                                    'min_subject_cnt': parseInt(min_subject_cnt_elem.value)
                                });
                            }
                        }
                        disableBtn($(create_exam_submit_btn));

                        let form1 = new FormData();
                        form1.append("exam_type", exam_type);
                        form1.append("exam_name", exam_name);
                        form1.append("exam_term", exam_term);
                        form1.append("exam_year", exam_year);
                        form1.append("exam_forms", JSON.stringify(exam_forms));
                        // console.log($('#create_exam_form').attr('action'))
                        var ajaxOptions = {
                            url: $('#create_exam_form').attr('action'),
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
                                enableBtn($(create_exam_submit_btn));
                                // window.location.href="/exams";
                                // return resp;
                                $('#exam_name_helper').text('');
                                $('#exam_year_helper').text('');
                                $('#exam_term_helper').text('');
                                for (let index = 1; index < 5; index++) {
                                    $('#min_subject_helper' + index).text('')
                                }

                            })
                            .fail(function(e) {
                                if (e.status == 422) {
                                    var errors = e.responseJSON.errors;
                                    console.log(errors)
                                    errors.forEach(error => {
                                        if (error == "The exam name field is required.") {
                                            $('#exam_name_helper').text(error);
                                        }
                                        if (error == "The exam year field is required.") {
                                            $('#exam_year_helper').text(error);
                                        }
                                        if (error == "The exam term field is required.") {
                                            $('#exam_term_helper').text(error);
                                        }
                                    })
                                }
                                if (e.status == 500) {
                                    displayAjaxErr([e.status + ' ' + e.statusText + ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'])
                                }
                                if (e.status == 404) {
                                    displayAjaxErr([e.status + ' ' + e.statusText + ' - Requested Resource or Record Not Found'])
                                }
                                enableBtn($(create_exam_submit_btn));
                            });
                    }
                });
            }
        }


    });

    function addSelected(id) {
        var chkExams = document.querySelectorAll('input[type=checkbox]');
        var arrForm = [];
        for (const chkExam of chkExams) {
            var examData = {
                id: '',
                cnt: ''
            }
            if (chkExam.checked) {
                console.log(chkExam.id.substr(3, chkExam.id.length))
                var formvalue = document.getElementById('form' + chkExam.id.substr(3, chkExam.id.length));
                examData.id = chkExam.id.substr(3, chkExam.id.length);
                examData.cnt = formvalue.value;
                console.log(examData.id)
                console.log(examData.cnt)
                arrForm.push(examData);
            }
        }
        console.log('length', arrForm.length)
        let form = new FormData();
        form.append("forms", JSON.stringify(arrForm));
        form.append("exam_id", id);
        if (arrForm.length > 0) {
            var ajaxOptions = {
                url: "/storeExamForm",
                type: 'POST',
                cache: false,
                processData: false,
                dataType: 'json',
                contentType: false,
                data: form,
            }
            console.log(form)
            var req = $.ajax(ajaxOptions);
            req.done(function(resp) {
                Swal.fire({
                    title: "success",
                    text: "Successfully added",
                    showCancelButton: false,
                    showConfirmButton: false,
                })
                window.location.href = '/exams/' + id;
            }).fail(function(e) {
                console.error(e)
                return e.status;
            });
        } else {
            Swal.fire({
                title: "Error",
                text: "Select at least one form to add.",
                showCancelButton: false,
                showConfirmButton: false,
            })
        }

    }

    function showSample() {
        alert('show sample')
    }

    var edit_ratio_status = false;
    var edit_tr_no = 0;
    var origin_ratio_id = 0;

    function editSubjectRatio(id, myObj) {
        // if(edit_ratio_status == true){
        //     let tbody = myObj.parentNode.parentNode.parentNode.parentNode.children;
        //         let tr2 = tbody[edit_tr_no];
        //         let td2 = tr2.children[1];
        //         td2.innerHTML =
        //             `<div class="d-flex align-items-center justify-content-start">
        //                 <button class="btn btn-secondary px-4" onclick="editSubjectRatio('`+ origin_ratio_id +`', this);">
        //                     <img src="/global_assets/images/icon/edit.png" width="20" height="20"/>Edit
        //                 </button>
        //             </div>`;
        // }
        let td1 = myObj.parentNode.parentNode;
        let tr1 = myObj.parentNode.parentNode.parentNode;
        let tchild = tr1.children;

        edit_tr_no = parseInt(tchild[0].innerHTML) - 1;
        edit_status = true;
        origin_ratio_id = id;

        // let classId = parseInt(tchild[8].innerHTML);

        td1.innerHTML = `<div class="d-flex">
                            <button class="btn mx-2 cancel-class-stream" style="padding: 6px;" onclick="cancelSubjectRatio(this);">
                                <img src="/global_assets/images/icon/cancel.png" width="20" height="20"/>Cancel
                            </button>
                            <button class="btn mx-2 save-class-stream" style="padding: 6px;" onclick="updateSubjectRatio(` + id + `, this);">
                                <img src="/global_assets/images/icon/save.png" width="20" height="20"/>Save
                            </button>
                        </div>`;

    }

    function cancelSubjectRatio(myObj) {

        myObj.parentNode.parentNode.innerHTML =
            `<div class="d-flex align-items-center justify-content-start">
                <button class="btn btn-secondary px-4"  onclick="editSubjectRatio('` + origin_ratio_id + `', this);">
                    Edit
                </button>
            </div>`;
        edit_status = false;
    }

    function updateSubjectRatio(id, myObj) {

        let ele = myObj.parentNode.parentNode.parentNode.children
        console.log(ele[2].children[0].value);

        let updated_subject_id = id;

        let form2 = new FormData();
        form2.append("id", updated_subject_id);
        form2.append("out_x", ele[2].children[0].value ? ele[2].children[0].value : 0);
        form2.append("out_y", ele[3].children[0].value ? ele[3].children[0].value : 0);
        form2.append("out_z", ele[4].children[0].value ? ele[4].children[0].value : 0);
        form2.append("con_x", ele[5].children[0].value ? ele[5].children[0].value : 0);
        form2.append("con_y", ele[6].children[0].value ? ele[6].children[0].value : 0);
        form2.append("con_z", ele[7].children[0].value ? ele[7].children[0].value : 0);
        var ajaxOptions = {
            url: '/subjects/update_subject',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: form2,
        };

        var req = $.ajax(ajaxOptions);

        req.done(function(resp) {
            console.log('resp', resp);

            resp.ok && resp.msg ? flash({
                msg: resp.msg,
                type: 'success'
            }) : flash({
                msg: resp.msg,
                type: 'danger'
            });
            hideAjaxAlert();
            myObj.parentNode.parentNode.innerHTML =
                `<div class="d-flex align-items-center justify-content-start">
                    <button class="btn btn-secondary px-4"  onclick="editSubjectRatio('` + updated_subject_id + `', this);">
                        Edit
                    </button>
                </div>`;
            edit_status = false;
            origin_ratio_id = updated_subject_id;

            return resp;
        });
        req.fail(function(e) {
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
        });
    }
    var edit_paper_status = false;
    var edit_paper_tr_no = 0;
    var origin_paper_ratio_id = 0;

    function editPaperRatio(id, myObj) {
        // if(edit_paper_status == true){
        //     let tbody = myObj.parentNode.parentNode.parentNode.parentNode.children;
        //         let tr2 = tbody[edit_paper_tr_no];
        //         let td2 = tr2.children[3];
        //         td2.innerHTML =
        //             `<div class="d-flex align-items-center justify-content-start">
        //                 <button class="btn btn-secondary px-4" onclick="editPaperRatio('`+ origin_paper_ratio_id +`', this);">
        //                     Edit
        //                 </button>
        //             </div>`;
        // }
        let td1 = myObj.parentNode.parentNode;
        let tr1 = myObj.parentNode.parentNode.parentNode;
        let tchild = tr1.children;

        edit_paper_tr_no = parseInt(tchild[0].innerHTML) - 1;
        edit_paper_status = true;
        origin_paper_ratio_id = id;
        // $('.out_x_disable'+id).addClass('active-state');
        $('.out_x_chk' + id).removeClass('active-state');
        $('.out_y_chk' + id).removeClass('active-state');
        $('.out_z_chk' + id).removeClass('active-state');
        // let classId = parseInt(tchild[8].innerHTML);
        td1.innerHTML = `<div class="d-flex">
                            <button class="btn mx-2 cancel-class-stream" style="padding: 6px;" onclick="cancelPaperRatio(` + id + `,this);">
                                <img src="/global_assets/images/icon/cancel.png" width="20" height="20"/>Close
                            </button>
                            <button class="btn mx-2 save-class-stream" style="padding: 6px;" onclick="updatePaperRatio(` + id + `, this);">
                                <img src="/global_assets/images/icon/save.png" width="20" height="20"/>Save
                            </button>
                        </div>`;



    }

    function cancelPaperRatio(id, myObj) {
        $('.out_x_chk' + id).addClass('active-state');
        $('.out_y_chk' + id).addClass('active-state');
        $('.out_z_chk' + id).addClass('active-state');
        myObj.parentNode.parentNode.innerHTML =
            `<div class="d-flex align-items-center justify-content-start">
            <button class="btn btn-secondary"  onclick="editPaperRatio('` + origin_paper_ratio_id + `', this);">
                Edit/Add Paper
            </button>
        </div>`;
        edit_status = false;
    }

    function updatePaperRatio(id, myObj) {

        let ele = myObj.parentNode.parentNode.parentNode.children
        let updated_paper_id = id;
        // console.log($('.out_x_val'+id)[0]?$('.out_x_val'+id)[0].innerText:'',' ',$('.out_y_val'+id)[0]? $('.out_y_val'+id)[0].innerText:'',' ', $('.out_z_val'+id)[0]?$('.out_z_val'+id)[0].innerText:'');
        // console.log($('.out_x_chk'+id)[0]?$('.out_x_chk'+id)[0].value:'',' ', $('.out_y_chk'+id)[0]?$('.out_y_chk'+id)[0].value:'',' ', $('.out_z_chk'+id)[0]?$('.out_z_chk'+id)[0].value:'');

        Swal.fire({
            title: "Confirm Action",
            text: "Would you like to save this new ratio to be the new default?",
            confirmButtonColor: 'green',
            confirmButtonText: "Only for this exam",
            showCancelButton: true,
        }).then((res) => {
            if (res.isConfirmed) {
                let form2 = new FormData();
                console.log($('.out_x_chk' + id)[0] ? $('.out_x_chk' + id)[0].checked : 0);

                form2.append("id", updated_paper_id);
                form2.append("status_x", $('.out_x_chk' + id)[0] ? $('.out_x_chk' + id)[0].checked : 0)
                form2.append("status_y", $('.out_y_chk' + id)[0] ? $('.out_y_chk' + id)[0].checked : 0)
                form2.append("status_z", $('.out_z_chk' + id)[0] ? $('.out_z_chk' + id)[0].checked : 0)
                var ajaxOptions = {
                    url: '/subjects/update_paper',
                    type: 'POST',
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    data: form2,
                };

                var req = $.ajax(ajaxOptions);

                req.done(function(resp) {
                    console.log('resp', resp);

                    resp.ok && resp.msg ? flash({
                        msg: resp.msg,
                        type: 'success'
                    }) : flash({
                        msg: resp.msg,
                        type: 'danger'
                    });
                    hideAjaxAlert();
                    myObj.parentNode.parentNode.innerHTML =
                        `<div class="d-flex align-items-center justify-content-start">
                                <button class="btn btn-secondary px-4"  onclick="editPaperRatio('` + updated_paper_id + `', this);">
                                    Edit
                                </button>
                            </div>`;
                    edit_status = false;
                    origin_paper_ratio_id = updated_paper_id;
                    $('.out_x_disable' + id).addClass('active-state');
                    $('.out_x_active' + id).removeClass('active-state');
                    $('.out_x_chk' + id).addClass('active-state');
                    window.location.reload(true);
                    return resp;
                });
                req.fail(function(e) {
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
                });
            }
        });

    }
    $('#activeExam').on('click', function(e) {
        onActiveExam(e);
    });

    function onActiveExam(e) {



        Swal.fire({
            title: "Confirm Action",
            text: "You are able to de-active all subject paper ratios. Proceed with action?",
            confirmButtonColor: 'green',
            confirmButtonText: "Proceed",
            showCancelButton: true,
        }).then((res) => {
            var txt_active_all = document.querySelector('#txt-active-all');
            // var table = $('#table_config');
            var table = document.getElementById("table_config");
            var tbodyRowCount = table.tBodies[0].rows.length;
            var str = "";
            var item = ""
            var currentStr = txt_active_all.textContent;
            currentStr = currentStr.replace(/\s/g, '');
            if (res.isConfirmed == true) {
                if (currentStr == "Disableall") {
                    txt_active_all.innerHTML = "Enable all";
                    for (let index = 0; index < tbodyRowCount; index++) {
                        str = "";
                        str = "id" + index
                        var item = document.getElementById(str)
                        // console.log(item.innerHTML);
                        var id = item.innerHTML;
                        // if($('.out_x_chk'+id).hasClass('active-state')){
                        //     $('.out_x_chk'+id).removeClass('active-state');
                        // }
                        // if(!$('.out_x_active'+id).hasClass('active-state')){
                        $('.out_x_active' + id).addClass('active-state');
                        // }
                        // if($('.out_x_disable'+id).hasClass('active-state'))
                        // {
                        $('.out_x_disable' + id).removeClass('active-state');
                        // }
                        // if($('.out_x_chk'+id).is(":checked")==true){
                        $('.out_x_chk' + id).prop('checked', false);
                        // }
                        // if($('.out_y_chk'+id).hasClass('active-state')){
                        //     $('.out_y_chk'+id).removeClass('active-state');
                        // }
                        // if(!$('.out_y_active'+id).addClass('active-state')){
                        $('.out_y_active' + id).addClass('active-state');
                        // }
                        // if($('.out_y_disable'+id).hasClass('active-state')){
                        $('.out_y_disable' + id).removeClass('active-state');
                        // }
                        // if($('.out_y_chk'+id).is(":checked")==true){
                        $('.out_y_chk' + id).prop('checked', false);
                        // }
                        // if($('.out_z_chk'+id).hasClass('active-state')){
                        //     $('.out_z_chk'+id).removeClass('active-state');
                        // }
                        // if(!$('.out_z_active'+id).hasClass('active-state')){
                        $('.out_z_active' + id).addClass('active-state');
                        // }
                        // if($('.out_z_disable'+id).removeClass('active-state')){
                        $('.out_z_disable' + id).removeClass('active-state');
                        // }
                        // if($('.out_z_chk'+id).is(":checked")==true){
                        $('.out_z_chk' + id).prop('checked', false);
                        // }
                        let form2 = new FormData();
                        form2.append("id", id);
                        // form2.append("status_x", 0)
                        // form2.append("status_y", 0)
                        // form2.append("status_z", 0)
                        form2.append("status_x", $('.out_x_chk' + id)[0] ? $('.out_x_chk' + id)[0].checked : 0)
                        form2.append("status_y", $('.out_y_chk' + id)[0] ? $('.out_y_chk' + id)[0].checked : 0)
                        form2.append("status_z", $('.out_z_chk' + id)[0] ? $('.out_z_chk' + id)[0].checked : 0)
                        var ajaxOptions = {
                            url: '/subjects/update_paper',
                            type: 'POST',
                            cache: false,
                            processData: false,
                            dataType: 'json',
                            contentType: false,
                            data: form2,
                        };

                        var req = $.ajax(ajaxOptions);
                        req.done(function(resp) {
                            // console.log('resp', resp);
                            return resp;
                        });
                    }
                } else {
                    txt_active_all.innerHTML = "Disable all";
                    for (let index = 0; index < tbodyRowCount; index++) {
                        str = "";
                        str = "id" + index
                        var item = document.getElementById(str)
                        // console.log(item.innerHTML);
                        var id = item.innerHTML;
                        // if($('.out_x_chk'+id).hasClass('active-state')){
                        //     $('.out_x_chk'+id).removeClass('active-state');
                        // }
                        // if($('.out_x_active'+id).hasClass('active-state')){
                        $('.out_x_active' + id).removeClass('active-state');
                        // }
                        // if(!$('.out_x_disable'+id).hasClass('active-state')){
                        $('.out_x_disable' + id).addClass('active-state');
                        // }
                        // if($('.out_x_chk'+id).is(":checked")==false){
                        $('.out_x_chk' + id).prop('checked', true);
                        // }
                        // if($('.out_y_chk'+id).hasClass('active-state')){
                        //     $('.out_y_chk'+id).removeClass('active-state');
                        // }
                        // if($('.out_y_active'+id).hasClass('active-state')){
                        $('.out_y_active' + id).removeClass('active-state');
                        // }
                        // if(!$('.out_y_disable'+id).hasClass('active-state')){
                        $('.out_y_disable' + id).addClass('active-state');
                        // }
                        // if($('.out_y_chk'+id).is(":checked")==false){
                        $('.out_y_chk' + id).prop('checked', true);
                        // }
                        // if($('.out_z_chk'+id).hasClass('active-state')){
                        //     $('.out_z_chk'+id).removeClass('active-state');
                        // }
                        // if($('.out_z_active'+id).hasClass('active-state')){
                        $('.out_z_active' + id).removeClass('active-state');
                        // }
                        // if(!$('.out_z_disable'+id).addClass('active-state')){
                        $('.out_z_disable' + id).addClass('active-state');
                        // }

                        // if($('.out_z_chk'+id).is(":checked")==false){
                        $('.out_z_chk' + id).prop('checked', true);
                        // }
                        let form2 = new FormData();
                        form2.append("id", id);
                        // form2.append("status_x", 1)
                        // form2.append("status_y", 1)
                        // form2.append("status_z", 1)
                        form2.append("status_x", $('.out_x_chk' + id)[0] ? $('.out_x_chk' + id)[0].checked : 0)
                        form2.append("status_y", $('.out_y_chk' + id)[0] ? $('.out_y_chk' + id)[0].checked : 0)
                        form2.append("status_z", $('.out_z_chk' + id)[0] ? $('.out_z_chk' + id)[0].checked : 0)
                        var ajaxOptions = {
                            url: '/subjects/update_paper',
                            type: 'POST',
                            cache: false,
                            processData: false,
                            dataType: 'json',
                            contentType: false,
                            data: form2,
                        };

                        var req = $.ajax(ajaxOptions);
                        req.done(function(resp) {
                            // console.log('resp', resp);
                            return resp;
                        });
                    }
                }

            } else {
                return;
            }
        });
    }

    function selectYear() {
        var currentYearEle = document.getElementById('exam_manage_academic');
        getInitExam(currentYearEle.value)
    }

    function selectExam() {
        var exam_class_tbody = document.getElementById('exam_class_tbody');
        var exam_class_tbody_stream = document.getElementById('exam_class_tbody_stream');
        var exam_class_tbody_super = document.getElementById('exam_class_tbody_super');
        var exam = document.getElementById('exam_class_select');
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
        console.log('exam.value:', exam.value)
        req.done(function(res) {
            let k = 0,
                cc = '';
            let flag = 0;
            for (let my_class_sub of res.my_class_subject) {
                flag = 0;
                if ((res.types == "student" || res.types == "staff" || res.types == "teacher" || res.types == "admin")) {
                    k++;
                    pp = 0;
                    cc += ` <tr style="line-height:0.5">
                                <td style="font-family: 'Times New Roman', Times, serif">` + k + `</td>
                                <td style="font-family: 'Times New Roman', Times, serif">Form` + my_class_sub.my_class.form.name + " " + my_class_sub.my_class.stream + " - " + my_class_sub.subject.title + ` </td>`;
                    for (let exam_form_per of my_class_sub.my_class.form.exam_form) {
                        if (exam_form_per.exam_id == exam.value) {
                            pp++;
                        }
                    }
                    var i = 0;
                    for (let exam_record of my_class_sub.subject.exam_record) {
                        if (exam_record.my_class_id == my_class_sub.my_class_id && exam_record.exam_id == exam.value && exam_record.af == my_class_sub.subject_id) {
                            console.log("checking ......",exam_record.flag);
                            if (exam_record.flag == null) {
                                flag = 1;
                                cc += `<td class="text-success" style="font-family: 'Times New Roman', Times, serif;">Uploaded but not published by <span style="color:red">subject teacher</span></td>`;
                            } else if(exam_record.flag == 1){
                                flag = 2;
                                cc += `<td class="text-success" style="font-family: 'Times New Roman', Times, serif;">Pending publishing by <span  style="color:red">class teacher</span></td>`;
                            }else if(exam_record.flag == 2){
                                flag = 2;
                                cc += `<td class="text-success" style="font-family: 'Times New Roman', Times, serif;">Pending publishing by <span style="color:red">class supervisor</span></td>`;
                            }
                            else if(exam_record.flag == 3){
                                flag = 2;
                                cc += `<td class="text-success" style="font-family: 'Times New Roman', Times, serif;">Pending publishing by <span style='color:red'>Dean</span></td>`;
                            }else if(exam_record.flag == 4){
                                flag = 2;
                                cc += `<td class="text-success" style="font-family: 'Times New Roman', Times, serif;">Published by <span style='color:red'>Dean</span></td>`;
                            }

                            break;
                        }

                    }
                    if (pp > 0) {
                        if (flag == 0) {
                            cc += `<td class="text-danger" style="font-family: 'Times New Roman', Times, serif;"> Upload Results</td>`;
                        }
                    } else {
                        cc += `<td class="text-danger" style="font-family: 'Times New Roman', Times, serif;"> This Class did not sit for this exam</td>`;
                    }
                    if (pp > 0) {
                        cc += `<td class="text-right" style="padding-right:5px !important;font-family: 'Times New Roman', Times, serif;">`;
                        if (flag == 1) {
                            cc += `<a href="exam_class_upload/publish/` + my_class_sub.id + `/` + exam.value + `/` + my_class_sub.teacher_id + `/` + my_class_sub.subject.id + `" class="btn btn-success px-2" style="font-family: 'Times New Roman', Times, serif;margin-top:2px;margin-bottom:2px;padding-left:1.3rem;padding-right:1.3rem;border-radius:5px;">Publish</a>`

                        } else if (flag == 2) {
                            cc += `<a href="exam_class_upload/view/` + my_class_sub.id + `/` + exam.value + `/` + my_class_sub.teacher_id + `/` + my_class_sub.subject.id + `" class="btn btn-success" style="background: #b7c1d1;color: #172b4c;margin-top:2px;margin-bottom:2px;padding-left:1.3rem;padding-right:1.3rem;border-radius:5px;">View</a>`
                        } else {
                            cc += `<a href="exam_class/upload/` + my_class_sub.id + `/` + exam.value + `/` + my_class_sub.teacher_id + `/` + my_class_sub.subject.id + `" class="btn btn-info" style="background: #b7c1d1;color: #172b4c;margin-top:2px;margin-bottom:2px;padding-left:10px;padding-right:1.3rem;border-radius:5px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"  style = "float:left;margin-right:8px;margin-top:3px" fill="currentColor" class="bi bi-cloud-upload" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                            <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                        </svg>
                                        Upload
                                    </a>`
                        };
                        cc += "</td><td class='d-none'>" + my_class_sub.id + "</td><td class='d-none'>" + exam.value + "</td><td class='d-none'>" + my_class_sub.teacher_id + "</td><td class='d-none'>" + my_class_sub.subject.id + "</td></tr>"
                    } else {
                        cc += '<td class="text-right" style="height:35px"></td></tr>'
                    }


                }
            }
            if (exam_class_tbody != null) {
                exam_class_tbody.innerHTML = cc;
            }
            k = 0;
            cc = '';
            flag = 0;
            console.log("res.all_myclasses", res.all_myclasses)
            for (let myclass of res.all_myclasses) {
                if (myclass.teacher_id == res.teacher.id) {
                    k++;
                    cc += `
                    <tr>
                        <td style="font-family: 'Times New Roman', Times, serif;">` + k + `</td>
                        <td style="font-family: 'Times New Roman', Times, serif;">Form` + myclass.form.name + ` ` + myclass.stream + `</td>
                    `;
                    cc += `<td class="text-danger" style="font-family: 'Times New Roman', Times, serif;">View Results</td>`;
                    cc += `<td class="text-right" style="padding-right:5px !important;font-family: 'Times New Roman', Times, serif;">`;
                    cc += `<a  href = "exam_stream_view/` + res.teacher.id + `/` + myclass.id + `/` + exam.value + `" class="btn btn-info" style="font-family: 'Times New Roman', Times, serif;background: #b7c1d1;color: #172b4c;margin-top:2px;margin-bottom:2px;padding-left:1.3rem;padding-right:1.3rem;border-radius:5px;">View</a>`
                    cc += "</td><td class='d-none'>" + myclass.id + "</td><td class='d-none'>" + myclass.teacher_id + "</td></tr>"
                }
            }
            if (exam_class_tbody_stream != null) {
                exam_class_tbody_stream.innerHTML = cc;
            }
            k = 0;
            cc = '';
            flag = 0;
            for (let form of res.forms) {
                if (form.teacher_id == res.teacher.id) {
                    k++;
                    cc += `
                    <tr>
                        <td style="font-family: 'Times New Roman', Times, serif;">` + k + `</td>
                        <td style="font-family: 'Times New Roman', Times, serif;">Form` + form.name + `</td>
                    `;
                    cc += `<td class="text-danger"  style="font-family: 'Times New Roman', Times, serif;text-align:center">View Results</td>`;
                    cc += `<td class="text-right" style="padding-right:5px !important;font-family: 'Times New Roman', Times, serif">`;
                    cc += `<a href="exam_form_view/` + form.id + `" class="btn btn-info" style="font-family: 'Times New Roman', Times, serif;background: #b7c1d1;color: #172b4c;margin-top:2px;margin-bottom:2px;padding-left:1.3rem;padding-right:1.3rem;border-radius:5px;">View</a>`
                    cc += "</td><td class='d-none' style='font-family: 'Times New Roman', Times, serif;'>" + form.id + "</td><td class='d-none'>" + res.teacher.id + "</td></tr>"
                }
            }
            exam_class_tbody_super.innerHTML = cc;

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

    function deleteGrade(class_type_id) {
        let formData = new FormData();
        formData.append("class_type_id", class_type_id);
        var ajaxOptions = {
            url: 'grade_delete',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log(resp);
            window.location.reload();
        });
        req.fail(function(e) {
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
        // alert(class_type_id);
        // Swal.fire({
        //     title: "Delete Grade",
        //     text: "Are You sure you'd like to delete Grade ",
        //     confirmButtonColor: 'green',
        //     confirmButtonText: "Okay",
        //     showCancelButton: true,
        // }).then((res)=>{

        // }
    }

    function showStream(myObj) {
        if ($('.table-stream').hasClass('active-state')) {
            console.log(myObj);
            myObj.innerHTML = "Hide Stream";
            $('.table-stream').removeClass('active-state');
        } else {
            console.log(myObj);
            myObj.innerHTML = "Show Stream";
            $('.table-stream').addClass('active-state');
        }
    }

    function recoverFinal(exam_id, form_id, myObj) {
        console.log(exam_id, form_id);

        let formData = new FormData();
        formData.append("exam_id", exam_id);
        formData.append("form_id", form_id);
        var ajaxOptions = {
            url: 'exam_final_recover',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log(resp);
            window.location.reload();
        });
        req.fail(function(e) {
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
        // Swal.fire({
        //     title: "Recover Exam",
        //     text: "Are You sure you'd like to recover Exam ",
        //     confirmButtonColor: 'green',
        //     confirmButtonText: "Okay",
        //     showCancelButton: true,
        // }).then((res)=>{
        //     if(res.isConfirmed){

        //     }

        // }

    }

    function deleteFinal(exam_id, form_id, myObj) {
        console.log(exam_id, form_id);
        let formData = new FormData();
        formData.append("exam_id", exam_id);
        formData.append("form_id", form_id);
        var ajaxOptions = {
            url: 'exam_final_delete',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log(resp);
            window.location.reload();
        });
        req.fail(function(e) {
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
        // Swal.fire({
        //     title: "Delete Exam Finally",
        //     text: "Are You sure you'd like to delete Exam ",
        //     confirmButtonColor: 'green',
        //     confirmButtonText: "Okay",
        //     showCancelButton: true,
        // }).then((res)=>{
        //     if(res.isConfirmed){

        //     }

        // }
    }

    function validate(id, myObj) {
        const mark = document.getElementById('exam_class_upload_max').value
        const selectedEle = document.getElementsByName('mark' + id)[0];
        if (Number(mark) < Number(selectedEle.value)) {
            // alert('fail');
            Swal.fire({
                title: "Higer Value Warning",
                text: "Maximumvalue should be " + mark,
                confirmButtonColor: 'green',
                confirmButtonText: "Okay",
                showCancelButton: true,
            }).then((res) => {
                if (res.isConfirmed) {
                    selectedEle.value = "";
                    selectedEle.focus();
                }
            });
        }

    }

    function addX(index) {
        // $("#mark"+index).val('');
        $(`input[name=mark` + index + `]`).val('')
        $("#btn_gear_trash" + index).css({
            "background": "#ff9720"
        });
        $("#mark" + index).attr("type", "text");
        $("#mark" + index).val("X");
        // $(`input[name=mark` + index + `]`).attr("placeholder", "X");
        if ($("#mark_gear" + index).css('display') == 'block') {
            $("#mark_gear" + index).css('display', 'none')
        }
        if ($("#mark_trash" + index).css('display') == 'none') {
            $("#mark_trash" + index).css('display', 'block');
        }

    }

    function addNewX(index) {
        // $("#mark"+index).val('');
        $(`input[name=src_mark` + index + `]`).val('')
        // $("#mark"+index).attr("placeholder", "X");
        $(`input[name=src_mark` + index + `]`).attr("placeholder", "X");
        if ($("#mark_new_gear" + index).css('display') == 'block') {
            $("#mark_new_gear" + index).css('display', 'none')
        }
        if ($("#mark_new_trash" + index).css('display') == 'none') {
            $("#mark_new_trash" + index).css('display', 'block');
        }

    }

    function addY(index) {
        $(`input[name=mark` + index + `]`).val('');
        $(`input[name=mark` + index + `]`).attr("type", "text");
        $("#btn_gear_trash" + index).css({
            "background": "#ff9720"
        });
        $("#mark" + index).val('Y');
        // $("#mark"+index).attr("placeholder", "Y");
        if ($("#mark_gear" + index).css('display') == 'block') {
            $("#mark_gear" + index).css('display', 'none')
        }
        if ($("#mark_trash" + index).css('display') == 'none') {
            $("#mark_trash" + index).css('display', 'block');
        }
    }

    function addNewY(index) {
        $(`input[name=mark` + index + `]`).val('');
        $(`input[name=mark` + index + `]`).attr("placeholder", "Y");
        // $("#mark"+index).val('');
        // $("#mark"+index).attr("placeholder", "Y");
        if ($("#mark_new_gear" + index).css('display') == 'block') {
            $("#mark_new_gear" + index).css('display', 'none')
        }
        if ($("#mark_new_trash" + index).css('display') == 'none') {
            $("#mark_new_trash" + index).css('display', 'block');
        }
    }

    function removeContent(index, mark = '') {
        $(`input[name=_mark` + index + `]`).attr("placeholder", "");
        $(`input[name=mark` + index + `]`).val(mark);
        $("#btn_gear_trash" + index).css({
            "background": "#43AB49"
        });
        // $("#mark"+index).attr("placeholder", "");
        // $("#mark"+index).val(mark);
        if ($("#mark_trash" + index).css('display') == 'block') {
            $("#mark_trash" + index).css('display', 'none');
        }
        if ($("#mark_gear" + index).css('display') == 'none') {
            $("#mark_gear" + index).css('display', 'block')
        }
    }

    function removeNewContent(index, mark = '') {
        $(`input[name=src_mark` + index + `]`).attr("placeholder", "");
        $(`input[name=src_mark` + index + `]`).val(mark);
        // $("#mark"+index).attr("placeholder", "");
        // $("#mark"+index).val(mark);
        if ($("#mark_new_trash" + index).css('display') == 'block') {
            $("#mark_new_trash" + index).css('display', 'none');
        }
        if ($("#mark_new_gear" + index).css('display') == 'none') {
            $("#mark_new_gear" + index).css('display', 'block')
        }
    }

    function updateMaxMark(e) {
        e.preventDefault()
        $('#update_mark').addClass('active-state');
        if ($('#cancel_mark').hasClass('active-state')) {
            $('#cancel_mark').removeClass('active-state');
        }
        if ($('#save_mark').hasClass('active-state')) {
            $('#save_mark').removeClass('active-state');
        }
        $('#exam_class_upload_max').attr('disabled', false);
    }

    function cancelMaxMark(e) {
        e.preventDefault();
        $('#cancel_mark').addClass('active-state');
        $('#save_mark').addClass('active-state');
        if ($('#update_mark').hasClass('active-state')) {
            $('#update_mark').removeClass('active-state');
        }
        $('#exam_class_upload_max').attr('disabled', true);
    }

    function saveMaxMark(e, id) {
        e.preventDefault();
        $('#cancel_mark').addClass('active-state');
        $('#save_mark').addClass('active-state');
        if ($('#update_mark').hasClass('active-state')) {
            $('#update_mark').removeClass('active-state');
        }
        var max = $('#exam_class_upload_max').val();
        let formData = new FormData();
        formData.append("exam_id", id);
        formData.append("p_comment", max);
        formData.append("sort", 0);
        var ajaxOptions = {
            url: '{{ route("exam_class_publish_mark") }}',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            // console.log(resp);
            //
            resp.ok && resp.msg ? flash({
                msg: "Saved successfully",
                type: 'success'
            }) : flash({
                msg: resp.msg,
                type: 'danger'
            });
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        });
        req.fail(function(e) {
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
        $('#exam_class_upload_max').attr('disabled', true);
    }

    function updateMark(e, id) {
        e.preventDefault();
        $('#mark_dactive_pos' + id).addClass('active-state');
        $('#mark_active_pos' + id).removeClass('active-state');
        $('#update_mark' + id).addClass('active-state');
        if ($('#cancel_mark' + id).hasClass('active-state')) {
            $('#cancel_mark' + id).removeClass('active-state');
        }
        if ($('#save_mark' + id).hasClass('active-state')) {
            $('#save_mark' + id).removeClass('active-state');
        }
    }

    function cancelMark(e, id) {
        e.preventDefault();
        $('#cancel_mark' + id).addClass('active-state');
        $('#save_mark' + id).addClass('active-state');
        if ($('#update_mark' + id).hasClass('active-state')) {
            $('#update_mark' + id).removeClass('active-state');
        }
        $('#mark_dactive_pos' + id).removeClass('active-state');
        $('#mark_active_pos' + id).addClass('active-state');
    }

    function saveMark(e, id, exam_id, subject_id, student_id, class_id) {
        e.preventDefault();
        $('#cancel_mark' + id).addClass('active-state');
        $('#save_mark' + id).addClass('active-state');
        if ($('#update_mark' + id).hasClass('active-state')) {
            $('#update_mark' + id).removeClass('active-state');
        }
        $('#mark_dactive_pos' + id).removeClass('active-state');
        $('#mark_active_pos' + id).addClass('active-state');
        var itemValue = $('#mark' + id).val();
        $('#mark_dactive_pos' + id).html(itemValue);
        let formData = new FormData();
        formData.append("exam_id", exam_id);
        formData.append("subject_id", subject_id);
        formData.append("student_id", student_id);
        formData.append("my_class_id", class_id);
        formData.append("pos", $('#mark' + id).val());
        formData.append("sort", 2);
        var ajaxOptions = {
            url: '{{ route("exam_class_publish_mark") }}',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log(resp);
            setTimeout(() => {
                window.location.reload();
            }, 2000);
            resp.ok && resp.msg ? flash({
                msg: "Marks updated successfully",
                type: 'success'
            }) : flash({
                msg: resp.msg,
                type: 'danger'
            });
        });
        req.fail(function(e) {
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
        $('#exam_class_upload_max').attr('disabled', true);
    }

    function deleteSave(e) {
        var rowCount = $('#publish_tbody>tr').length;
        for (let index = 0; index < rowCount; index++) {
            if ($('#chk' + index).is(":checked") == true) {
                var pressed = index;
            }
        }
        // alert($('input[name=exam'+pressed+']').val());
        let formData = new FormData();
        formData.append("exam_id", $('input[name=exam' + pressed + ']').val());
        formData.append("student_id", $('input[name=student' + pressed + ']').val());
        formData.append("my_class_id", $('input[name=class' + pressed + ']').val());
        var ajaxOptions = {
            url: '/exam_delete_mark',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log(resp);
            resp.ok && resp.msg ? flash({
                msg: resp.msg,
                type: 'success'
            }) : flash({
                msg: resp.msg,
                type: 'danger'
            });
            window.location.reload();
        });
        req.fail(function(e) {
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

    function addMarkItem(e) {
        e.preventDefault();
        if (!$('.deleteCtrl').hasClass('active-state')) {

            $('.deleteCtrl').addClass('active-state');
        }
        if ($('.editCtrl').hasClass('active-state')) {
            $('.editCtrl').removeClass('active-state');
        }
        var rowCount = $('#tbodyRow>tr').length;
        $('#tableForNew').removeClass('active-state')
        $('#actionForResults').addClass('active-state')
        $('#addForResults').removeClass('active-state')
        $('#new_save').removeClass('active-state')
        $('button[type="submit"]').addClass('active-state');
        let formData = new FormData();
        formData.append("my_class_id", $('input[name="classID"]').val());
        var adm_nos = []
        var ajaxOptions = {
            url: '/mystudents',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: formData
        };
        var req = $.ajax(ajaxOptions);
        req.done(function(resp) {
            console.log(resp);
            // window.location.reload();
            var row = `<tr id=row` + rowCount + `>
                <td>
                    <select class="form-control" id="adm_no` + rowCount + `" onchange="selUser(this, ` + rowCount + `)"><option></option>`;
            for (let index = 0; index < resp.length; index++) {
                row += `<option id=adm` + index + `>` + resp[index]['adm_no'] + `</option>`;
            }
            row += `</select></td>
                <td>
                    <select class="form-control" id="adm_name` + rowCount + `"><option></option>`;
            for (let index = 0; index < resp.length; index++) {
                row += `<option id=user` + resp[index]['id'] + `>` + resp[index]['user']['name'] + `</option>`;
            }
            row += `</select></td>
                <td>
                    <div class="input-group">
                        <input type="number" step="0.1" name=src_mark` + rowCount + ` class="form-control"/>
                        <span class="input-group-text">
                            <div class="dropdown">
                                <i class="icofont-gear" id="mark_new_gear` + rowCount + `" data-toggle="dropdown" style="cursor: pointer"></i>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" onclick="addNewX(` + rowCount + `)">Grade X</a>
                                    <a class="dropdown-item" href="#" onclick="addNewY(` + rowCount + `)">Grade Y</a>
                                </div>
                                <i class="icofont-trash" id="mark_new_trash` + rowCount + `" onclick="removeNewContent(` + rowCount + `)" style="cursor: pointer;display:none"></i>
                            </div>
                        </span>
                    </div>
                </td>
                <td><button type="button" class="btn btn-secondary" id=ID` + rowCount + ` onclick="removeForRow(` + rowCount + `)">Delete</button></td>
                <td id=std` + rowCount + ` class="d-none"></td>
                </tr>`;
            $('#tbodyRow').append(row);
        });
        req.fail(function(e) {
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

    function selUser(myObj, index) {
        // alert(myObj.selectedIndex);
        $('#adm_name' + index)[0].selectedIndex = myObj.selectedIndex;
        var id = $('#adm_name' + index).children(":selected").attr('id');
        $('#std' + index).text(id.substring(4, id.length));
    }

    function removeForRow(index) {
        var rowCount = $('#tbodyRow>tr').length;
        if (rowCount > 1) {
            $('#row' + index).remove();
        } else {
            $('#tableForNew').addClass('active-state');
            $('#actionForResults').removeClass('active-state');
            $('#addForResults').addClass('active-state');
            $('#new_save').addClass('active-state');
            $('button[type="submit"]').removeClass('active-state');
            $('#tbodyRow').text('')
        }
    }

    function newSave(e) {
        e.preventDefault();
        var desRowCount = $('#publish_tbody>tr').length;
        var srcRowCount = $('#tbodyRow>tr').length;
        let formData = new FormData();
        var exam_id = $(`input[name=examID]`).val();
        var class_id = $(`input[name=classID]`).val();
        var af = $(`input[name=subjectID]`).val();
        var p_comment = $('#exam_class_upload_max').val();
        var section_id = $(`input[name=paperID]`).val();
        for (let index = 0; index < srcRowCount; index++) {
            if ($(`input[name=src_mark` + index + `]`).val() > 0) {
                formData.append("exam_id", exam_id);
                formData.append("student_id", $('#std' + index).text());
                formData.append("my_class_id", class_id);
                formData.append("pos", $(`input[name=src_mark` + index + `]`).val());
                formData.append("p_comment", p_comment);
                formData.append("af", af);
                formData.append("section_id", section_id);
                formData.append("sort", 1);
                console.log(exam_id, $('#std' + index).text(), class_id, $(`input[name=src_mark` + index + `]`).val(), p_comment, af, section_id);
                var ajaxOptions = {
                    url: $('#exam_publish_mark').attr('action'),
                    type: 'POST',
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    data: formData
                };
                var req = $.ajax(ajaxOptions);
                req.done(function(resp) {
                    console.log('ok')
                    console.log(resp);
                    // setTimeout(() => {
                    //     window.location.reload();
                    // }, 2000);
                    // resp.ok && resp.msg ? flash({msg:"Marks updated successfully", type:'success'}) : flash({msg:resp.msg, type:'danger'});
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
                });
            }
        }
        setTimeout(() => {
            flash({
                msg: "Marks updated successfully",
                type: 'success'
            })
        }, 1000)
        setTimeout(() => {
            window.location.reload();
        }, 2000);
        // for (let index = 0; index < srcRowCount; index++) {
        //     var row = `<tr><td>`+Number(desRowCount+index+1)+`</td>
        //     <td>`+$('#adm_no'+index).val()+`</td><td>`+$('#adm_name'+index).val()+`</td>
        //     <td>
        //         <span id="mark_dactive_pos`+Number(desRowCount+index)+`">`+$(`input[name=src_mark`+index+`]`).val()+`</span>
        //             <div class="input-group active-state" id="mark_active_pos`+Number(desRowCount+index)+`">
        //                 <input type="number" step="0.1" id=mark`+Number(desRowCount+index)+` name=mark`+Number(desRowCount+index)+` value=`+$(`input[name=src_mark`+index+`]`).val()+` class="form-control"/>
        //                 <span class="input-group-text">
        //                     <div class="dropdown">
        //                         <i class="icofont-gear" id="mark_new_gear`+Number(desRowCount)+`" data-toggle="dropdown" style="cursor: pointer"></i>
        //                         <div class="dropdown-menu">
        //                             <a class="dropdown-item" href="#" onclick="addNewX(`+Number(desRowCount+index)+`)">Grade X</a>
        //                             <a class="dropdown-item" href="#" onclick="addNewY(`+Number(desRowCount+index)+`)">Grade Y</a>
        //                         </div>
        //                         <i class="icofont-trash" id="mark_new_trash`+Number(desRowCount+index)+`" onclick="removeNewContent(`+Number(desRowCount)+`)" style="cursor: pointer;display:none"></i>
        //                     </div>
        //                 </span>
        //             </div>
        //         </td>

        //     <td class="d-none"><input type="text" name="student`+Number(desRowCount+index)+`" value=`+$('#std'+index).text()+`></td>
        //     <td class="d-none"><input type="text" name="class`+Number(desRowCount+index)+`" value=`+$(`input[name=classID]`).val()+`></td>
        //     <td class="d-none"><input type="text" name="teacher`+Number(desRowCount+index)+`" value=`+$(`input[name=teacher0]`).val()+`></td>
        //     <td>`+(($(`input[name=src_mark`+index+`]`).val()/$('#exam_class_upload_max').val())*100)+`</td>
        //     <td class="editCtrl">
        //         <button id="update_mark`+Number(desRowCount+index)+`" class="btn btn-secondary" onclick="updateMark(event, `+Number(desRowCount+index)+`)">Edit</button>
        //         <button id="cancel_mark`+Number(desRowCount+index)+`" class="btn btn-secondary active-state" onclick="cancelMark(event, `+Number(desRowCount+index)+`)">Cancel</button>
        //         <button id="save_mark`+Number(desRowCount+index)+`" class="btn btn-primary active-state" onclick="saveMark(event, `+Number(desRowCount+index)+`, `+$(`input[name=examID]`).val()+`, `+$('#std'+index).text()+`, `+$(`input[name=classID]`).val()+`)">Save</button>
        //         </td>
        //     <td class="deleteCtrl active-state">
        //         <input type="checkbox" class="chk_boxes1" name=chk`+Number(desRowCount+index)+` id=chk`+Number(desRowCount+index)+`>
        //     </td>
        //     </tr>`
        //     $('#publish_tbody').append(row);
        // }

    }

    function cancelMarkItem(e) {
        e.preventDefault();
        window.location.reload();
    }

    function download(e) {
        e.preventDefault();
        $('#add_mark').addClass('active-state');
        $('#download').removeClass('active-state');
    }

    function back(e) {
        e.preventDefault();
        $('#add_mark').removeClass('active-state');
        $('#download').addClass('active-state');
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

    function fnExcelReport() {
        var tab_text = document.getElementById('printView').innerHTML;
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
        window.focus();
    }

    function showCheckbox(e) {
        e.preventDefault();
        if ($('.deleteCtrl').hasClass('active-state')) {
            $('.deleteCtrl').removeClass('active-state');
        }
        if ($('#cancelForResults').hasClass('active-state')) {
            $('#cancelForResults').removeClass('active-state');
        }
        if (!$('button[data-toggle=dropdown]').hasClass('active-state')) {
            $('button[data-toggle=dropdown]').addClass('active-state');
        }
        if (!$('.editCtrl').hasClass('active-state')) {
            $('.editCtrl').addClass('active-state');
        }
        if ($('#delete_save').hasClass('active-state')) {
            $('#delete_save').removeClass('active-state');
        }
        if (!$('#new_save').hasClass('active-state')) {
            $('#new_save').addClass('active-state');
        }
        if (!$('button[type=submit]').hasClass('active-state')) {
            $('button[type=submit]').addClass('active-state')
        }


    }
    window.onload = function() {
        getInitExam();
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