<?php
    namespace App\Services;

    use App\Models\His\HisPatient;
    use App\Models\Patient;

    class PatientService
    {
        public function mapData($row)
        {
            $uid = auth()->user()->id;

            return [
                'hn' => $row->hn,
                'pname' => $row->pname,
                'fname' => $row->fname,
                'lname' => $row->lname,
                'cid' => $row->cid,
                'sex' => $row->sex,
                'birthday' => $row->birthday,
                'mobile_phone_number' => $row->mobile,
                'is_death' => false,
                'is_admit' => false,
                'updated_by' => $uid,
                'created_by' => $uid
            ];
        }

        public function load($hn)
        {
            if(Patient::where('hn', $hn)->count() == 0)
            {
                $hisPat = HisPatient::where('hn', $hn)->first();

                if($hisPat)
                {
                    $data = $this->mapData($hisPat);
                    $pat = Patient::make($data);
                    $pat->save();
                }
            }

            return Patient::where('hn', $hn)->first();
        }
    }
