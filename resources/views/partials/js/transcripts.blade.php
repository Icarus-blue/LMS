<script>
$(".up_arrow_transcripts").hide()
$(".down_arrow_transcripts").show()
$("#transcripts_first").hide()
$(".up_arrow_transcripts").on("click", () => {
    console.log("this is okay]");
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


// $("#select_stream_transcripts").on("click", (e) => {
//     stream_id = e.target.value;
//     if (stream_id != "") {
//         $("#exam_area_transcripts").hide();
//         $(".spinner-square").show();
//         setTimeout(() => {
//             $(".spinner-square").hide();
//             $("#exam_area_transcripts").show(600);
//         }, 3000);
//     }

// })
</script>