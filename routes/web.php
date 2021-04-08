<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/login', 'namespace' => 'Login'], function () {
    Route::get('index', 'LoginController@index')->name('login.index');
    Route::post('auth', 'LoginController@auth')->name('login.auth');

    Route::get('logout', 'LoginController@logout')->name('login.logout');
});


Route::group(['prefix' => '/', 'namespace' => 'Home', 'middleware' => 'admin'], function () {
    Route::get('/', 'HomeController@index')->name('admin.home');
});

Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    Route::group(['prefix' => '/tracking', 'namespace' => 'Tracking'], function () {
        //Trafik Kazası Listeleme
        Route::get('traffic_accident', 'TrackingController@trafficAccident')->name('admin.tracking.traffic_accident');
        //İş Kazası Listeleme
        Route::get('work_accident', 'TrackingController@workAccident')->name('admin.tracking.work_accident');
        //Çekici Bildirme Listeleme
        Route::get('tow_accident', 'TrackingController@tow')->name('admin.tracking.tow');

        //Trafik Kazasını Hukuka gönderme
        Route::post('lawTrafficAccidentCreate', 'TrackingController@lawTrafficAccidentCreate')->name('admin.tracking.lawTrafficAccidentCreate');
        //İş Kazasını Hukuka gönderme
        Route::post('lawWorkAccidentCreate', 'TrackingController@lawWorkAccidentCreate')->name('admin.tracking.lawWorkAccidentCreate');

        //İptal etme işlemi
        Route::post('cancel', 'TrackingController@cancel')->name('admin.tracking.cancel');

        //Onaylananlar
        Route::get('getApproved', 'TrackingController@getApproved')->name('admin.tracking.getApproved');
        //İptal Edilenler
        Route::get('getCancel', 'TrackingController@getCancel')->name('admin.tracking.getCancel');
        //İptal edileni geri alma
        Route::post('backTracking', 'TrackingController@backTracking')->name('admin.tracking.backTracking');
    });

    //Hukukta
    Route::group(['prefix' => '/lawTracking', 'namespace' => 'LawTracking'], function () {
        Route::get('index', 'LawTrackingController@index')->name('admin.lawTracking.index');
        Route::post('backTracking', 'LawTrackingController@backTracking')->name('admin.lawTracking.backTracking');
        Route::post('lawSaveTracking', 'LawTrackingController@lawSaveTracking')->name('admin.lawTracking.lawSaveTracking');
    });

    //Genel Ayarlar
    Route::group(['prefix' => '/settings', 'namespace' => 'Setting'], function () {
        Route::get('index', 'SettingController@index')->name('admin.settings.index');
        Route::post('update', 'SettingController@update')->name('admin.settings.update');
        Route::post('clearAllData', 'SettingController@clearAllData')->name('admin.settings.clearAllData');
    });

    //Hata Kayıtları
    Route::group(['prefix' => '/logs', 'namespace' => 'Log'], function () {
        Route::get('index', 'LogController@index')->name('admin.log.index');
        Route::post('delete', 'LogController@delete')->name('admin.log.delete');
        Route::post('clearLog', 'LogController@clearLog')->name('admin.log.clearLog');
    });

    //Aranacak Kelimeler
    Route::group(['prefix' => '/words', 'namespace' => 'Word'], function () {
        Route::get('index', 'WordController@index')->name('admin.word.index');
        Route::get('getAdd', 'WordController@getAdd')->name('admin.word.getAdd');
        Route::post('create', 'WordController@create')->name('admin.word.create');
        Route::post('delete', 'WordController@delete')->name('admin.word.delete');
    });
});
