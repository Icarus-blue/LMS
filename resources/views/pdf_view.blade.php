<html>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
<style>
.headdiv {
    width: 30%;
    display: inline-block;
}

th,
td {
    padding: 3px !important;
    border: 1px solid black;
    border-collapse: collapse;
    font-size: 11px;
}

html {
    margin-left: -200px
}
</style>

<body>
    <div style="width:800px;margin:auto">
        <div style="margin-top:20px">
            <div>
                <div class="headdiv">
                    <img src="{{public_path('assets\images\school.png')}}" width="200" height="150">
                </div>
                <div class="headdiv" style="padding-left:150px">
                    <h5>BIBIRIONI HIGH SCHOOL -LIMURU FORM {{$form_name}} {{ $stream_name}} - {{$exam_name->name}} term
                        {{$exam_name->term}},{{$exam_name->year}}</h5>
                </div>
                <div class="headdiv" style="padding-left:170px">
                    <p>553Limuru 00 bibirioniboyz@gmail.com</p>
                </div>
            </div>
            <div style="padding-top:200px;margin:auto">
                <table class="table-striped"
                    style="padding:3px !important;border:1px solid black;border-collapse:collapse">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ADMNO</th>
                            <th style="width:160px">NAME</th>
                            <th>STR</th>
                            @foreach($subject_arr as $val)
                            <th>{{$val}}</th>
                            @endforeach
                            <th>SBJ</th>
                            <th>KCPE</th>
                            <th style="width:40px">VAP</th>
                            <th>MNMKS</th>
                            <th style="width:40px">DEV</th>
                            <th>GR</th>
                            <th>TTMKS</th>
                            <th>TTPTS</th>
                            <th>STRPOS</th>
                            <th>OVERPOS</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?= $i = 1;
                        ?>
                        @foreach($data as $val)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$val['adm_no']}}</td>
                            <td>{{$val['Name']}}</td>
                            <td>{{$val['stream_name']}}</td>
                            @foreach(explode(',', $val['marks_new']) as $value)
                            <td>{{$value}}</td>
                            @endforeach
                            <td>{{$val['sbj']}}</td>
                            <td>{{$val['kcpe']}}</td>
                            <td>{{$val['vap']}}</td>
                            <td>{{$val['mn_mks']}}</td>
                            <td>{{$val['dev']}}</td>
                            <td>{{$val['over_grad']}}</td>
                            <td>{{$val['total_mark']}}</td>
                            <td>{{$val['Total_pts']}}</td>
                            <td>{{$val['stream_order']}}</td>
                            <td>{{$val['order_form']}}</td>
                            <?= $i++; ?>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>