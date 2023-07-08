<script>
var checkbox1 = document.getElementById('showmark');
var checkbox2 = document.getElementById('showrank');
var checkbox3 = document.getElementById('showdesc');

// Check the first three checkboxes
checkbox1.checked = true;
checkbox2.checked = true;
checkbox3.checked = true;
$(".up_arrow_transcripts").hide()
$(".down_arrow_transcripts").show()
$("#transcripts_first").hide()
$(".up_arrow_transcripts").on("click", () => {
    $(".down_arrow_transcripts").show()
    $(".up_arrow_transcripts").hide()
    $("#transcripts_first").hide(300)
})
$(".down_arrow_transcripts").on("click", () => {
    $(".down_arrow_transcripts").hide()
    $(".up_arrow_transcripts").show()
    $("#transcripts_first").show(300)
})

$(".up_arrow_option-div-transcripts").hide()
$(".down_arrow_option-div-transcripts").show()
$("#option-transcripts-panel").hide()
$(".up_arrow_option-div-transcripts").on("click", () => {
    $(".down_arrow_option-div-transcripts").show()
    $(".up_arrow_option-div-transcripts").hide()
    $("#option-transcripts-panel").hide(300)
})
$(".down_arrow_option-div-transcripts").on("click", () => {
    $(".down_arrow_option-div-transcripts").hide()
    $(".up_arrow_option-div-transcripts").show()
    $("#option-transcripts-panel").show(300)
})


$("#select_form_transcripts").on("click", (e) => {
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
            $("#select_stream_transcripts").children().remove();
            $("#select_stream_transcripts").append(option_arr);
        })
    }
})


$("#get_transcripts").on("click", () => {
    $("#transcripts_first").hide()
    str =
        '<div class="col-12" id="spinner_area_transcripts" style="margin-top:70px"><p stye="font-size:25px;">Generating Transcripts , Please wait ....</p><div class="spinner-square" style="margin:auto"><div class="square-1 square"></div><div class="square-2 square"></div><div class="square-3 square"></div></div></div>'
    $("#spin-div-transcripts").append(str)
    setTimeout(() => {
        $("#spinner_area_transcripts").hide();
        $("#transcript_panel").show(600);
    }, 3000);
    stream_id = $("#select_stream_transcripts").val();
    form_id = $("#select_form_transcripts").val();
    $.post("get_meta_data_for_transcripts", {
        stream_id: stream_id,
        form_id: form_id
    }, (res) => {
        res = JSON.parse(res);
        $("#trans_show_panel").show();
        displayData(res.data);
    })
})

function displayData(data) {
    str = "";
    i = 0;
    for (studentdata of data) {
        str += ` <div class="row" style="padding:0px 20px">
                                            <div class="col-4" style="text-align:left">
                                                <img style="display:inline-block;border-radius:5px;margin-bottom:20px"
                                                    src="{{asset('assets/images/avatar_blue.png')}}" style="float:left"
                                                    width="150" height="150">
                                                <p>NAME:${studentdata.name}</p>
                                                <p>ADMISSION NUMBER:${studentdata.admno}</p>
                                                <p>CURRENT Form:${studentdata.currentform}</p>
                                                <p>KCPE SCORE:${studentdata.kcpe}</p>
                                            </div>
                                            <div class="col-4" >
                                                <p style="font-size:30px;text-align:left;margin-bottom:20px">
                                                    {{$schoolname->school_name}}-{{$schoolname->school_postal}}
                                                </p>
                                                <p>Academic Transcripts</p>
                                            </div>
                                            <div class="col-4" style="text-align:right">
                                                <img src="{{asset('assets/images/school.png')}}"
                                                    style="padding-top:40px;margin-bottom:20px" width="150"
                                                    height="150">
                                                <p>553Limuru</p>
                                                <p>00</p>
                                                <p>bibrioniboyz@gmail.com</p>
                                            </div>
                                        </div>
                                        <div class="row" style="padding:0px 20px;margin-bottom:50px">
                                            <div class="col-12">
                                                <table class="table ">
                                                    <tr>
                                                        <td rowspan="2" style="width: 60%;">subject</td>
                                                        <td colspan="3" style="text-align: center;">Form 1</td>
                                                        <td style="text-align: center;">Form 2</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center;">Term 1</td>
                                                        <td style=" text-align: center;">Term 2</td>
                                                        <td style="text-align: center;">Term 3</td>
                                                        <td style="text-align: center;">Term 1</td>
                                                    </tr>`
        for (subject of studentdata.subjectname) {
            str += ` <tr>
                                                        <td>${subject}</td>
                                                        <td>${ getval()}% ${ ran()}</td>
                                                        <td>${ getval()}% ${ ran()}</td>
                                                        <td>${ getval()}% ${ ran()}</td>
                                                        <td>${ getval()}% ${ ran()}</td>
                                                    </tr>  `
        }
        str += `<tr class="markclass" ><td>MEAN MARKS</td><td>${ getval()}%</td><td>${ getval()}%</td><td>${ getval()}%</td><td>${ getval()}%</td></tr>
        <tr class="markclass" ><td>TOTAL MARKS</td><td>${ getInt(1,1200)}/1200</td><td>${ getInt(1,1200)}/1200</td><td>${ getInt(1,1200)}/1200</td><td>${ getInt(1,1200)}/1200</td></tr>
        <tr class="markclass" ><td>TOTAL POINTS</td><td>${  getInt(1,84)}/84</td><td>${  getInt(1,84)}/84</td><td>${  getInt(1,84)}/84</td><td>${  getInt(1,84)}/84</td></tr>
        <tr class="rankclass" ><td>OVERALL RANK</td><td>${  getInt(1,35)}/35</td><td>${  getInt(1,35)}/35</td><td>${  getInt(1,35)}/35</td><td>${  getInt(1,35)}/35</td></tr>
        <tr class="markclass"><td>OVERALL GRADE</td><td>${ ran()}</td><td>${ ran()}</td><td>${ ran()}</td><td>${ ran()}</td></tr></table> </div >   <div class="col-12" style="margin-top:10px">

                                    <div class="row gradedesc" >
                                    <div class="col-12">   <p style="text-align: left;">Grades</p></div>

                                        <div class="col-2">
                                            <p>A Excellent</p>
                                            <p>A- Very Good</p>
                                        </div>
                                        <div class="col-2">
                                            <p>B+ Good</p>
                                            <p>B Fairly Good</p>
                                            <p>B- Above Average</p>
                                        </div>
                                        <div class="col-2">
                                            <p>C+ Average</p>
                                            <p>C Average</p>
                                            <p>C- Aim High</p>
                                        </div>
                                        <div class="col-2">
                                            <p>D+ Below Average</p>
                                            <p>D Weak</p>
                                            <p>D- Weak</p>
                                        </div>
                                        <div class="col-2">
                                            <p>E+ Poor</p>
                                            <p>X Absent</p>
                                            <p>Y Irregular</p>
                                        </div>
                                        <div class="col-2"></div>
                                    </div>
                                </div>
                                <div class="col-12">

                                <div class="row">
                                        <div class="col-12" style="margin-bottom: 40px;">
                                            <p style="text-align:left">H.O.D ACADEMICs /D.O.S</p>
                                        </div>
                                        <div class="col-6">
                                            <p style="text-align:left;padding-left:30px">H.O.D ACADEMICs /D.O.S</p>
                                        </div>
                                        <div class="col-6">
                                            <p style="text-align:left;padding-left:30px">PRINCIPAL</p>
                                        </div>
                                        <div class="col-6">
                                            <p style="text-align:left;padding-left:30px">Ndugnua</p>
                                        </div>
                                        <div class="col-6">
                                            <p style="text-align:left;padding-left:30px">Mr.Marcheria</p>
                                        </div>
                                        <div class="col-12"
                                            style=" border-top: 3px dotted black;  border-bottom: 3px dotted black;height:40px">
                                        </div>
                                    </div>
                                    </div>
            </div>
        </div>`;

    }
    $(".transcript_panel").append(str);
}

function getval() {
    return Math.floor(Math.random() * 101)
}

function getInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function ran() {
    var letters = ['A', 'B', 'C', 'D', 'E', "D-", "D+", "C-", "C+", "B-", "B+", "A-"];
    var l = letters[Math.floor(Math.random() * letters.length)];
    return l;
}

function fnPrintReport_Transcript(e) {
    e.preventDefault();
    var mywindow = window.open('', 'PRINT', 'height=800,width=1024');
    mywindow.document.write('<html><head><title>' + " " + '</title>');
    // mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write(
        '<style>table,td {border:2px solid black !important;border-collapse:collapse !important; padding:10px !important} table,th {border:2px solid black !important ;border-collapse:collapse !important; padding:10px !important}</style>'
    );
    mywindow.document.write(
        `<link rel="stylesheet" href="{{ asset('assets/css/bootstraponline.min.css') }}">`
    );
    mywindow.document.write('</head><body >');
    // mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById('transcript_printing_panel').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();
    return true;
}


var toggleCheckbox1 = document.getElementById('showmark');
var toggleableElement1 = document.getElementsByClassName('markclass');
if (toggleableElement1) {
    toggleCheckbox1.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement1.length; index++) {
                const element = toggleableElement1[index];
                element.style.display = 'table-row';
            }
        } else {
            for (let index = 0; index < toggleableElement1.length; index++) {
                const element = toggleableElement1[index];
                element.style.display = 'none';
            }
        }
    });
}

var toggleCheckbox2 = document.getElementById('showrank');
var toggleableElement2 = document.getElementsByClassName('rankclass');
if (toggleableElement2) {
    toggleCheckbox2.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement2.length; index++) {
                const element = toggleableElement2[index];
                element.style.display = 'table-row';
            }
        } else {
            for (let index = 0; index < toggleableElement2.length; index++) {
                const element = toggleableElement2[index];
                element.style.display = 'none';

            }
        }
    });
}

var toggleCheckbox3 = document.getElementById('showdesc');
var toggleableElement3 = document.getElementsByClassName('gradedesc');
if (toggleableElement3) {
    toggleCheckbox3.addEventListener('change', function() {
        if (this.checked) {
            for (let index = 0; index < toggleableElement3.length; index++) {
                const element = toggleableElement3[index];
                element.style.display = 'flex';

            }
        } else {
            for (let index = 0; index < toggleableElement3.length; index++) {
                const element = toggleableElement3[index];
                element.style.display = 'none';

            }
        }
    });
}
</script>