<?php

namespace App\Http\Controllers\Home;

use App\Helpers\GoogleSearch\GoogleSearch;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Tracking;
use App\Models\LinkTracking;
use App\Models\Word;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use JanDrda\LaravelGoogleCustomSearchEngine\LaravelGoogleCustomSearchEngine;
use KubAT\PhpSimple\HtmlDomParser;

class HomeController extends Controller
{
    public function index()
    {
        $trafficAccidentWaitingCount = Tracking::where("type", 0)->where("status", 0)->count();
        $trafficAccidentApprovedCount = Tracking::where("type", 0)->where("status", 2)->count();

        $workWaitingCount = Tracking::where("type", 1)->where("status", 0)->count();
        $workAccidentApprovedCount = Tracking::where("type", 1)->where("status", 2)->count();

        $towWaitingCount = Tracking::where("type", 2)->where("status", 0)->count();
        $towAccidentApprovedCount = Tracking::where("type", 2)->where("status", 2)->count();

        return view('home.index')
            ->with("towWaitingCount", $towWaitingCount)
            ->with("towAccidentApprovedCount", $towAccidentApprovedCount)
            ->with("workWaitingCount", $workWaitingCount)
            ->with("workAccidentApprovedCount", $workAccidentApprovedCount)
            ->with("trafficAccidentWaitingCount", $trafficAccidentWaitingCount)
            ->with("trafficAccidentApprovedCount", $trafficAccidentApprovedCount);

    }

}
