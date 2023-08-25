<?php

namespace App\Observers;

use App\Models\Bed;
use App\Models\his\HisTransferData;
use App\Models\Ipd;
use App\Models\IpdBedmove;

class IpdBedmoveObserver
{
    /**
     * Handle the IpdBedmove "created" event.
     */
    public function created(IpdBedmove $ipdBedmove): void
    {
        //
    }

    public function saved(IpdBedmove $ipdBedmove): void
    {
        if($ipdBedmove->bedmove_type_id == config('ipd.newcase'))
        {
            $ipd = Ipd::find($ipdBedmove->ipd_id);

            $count = HisTransferData::where('pk_fieldname', 'an')
                ->where('code', 'ipt')
                ->where('value', $ipd->an)->count();

            if($ipd) {
                // Set Current bedmove to IPD
                $ipd->current_bedmove_id = $ipdBedmove->id;
                $ipd->save();

                if($count == 0) //* Dispatch IPD to HIS *//
                    HisTransferData::create([
                        'code' => 'ipt',
                        'pk_fieldname' => 'an',
                        'value' => $ipd->an,
                        'created_by' => auth()->user()->id
                    ]);

            }

            $bed = Bed::find($ipdBedmove->bed_id);

            if($bed) {
                $bed->empty_flag = false;
                $bed->last_bedmove_id = $ipdBedmove->id;
                $bed->save();
            }

            /*(($lbm->bedmove_type_id == config('ipd.moveout'))||($lbm->to_ref_id != '0' && $lbm->to_ref_id != null));
            ->update([
                'empty_flag' => (
                        ($lbm->bedmove_type_id == config('ipd.moveout'))
                        ||($lbm->to_ref_id != '0' && $lbm->to_ref_id != null)
                )
            ]);*/

            // Update Current
        }
    }
    /**
     * Handle the IpdBedmove "updated" event.
     */
    public function updated(IpdBedmove $ipdBedmove): void
    {
        //
    }

    /**
     * Handle the IpdBedmove "deleted" event.
     */
    public function deleted(IpdBedmove $ipdBedmove): void
    {
        if($ipdBedmove->bedmove_type_id == config('ipd.newcase'))
        {
            $ipd = Ipd::find($ipdBedmove->ipd_id);

            if(!$ipd) return;

            HisTransferData::where('pk_fieldname', 'an')
                ->where('code', 'ipt')
                ->where('value', $ipd->an)
                ->delete();

            $ipd->delete();

            $bed = Bed::find($ipdBedmove->bed_id);

            if($bed) {
                $bed->empty_flag = true;
                $bed->last_bedmove_id = null;
                $bed->save();
            }
        }
    }

    /**
     * Handle the IpdBedmove "restored" event.
     */
    public function restored(IpdBedmove $ipdBedmove): void
    {
        //
    }

    /**
     * Handle the IpdBedmove "force deleted" event.
     */
    public function forceDeleted(IpdBedmove $ipdBedmove): void
    {
        //
    }
}
