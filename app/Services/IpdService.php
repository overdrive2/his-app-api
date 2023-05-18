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
                $ipd->dch_status_id = $hisIpd->dch_status_id;
                $ipd->dch_type_id = $hisIpd->dch_type_id;
                $ipd->dch_officer_id = $hisIpd->dch_officer_id;
                $ipd->firstward_id = $hisIpd->firstward_id;
                $ipd->pttype_id = $hisIpd->pttype_id;
                $ipd->spclty_id = $hisIpd->spclty_id;
                $ipd->save();

            return $ipd;
        }
    }
