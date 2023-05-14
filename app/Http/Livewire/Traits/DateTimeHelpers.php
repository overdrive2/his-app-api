<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Support\Facades\DB;

trait DateTimeHelpers
{
    public function getCurrentDate() {
        $data = DB::select("SELECT CURRENT_DATE");
        return collect($data)->first()->current_date;
    }

    public function getTomorrowDate() {
        $data = DB::select("SELECT (CURRENT_DATE + interval '1 day') as d ");
        return collect($data)->first()->d;
    }

    public function getCurrentSTM() {
        $data = DB::select("SELECT CURRENT_TIMESTAMP::char(19)");
        return collect($data)->first()->current_timestamp;
    }

    public function getCurrentTime() {
        $data = DB::select("select CURRENT_TIME::time(0)");
        return collect($data)->first()->current_time;
    }

    public function getWsaeDate($date) {
        return collect(DB::select("select (cast(date_trunc('week', '".$date."'::date) as date)"
            ." + i )::date as  date from generate_series(0,6) i"));
    }

    public function incTime($time, $number) {
        return collect(DB::connection('his')
            ->select(sprintf("select ('%s'::time + interval '%s hour')::time", $time, $number)))
            ->first()
            ->time;
    }
}
