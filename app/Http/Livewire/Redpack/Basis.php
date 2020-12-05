<?php

namespace App\Http\Livewire\Redpack;

use App\Models\RedpackSetting;
use Livewire\Component;

class Basis extends Component
{
    public $amount;
    public $min_random_amount;
    public $max_random_amount;
    public $start_date;
    public $end_date;

    public $rules = [
        'amount' => 'required',
        'min_random_amount' => 'required',
        'max_random_amount' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|before:start_date'
    ];

    protected $validationAttributes = [
        'amount' => '金额',
        'min_random_amount' => '随机最小金额',
        'max_random_amount' => '随机最大金额',
        'start_date' => '随机金额开始时间',
        'end_date' => '随机金额结束时间'
    ];

    public function submit()
    {
        $this->validate();
    }

    public function mount(RedpackSetting $redpack)
    {
        $this->amount = $redpack->amount;
        $this->min_random_amount = $redpack->min_random_amount;
        $this->max_random_amount = $redpack->max_random_amount;
        $this->start_date = $redpack->start_date->toDateString();
        $this->end_date = $redpack->end_date->toDateString();


    }

    public function render()
    {
        return view('livewire.redpack.basis');
    }
}
