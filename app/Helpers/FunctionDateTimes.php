<?php

namespace App\Helpers;

trait FunctionDateTimes
{
    public   $dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
    public   $monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
    public   $monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];

    public function thai_date_and_time($time){   // 19 ธันวาคม 2556 เวลา 10:10:43
        $thai_date_return = date("j",$time);
        $thai_date_return.=" ".$this->monthTH[$time->format("n")];
        $thai_date_return.= " ".(date("Y",$time)+543);
        $thai_date_return.= " เวลา ".date("H:i:s",$time);
        return $thai_date_return;
    }

    public function thai_date_and_time_short($time){   // 19  ธ.ค. 2556 10:10:4
        global $dayTH,$monthTH_brev;
        $thai_date_return = $time->format("j");
        $thai_date_return.=" ".$monthTH_brev[$time->format("m")];
        $thai_date_return.= " ".($time->format("Y")+543);
        $thai_date_return.= " ".$time->format("H:i:s");
        return $thai_date_return;
    }

    public function thai_date_short($time){   // 19  ธ.ค. 2556a
        $thai_date_return = $time->format("j");
        $thai_date_return.=" ".$this->monthTH_brev[$time->format("n")];
        $thai_date_return.= " ".($time->format("Y")+543);
        return $thai_date_return;
    }

    public function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
        $thai_date_return = $time->format("j");
        $thai_date_return.=" ".$this->monthTH[$time->format("n")];
        $thai_date_return.= " ".($time->format("Y")+543);
        return $thai_date_return;
    }

    public function thai_date_short_number($time){   // 19-12-56
        $thai_date_return = date("d",$time);
        $thai_date_return.="-".date("m",$time);
        $thai_date_return.= "-".substr((date("Y",$time)+543),-2);
        return $thai_date_return;
    }

    public function thai_date_short_number2($time){   // 19/12/2556
        $thai_date_return = (int)$time->format("d");
        $thai_date_return.="/".(int)$time->format("m");
        $y = intval($time->format("Y"))+543;
        $thai_date_return.= "/".(string)$y;
        return $thai_date_return;
    }

    public function thdate2YMD($value)
    {
        $d = explode("/",$value);
		$d = ($d[2]-543).'-'.str_pad(($d[1]*1), 2, '0', STR_PAD_LEFT).'-'.str_pad($d[0], 2, '0', STR_PAD_LEFT);
		return $d;
    }

    public function YMD2ThaiDate($value)
    {
        $d = explode("-",$value);
		$d = $d[2].'/'.$d[1].'/'.$d[0];
		return $d;
    }

    function highlight($text='', $word='')
    {
        if(strlen($text) > 0 && strlen($word) > 0)
        {
            return (str_ireplace($word, "<span class='text-red-600'>{$word}</span>", $text));
        }
        return ($text);
    }

}
