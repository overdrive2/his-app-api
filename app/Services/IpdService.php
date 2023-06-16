<?php
    namespace App\Services;

    use App\Models\His\HisIpd;
use App\Models\his\HisTransferData;
use App\Models\Ipd;

    class IpdService
    {

        public function mapData($row)
        {
            $uid = auth()->user()->id;

            return [
                'an' => $row->an,
                'adm_officer_id' => $row->adm_officer_id,
                'firstward_id' => $row->first_ward_id,
                'regdate' => $row->regdate,
                'regtime' => $row->regtime,
                'prediag' => $row->prediag,
                'pttype_id' => $row->pttype_id,
                'spclty_id' => $row->spclty_id,
                'vn' => $row->vn,
                'ipd_admit_type_id' => $row->ipd_admit_type_id,
                'confirm_discharge' => false,
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

            return Ipd::select('id', 'an', 'admit_for', 'regdate', 'regtime', 'pttype_id', 'patient_id')
                ->where('an', $an)->first();
        }

        public function tranfered($id)
        {
            $row = [
                'code' => 'ipt',
                'pk_fieldname' => 'an',
                'value' => Ipd::where('id', $id)->value('an'),
                'created_by' => auth()->user()->id
            ];

            HisTransferData::create($row);
        }
    }
