<html>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script> -->
<style>
.headdiv {
    float: left
}

th,
td {
    padding: 3px !important;
    border: 1px solid black;
    border-collapse: collapse;
    font-size: 20px;
    font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif
}

html {
    margin-left: -200px
}
</style>

<body>
    <div style="width:1200px;margin:auto">
        <div style="margin-top:20px">
            <div>
                <div style="width:15%" class="headdiv">
                    <img src="{{asset('assets\images\school.png')}}" width="200" height="150">
                </div>
                <div style="padding-left:150px;width:60%" class="headdiv">
                    <p style="font-size: 35px;">BIBIRIONI HIGHSCHOOL- RIMURU
                    </p>
                    <p style="font-size:25px;text-align:center">Class List</p>
                </div>
                <div style="padding-left:170px;width:20%" class="headdiv">
                    <p style="text-align:left;line-height:0.8;font-size:14px">553Limuru </p>
                    <p style="text-align:left;line-height:0.8;font-size:14px">00 </p>
                    <p style="text-align:left;line-height:0.8;font-size:14px">bibirioniboyz@gmail.com
                    </p>
                </div>
            </div>
            <div style="padding-top:200px;margin:auto">
                <table class="table table-striped"
                    style="padding:3px !important;border:1px solid black;border-collapse:collapse">
                    <thead>
                        <thead class="class_list_thead">
                            <tr>
                                <td colspan="10" style="text-align: center;">
                                    Form 1 East - 2022
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10" style="text-align: center;">
                                    Class Teacher : Ann
                                </td>
                            </tr>
                            <tr>
                                <th>#
                                </th>
                                <th>IMAGE
                                </th>
                                <th>ADMNO
                                </th>
                                <th>NAME
                                </th>

                                <th>KCPE
                                </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                            </tr>
                        </thead>
                    </thead>
                    <tbody>
                        <span style="display:none"> <?= $i = 1;
                                                    ?></span>

                        @foreach($data as $val)
                        <tr>
                            <td>{{$i}}</td>
                            <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                </svg></td>
                            <td>{{$val['adm_no']}}</td>
                            <td>{{$val->user['name']}}</td>
                            <td>{{$val['kcpe']}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <span style="display:none"><?= $i++; ?></span>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>