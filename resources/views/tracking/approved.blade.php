@extends('layout.master')

@section('title', "Onaylanan Arşiv")

@section('page_name', "Onaylanan Arşiv")

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
                </tr>
            </thead>
            <tbody>
                @foreach($trackings as $key => $tracking)

                    <tr>
                        <td>{{$tracking->type_text}}</td>
                        <td>{{$tracking->title}}</td>
                        <td>{!! substr($tracking->description, 0, 120) !!}</td>
                        <td>{{\Carbon\Carbon::parse($tracking->created_at)->format("d.m.Y")}}</td>
                        <td><a class="btn btn-info" href="{{$tracking->main_url}}" target="_blank">Link</a></td>
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

    </script>

@endsection


