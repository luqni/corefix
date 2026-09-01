<?php

namespace App\Livewire\Admin;

use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Pemasukan & Pengeluaran (Non-Order)'])]
class FinancialTransactionList extends Component
{
    use WithPagination, WithFileUploads;

    // Filter & Search
    public $search = '';
    public $typeFilter = 'all';
    public $categoryFilter = 'all';
    public $dateFilter = 'all';
    public $startDate = '';
    public $endDate = '';
    public $sortField = 'transaction_date';
    public $sortDirection = 'desc';

    // Modal State & Form Fields
    public $isModalOpen = false;
    public $isAttachmentModalOpen = false;
    public $viewingAttachmentUrl = null;
    public $viewingAttachmentName = '';

    public $transactionId = null;
    public $type = 'expense';
    public $category = '';
    public $customCategory = '';
    public $title = '';
    public $amount = '';
    public $transaction_date = '';
    public $payment_method = 'cash';
    public $description = '';
    public $attachment = null;
    public $existingAttachment = null;

    public $defaultIncomeCategories = [
        'Penjualan Aksesoris & Merchandise',
        'Penjualan Perangkat / Gadget Bekas',
        'Jasa Konsultasi / Setting Software',
        'Sewa Alat / Fasilitas',
        'Cashback / Komisi Vendor',
        'Suntikan Modal / Investasi',
        'Pemasukan Lain-lain',
    ];

    public $defaultExpenseCategories = [
        'Sewa Tempat & Bangunan',
        'Listrik, Air & Kebersihan',
        'Internet, Wi-Fi & Pulsa',
        'Gaji & Uang Makan Karyawan',
        'Pembelian Alat & Tools Servis',
        'Perlengkapan Operasional & ATK',
        'Konsumsi / Snack / Kopi Toko',
        'Transportasi & Ongkos Kirim',
        'Iklan, Promosi & Pemasaran',
        'Maintenance & Perbaikan Toko',
        'Pengeluaran Lain-lain',
    ];

    protected function rules()
    {
        return [
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'title' => 'required|string|min:3|max:255',
            'amount' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'payment_method' => 'required|string|in:cash,transfer,qris,other',
            'description' => 'nullable|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5120', // 5MB max
        ];
    }

    public function mount()
    {
        $this->transaction_date = now()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function applyDateFilter($query)
    {
        return match ($this->dateFilter) {
            'today' => $query->whereDate('transaction_date', today()),
            'week' => $query->whereBetween('transaction_date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()]),
            'month' => $query->whereMonth('transaction_date', now()->month)->whereYear('transaction_date', now()->year),
            'last_month' => $query->whereBetween('transaction_date', [
                now()->subMonth()->startOfMonth()->toDateString(),
                now()->subMonth()->endOfMonth()->toDateString()
            ]),
            'year' => $query->whereYear('transaction_date', now()->year),
            'custom' => $query->when($this->startDate, fn($q) => $q->whereDate('transaction_date', '>=', $this->startDate))
                              ->when($this->endDate, fn($q) => $q->whereDate('transaction_date', '<=', $this->endDate)),
            default => $query,
        };
    }

    public function create()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) {
            abort(403);
        }

        $this->resetInputFields();
        $this->transaction_date = now()->format('Y-m-d');
        $this->type = 'expense';
        $this->category = $this->defaultExpenseCategories[0];
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) {
            abort(403);
        }

        $transaction = FinancialTransaction::findOrFail($id);
        $this->transactionId = $transaction->id;
        $this->type = $transaction->type;
        $this->title = $transaction->title;
        $this->amount = $transaction->amount;
        $this->transaction_date = $transaction->transaction_date->format('Y-m-d');
        $this->payment_method = $transaction->payment_method;
        $this->description = $transaction->description;
        $this->existingAttachment = $transaction->attachment;
        $this->attachment = null;

        $categories = $this->type === 'income' ? $this->defaultIncomeCategories : $this->defaultExpenseCategories;
        if (in_array($transaction->category, $categories)) {
            $this->category = $transaction->category;
            $this->customCategory = '';
        } else {
            $this->category = 'custom';
            $this->customCategory = $transaction->category;
        }

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function updatedType($value)
    {
        if ($this->category !== 'custom') {
            $this->category = $value === 'income'
                ? $this->defaultIncomeCategories[0]
                : $this->defaultExpenseCategories[0];
        }
    }

    public function resetInputFields()
    {
        $this->transactionId = null;
        $this->type = 'expense';
        $this->category = '';
        $this->customCategory = '';
        $this->title = '';
        $this->amount = '';
        $this->transaction_date = now()->format('Y-m-d');
        $this->payment_method = 'cash';
        $this->description = '';
        $this->attachment = null;
        $this->existingAttachment = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) {
            abort(403);
        }

        $finalCategory = $this->category === 'custom' ? trim($this->customCategory) : $this->category;
        
        // Manually replace category value for validation if custom
        if ($this->category === 'custom') {
            $this->category = $finalCategory;
        }

        $this->validate();

        $attachmentPath = $this->existingAttachment;
        if ($this->attachment) {
            // Delete old attachment if exists
            if ($this->existingAttachment && Storage::disk('public')->exists($this->existingAttachment)) {
                Storage::disk('public')->delete($this->existingAttachment);
            }
            $attachmentPath = $this->attachment->store('financial_attachments', 'public');
        }

        FinancialTransaction::updateOrCreate(
            ['id' => $this->transactionId],
            [
                'user_id' => auth()->id(),
                'type' => $this->type,
                'category' => $finalCategory,
                'title' => $this->title,
                'amount' => $this->amount,
                'transaction_date' => $this->transaction_date,
                'payment_method' => $this->payment_method,
                'description' => $this->description,
                'attachment' => $attachmentPath,
            ]
        );

        session()->flash('message', $this->transactionId ? 'Transaksi berhasil diperbarui.' : 'Transaksi berhasil ditambahkan.');
        $this->closeModal();
    }

    public function delete($id)
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) {
            abort(403);
        }

        $transaction = FinancialTransaction::findOrFail($id);

        if ($transaction->attachment && Storage::disk('public')->exists($transaction->attachment)) {
            Storage::disk('public')->delete($transaction->attachment);
        }

        $transaction->delete();
        session()->flash('message', 'Transaksi berhasil dihapus.');
    }

    public function viewAttachment($id)
    {
        $transaction = FinancialTransaction::findOrFail($id);
        if ($transaction->attachment) {
            $this->viewingAttachmentUrl = Storage::disk('public')->url($transaction->attachment);
            $this->viewingAttachmentName = $transaction->title;
            $this->isAttachmentModalOpen = true;
        }
    }

    public function closeAttachmentModal()
    {
        $this->isAttachmentModalOpen = false;
        $this->viewingAttachmentUrl = null;
        $this->viewingAttachmentName = '';
    }

    public function render()
    {
        // Query for transaction list
        $query = FinancialTransaction::with('user');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'ilike', '%' . $this->search . '%')
                  ->orWhere('category', 'ilike', '%' . $this->search . '%')
                  ->orWhere('description', 'ilike', '%' . $this->search . '%');
            });
        }

        if ($this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category', $this->categoryFilter);
        }

        $this->applyDateFilter($query);

        $query->orderBy($this->sortField, $this->sortDirection);

        // Calculate summary metrics with the same active date filter
        $metricQuery = FinancialTransaction::query();
        $this->applyDateFilter($metricQuery);

        $totalIncome = (clone $metricQuery)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $metricQuery)->where('type', 'expense')->sum('amount');
        $netCashFlow = $totalIncome - $totalExpense;

        // Distinct categories for filter dropdown
        $allCategories = FinancialTransaction::select('category')->distinct()->pluck('category')->toArray();

        return view('livewire.admin.financial-transaction-list', [
            'transactions' => $query->paginate(15),
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netCashFlow' => $netCashFlow,
            'availableCategories' => $allCategories,
        ]);
    }
}
