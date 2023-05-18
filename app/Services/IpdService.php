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

                if($hisIpd)
                {
                    $patient = (new PatientService())->load($hisIpd->hn);

                    $data = $this->mapData($hisIpd);
                    $ipd = Ipd::make($data);

                    $ipd->patient_id = $patient->id;
                    $ipd->adm_officer_id = $hisIpd->adm_officer_id;
                    $ipd->save();
                }
            }

            return Ipd::where('an', $an)->first();
        }
    }
