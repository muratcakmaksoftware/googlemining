@extends('layout.master')

@section('title', "Trafik Kazası")

@section('page_name', "Trafik Kazası")

@section('content')

    <div class="row">

        @foreach($trackings as $tracking)

            <?php
                $plates = $tracking->json_data != null ? json_decode($tracking->json_data)->plate : "Bulunamadı";
            ?>

            <div class="col-md-3" id="card_id_{{$tracking->id}}">
                <div class="card card-primary collapsed-card">
                    <div style="cursor:pointer;" data-card-widget="collapse" class="card-header">
                        <h3 class="card-title">{{$tracking->plate}}</h3>

                        <div class="card-tools">
                            {{\Carbon\Carbon::parse($tracking->created_at)->format("d.m.Y")}} <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="font-weight: bold;">
                            Plakalar: {{$plates}}
                        </div>
                        <p>
                            {!! $tracking->description !!}
                        </p>

                        <hr/>
                        <a style="width: 100%;margin-bottom: 10px;" class="btn btn-info" data-toggle="collapse" href="#collapse_{{$tracking->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Linkleri Göster
                        </a>
                        <div class="collapse" id="collapse_{{$tracking->id}}">
                            <div class="card card-body">
                                <ul>
                                    @foreach($tracking->links as $link)
                                        <li><a href="{{$link->url}}" target="_blank">{{$link->site_name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn btn-block btn-success" onclick="$.lawSend({{$tracking->id}}, '{{$plates}}')" >Hukuka Gönder</button>
                        <button type="button" class="btn btn-block btn-danger" onclick="$.cancelTracking({{$tracking->id}}, '{{$tracking->plate}}')">İptal</button>
                    </div>
                </div>
            </div>
        @endforeach


    </div>

    <div class="modal fade" id="law_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hukuka Gönder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="law_tracking_id" value="" />

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Kaza Tipi</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="law_accident_type">
                                <option value="0">Tek Taraflı</option>
                                <option value="1">Çift Taraflı</option>
                                <option value="2">Zincirleme</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Plakalar</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_plates" placeholder="Kaç adet plaka varsa giriniz.">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Sürücüler</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_drivers" placeholder="Kaç adet sürücü varsa giriniz.">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Kaza Tarihi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control datepicker" id="law_accident_date" placeholder="Kaza Tarihi">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">İl</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_city" placeholder="İl">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Kazada Yaralı</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_accident_injured" placeholder="Kazada Yaralı varsa adetini yazınız yoksa boş geçiniz.">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Kazada Vefat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_accident_death" placeholder="Kazada Vefat varsa adetini yazınız yoksa boş geçiniz.">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Sigorta Firması</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_insurance_company" placeholder="Sigorta Firması">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Poliçe No</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_policy_no" placeholder="Poliçe No">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Telefon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="law_phone" placeholder="Telefon">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-right">Açıklama</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="law_description" rows="5" placeholder="Ek bilgi girmek isterseniz."></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-success" onclick="$.lawCreate()">Kaydet</button>
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
            $.cancelTracking = function (tracking_id, plate) {

                Swal.fire({
                    title: plate,
                    text: "Silmek istediğinize emin misiniz ?",
                    icon: 'warning',
                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{route('admin.tracking.cancel')}}",
                            type: "POST",
                            data: {tracking_id:tracking_id},
                            success: function(response){

                                if(response.status == 1){
                                    //toastr.success(response.message);
                                    Swal.fire({
                                        icon:'success',
                                        title: plate,
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

            $.lawSend = function (id, plates) {
                $("#law_modal").modal("show");
                $("#law_tracking_id").val(id);
                $("#law_plates").val(plates);
            };

            $.lawCreate = function () {
                var tracking_id = $("#law_tracking_id").val();
                var accident_type = $("#law_accident_type").val();
                var plates = $("#law_plates").val();
                var drivers = $("#law_drivers").val();
                var accident_date = $("#law_accident_date").val();
                var city = $("#law_city").val();
                var accident_injured = $("#law_accident_injured").val();
                var accident_death = $("#law_accident_death").val();
                var insurance_company = $("#law_insurance_company").val();
                var policy_no = $("#law_policy_no").val();
                var phone = $("#law_phone").val();
                var description = $("#law_description").val();


                if(tracking_id == "" || plates == ""){
                    Toast.fire({
                        icon: 'warning',
                        title: 'Lütfen plaka numarasını giriniz!'
                    });
                }

                $.ajax({
                    url: "{{route('admin.tracking.lawTrafficAccidentCreate')}}",
                    type: "POST",
                    data: {
                        tracking_id:tracking_id,
                        accident_type:accident_type,
                        plates:plates,
                        drivers:drivers,
                        accident_date:accident_date,
                        city:city,
                        accident_injured:accident_injured,
                        accident_death:accident_death,
                        insurance_company:insurance_company,
                        policy_no:policy_no,
                        phone:phone,
                        description:description,
                    },
                    success: function(response){

                        if(response.status == 1){
                            Swal.fire({
                                icon:'success',
                                title: plates,
                                html: response.message,
                                confirmButtonText: 'Tamam',
                            });

                            $("#card_id_"+tracking_id).remove();
                            $("#law_modal").modal("hide");

                            //Clear Inputs
                            $("#law_tracking_id").val("");
                            $("#law_accident_type").val("0");
                            $("#law_plates").val("");
                            $("#law_drivers").val("");
                            $("#law_accident_date").val("");
                            $("#law_city").val("");
                            $("#law_accident_injured").val("");
                            $("#law_accident_death").val("");
                            $("#law_insurance_company").val("");
                            $("#law_policy_no").val("");
                            $("#law_phone").val("");
                            $("#law_description").val("");

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

        });
    </script>

@endsection


