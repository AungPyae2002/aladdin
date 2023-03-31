<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentResource;
use App\Http\Resources\TransactionResource;
use App\Models\Agent;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\ThreeDSchedule;
use App\Models\ThreeDSection;
use App\Models\Transaction;
use App\Models\TwoDSection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index($page = 1){
        return Agent::find(1)->customerTransactions;
    }

}
