<?php

namespace App\Http\Livewire\OccuIpd;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\Bed;
use App\Models\Ipd;
use App\Models\IpdBedmove;
use App\Models\IpdNurseShift;
use App\Models\IpdRecord;
use App\Models\IpdRecordList;
use App\Models\OccuIpd;
use App\Models\OccuIpdDetail;
use App\Models\OccuIpdRecord;
use App\Models\OccuIpdStaff;
use App\Models\OccuIpdStaffList;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Home extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public OccuIpd $editing;
    public $filters = [
        'sdate' => '',
        'edate' => '',
        'shiftId' => 0,
    ];
    public $nurseshifts = [];
    public $wards = [];
    public $userId;
    public $from_ref_id;
    public $delId;
    public $occu_stime;
    public $occu_etime;

    protected $listeners = [
        'delete:occu-ipd' => 'delete'
    ];

    public function rules()
    {
        return [
            'editing.nurse_shift_date' => 'required',
            'editing.nurse_shift_time' => 'required',
            'editing.ward_id' => 'required|exists:wards,id',
            'editing.ipd_nurse_shift_id' => 'required|exists:ipd_nurse_shifts,id',
            'editing.occu_status_id' => '',
            'editing.note' => '',
            'editing.getin' => '',
            'editing.getnew' => '',
            'editing.getmove' => '',
            'editing.moveout' => '',
            'editing.discharge' => '',
            'editing.getout' => '',
            'editing.severe_1' => '',
            'editing.severe_2' => '',
            'editing.severe_3' => '',
            'editing.severe_4' => '',
            'editing.severe_5' => '',
            'editing.severe_6' => '',
            'editing.created_by' => '',
            'editing.updated_by' => '',
            'editing.delflag' => '',
            'editing.saved' => '',
            'editing.time_for_editing' => '',
            'editing.date_for_editing' => '',
        ];
    }

    public function makeBlank()
    {
        return OccuIpd::make([
            'nurse_shift_date' => $this->getCurrentDate(),
            'nurse_shift_time' => $this->getCurrentTime(),
            'getin' => 0,
            'getnew' => 0,
            'getmove' => 0,
            'moveout' => 0,
            'discharge' => 0,
            'getout' => 0,
            'occu_status_id' => 1,
            'severe_1' => 0,
            'severe_2' => 0,
            'severe_3' => 0,
            'severe_4' => 0,
            'severe_5' => 0,
            'severe_6' => 0,
            'created_by' => $this->userId,
            'updated_by' => $this->userId,
            'delflag' => false,
            'saved' => false,
            'note' => '',
        ]);
    }

    public function mount()
    {
        // $this->perPage = 3;
        $this->editing = $this->makeBlank();
        $this->nurseshifts = IpdNurseShift::orderBy('display_order', 'asc')->get();
        $this->wards = auth()->user()->wards();
        $this->filters['edate'] = Carbon::parse($this->getCurrentDate())->format('d/m/Y');
        $this->filters['sdate'] = Carbon::parse($this->getCurrentDate())->format('d/m/Y');
        $this->userId = auth()->user()->id;
    }

    public function edit($id)
    {
        $this->editing = OccuIpd::find($id);
        $this->dispatchBrowserEvent('ipdmain-modal-show');
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        //dd($this->editing);
        $this->dispatchBrowserEvent('ipdmain-modal-show');
    }

    public function saveDraft()
    {
        //get start & end time to make shift
        $etnf = IpdNurseShift::where('id', $this->editing->ipd_nurse_shift_id)->value('etime');
        $this->occu_etime = Carbon::parse($this->editing->nurse_shift_date . ' ' . $etnf);
        $this->occu_stime = clone $this->occu_etime;
        $this->occu_stime->addSecond(-28801);
        //dd($stime,$etime);

        $this->saveOccuDetail();
        $this->saveSevere();
        $this->saveStaff();
        $this->saveIpdRecord();
    }

    public function saveStaff()
    {
        $occustaff = OccuIpdStaff::orderBy('display_order', 'asc')->get();
        foreach ($occustaff as $os) {
            OccuIpdStaffList::create([
                'occu_ipd_id' => $this->editing->id,
                'staff_id' => $os->id,
                'value' => 0,
                'updated_by' => $this->userId,
                'created_by' => $this->userId,
            ]);
        }
    }

    public function saveIpdRecord()
    {
        $cc_record = IpdRecordList::selectRaw('ipd_record_id,count(*)')
        ->whereIn('ipd_id', OccuIpdDetail::where('occu_ipd_id', $this->editing->id)
            ->where('is_getout', true)->pluck('ipd_id'))
        ->whereIn('ipd_bedmove_id', OccuIpdDetail::where('occu_ipd_id', $this->editing->id)
            ->where('is_getout', true)->pluck('ipd_bedmove_id'))
        ->groupBy('ipd_record_id')
        ->orderBy('ipd_record_id')->get();
        foreach ($cc_record as $cc_rc) {
            OccuIpdRecord::create([
                'occu_ipd_id' => $this->editing->id,
                'ipd_record_id' => $cc_rc->ipd_record_id,
                'qty' => $cc_rc->count,
            ]);
        }
    }

    public function saveOccuDetail()
    {
        //update to_ref_id to last shift
        $occuipd = OccuIpd::where('ward_id', $this->editing->ward_id)
            ->whereNull('to_ref_id')
            ->where('id', '<>', $this->editing->id)
            ->orderBy('nurse_shift_date', 'desc')
            ->orderBy('nurse_shift_time', 'desc')->first();

        //occu_ipd_type_id = 1	ยกมา
        $i_getin = 0;
        if ($occuipd != null) {

            OccuIpd::where('id', $occuipd->id)->update(['to_ref_id' => $this->editing->id]);
            $i_getin = $occuipd->getout;
            OccuIpd::where('id', $this->editing->id)->update(['getin' => $i_getin]);

            $bedmoves_t1 = OccuIpdDetail::where('occu_ipd_id', $occuipd->id)
                ->where('is_getout', true)
                ->orderBy('id', 'asc')->get();
            foreach ($bedmoves_t1 as $bm1) {

                OccuIpdDetail::create([
                    'occu_ipd_id' => $this->editing->id,
                    'ipd_id' => $bm1->ipd_id,
                    'occu_ipd_type_id' => 1,
                    'is_getout' => true,
                    'ipd_bedmove_id' => $bm1->ipd_bedmove_id,
                    'updated_by' => $this->userId,
                    'created_by' => $this->userId,
                    'saved' => false,
                ]);
            }
        }

        //occu_ipd_type_id = 2	รับใหม่
        $bedmoves_t2 = IpdBedmove::wherebetween('moved_at', [$this->occu_stime, $this->occu_etime])
            ->where('bedmove_type_id', '1')
            ->where('ward_id', $this->editing->ward_id)
            ->where('delflag', false)
            ->orderBy('moved_at', 'asc')->get();
        $i_getnew = 0;
        foreach ($bedmoves_t2 as $bm2) {

            OccuIpdDetail::create([
                'occu_ipd_id' => $this->editing->id,
                'ipd_id' => $bm2->ipd_id,
                'occu_ipd_type_id' => 2,
                'is_getout' => 'Y',
                'ipd_bedmove_id' => $bm2->id,
                'updated_by' => $this->userId,
                'created_by' => $this->userId,
                'saved' => false,
            ]);
            $i_getnew++;
        }
        OccuIpd::where('id', $this->editing->id)->update(['getnew' => $i_getnew]);

        //occu_ipd_type_id = 3	รับย้าย
        $bedmoves_t3 = IpdBedmove::wherebetween('moved_at', [$this->occu_stime, $this->occu_etime])
            ->where('bedmove_type_id', '2')
            ->where('delflag', false)
            ->where('ward_id', $this->editing->ward_id)
            ->orderBy('moved_at', 'asc')->get();
        $i_getmove = 0;
        foreach ($bedmoves_t3 as $bm3) {

            OccuIpdDetail::where('occu_ipd_id', $this->editing->id)
                ->where('ipd_id', $bm3->ipd_id)->update(['is_getout' => false]);
            OccuIpdDetail::create([
                'occu_ipd_id' => $this->editing->id,
                'ipd_id' => $bm3->ipd_id,
                'occu_ipd_type_id' => 3,
                'is_getout' => 'Y',
                'ipd_bedmove_id' => $bm3->id,
                'updated_by' => $this->userId,
                'created_by' => $this->userId,
                'saved' => false,
            ]);
            $i_getmove++;
        }
        OccuIpd::where('id', $this->editing->id)->update(['getmove' => $i_getmove]);

        //occu_ipd_type_id = 4	ย้าย Ward
        $bedmoves_t4 = IpdBedmove::wherebetween('moved_at', [$this->occu_stime, $this->occu_etime])
            ->where('bedmove_type_id', '3')
            ->where('delflag', false)
            ->where('ward_id', $this->editing->ward_id)
            ->orderBy('moved_at', 'asc')->get();
        $i_moveout = 0;
        foreach ($bedmoves_t4 as $bm4) {

            OccuIpdDetail::where('occu_ipd_id', $this->editing->id)
                ->where('ipd_id', $bm4->ipd_id)->update(['is_getout' => false]);
            OccuIpdDetail::create([
                'occu_ipd_id' => $this->editing->id,
                'ipd_id' => $bm4->ipd_id,
                'occu_ipd_type_id' => 4,
                'is_getout' => false,
                'ipd_bedmove_id' => $bm4->id,
                'updated_by' => $this->userId,
                'created_by' => $this->userId,
                'saved' => false,
            ]);
            $i_moveout++;
        }
        OccuIpd::where('id', $this->editing->id)->update(['moveout' => $i_moveout]);

        //occu_ipd_type_id = 5	Discharge
        $bedmoves_t5 = IpdBedmove::wherebetween('moved_at', [$this->occu_stime, $this->occu_etime])
            ->where('bedmove_type_id', '5')
            ->where('delflag', false)
            ->where('ward_id', $this->editing->ward_id)
            ->orderBy('moved_at', 'asc')->get();
        $i_dc = 0;
        foreach ($bedmoves_t5 as $bm5) {

            OccuIpdDetail::where('occu_ipd_id', $this->editing->id)
                ->where('ipd_id', $bm5->ipd_id)->update(['is_getout' => false]);
            OccuIpdDetail::create([
                'occu_ipd_id' => $this->editing->id,
                'ipd_id' => $bm5->ipd_id,
                'occu_ipd_type_id' => 5,
                'is_getout' => false,
                'ipd_bedmove_id' => $bm5->id,
                'updated_by' => $this->userId,
                'created_by' => $this->userId,
                'saved' => false,
            ]);
            $i_dc++;
        }
        OccuIpd::where('id', $this->editing->id)->update(['discharge' => $i_dc]);

        $i_getout = ($i_getin + $i_getnew + $i_getmove) - ($i_moveout - $i_dc);
        OccuIpd::where('id', $this->editing->id)->update(['getout' => $i_getout]);
    }

    public function saveSevere()
    {
        //update severe
        $cc_severe = Ipd::selectRaw('severe_type_id,count(*)')
            ->whereIn('id', OccuIpdDetail::where('occu_ipd_id', $this->editing->id)
                ->where('is_getout', true)->pluck('ipd_id'))
            ->groupBy('severe_type_id')->get();
        foreach ($cc_severe as $cc_sv) {
            OccuIpd::where('id', $this->editing->id)
                ->update(['severe_' . $cc_sv->severe_type_id => $cc_sv->count]);
        }
    }
    
    public function save()
    {
        //dd($this->editing);
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message', ['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $editmode = $this->editing->id ? true : false;
        $saved = $this->editing->save();

        if (!$saved)
            return $this->dispatchBrowserEvent('swal:error', [
                'title' => 'ABC title',
                'text' => 'ABC text',
            ]);

        if (!$editmode) {
            $this->saveDraft();
        }

        $this->dispatchBrowserEvent('ipdmain-modal-close', [
            'msgstatus' => 'done',
        ]);
    }

    public function deleteConfirm($id)
    {
        $this->delId = $id;
        $this->dispatchBrowserEvent('delete:confirm', [
            'action' => 'delete:occu-ipd',
        ]);
    }

    public function delete()
    {
        OccuIpd::where('id', $this->delId)->update(['delflag' => true]);
        OccuIpd::where('to_ref_id', $this->delId)->update(['to_ref_id' => null]);

        $this->dispatchBrowserEvent('toastify');
    }

    public function setDate($date)
    {
        $date = Carbon::createFromFormat('d/m/Y',  $date);
        return $date->format('Y-m-d');
    }

    public function getRowsQueryProperty()
    {
        $query =  OccuIpd::query()
            ->when($this->filters['shiftId'], function ($query, $sid) {
                return $query->where('ipd_nurse_shift_id', $sid);
            })
            ->when($this->filters['sdate'] && $this->filters['edate'], function ($query) {
                $sdate = $this->setDate($this->filters['sdate']);
                $edate = $this->setDate($this->filters['edate']);

                return $query->whereBetween('nurse_shift_date', [$sdate, $edate]);
            })
            ->where('delflag', false)
            ->orderBy('nurse_shift_date', 'asc')
            ->orderBy('nurse_shift_time', 'asc');
        return $query;
    }

    public function getRowCountProperty()
    {
        return $this->rowsQuery->count();
    }

    public function getRowsProperty()
    {
        return $this->applyPagination($this->rowsQuery);
    }

    public function render()
    {
        return view(
            'livewire.occu-ipd.home',
            [
                'rows' => $this->rows,
            ]
        );
    }
}
