<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    // class teacher assign & delete
    function assignClassTeacher(classId, myObj) {

        let td1 = myObj.parentNode;

        var teacher_id = myObj.options[myObj.selectedIndex].value;

        let form1 = new FormData();
        form1.append("classId", classId);
        form1.append("teacher_id", teacher_id);

        console.log(classId);
        console.log(teacher_id);

        var ajaxOptions = {
            url: '/classes/assign_class_teacher',
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
                                <p style="margin: 0;">` + teacher_name + `</p>
                                <button class="btn" style="background:transparent;line-height: 7px;margin:0;font-size: 10px;height:auto;text-align:center" title="Delete this user" onclick="deleteClassTeacher(` + classId + `, this);">
                                <svg xmlns="http://www.w3.org/2000/svg" style="color:red" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
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
                displayAjaxErr([e.status + ' ' + e.statusText + ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'])
            }
            if (e.status == 404) {
                displayAjaxErr([e.status + ' ' + e.statusText + ' - Requested Resource or Record Not Found'])
            }
            return e.status;
        });
    }

    function deleteClassTeacher(classId, myObj) {

        let div1 = myObj.parentNode.parentNode;
        let form = new FormData();
        form.append("classId", classId);

        var ajaxOptions = {
            url: '/classes/delete_class_teacher',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: form,
        };

        var req = $.ajax(ajaxOptions);

        req.done(function(resp) {

            let all_teachers = resp.all_teachers;
            let div2 = '';
            for (let i = 0; i < all_teachers.length; i++) {
                div2 += `<option value="` + all_teachers[i].id + `">` + all_teachers[i].name + `</option>`;
            }
            div1.innerHTML = `<select required data-placeholder="Assign" class="form-control " onchange="assignClassTeacher(` + classId + `, this)" data-id="` + classId + `">
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
                displayAjaxErr([e.status + ' ' + e.statusText + ' Please Check for Duplicate entry or Contact School Administrator/IT Personnel'])
            }
            if (e.status == 404) {
                displayAjaxErr([e.status + ' ' + e.statusText + ' - Requested Resource or Record Not Found'])
            }
            return e.status;
        });
    }

    // edit class stream
    var edit_status = false;
    var edit_tr_no = 0;
    var origin_class_stream = [];
    $(".edit_class_stream").on('click', function(e) {
        e.preventDefault();
        console.log("this is -->",this)
        if (edit_status == true) {
            let tbody = this.parentNode.parentNode.parentNode; // tbody
            var tchild = tbody.children;
            var editing_tr = tchild[edit_tr_no];
            var editing_td = editing_tr.children; //td
            editing_td[2].innerHTML = origin_class_stream;
            edit_status = false;
        }

        let tr_ele = this.parentNode.parentNode; // tr

        var div = tr_ele.children;
        origin_class_stream[0] = div[2].innerHTML;
        // origin_class_stream[1] = div[7].innerHTML;
        let currentTD = $(div[0]);
        let classId = currentTD.data("id");

        div[2].innerHTML = `<div class="d-flex">
                                <input type="text" placeholder="Stream Name" style="width: 110px;text-aglin:center" id="editing_class_stream" value="` + origin_class_stream + `">
                            </div>`;
        div[7].innerHTML = `<div class="d-flex">
        <button class="btn cancel-class-stream" style="padding: 2px;background-color:#98A6BD;width:100px;border-radius:7px;margin-left:5px;margin-right:5px" onclick="cancelClassStream(` + classId + `, this);">
                                <svg xmlns="http://www.w3.org/2000/svg" style="float:left;margin-top:2px;margin-left:3px" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
</svg>Cancel
                                </button>
        <button class="btn save-class-stream" style="padding:2px;background-color:#2EA5DE;color:white;margin-left:4px;margin-right:4px;border-radius:7px;width:100px" onclick="updateClassStream(` + classId + `, this);">
        <svg xmlns="http://www.w3.org/2000/svg" style="float:left;margin-top:2px;margin-left:5px;margin-right:5px" width="16" height="16" fill="currentColor" class="bi bi-sim" viewBox="0 0 16 16">
  <path d="M2 1.5A1.5 1.5 0 0 1 3.5 0h7.086a1.5 1.5 0 0 1 1.06.44l1.915 1.914A1.5 1.5 0 0 1 14 3.414V14.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-13zM3.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V3.414a.5.5 0 0 0-.146-.353l-1.915-1.915A.5.5 0 0 0 10.586 1H3.5z"/>
  <path d="M5.5 4a.5.5 0 0 0-.5.5V6h2.5V4h-2zm3 0v2H11V4.5a.5.5 0 0 0-.5-.5h-2zM11 7H5v2h6V7zm0 3H8.5v2h2a.5.5 0 0 0 .5-.5V10zm-3.5 2v-2H5v1.5a.5.5 0 0 0 .5.5h2zM4 4.5A1.5 1.5 0 0 1 5.5 3h5A1.5 1.5 0 0 1 12 4.5v7a1.5 1.5 0 0 1-1.5 1.5h-5A1.5 1.5 0 0 1 4 11.5v-7z"/>
</svg>Save
                                </button>

                            </div>`;
        edit_status = true;
        edit_tr_no = div[0].innerHTML;

    });

    function updateClassStream(classId, myObj) {

        let updated_class_stream = $("#editing_class_stream").val();

        let form2 = new FormData();
        form2.append("classId", classId);
        form2.append("updated_class_stream", updated_class_stream);
        var ajaxOptions = {
            url: '/classes/update_class_stream',
            type: 'POST',
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            data: form2,
        };

        var req = $.ajax(ajaxOptions);

        req.done(function(resp) {

            resp.ok && resp.msg ? flash({
                msg: resp.msg,
                type: 'success'
            }) : flash({
                msg: resp.msg,
                type: 'danger'
            });
            hideAjaxAlert();
            myObj.parentNode.parentNode.innerHTML = updated_class_stream;
            origin_class_stream = updated_class_stream;
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

    function cancelClassStream(classId, myObj) {
        console.log("id:--",classId)
        console.log("DOM:--", myObj.parentNode.parentNode.parentNode.children[2])
        console.log("DOM:--", origin_class_stream[0])
        myObj.parentNode.parentNode.innerHTML = origin_class_stream[1];
        myObj.parentNode.parentNode.parentNode.children[2].innerHTML = origin_class_stream[0];
        edit_status = false;
    }

    // delete class
    $(".delete_class").on('click', function(e) {
        e.preventDefault();
        if (confirm("Are you sure you want to delete this class?")) {

            let classtr = $(this);
            let myObj = this.parentNode.parentNode;
            let classId = classtr.data("id");

            let form2 = new FormData();
            form2.append("classId", classId);
            var ajaxOptions = {
                url: '/classes/delete_class',
                type: 'POST',
                cache: false,
                processData: false,
                dataType: 'json',
                contentType: false,
                data: form2,
            };

            var req = $.ajax(ajaxOptions);

            req.done(function(resp) {

                resp.ok && resp.msg ? flash({
                    msg: resp.msg,
                    type: 'success'
                }) : flash({
                    msg: resp.msg,
                    type: 'danger'
                });
                hideAjaxAlert();
                myObj.remove()
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
</script>