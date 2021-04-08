@extends('layout.master')

@section('title', "Hata Kayıtları")

@section('page_name', "Hata Kayıtları")

@section('content')

    <div class="row">

        <div style="width: 100%;text-align: right;margin-bottom: 10px;">
            <button type="button" class="btn btn-warning" style="color:white;" onclick="$.clearLog()">Tüm Logu Temizle</button>
        </div>

        <table class="table table-bordered" style="word-break: break-word;width: 100%;text-align: center;">
            <thead>
                <tr>
                    <th width="10%">Öncelik</th>
                    <th width="20%">Başlık</th>
                    <th>İçerik</th>
                    <th width="10%">Tarih</th>
                    <th width="10%">Sil</th>
                </tr>
            </thead>
            <tbody id="log_body">
                @foreach($logs as $log)

                    <tr id="row_{{$log->id}}">
                        <td style="color:{{$log->type_color}}">{{$log->type_text}}</td>
                        <td>{{$log->title}}</td>
                        <td>{{$log->description}}</td>
                        <td>{{\Carbon\Carbon::parse($log->created_at)->format("d.m.Y")}}</td>
                        <td><a class="btn btn-danger" style="color:white;" onclick="$.deleteLog({{$log->id}})">Sil</a></td>
                    </tr>

                @endforeach

            </tbody>
        </table>


    </div>

@endsection

@section('css')
    <style>

    </style>
@endsection

@section('javascript')

@endsection

@section('js_init')

    <script>
        $( document ).ready(function() {

            $.deleteLog = function (id) {

                Swal.fire({
                    title: "Hata Kaydı Silme",
                    text: "Silmek İstediğinize Emin Misiniz ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{route('admin.log.delete')}}",
                            type: "POST",
                            data: {id:id},
                            success: function(response){

                                if(response.status == 1){
                                    Swal.fire({
                                        icon:'success',
                                        title: "Hata Kaydı Silme",
                                        html: response.message,
                                        confirmButtonText: 'Tamam',
                                    });
                                    $("#row_"+id).remove();
                                }else{
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Bir hata Oluştu: '+response.message
                                    });
                                }
                            },
                            beforeSend: function () {
                                pleaseWaitOpen();
                            },
                            complete: function () {
                                pleaseWaitClose();
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Bir hata Oluştu: '+jqXHR.responseText
                                })
                                pleaseWaitClose();
                            },
                        });
                    }
                });
            };

            $.clearLog = function (id) {

                Swal.fire({
                    title: "Log Temizle",
                    text: "Tüm Logu Temizlemek İstediğinize Emin Misiniz ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{route('admin.log.clearLog')}}",
                            type: "POST",
                            data: {id:id},
                            success: function(response){

                                if(response.status == 1){
                                    Swal.fire({
                                        icon:'success',
                                        title: "Log Temizle",
                                        html: response.message,
                                        confirmButtonText: 'Tamam',
                                    });
                                    $("#log_body").html("");
                                }else{
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Bir hata Oluştu: '+response.message
                                    });
                                }
                            },
                            beforeSend: function () {
                                pleaseWaitOpen();
                            },
                            complete: function () {
                                pleaseWaitClose();
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Bir hata Oluştu: '+jqXHR.responseText
                                })
                                pleaseWaitClose();
                            },
                        });
                    }
                });
            };
        });
    </script>

@endsection


