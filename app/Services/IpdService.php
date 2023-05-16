<?php
    namespace App\Services;

use App\Models\HisIpd;
use App\Models\Ipd;

    class IpdService
    {
        public function create($an)
        {
            if(Ipd::where('an', $an)->count() == 0)

                $hisIpd = HisIpd::select(
                    'an',
                    'admdoctor',
                    'dchdate',
                    'dchtime',
                    'dchstts',
                    'dchtype',
                    'dch_doctor',
                    'hn',
                    'first_ward',
                    'ward',
                    'regdate',
                    'regtime',
                    'prediag',
                    'pttype',
                    'spclty',
                    'vn',
                    'ipd_admit_type_id',
                    'confirm_discharge',
                    'pname',
                    'fname',
                    'lname',
                    'birthday',
                    'cid',
                    'sex',
                    'fullname')
                    ->where('an', $an)->first();

                $ipd = Ipd::make($hisIpd);

                $ipd->adm_officer_id = $hisIpd->adm_officer_id;
                $ipd->save();

            return $ipd;
        }
    }
