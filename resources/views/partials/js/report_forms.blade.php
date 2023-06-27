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
    $("#report_form_panel").append(str)
    setTimeout(() => {
        $("#spinner_area").hide();
        $("#print_arr").show(600);
    }, 3000);
    // stream_id = $("#select_stream").val();
    // exam_id = $("#select_exam").val();
    // form_id = $("#select_form").val();
    // $.post("get_analysis_data", {
    //     stream_id: stream_id,
    //     exam_id: exam_id,
    //     form_id: form_id
    // }, (res) => {
    //     res = JSON.parse(res);
    //     console.log(res);
    //     (async function() {
    //         new Chart(
    //             document.getElementById('classsubjectmeans'), {
    //                 type: 'bar',
    //                 data: {
    //                     labels: res.firth_table.map(row => row[0].substring(0, 3)
    //                         .toUpperCase()),
    //                     datasets: [{
    //                         label: "",
    //                         // res.third_table.map(row => row[5])
    //                         data: res.firth_table.map(row => row[3]),
    //                         barThickness: 15
    //                     }]
    //                 },
    //                 options: {
    //                     plugins: {
    //                         legend: {
    //                             display: false // This hides all text in the legend and also the labels.
    //                         }
    //                     },
    //                     scales: {
    //                         y: {
    //                             suggestedMin: 6,
    //                             suggestedMax: 6,
    //                             ticks: {
    //                                 // forces step size to be 50 units
    //                                 stepSize: 1
    //                             },
    //                             title: {
    //                                 display: true,
    //                                 text: 'Points'
    //                             },

    //                         },
    //                         x: {
    //                             grid: {
    //                                 display: false
    //                             }
    //                         }
    //                     },
    //                 }
    //             }
    //         );
    //         const labelarr = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D',
    //             'D-', 'E'
    //         ];
    //         const dataarr = [];
    //         for (dataval of res.sixth_table) {
    //             if (dataval[0] == res.stream_name[0].stream) {
    //                 for (pp of labelarr) {
    //                     dataarr.push(dataval[4].filter(str => str === pp).length)
    //                 }
    //             }
    //         }


    //         new Chart(
    //             document.getElementById('overallclassstatistics'), {
    //                 type: 'bar',
    //                 data: {
    //                     labels: labelarr.map(row => row),
    //                     datasets: [{
    //                         data: dataarr.map(row => row),
    //                         barThickness: 15
    //                     }],
    //                 },
    //                 options: {
    //                     plugins: {
    //                         legend: {
    //                             display: false // This hides all text in the legend and also the labels.
    //                         }
    //                     },
    //                     scales: {
    //                         y: {
    //                             suggestedMin: 12,
    //                             suggestedMax: 12,
    //                             title: {
    //                                 display: true,
    //                                 text: 'Number of students'
    //                             },
    //                             ticks: {
    //                                 stepSize: 2
    //                             }
    //                         },
    //                         x: {
    //                             grid: {
    //                                 display: false
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         );



    //         const datafirst = {
    //             labels: res.sixth_table.map(row => row[0]),
    //             datasets: [{
    //                 backgroundColor: '#90DE8F',
    //                 borderColor: '#90DE8F',
    //                 data: res.sixth_table.map(row => row[5]),
    //                 fill: true,
    //             }]
    //         };
    //         new Chart(
    //             document.getElementById('performance'), {
    //                 type: 'line',
    //                 data: datafirst,
    //                 options: {
    //                     responsive: true,
    //                     maintainAspectRatio: false,
    //                     plugins: {
    //                         title: {
    //                             display: false,
    //                             text: 'Chart.js Line Chart'
    //                         },
    //                         legend: {
    //                             display: false // This hides all text in the legend and also the labels.
    //                         }
    //                     },
    //                     interaction: {
    //                         mode: 'index',
    //                         intersect: false
    //                     },
    //                     scales: {
    //                         x: {
    //                             display: true,
    //                             title: {
    //                                 display: false,
    //                                 text: 'Month'
    //                             }
    //                         },
    //                         y: {
    //                             display: true,
    //                             title: {
    //                                 display: false,
    //                                 text: 'Value'
    //                             },
    //                             ticks: {
    //                                 // forces step size to be 50 units
    //                                 stepSize: 0.5
    //                             }
    //                         }
    //                     }
    //                 },
    //             }
    //         );


    //         const lastlabels = ["first_test 2023", "second 2023", "3rd 2023",
    //             "4th 2023"
    //         ]
    //         const data = {
    //             labels: lastlabels,
    //             datasets: [{
    //                     label: 'Form 1',
    //                     data: [4.1, 2.3, 3.4, 2.3],
    //                     backgroundColor: "#FFBF75",
    //                     borderColor: "#FFBF75",
    //                     yAxisID: 'y',
    //                 },
    //                 {
    //                     label: 'Form 1 west',
    //                     data: [3.2, 2.4, 2.3, 4.5],
    //                     backgroundColor: "#ABFF9A",
    //                     borderColor: "#ABFF9A",
    //                     yAxisID: 'y',
    //                 },
    //                 {
    //                     label: 'Form 1 east',
    //                     data: [2.1, 3.5, 1.2, 1.3],
    //                     backgroundColor: "#655C6A",
    //                     borderColor: "#655C6A",
    //                     yAxisID: 'y',
    //                 }
    //             ]
    //         };
    //         new Chart(
    //             document.getElementById('performanceovertime'), {
    //                 type: 'line',
    //                 data: data,
    //                 options: {
    //                     responsive: true,
    //                     maintainAspectRatio: false,
    //                     interaction: {
    //                         mode: 'index',
    //                         intersect: false,
    //                     },
    //                     stacked: false,
    //                     plugins: {
    //                         title: {
    //                             display: true,
    //                             text: 'Chart.js Line Chart - Multi Axis'
    //                         }
    //                     },
    //                     scales: {
    //                         y: {
    //                             type: 'linear',
    //                             display: true,
    //                             position: 'left',
    //                         },
    //                         y1: {
    //                             type: 'linear',
    //                             display: true,
    //                             position: 'right',

    //                             // grid line settings
    //                             grid: {
    //                                 drawOnChartArea: false, // only want the grid lines for one axis to show up
    //                             },
    //                         },
    //                     }
    //                 },
    //             }
    //         );
    //     })();
    //     display_analysis(res)
    // })
})
</script>