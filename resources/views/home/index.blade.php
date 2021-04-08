@extends('layout.master')

@section('title', "Ana Sayfa")

@section('page_name', "Ana Sayfa")

@section('content')
    <div style="background-color: #DF8C2F;padding: 10px;margin-bottom: 5px;cursor: pointer;">
        <h3 style="margin:0;color:white;font-weight: bold;"><i class="fas fa-car-crash"></i> TRAFİK KAZASI</h3>
    </div>
    <div class="row">

        <div class="col-lg-3 col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$trafficAccidentWaitingCount}}</h3>
                    <p>Bekleyen</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner" style="color:white;"></i>
                </div>
                <a href="{{route('admin.tracking.traffic_accident')}}" class="small-box-footer">
                    Daha Fazla <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$trafficAccidentApprovedCount}}</h3>
                    <p>Hukukta</p>
                </div>
                <div class="icon">
                    <i class="fas fas fa-book" style="color:white;"></i>
                </div>
                <a href="{{route('admin.lawTracking.index')}}" class="small-box-footer">
                    Daha Fazla <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>

    <div style="background-color: #DF8C2F;padding: 10px;margin-bottom: 5px;cursor: pointer;">
        <h3 style="margin:0;color:white;font-weight: bold;"><i class="fas fa-user-injured"></i> İŞ KAZASI</h3>
    </div>
    <div class="row">

        <div class="col-lg-3 col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$workWaitingCount}}</h3>
                    <p>Bekleyen</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner" style="color:white;"></i>
                </div>
                <a href="{{route('admin.tracking.work_accident')}}" class="small-box-footer">
                    Daha Fazla <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$workAccidentApprovedCount}}</h3>
                    <p>Hukukta</p>
                </div>
                <div class="icon">
                    <i class="fas fas fa-book" style="color:white;"></i>
                </div>
                <a href="{{route('admin.lawTracking.index')}}" class="small-box-footer">
                    Daha Fazla <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>

    <div style="background-color: #DF8C2F;padding: 10px;margin-bottom: 5px;cursor: pointer;">
        <h3 style="margin:0;color:white;font-weight: bold;"><i class="fas fa-truck-pickup"></i> ÇEKİCİ</h3>
    </div>
    <div class="row">

        <div class="col-lg-3 col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{$towWaitingCount}}</h3>
                    <p>Bekleyen</p>
                </div>
                <div class="icon">
                    <i class="fas fa-spinner" style="color:white;"></i>
                </div>
                <a href="{{route('admin.tracking.tow')}}" class="small-box-footer">
                    Daha Fazla <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$towAccidentApprovedCount}}</h3>
                    <p>Hukukta</p>
                </div>
                <div class="icon">
                    <i class="fas fas fa-book" style="color:white;"></i>
                </div>
                <a href="{{route('admin.lawTracking.index')}}" class="small-box-footer">
                    Daha Fazla <i class="fas fa-arrow-circle-right"></i>
                </a>
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

        });
    </script>

@endsection


