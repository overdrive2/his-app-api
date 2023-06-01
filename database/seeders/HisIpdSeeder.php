<?php

namespace Database\Seeders;

use App\Models\His\HisIpd;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HisIpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HisIpd::truncate();

        $json = json_decode(file_get_contents("database/data/his_ipd.json"), true);

        foreach ($json as $key => $value) {
            HisIpd::create([
                'id'                => $value['id'],
                'an'                => $value['an'],
                'admdoctor'         => $value['admdoctor'],
                'dchdate'           => $value['dchdate'],
                'dchtime'           => $value['dchtime'],
                'dchstts'           => $value['dchstts'],
                'dchtype'           => $value['dchtype'],
                'dch_doctor'        => $value['dch_doctor'],
                'hn'                => $value['hn'],
                'first_ward'        => $value['first_ward'],
                'ward'              => $value['ward'],
                'regdate'           => $value['regdate'],
                'regtime'           => $value['regtime'],
                'prediag'           => $value['prediag'],
                'pttype'            => $value['pttype'],
                'spclty'            => $value['spclty'],
                'vn'                => $value['vn'],
                'ipd_admit_type_id' => $value['ipd_admit_type_id'],
                'confirm_discharge' => $value['confirm_discharge'],
                'pname'             => $value['pname'],
                'fname'             => $value['fname'],
                'lname'             => $value['lname'],
                'birthday'          => $value['birthday'],
                'cid'               => $value['cid'],
                'sex'               => $value['sex'],
                'fullname'          => $value['fullname']
            ]);
        }
    }
}
