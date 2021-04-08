@extends('layout.master')

@section('title', "Genel Ayarlar")

@section('page_name', "Genel Ayarlar")

@section('content')

    <div class="card card-default">
        <div class="card-body">

            <form role="form" method="post" action="{{route('admin.settings.update')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label text-right">Site Adı</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" name="site_name" placeholder="" value="{{$site_name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-1 col-form-label text-right">Logo</label>
                    <div class="col-sm-11">
                        <input type="file" name="logo">
                        <small class="form-text text-muted" style="color:red!important;">*Resim jpg veya png, Çözünürlük 128x128, Dosya boyutu max: 1MB olmalıdır!</small>
                        <img src="{{$logo}}" width="128" height="128" />
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-right">Google Maksimum Sayfa Sayısı</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="google_max_page" placeholder="" value="{{$google_max_page}}">
                        <small class="form-text text-muted" style="color:red!important;">*Google aramada bakacağı maksimum sayfa sayısını belirler. Artış ve azalışları 10 olarak yapınız. Kullanabileceğiniz rakamlar 10,20,30,40,50,60,70,80</small>
                    </div>
                </div>

                <!--div class="form-group row">
                    <label class="col-sm-2 col-form-label text-right">Google Custom Search API KEY</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="google_custom_search_api_key" placeholder="" value="{{$google_custom_search_api_key}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-right">Kimlik Trafik Kazası</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="search_engine_id" placeholder="" value="{{$search_engine_id}}">
                        <small class="form-text text-muted" style="color:red!important;">*Arama Motoru Kimliği trafik kazası için ayarlanmıştır. Site Filtrelemesi yoktur.</small>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label text-right">Kimlik İş Kazası</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="work_accident_search_engine_id" placeholder="" value="{{$work_accident_search_engine_id}}">
                        <small class="form-text text-muted" style="color:red!important;">*Arama Motoru Kimliği iş kazası için ayarlanmıştır. Site Filtreleme mevcuttur.</small>
                    </div>
                </div-->

                <div class="col-md-12" style="margin-top: 30px;">
                    <button type="submit" class="btn btn-success" style="width: 100%;">Kaydet</button>
                </div>

                <div class="col-md-12" style="margin-top: 30px;">
                    <small class="form-text text-muted" style="color:red!important;">*DİKKAT: Ayarlar,Hata Kayıtları,Aranacak Kelimeler hariç geri kalan tüm bilgileri silinecektir!</small>
                    <button type="button" onclick="$.clearAllData()" class="btn btn-danger" style="width: 100%;">TÜM VERİLERİ SIFIRLA</button>
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

            $.clearAllData = function () {

                Swal.fire({
                    title: "Tüm Verileri Temizle",
                    text: "Tüm Verileri Temizlemek İstediğinize Emin Misiniz ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{route('admin.settings.clearAllData')}}",
                            type: "POST",
                            success: function(response){

                                if(response.status == 1){
                                    Swal.fire({
                                        icon:'success',
                                        title: "Tüm Verileri Temizle",
                                        html: response.message,
                                        confirmButtonText: 'Tamam',
                                    });
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


