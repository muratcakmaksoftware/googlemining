@extends('layout.master')

@section('title', "Hukukta")

@section('page_name', "Hukukta")

@section('content')

    <div data-toggle="collapse" href="#traffic_accident_collapse" style="background-color: #DF8C2F;padding: 10px;margin-bottom: 5px;cursor: pointer;">
        <h3 style="margin:0;color:white;font-weight: bold;"><i class="fas fa-car-crash"></i> TRAFİK KAZASI</h3>
    </div>
    <div id="traffic_accident_collapse" class="row collapse show">
        @foreach($trafficAccident as $tracking)


            <div class="col-md-3" id="card_id_{{$tracking->id}}">
                <div class="card card-primary collapsed-card">
                    <div style="cursor:pointer;" data-card-widget="collapse" class="card-header">
                        <h3 class="card-title">{{substr($tracking->lawTracking->plates,0, 30)}}</h3>

                        <div class="card-tools">
                            {{\Carbon\Carbon::parse($tracking->created_at)->format("d.m.Y")}} <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="card-body">

                        <a style="width: 100%;margin-bottom: 10px;" class="btn btn-info" data-toggle="collapse" href="#detail_collapse_{{$tracking->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            KAYNAK
                        </a>
                        <div class="collapse" id="detail_collapse_{{$tracking->id}}">
                            <div class="card card-body">
                                <div style="font-weight: bold;">
                                    Plakalar: {{($tracking->json_data != null ? json_decode($tracking->json_data)->plate : "Bulunamadı")}}
                                </div>
                                <p>
                                    {!! $tracking->description !!}
                                </p>

                                <hr/>

                                <a style="width: 100%;margin-bottom: 10px;" class="btn btn-info" data-toggle="collapse" href="#link_collapse_{{$tracking->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Linkleri Göster
                                </a>
                                <div class="collapse" id="link_collapse_{{$tracking->id}}">
                                    <div class="card card-body">
                                        <ul>
                                            @foreach($tracking->links as $link)
                                                <li><a href="{{$link->url}}" target="_blank">{{$link->site_name}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <table class="table table-bordered" style="word-break: break-word;width: 100%;">
                            <tr>
                                <td style="font-weight: bold;width: 30%;">Kaza Tipi</td>
                                <td>{{$tracking->lawTracking->accident_type_text}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Plakalar</td>
                                <td>{{$tracking->lawTracking->plates}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Sürücüler</td>
                                <td>{{$tracking->lawTracking->plates}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Kaza Tarihi</td>
                                <td>{{\Carbon\Carbon::parse($tracking->lawTracking->accident_date)->format("d.m.Y")}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">İl</td>
                                <td>{{$tracking->lawTracking->city}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Kazada Yaralı</td>
                                <td>{{$tracking->lawTracking->accident_injured}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Kazada Vefat</td>
                                <td>{{$tracking->lawTracking->accident_death}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Sigorta Firması</td>
                                <td>{{$tracking->lawTracking->insurance_company}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Poliçe No</td>
                                <td>{{$tracking->lawTracking->policy_no}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Telefon</td>
                                <td>{{$tracking->lawTracking->phone}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Açıklama</td>
                                <td>{!! $tracking->lawTracking->description !!}</td>
                            </tr>
                        </table>


                        <div class="form-group" style="margin-top:10px;">
                            <label>Durum</label>
                            <select class="form-control" id="law_status_{{$tracking->lawTracking->id}}">
                                <option value="0" @if($tracking->lawTracking->status == 0) selected @endif>Bekliyor</option>
                                <option value="1" @if($tracking->lawTracking->status == 1) selected @endif>Arandı</option>
                                <option value="2" @if($tracking->lawTracking->status == 2) selected @endif>Arandı Açmadı</option>
                                <option value="3" @if($tracking->lawTracking->status == 3) selected @endif>İşlemde</option>
                                <option value="4" @if($tracking->lawTracking->status == 4) selected @endif>Tamamlandı</option>
                                <option value="5" @if($tracking->lawTracking->status == 5) selected @endif>Kaydı Kapat</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label>Açıklama</label>
                            <textarea class="form-control" id="law_description_{{$tracking->lawTracking->id}}" rows="5" placeholder="Ek bilgi girmek isterseniz.">{{$tracking->lawTracking->law_description}}</textarea>
                        </div>

                        <button type="button" class="btn btn-block btn-success" onclick="$.lawSaveTracking({{$tracking->lawTracking->id}}, {{$tracking->id}})" style="margin-top: 10px;">Kaydet</button>

                        <button type="button" class="btn btn-block btn-danger" onclick="$.backTracking({{$tracking->id}})" style="margin-top: 10px;">Takibe Geri Gönder</button>
                    </div>
                </div>
            </div>
        @endforeach


    </div>

    <div data-toggle="collapse" href="#work_accident_collapse" style="background-color: #DF8C2F;padding: 10px;margin-bottom: 5px;cursor: pointer;">
        <h3 style="margin:0;color:white;font-weight: bold;"><i class="fas fa-user-injured"></i> İŞ KAZASI</h3>
    </div>
    <div id="work_collapse" class="row collapse show">
        @foreach($workAccident as $tracking)


            <div class="col-md-3" id="card_id_{{$tracking->id}}">
                <div class="card card-primary collapsed-card">
                    <div style="cursor:pointer;" data-card-widget="collapse" class="card-header">
                        <h3 class="card-title">{{substr($tracking->title, 0, 30)}}</h3>

                        <div class="card-tools">
                            {{\Carbon\Carbon::parse($tracking->created_at)->format("d.m.Y")}} <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="card-body">

                        <a style="width: 100%;margin-bottom: 10px;" class="btn btn-info" href="{{$tracking->main_url}}" target="_blank">Kaynak</a>

                        <table class="table table-bordered" style="word-break: break-word;width: 100%;">
                            <tr>
                                <td style="font-weight: bold;width: 30%;">Kaza Tipi</td>
                                <td>{{$tracking->lawTracking->accident_type_text}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Kaza Tarihi</td>
                                <td>{{\Carbon\Carbon::parse($tracking->lawTracking->accident_date)->format("d.m.Y")}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">İl</td>
                                <td>{{$tracking->lawTracking->city}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Kazada Yaralı</td>
                                <td>{{$tracking->lawTracking->accident_injured}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Kazada Vefat</td>
                                <td>{{$tracking->lawTracking->accident_death}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Telefon</td>
                                <td>{{$tracking->lawTracking->phone}}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Açıklama</td>
                                <td>{!! $tracking->lawTracking->description !!}</td>
                            </tr>
                        </table>

                        <div class="form-group" style="margin-top:10px;">
                            <label>Durum</label>
                            <select class="form-control" id="law_status_{{$tracking->lawTracking->id}}">
                                <option value="0" @if($tracking->lawTracking->status == 0) selected @endif>Bekliyor</option>
                                <option value="1" @if($tracking->lawTracking->status == 1) selected @endif>Arandı</option>
                                <option value="2" @if($tracking->lawTracking->status == 2) selected @endif>Arandı Açmadı</option>
                                <option value="3" @if($tracking->lawTracking->status == 3) selected @endif>İşlemde</option>
                                <option value="4" @if($tracking->lawTracking->status == 4) selected @endif>Tamamlandı</option>
                                <option value="5" @if($tracking->lawTracking->status == 5) selected @endif>Kaydı Kapat</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label>Açıklama</label>
                            <textarea class="form-control" id="law_description_{{$tracking->lawTracking->id}}" rows="5" placeholder="Ek bilgi girmek isterseniz.">{{$tracking->lawTracking->law_description}}</textarea>
                        </div>

                        <button type="button" class="btn btn-block btn-success" onclick="$.lawSaveTracking({{$tracking->lawTracking->id}}, {{$tracking->id}})" style="margin-top: 10px;">Kaydet</button>

                        <button type="button" class="btn btn-block btn-danger" onclick="$.backTracking({{$tracking->id}})" style="margin-top: 10px;">Takibe Geri Gönder</button>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div data-toggle="collapse" href="#tow_collapse" style="background-color: #DF8C2F;padding: 10px;margin-bottom: 5px;cursor: pointer;">
        <h3 style="margin:0;color:white;font-weight: bold;"><i class="fas fa-truck-pickup"></i> ÇEKİCİ</h3>
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
                    title: "Hukuktan Geri Alma",
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
                            url: "{{route('admin.lawTracking.backTracking')}}",
                            type: "POST",
                            data: {tracking_id:tracking_id},
                            success: function(response){

                                if(response.status == 1){
                                    Swal.fire({
                                        icon:'success',
                                        title: "Hukuktan Geri Alma",
                                        html: response.message,
                                        confirmButtonText: 'Tamam',
                                    });
                                    $("#card_id_"+tracking_id).remove();
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

            $.lawSaveTrackingAjax = function(law_tracking_id, tracking_id, status, description, remove){
                $.ajax({
                    url: "{{route('admin.lawTracking.lawSaveTracking')}}",
                    type: "POST",
                    data: {
                        law_tracking_id:law_tracking_id,
                        status:status,
                        description:description
                    },
                    success: function(response){

                        if(response.status == 1){
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });

                            if(remove){
                                $("#card_id_"+tracking_id).remove();
                            }
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
            };

            $.lawSaveTracking = function (law_tracking_id, tracking_id) {
                var status = $("#law_status_"+law_tracking_id).val();
                var description = $("#law_description_"+law_tracking_id).val();

                if(status == 5){ //Kaydı kapatma
                    Swal.fire({
                        title: "Hukukta Kaydı Kapat",
                        text: "Kaydı Kapatmak İstediğinize Emin Misiniz ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Evet Eminim',
                        cancelButtonText: 'Vazgeç'
                    }).then((result) => {
                        if (result.value) {
                            $.lawSaveTrackingAjax(law_tracking_id, tracking_id, status, description, true);
                        }
                    });
                }else{
                    $.lawSaveTrackingAjax(law_tracking_id, tracking_id, status, description, false);
                }

            };


        });
    </script>

@endsection


