@extends('layout.master')

@section('title', "İptal Edilen Arşiv")

@section('page_name', "İptal Edilen Arşiv")

@section('content')

    <div class="row">

        <table class="table table-bordered" style="word-break: break-word;width: 100%;text-align: center;">
            <thead>
                <tr>
                    <th>Tip</th>
                    <th>Başlık</th>
                    <th>İçerik</th>
                    <th width="10%">Tarih</th>
                    <th width="10%">Kaynak</th>
                    <th width="10%">Geri Al</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trackings as $tracking)

                    <tr id="tracking_row_{{$tracking->id}}">
                        <td>{{$tracking->type_text}}</td>
                        <td>{{$tracking->title}}</td>
                        <td>{!! substr($tracking->description, 0, 120) !!}</td>
                        <td>{{\Carbon\Carbon::parse($tracking->created_at)->format("d.m.Y")}}</td>
                        <td><a class="btn btn-info" href="{{$tracking->main_url}}" target="_blank">Link</a></td>
                        <td><a class="btn btn-success" style="color:white;" onclick="$.backTracking({{$tracking->id}})">Geri Al</a></td>
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

            $.backTracking = function (tracking_id) {

                Swal.fire({
                    title: "İptalden Geri Alma",
                    text: "Geri Almak İstediğinize Emin Misiniz ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{route('admin.tracking.backTracking')}}",
                            type: "POST",
                            data: {tracking_id:tracking_id},
                            success: function(response){

                                if(response.status == 1){
                                    Swal.fire({
                                        icon:'success',
                                        title: "İptalden Geri Alma",
                                        html: response.message,
                                        confirmButtonText: 'Tamam',
                                    });
                                    $("#tracking_row_"+tracking_id).remove();
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


