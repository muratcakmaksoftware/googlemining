@extends('layout.master')

@section('title', "Kelimeler")

@section('page_name', "Kelimeler")

@section('content')

    <div class="row">
        <div class="col-md-12 text-right" style="margin-bottom: 10px;">
            <a href="{{route('admin.word.getAdd')}}" type="button" class="btn btn-success">Kelime Ekle</a>
        </div>
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs nav-fill">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="pill" href="#tab1" aria-selected="true">Trafik Kazası</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab2" role="tab" aria-selected="false">İş Kazası</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#tab3" role="tab" aria-selected="false">Çekici Bildirim</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1">

                            <table class="table table-bordered" style="word-break: break-word;width: 100%;text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Kelime</th>
                                        <th width="10%">Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($traffic_accident as $row)
                                        <tr id="traffic_accident_{{$row->id}}">
                                            <td>{{$row->name}}</td>
                                            <td><a class="btn btn-danger" style="color:white;" onclick="$.deleteWord('traffic_accident_', {{$row->id}})">Sil</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="tab2">
                            <table class="table table-bordered" style="word-break: break-word;width: 100%;text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Kelime</th>
                                        <th width="10%">Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($work_accident as $row)
                                        <tr id="work_accident_{{$row->id}}">
                                            <td>{{$row->name}}</td>
                                            <td><a class="btn btn-danger" style="color:white;" onclick="$.deleteWord('work_accident_', {{$row->id}})">Sil</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab3">
                            <table class="table table-bordered" style="word-break: break-word;width: 100%;text-align: center;">
                                <thead>
                                    <tr>
                                        <th>Kelime</th>
                                        <th width="10%">Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tows as $row)
                                        <tr id="tows_{{$row->id}}">
                                            <td>{{$row->name}}</td>
                                            <td><a class="btn btn-danger" style="color:white;" onclick="$.deleteWord('tows_', {{$row->id}})">Sil</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

            $.deleteWord = function (tag, id) {

                Swal.fire({
                    title: "Aranacak Kelime Silme",
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
                            url: "{{route('admin.word.delete')}}",
                            type: "POST",
                            data: {id:id},
                            success: function(response){

                                if(response.status == 1){
                                    Swal.fire({
                                        icon:'success',
                                        title: "Aranacak Kelime Silme",
                                        html: response.message,
                                        confirmButtonText: 'Tamam',
                                    });
                                    $("#"+tag+id).remove();
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


