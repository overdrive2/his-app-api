<?php
    namespace App\Services;

use App\Models\Ipd;

    class IpdService
    {
        public function create($an)
        {
            if(Ipd::where('an', $an)->count() == 0)
                $ipd = Ipd::make();
                $ipd->save();
            return $ipd;
        }
    }
