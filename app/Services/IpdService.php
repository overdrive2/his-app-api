<?php
    namespace App\Services;

    use App\Models\His\HisIpd;
    use App\Models\Ipd;
    use App\Models\Officer;
    use App\Models\Ward;

    class IpdService
    {

        public function mapData($row)
        {
            $uid = auth()->user()->id;

            return [
                'an' => $row->an,
                'admdoctor' => Officer::where('doctor_code', $row->admdoctor)->value('id'),
                'dchdate' => $row->dchdate,
                'dchtime' => $row->dchtime,
                'dchstts' => $row->dchstts,
                'dchtype' => $row->dchtype,
                'dch_doctor' => $row->dch_doctor,
                'first_ward' => Ward::where('ward_code', $row->first_ward)->value('id'),
                'ward' => Ward::where('ward_code', $row->ward)->value('id'),
                'regdate' => $row->regdate,
                'regtime' => $row->regtime,
                'prediag' => $row->prediag,
                //'pttype' => $row->pttype,
                'spclty' => $row->spclty,
                'vn' => $row->vn,
                'ipd_admit_type_id' => $row->ipd_admit_type_id,
                'confirm_discharge' => $row->confirm_discharge,
                'pname' => $row->pname,
                'fname' => $row->fname,
                'lname' => $row->lname,
                'birthday' => $row->birthday,
                'cid' => $row->cid,
                'sex' => $row->sex,
                'fullname' => $row->fullname,
                'created_by' => $uid,
                'updated_by' => $uid
            ];
        }

        public function create($an)
        {
            if(Ipd::where('an', $an)->count() == 0)
            {
                $hisIpd = HisIpd::where('an', $an)->first();

<<<<<<< HEAD
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
=======
                if($hisIpd)
                {
                    $patient = (new PatientService())->load($hisIpd->hn);
>>>>>>> ba91180a38bbbd5304fd2823fa949ea74b2fcc20

                    $data = $this->mapData($hisIpd);
                    $ipd = Ipd::make($data);

<<<<<<< HEAD
                $ipd->adm_officer_id = $hisIpd->adm_officer_id;
                $ipd->dch_status_id = $hisIpd->dch_status_id;
                $ipd->dch_type_id = $hisIpd->dch_type_id;
                $ipd->dch_officer_id = $hisIpd->dch_officer_id;
                $ipd->firstward_id = $hisIpd->firstward_id;
                $ipd->pttype_id = $hisIpd->pttype_id;
                $ipd->spclty_id = $hisIpd->spclty_id;
                $ipd->save();
=======
                    $ipd->patient_id = $patient->id;
                    $ipd->adm_officer_id = $hisIpd->adm_officer_id;
                    $ipd->save();
                }
            }
>>>>>>> ba91180a38bbbd5304fd2823fa949ea74b2fcc20

            return Ipd::where('an', $an)->first();
        }
    }
