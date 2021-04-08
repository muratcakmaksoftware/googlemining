@extends('layout.master')

@section('title', "Kelimeler")

@section('page_name', "Kelimeler")

@section('content')

    <div class="card card-default">
        <div class="card-body">
            <form method="POST" action="{{route('admin.word.create')}}">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label text-right">Kaza Tipi</label>
                    <div class="col-sm-11">
                        <select class="form-control" name="accident_type">
                            <option value="0">Trafik Kazası</option>
                            <option value="1">İş Kazası</option>
                            <option value="2">Çekici Bildirim</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-1 col-form-label text-right">Kelime</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" name="word" placeholder="Aranacak kelimeyi giriniz">
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br/>
                        @endforeach
                    </div>
                @endif

                <div class="col-md-12" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-success" style="width: 100%;">Kaydet</button>
                </div>

            </form>
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
        });
    </script>

@endsection


