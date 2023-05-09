<?php

namespace App\Http\Livewire\DataTable;

use App\Models\Opitemrec;
use App\Models\Serial;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait WithGetSerial
{
    public function checkDuplicate($schema, $val)
    {
        $row = DB::connection('his')->select("select count(*) from ".$schema->table_name." where ".$schema->column_name." = ".$val);
        $row = collect($row)->first();
        if($row->count > 0)
            return true;
        else
            return false;     
    }

    public function getSerial($srName)
    {
        $nextval = collect(DB::connection('his')->select("SELECT nextval('hosxp_seq".$srName."') AS cc"))->first();
        
        if($nextval){
            $schema = DB::connection('his')->select("SELECT c.column_name,c.table_name FROM information_schema.columns c WHERE c.table_catalog = '".env('HIS_DATABASE')."' 
            and c.column_name = '".$srName."' and is_nullable='NO'");

            $schema = collect($schema)->first();

            $serial = Serial::where('name', $srName)->first();

            if((int)$serial->serial_no < (int)$nextval->cc){
                $serial->serial_no = $nextval->cc;
            }else{
                DB::connection('his')->select("SELECT setval('hosxp_seq".$srName."', (select max_id from ict_get_maxid('".$schema->column_name."', '".$schema->table_name."')), true)");
                $nextval = collect(DB::connection('his')->select("SELECT nextval('hosxp_seq".$srName."') AS cc"))->first();
                $serial->serial_no = $nextval->cc;
            }
            
            return ($serial->save())? $nextval->cc : 0;  
        }
        else
            return 0;
    }

    public function getUuid_v4() {
        $have = true;
        $i = 0;
        $guid = '';

        while(($have)&&($i<=5)){
            $guid = '{'.(string) strtoupper(Str::uuid()).'}';
            $guid_count = Opitemrec::selectRaw("count(hos_guid)")->where('hos_guid', $guid)->first();
            if($guid_count->count == 0) $have = false;
            $i++;
        }
        
        return $guid;
    }
}
