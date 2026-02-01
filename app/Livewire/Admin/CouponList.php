<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Manage Coupons'])]
class CouponList extends Component
{
    use WithPagination;

    public $code, $type = 'fixed', $value, $max_uses, $start_date, $end_date, $is_active = true;
    public $couponId;
    public $isModalOpen = false;

    protected $rules = [
        'code' => 'required|unique:coupons,code',
        'type' => 'required|in:fixed,percentage',
        'value' => 'required|numeric|min:0',
        'max_uses' => 'nullable|integer|min:1',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    public function render()
    {
        return view('livewire.admin.coupon-list', [
            'coupons' => Coupon::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->code = '';
        $this->type = 'fixed';
        $this->value = '';
        $this->max_uses = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->is_active = true;
        $this->couponId = null;
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->couponId) {
            $rules['code'] = 'required|unique:coupons,code,' . $this->couponId;
        }

        $this->validate($rules);

        Coupon::updateOrCreate(['id' => $this->couponId], [
            'code' => strtoupper($this->code),
            'type' => $this->type,
            'value' => $this->value,
            'max_uses' => $this->max_uses ?: null,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', $this->couponId ? 'Coupon updated.' : 'Coupon created.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        $this->couponId = $id;
        $this->code = $coupon->code;
        $this->type = $coupon->type;
        $this->value = $coupon->value;
        $this->max_uses = $coupon->max_uses;
        $this->start_date = $coupon->start_date?->format('Y-m-d\TH:i');
        $this->end_date = $coupon->end_date?->format('Y-m-d\TH:i');
        $this->is_active = $coupon->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        Coupon::find($id)->delete();
        session()->flash('message', 'Coupon deleted.');
    }
}
