<?php
    namespace App\Services;

    use App\Http\Livewire\Traits\DateTimeHelpers;

    use App\Models\IpdBedmove;

    class BedmoveService
    {
        use DateTimeHelpers;

        public function create()
        {
            $uid = auth()->user()->id;

            return
                IpdBedmove::make([
                    'bed_id' => 0,
                    'from_ref_id' => 0,
                    'to_ref_id' => 0,
                    'updated_by' => $uid,
                    'created_by' => $uid,
                    'delflag' => false,
                    'movedate' => $this->getCurrentDate(),
                    'movetime' => $this->getCurrentTime()
                ]);
        }

    }

