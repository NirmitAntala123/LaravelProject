<?php

namespace App\Listeners;

use App\Events\LoginHistory;
use App\Events\Logcompany;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class storeUserLoginHistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LoginHistory  $event
     * @return void
     */
    public function handle($event)
    {
        if($event instanceof LoginHistory ){
            $message = $event->user->name . ' just logged in';
            $current_timestamp = Carbon::now()->toDateTimeString();
            $userinfo = $event->user;
            $saveHistory = DB::table('log')->insert(
                ['user_id' => $userinfo->id,'message' => $message,'name' => $userinfo->name, 'email' => $userinfo->email, 'created_at' => $current_timestamp, 'updated_at' => $current_timestamp]
            );
            return $saveHistory;
        }
        else if($event instanceof Logcompany){
            $userid=Auth::user()->id;
            // dd($event->company);
            $message = Auth::user()->name . ' just create company data..';
            $current_timestamp = Carbon::now()->toDateTimeString();
            $userinfo = $event->company;
            $saveHistory = DB::table('log')->insert(
                ['user_id' => $userid,'message' => $message,'name' => $userinfo->name, 'email' => $userinfo->email, 'created_at' => $current_timestamp, 'updated_at' => $current_timestamp]
            );
            return $saveHistory;
        }
       
    }
}

