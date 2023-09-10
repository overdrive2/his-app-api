<?php

namespace App\Http\Livewire\OccuIpd;

use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\Traits\DateTimeHelpers;
use App\Models\DchType;
use App\Models\Ipd;
use App\Models\OccuIpd;
use App\Models\OccuIpdDetail;
use App\Models\OccuIpdSub;
use Illuminate\Validation\Validator;
use Livewire\Component;

class Detail extends Component
{
    use WithPerPagePagination, DateTimeHelpers;

    public $occu_ipd_id;
    public OccuIpdDetail $editing;
    public $occuIpd;
    public $delId;
    public $userId;
    public $pageId = 0;
    public $pageSvId = 0;

    protected $listeners = [
        'delete:occu-ipd-detail' => 'delete',
        'confirm:commit' => 'commit'
    ];

    protected $queryString = [
        'occu_ipd_id' => ['except' => '', 'as' => 'id']
    ];

    public function rules()
    {
        return [
            'editing.occu_ipd_id' => 'required',
            'editing.ipd_id' => 'required',
            'editing.occu_ipd_type_id' => 'required',
            'editing.is_getout' => '',
            'editing.ipd_bedmove_id' => '',
            'editing.updated_by' => '',
            'editing.created_by' => '',
        ];
    }

    public function makeBlank()
    {
        return OccuIpdDetail::make([
            'occu_ipd_id' => $this->occu_ipd_id,
            'created_by' => $this->userId,
            'updated_by' => $this->userId,
        ]);
    }

    public function mount()
    {
        $this->userId = auth()->user()->id;
        $this->occuIpd = OccuIpd::find($this->occu_ipd_id);
        $this->editing = $this->makeBlank();
    }

    public function edit($id)
    {
        $this->editing = OccuIpdDetail::find($id);
        //dd($this->editing);
        $this->dispatchBrowserEvent('ipddetail-modal-show');
    }

    public function new()
    {
        $this->editing = $this->makeBlank();
        //dd($this->editing);
        $this->dispatchBrowserEvent('ipddetail-modal-show');
    }

    public function save()
    {
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if ($validator->errors()->isNotEmpty()) {
                    $errorMsg =  $validator->errors()->messages();
                    $this->dispatchBrowserEvent('err-message', ['errors' => json_encode($errorMsg)]);
                }
            });
        })->validate();

        $saved = $this->editing->save();

        if (!$saved)
            return $this->dispatchBrowserEvent('swal:error', [
                'title' => 'ABC title',
                'text' => 'ABC text',
            ]);
        //$saved = false;

        $this->dispatchBrowserEvent('ipddetail-modal-close', [
            'msgstatus' => 'done',
        ]);
    }

    public function getRowsQueryProperty()
    {
        $query =  OccuIpdDetail::query()
            ->when($this->occu_ipd_id, function ($query, $sid) {
                return $query->where('occu_ipd_id', $sid);
            })
            ->when($this->pageId > 0, function ($query) {
                return $query->where('occu_ipd_type_id', $this->pageId);
            })
            ->when($this->pageSvId > 0, function ($query) {
                return $query->where('ipd_severe_id', $this->pageSvId);
            })
            ->orderBy('id', 'asc');
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

    public function deleteConfirm($id)
    {
        $this->delId = $id;
        $this->dispatchBrowserEvent('delete:confirm', [
            'action' => 'delete:occu-ipd-detail',
        ]);
    }

    public function delete()
    {
        //$this->delId
        $occu_ipd_detail = OccuIpdDetail::find($this->delId);
        $occu_ipd_detail->delete();

        $this->dispatchBrowserEvent('toastify');
    }

    public function confirmCommit()
    {
        $this->dispatchBrowserEvent('delete:confirm', [
            'title' => 'ยืนยันการส่งเวรใช่หรือไม่?',
            'text' => '',
            'confirmButtonText' => 'ยืนยัน',
            'cancelButtonText' => 'ยกเลิก',
            'action' => 'confirm:commit',
        ]);
    }

    public function commit()
    {
        $occu = OccuIpd::find($this->occu_ipd_id);
        $occu->saved = true;
        $occu->updated_by = $this->userId;
        $occu->save();
        $this->saveIpdDches();

        //add sub detail
        //getin
        $cc_1 = OccuIpdDetail::selectRaw('ipd_admit_type_id,count(*)')
            ->where('occu_ipd_id', $this->occu_ipd_id)
            ->where('occu_ipd_type_id', 1)
            ->groupBy('ipd_admit_type_id')
            ->orderBy('ipd_admit_type_id')->get();
        foreach ($cc_1 as $cc1) {
            if ($cc1->count > 0) {
                OccuIpdSub::upsert(
                    ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, 'getin' => $cc1->count],
                    ['occu_ipd_id', 'ipd_admit_type_id'],
                    ['getin'],
                );
            }
        }

        // getnew
        $cc_1 = OccuIpdDetail::selectRaw('ipd_admit_type_id,count(*)')
            ->where('occu_ipd_id', $this->occu_ipd_id)
            ->where('occu_ipd_type_id', 2)
            ->groupBy('ipd_admit_type_id')
            ->orderBy('ipd_admit_type_id')->get();
        foreach ($cc_1 as $cc1) {
            if ($cc1->count > 0) {
                OccuIpdSub::upsert(
                    ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, 'getnew' => $cc1->count],
                    ['occu_ipd_id', 'ipd_admit_type_id'],
                    ['getnew'],
                );
            }
        }

        // getmove
        $cc_1 = OccuIpdDetail::selectRaw('ipd_admit_type_id,count(*)')
            ->where('occu_ipd_id', $this->occu_ipd_id)
            ->where('occu_ipd_type_id', 3)
            ->groupBy('ipd_admit_type_id')
            ->orderBy('ipd_admit_type_id')->get();
        foreach ($cc_1 as $cc1) {
            if ($cc1->count > 0) {
                OccuIpdSub::upsert(
                    ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, 'getmove' => $cc1->count],
                    ['occu_ipd_id', 'ipd_admit_type_id'],
                    ['getmove'],
                );
            }
        }

        // moveout
        $cc_1 = OccuIpdDetail::selectRaw('ipd_admit_type_id,count(*)')
            ->where('occu_ipd_id', $this->occu_ipd_id)
            ->where('occu_ipd_type_id', 4)
            ->groupBy('ipd_admit_type_id')
            ->orderBy('ipd_admit_type_id')->get();
        foreach ($cc_1 as $cc1) {
            if ($cc1->count > 0) {
                OccuIpdSub::upsert(
                    ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, 'moveout' => $cc1->count],
                    ['occu_ipd_id', 'ipd_admit_type_id'],
                    ['moveout'],
                );
            }
        }

        // discharge
        $cc_1 = OccuIpdDetail::selectRaw('ipd_admit_type_id,count(*)')
            ->where('occu_ipd_id', $this->occu_ipd_id)
            ->where('occu_ipd_type_id', 5)
            ->groupBy('ipd_admit_type_id')
            ->orderBy('ipd_admit_type_id')->get();
        foreach ($cc_1 as $cc1) {
            if ($cc1->count > 0) {
                OccuIpdSub::upsert(
                    ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, 'discharge' => $cc1->count],
                    ['occu_ipd_id', 'ipd_admit_type_id'],
                    ['discharge'],
                );
            }
        }

        // getout
        $cc_1 = OccuIpdDetail::selectRaw('ipd_admit_type_id,count(*)')
            ->where('occu_ipd_id', $this->occu_ipd_id)
            ->where('is_getout', true)
            ->groupBy('ipd_admit_type_id')
            ->orderBy('ipd_admit_type_id')->get();
        foreach ($cc_1 as $cc1) {
            if ($cc1->count > 0) {
                OccuIpdSub::upsert(
                    ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, 'getout' => $cc1->count],
                    ['occu_ipd_id', 'ipd_admit_type_id'],
                    ['getout'],
                );
            }
        }

        for ($i = 1; $i < 6; $i++) {
            // severe_1
            $cc_1 = OccuIpdDetail::selectRaw('ipd_admit_type_id,count(*)')
                ->where('occu_ipd_id', $this->occu_ipd_id)
                ->where('ipd_severe_id', $i)
                ->groupBy('ipd_admit_type_id')
                ->orderBy('ipd_admit_type_id')->get();

            foreach ($cc_1 as $cc1) {
                if ($cc1->count > 0) {
                    OccuIpdSub::upsert(
                        ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, 'severe_' . $i => $cc1->count],
                        ['occu_ipd_id', 'ipd_admit_type_id'],
                        ['severe_' . $i],
                    );
                }
            }
        }

        $this->redirect(route('occu.ipd'));
    }

    public function saveIpdDches()
    {
        $cc_1 = Ipd::selectRaw('ipd_admit_type_id,dch_type_id,count(*)')
            ->whereIn('id', OccuIpdDetail::where('occu_ipd_id', $this->occu_ipd_id)
                ->where('occu_ipd_type_id', 5)->pluck('ipd_id'))
            ->groupBy('ipd_admit_type_id')
            ->groupBy('dch_type_id')
            ->orderBy('ipd_admit_type_id')
            ->orderBy('dch_type_id')->get();

        foreach ($cc_1 as $cc1) {
            if ($cc1->count > 0) {
                $field = DchType::find($cc1->dch_type_id);

                OccuIpdSub::upsert(
                    ['occu_ipd_id' => $this->occu_ipd_id, 'ipd_admit_type_id' => $cc1->ipd_admit_type_id, $field->occu_field_name => $cc1->count],
                    ['occu_ipd_id', 'ipd_admit_type_id'],
                    [$field->occu_field_name],
                );
            }
        }

        $cc_1 = OccuIpdSub::selectRaw('occu_ipd_id,sum(dc_appr) dc_appr,sum(dc_refer) dc_refer,sum(dc_agnt) dc_agnt,sum(dc_esc) dc_esc,sum(dc_dead) dc_dead')
            ->where('occu_ipd_id', $this->occu_ipd_id)
            ->groupBy('occu_ipd_id')
            ->get();
        foreach ($cc_1 as $cc1) {
            OccuIpd::where('id', $this->occu_ipd_id)
                ->update([
                    'dc_appr' => $cc1->dc_appr,
                    'dc_refer' => $cc1->dc_refer,
                    'dc_agnt' => $cc1->dc_agnt,
                    'dc_esc' => $cc1->dc_esc,
                    'dc_dead' => $cc1->dc_dead,
                ]);
        }
    }

    public function render()
    {
        return view(
            'livewire.occu-ipd.detail',
            [
                'rows' => $this->rows,
            ]
        );
    }
}
