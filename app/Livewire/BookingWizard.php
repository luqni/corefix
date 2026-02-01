<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Str;

class BookingWizard extends Component
{
    public $step = 1;

    // Step 1: Device Info
    public $brand = '';
    public $model = '';
    public $issue = '';

    // Step 2: Service Type
    public $service_type = 'walk-in'; // walk-in or pickup

    // Step 3: Customer Info
    public $name = '';
    public $whatsapp = '';
    public $address = '';

    public $promoCode = '';
    public $promoValid = false;
    public $promoMessage = '';

    public function mount()
    {
        if (request()->has('promo')) {
            $this->promoCode = request()->query('promo');
            $this->checkPromoCode();
        }
    }

    protected $rules = [
        1 => [
            'brand' => 'required|min:2',
            'model' => 'required|min:2',
            'issue' => 'required|min:5',
        ],
        2 => [
            'service_type' => 'required|in:walk-in,pickup',
        ],
        3 => [
            'name' => 'required|min:3',
            'whatsapp' => 'required|numeric|min_digits:10',
            'address' => 'required|min:5',
            'promoCode' => 'nullable|string',
        ],
    ];

    public function checkPromoCode()
    {
        if (empty($this->promoCode)) {
            $this->promoMessage = '';
            $this->promoValid = false;
            return;
        }

        $code = strtoupper($this->promoCode);
        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if ($coupon && $coupon->isValid()) {
            $this->promoValid = true;
            $type = $coupon->type === 'fixed' ? 'Rp '.number_format($coupon->value) : $coupon->value.'%';
            $this->promoMessage = "Coupon applied! Discount: $type";
        } else {
            $this->promoValid = false;
            $this->promoMessage = 'Invalid or expired coupon code.';
        }
    }

    public function nextStep()
    {
        $this->validate($this->rules[$this->step]);
        $this->step++;
    }

    public function prevStep()
    {
        $this->step--;
    }

    public function submit()
    {
        $this->validate($this->rules[3]);

        // Re-validate promo code if entered
        $couponCodeToSave = null;
        if ($this->promoCode) {
            $this->checkPromoCode();
            if ($this->promoValid) {
                $couponCodeToSave = strtoupper($this->promoCode);
                // Increment usage
                $coupon = \App\Models\Coupon::where('code', $couponCodeToSave)->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }
        }

        $ticket = Ticket::create([
            'customer_name' => $this->name,
            'customer_wa' => $this->whatsapp,
            'customer_address' => $this->address,
            'device_model' => "$this->brand $this->model",
            'issue_description' => $this->issue,
            'status' => 'pending', 
            'payment_status' => 'unpaid',
            'coupon_code' => $couponCodeToSave,
        ]);

        $ticket->logs()->create([
            'new_status' => 'pending',
            'notes' => 'Ticket created via Booking Wizard.' . ($couponCodeToSave ? " Coupon: $couponCodeToSave" : ''),
        ]);

        return redirect()->route('tracking', ['id' => $ticket->id]);
    }

    public function render()
    {
        return view('livewire.booking-wizard');
    }
}
