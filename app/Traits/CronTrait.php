<?php
namespace App\Traits;

use App\Models\ClosingDay;
use App\Models\CustomerBalance;
use App\Models\CustomerTransaction;
use App\Models\ThreeDSchedule;
use App\Models\ThreeDSection;
use App\Models\Transaction;
use App\Models\TwoDSchedule;
use App\Models\TwoDSection;
use App\Notifications\WinningNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

trait CronTrait{
    public function set2DSection(){
        \Log::info("2D Cron Running...");

        $twod_schedules = TwoDSchedule::active()->get();
        foreach ($twod_schedules as $schedule) {

            if (Carbon::now()->gt(Carbon::createFromTimeString('17:00'))) {
                $opening_date_time = Carbon::parse(Carbon::today()->addDay()->format('Y-m-d') . ' ' . Carbon::parse($schedule->opening_time)->format('H:i'))->format('Y-m-d H:i');
            } else {
                $opening_date_time = Carbon::parse(Carbon::today()->format('Y-m-d') . ' ' . Carbon::parse($schedule->opening_time)->format('H:i'))->format('Y-m-d H:i');
            }

            if (TwoDSection::where('opening_date_time', $opening_date_time)->doesntExist() && 
                ClosingDay::where('date',$opening_date_time)->doesntExist() && 
                Carbon::parse($opening_date_time)->isWeekday()) {
                    
                $section = new TwoDSection();
                $section->twod_type_id = $schedule->type->id ?? null;
                $section->twod_schedule_id = $schedule->id;
                $section->opening_date_time = $opening_date_time;
                $section->multiply = $schedule->multiply;
                $section->minimum_amount = $schedule->minimum_amount;
                $section->maximum_amount = $schedule->maximum_amount;
                $numbers = [];
                for ($i = 0; $i <= 99; $i++) {
                    $number = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $numbers[$number] = [
                        'minimum_amount' => $schedule->mininum_amount,
                        'maximum_amount' => $schedule->maximum_amount
                    ];
                }
                $section->numbers_info = json_encode($numbers);
                $section->save();

                \Log::info("New 2D Sections Set!");
            }
        }
        \Log::info("2D Cron Running Complete...");
    }

    public function set3DSection(){
        \Log::info("3D Cron Running...");

        $threed_schedules = ThreeDSchedule::active()->orderBy('opening_date')->get();
        foreach ($threed_schedules as $schedule) {

            $year = Carbon::today()->format('Y');
            $day = $schedule->opening_date;

            if (Carbon::today()->format('d') > $schedule->opening_date) {
                $month = Carbon::today()->addMonth()->format('m');
            } else {
                $month = Carbon::today()->format('m');
            }

            $opening_date_time = Carbon::parse($year . '-' . $month . '-' . $day . ' ' . Carbon::parse($schedule->opening_time)->format('H:i'));

            if (
                ThreeDSection::whereDate('opening_date_time', $opening_date_time->format('Y-m-d'))->doesntExist()
            ) {

                $section = new ThreeDSection();
                $section->threed_schedule_id = $schedule->id;
                $section->opening_date_time = $opening_date_time->format('Y-m-d H:i');
                $section->multiply = $schedule->multiply;
                $section->ending_minute = $schedule->ending_minute;
                $section->minimum_amount = $schedule->minimum_amount;
                $section->maximum_amount = $schedule->maximum_amount;
                $numbers = [];
                for ($i = 0; $i <= 999; $i++) {
                    $number = str_pad($i, 3, '0', STR_PAD_LEFT);
                    $numbers[$number] = [
                        'minimum_amount' => $schedule->mininum_amount,
                        'maximum_amount' => $schedule->maximum_amount
                    ];
                }
                $section->numbers_info = json_encode($numbers);
                $section->save();

                \Log::info("New 3D Section Set!");
            }
        }
        \Log::info("3D Cron Running Complete...");
    }


    public function reward2DBettings(){
        \Log::info("Reward Cron Running...");

        $twod_sections = TwoDSection::where('opening_date_time','<=',Carbon::now())->where('rewarded_users',0)->get();
        foreach($twod_sections as $section){
            if($section->winning_number){
                foreach ($section->bettingLogs()->where('bet_number', $section->winning_number)->get() as $log) {

                    $winning_amount = $log->amount * $section->multiply;
                    $customer = $log->customer;

                    DB::beginTransaction();
                    try{
                        $transaction = new CustomerTransaction;
                        $transaction->transaction_id = Str::uuid();
                        $transaction->customer_id = $customer->id;
                        $transaction->type = CustomerTransaction::IN;
                        $transaction->status = 2;
                        $transaction->amount = $winning_amount;
                        $transaction->save();
                        $section->customerTransactions()->save($transaction);

                        $balance = new CustomerBalance();
                        $balance->amount = $winning_amount;
                        $balance->customer_id = $customer->id;
                        $balance->save();

                        $log->received_winning = true;
                        $log->update();

                        Notification::send($customer, new WinningNotification($log));

                        DB::commit();
                    }catch(Exception $e){
                        \Log::info( $e->getMessage());
                        DB::rollBack();
                    }
                }

                $section->rewarded_users = true;
                $section->update();
            }

            
        }

        $threed_sections = ThreeDSection::where('opening_date_time', '<=', Carbon::now())->where('rewarded_users', 0)->get();
        foreach ($threed_sections as $section) {
            if ($section->winning_number) {
                foreach ($section->bettingLogs()->where('bet_number', $section->winning_number)->get() as $log) {

                    $winning_amount = $log->amount * $section->multiply;
                    $customer = $log->customer;

                    DB::beginTransaction();
                    try {
                        $transaction = new CustomerTransaction;
                        $transaction->transaction_id = Str::uuid();
                        $transaction->customer_id = $customer->id;
                        $transaction->type = CustomerTransaction::IN;
                        $transaction->status = 2;
                        $transaction->amount = $winning_amount;
                        $transaction->save();
                        $section->customerTransactions()->save($transaction);

                        $balance = new CustomerBalance();
                        $balance->amount = $winning_amount;
                        $balance->customer_id = $customer->id;
                        $balance->save();

                        $log->received_winning = true;
                        $log->update();

                        Notification::send($customer, new WinningNotification($log));

                        DB::commit();
                    } catch (Exception $e) {
                        \Log::info($e->getMessage());
                        DB::rollBack();
                    }
                }

                $section->rewarded_users = true;
                $section->update();
            }
        }


        \Log::info("Reward Cron Running Complete...");

    }
}