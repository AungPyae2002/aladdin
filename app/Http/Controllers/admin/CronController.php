<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TwoDSchedule;
use App\Models\TwoDSection;
use App\Traits\CronTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDO;

class CronController extends Controller
{
    use CronTrait;
    public function set2DSections(){
        $this->set2DSection();
        return back();
    }
}
