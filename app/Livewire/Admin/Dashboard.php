<?php

namespace App\Livewire\Admin;

use App\Models\FinancialTransaction;
use App\Models\SparePart;
use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Dashboard Ringkasan'])]
class Dashboard extends Component
{
    public $dateFilter = 'all';

    public function applyDateFilter($query, $column = 'created_at')
    {
        return match ($this->dateFilter) {
            'today' => $query->whereDate($column, today()),
            'week' => $query->whereBetween($column, [
                now()->startOfWeek()->toDateTimeString(),
                now()->endOfWeek()->toDateTimeString()
            ]),
            'month' => $query->whereMonth($column, now()->month)->whereYear($column, now()->year),
            'last_month' => $query->whereBetween($column, [
                now()->subMonth()->startOfMonth()->toDateTimeString(),
                now()->subMonth()->endOfMonth()->toDateTimeString()
            ]),
            'year' => $query->whereYear($column, now()->year),
            default => $query,
        };
    }

    public function updatedDateFilter()
    {
        $this->dispatch('update-chart', chartData: $this->getChartData());
    }

    public function getChartData()
    {
        $tickets = $this->applyDateFilter(Ticket::query())->where('payment_status', 'paid')->get();
        $labels = [];
        $data = [];

        if ($this->dateFilter === 'today') {
            $grouped = $tickets->groupBy(fn($t) => $t->created_at->format('H:00'));
            for ($i = 0; $i < 24; $i++) {
                $hour = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                $labels[] = $hour;
                $data[] = isset($grouped[$hour]) ? $grouped[$hour]->sum('total_cost') : 0;
            }
        } elseif ($this->dateFilter === 'week') {
            $grouped = $tickets->groupBy(fn($t) => $t->created_at->format('D'));
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            foreach ($days as $day) {
                $labels[] = $day;
                $data[] = isset($grouped[$day]) ? $grouped[$day]->sum('total_cost') : 0;
            }
        } elseif ($this->dateFilter === 'month') {
            $grouped = $tickets->groupBy(fn($t) => $t->created_at->format('d'));
            $daysInMonth = now()->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $day = str_pad($i, 2, '0', STR_PAD_LEFT);
                $labels[] = $day;
                $data[] = isset($grouped[$day]) ? $grouped[$day]->sum('total_cost') : 0;
            }
        } elseif ($this->dateFilter === 'last_month') {
            $lastMonth = now()->subMonth();
            $grouped = $tickets->groupBy(fn($t) => $t->created_at->format('d'));
            $daysInMonth = $lastMonth->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $day = str_pad($i, 2, '0', STR_PAD_LEFT);
                $labels[] = $day . ' ' . $lastMonth->format('M');
                $data[] = isset($grouped[$day]) ? $grouped[$day]->sum('total_cost') : 0;
            }
        } elseif ($this->dateFilter === 'year') {
            $grouped = $tickets->groupBy(fn($t) => $t->created_at->format('M'));
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            foreach ($months as $month) {
                $labels[] = $month;
                $data[] = isset($grouped[$month]) ? $grouped[$month]->sum('total_cost') : 0;
            }
        } else {
            $grouped = $tickets->groupBy(fn($t) => $t->created_at->format('M Y'));
            $keys = $grouped->keys()->toArray();
            usort($keys, fn($a, $b) => strtotime($a) - strtotime($b));
            foreach ($keys as $key) {
                $labels[] = $key;
                $data[] = $grouped[$key]->sum('total_cost');
            }
            if (empty($labels)) {
                $labels = [now()->format('M Y')];
                $data = [0];
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function exportExcel()
    {
        if (!auth()->user()->hasRole(['super_admin', 'admin'])) {
            abort(403);
        }

        $filterLabel = match ($this->dateFilter) {
            'today' => 'Hari Ini (' . now()->format('d M Y') . ')',
            'week' => 'Minggu Ini (' . now()->startOfWeek()->format('d M') . ' - ' . now()->endOfWeek()->format('d M Y') . ')',
            'month' => 'Bulan Ini (' . now()->format('M Y') . ')',
            'last_month' => 'Bulan Lalu (' . now()->subMonth()->format('M Y') . ')',
            'year' => 'Tahun Ini (' . now()->year . ')',
            default => 'Semua Waktu',
        };

        $filename = 'Laporan_Keuangan_CoreFix_' . str_replace(' ', '_', $this->dateFilter) . '_' . date('Ymd_His') . '.csv';

        // Retrieve relevant data
        $relevantTickets = $this->applyDateFilter(Ticket::query())->with(['items', 'logs'])->where(function ($q) {
            $q->where('payment_status', 'paid')
              ->orWhereIn('status', ['cancelled', 'refunded'])
              ->orWhere('payment_status', 'refunded');
        })->get();

        $allTickets = $this->applyDateFilter(Ticket::query())->with('items')->latest()->get();
        $financialTransactions = $this->applyDateFilter(FinancialTransaction::query(), 'transaction_date')->with('user')->orderBy('transaction_date', 'desc')->get();

        $sparepartProfit = 0;
        $serviceProfit = 0;
        $sparepartRevenue = 0;
        $sparepartCapital = 0;
        $serviceRevenue = 0;
        $serviceCapital = 0;
        $orderTotalDiscount = 0;
        $cancelledLoss = 0;

        foreach ($relevantTickets as $ticket) {
            $tSparepartRev = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->price * $i->quantity);
            $tSparepartCap = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->capital_price * $i->quantity);
            
            $tServiceRev = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->price * $i->quantity);
            $tServiceCap = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->capital_price * $i->quantity);

            $isCancelledOrRefunded = in_array($ticket->status, ['cancelled', 'refunded']) || $ticket->payment_status === 'refunded';

            if ($isCancelledOrRefunded) {
                if ($ticket->payment_status === 'paid') {
                    $subtotal = $tSparepartRev + $tServiceRev;
                    $discount = $ticket->discount_amount ?? 0;
                    $orderTotalDiscount += $discount;
                    $sparepartRevenue += $tSparepartRev;
                    $serviceRevenue += $tServiceRev;

                    if ($subtotal > 0 && $discount > 0) {
                        $serviceDiscount = $discount * ($tServiceRev / $subtotal);
                        $sparepartDiscount = $discount * ($tSparepartRev / $subtotal);
                        $serviceProfit += ($tServiceRev - $serviceDiscount) - $tServiceCap;
                        $sparepartProfit += ($tSparepartRev - $sparepartDiscount) - $tSparepartCap;
                    } else {
                        $serviceProfit += $tServiceRev - $tServiceCap;
                        $sparepartProfit += $tSparepartRev - $tSparepartCap;
                    }
                } else {
                    $sparepartProfit -= $tSparepartCap;
                    $serviceProfit -= $tServiceCap;
                    $cancelledLoss += ($tSparepartCap + $tServiceCap);
                }

                $sparepartCapital += $tSparepartCap;
                $serviceCapital += $tServiceCap;
            } else {
                $sparepartRevenue += $tSparepartRev;
                $sparepartCapital += $tSparepartCap;
                $serviceRevenue += $tServiceRev;
                $serviceCapital += $tServiceCap;

                $subtotal = $tSparepartRev + $tServiceRev;
                $discount = $ticket->discount_amount ?? 0;
                $orderTotalDiscount += $discount;

                if ($subtotal > 0 && $discount > 0) {
                    $serviceDiscount = $discount * ($tServiceRev / $subtotal);
                    $sparepartDiscount = $discount * ($tSparepartRev / $subtotal);
                    $serviceProfit += ($tServiceRev - $serviceDiscount) - $tServiceCap;
                    $sparepartProfit += ($tSparepartRev - $sparepartDiscount) - $tSparepartCap;
                } else {
                    $serviceProfit += $tServiceRev - $tServiceCap;
                    $sparepartProfit += $tSparepartRev - $tSparepartCap;
                }
            }
        }

        $otherIncome = (float) $this->applyDateFilter(FinancialTransaction::query(), 'transaction_date')->where('type', 'income')->sum('amount');
        $otherExpense = (float) $this->applyDateFilter(FinancialTransaction::query(), 'transaction_date')->where('type', 'expense')->sum('amount');
        $orderGrossProfit = $sparepartProfit + $serviceProfit;
        $netBusinessProfit = ($orderGrossProfit + $otherIncome) - $otherExpense;

        $pendingCount = $this->applyDateFilter(Ticket::query())->where('status', 'pending')->count();
        $processCount = $this->applyDateFilter(Ticket::query())->whereIn('status', ['diagnosing', 'repairing', 'waiting_approval', 'received', 'payment_verification'])->count();
        $completedCount = $this->applyDateFilter(Ticket::query())->where('status', 'done')->count();
        $cancelledCount = $this->applyDateFilter(Ticket::query())->where('status', 'cancelled')->count();
        $refundedCount = $this->applyDateFilter(Ticket::query())->where('status', 'refunded')->count();

        return response()->streamDownload(function () use (
            $filterLabel,
            $sparepartRevenue,
            $sparepartCapital,
            $sparepartProfit,
            $serviceRevenue,
            $serviceCapital,
            $serviceProfit,
            $orderTotalDiscount,
            $cancelledLoss,
            $orderGrossProfit,
            $otherIncome,
            $otherExpense,
            $netBusinessProfit,
            $pendingCount,
            $processCount,
            $completedCount,
            $cancelledCount,
            $refundedCount,
            $allTickets,
            $financialTransactions
        ) {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Section 1: Header Meta
            fputcsv($handle, ['LAPORAN KEUANGAN & PERFORMA OPERASIONAL COREFIX']);
            fputcsv($handle, ['Periode Laporan:', $filterLabel]);
            fputcsv($handle, ['Tanggal Unduh:', date('d/m/Y H:i:s')]);
            fputcsv($handle, ['Diekspor Oleh:', auth()->user()->name . ' (' . auth()->user()->email . ')']);
            fputcsv($handle, []);

            // Section 2: Ringkasan Laba Rugi Eksekutif
            fputcsv($handle, ['=== 1. RINGKASAN LABA RUGI & ARUS KAS USAHA ===']);
            fputcsv($handle, ['Komponen Keuangan', 'Nilai / Nominal (IDR)', 'Keterangan']);
            fputcsv($handle, ['Pendapatan Suku Cadang (Sparepart)', $sparepartRevenue, 'Total penjualan sparepart pada order']);
            fputcsv($handle, ['Modal / HPP Suku Cadang', $sparepartCapital, 'HPP sparepart terpasang']);
            fputcsv($handle, ['Margin Laba Suku Cadang', $sparepartProfit, 'Pendapatan sparepart - HPP sparepart']);
            fputcsv($handle, ['Pendapatan Jasa Servis', $serviceRevenue, 'Total biaya jasa perbaikan']);
            fputcsv($handle, ['Modal / Beban Jasa Teknisi', $serviceCapital, 'Biaya langsung pengerjaan']);
            fputcsv($handle, ['Margin Laba Jasa Servis', $serviceProfit, 'Pendapatan jasa - Modal jasa']);
            fputcsv($handle, ['Total Potongan Diskon Kupon', $orderTotalDiscount, 'Potongan harga dari kupon promo']);
            fputcsv($handle, ['Laba Kotor Servis & Part (Gross Profit)', $orderGrossProfit, 'Total margin laba order servis']);
            fputcsv($handle, ['Beban Kerugian Part Hangus (Batal/Refund)', -$cancelledLoss, 'Modal part/jasa terpakai saat order dibatalkan/refund']);
            fputcsv($handle, ['Pemasukan Kas Toko Lainnya (Non-Order)', $otherIncome, 'Penjualan aksesoris, sewa, modal, dll']);
            fputcsv($handle, ['Pengeluaran Operasional Kas Toko', -$otherExpense, 'Sewa tempat, listrik, gaji, perlengkapan, dll']);
            fputcsv($handle, ['TOTAL LABA BERSIH AKHIR (NET PROFIT)', $netBusinessProfit, 'Laba Bersih Toko']);
            fputcsv($handle, []);

            // Section 3: Ringkasan Status Unit Servis
            fputcsv($handle, ['=== 2. STATISTIK STATUS UNIT SERVIS ===']);
            fputcsv($handle, ['Status Order Servis', 'Jumlah Unit']);
            fputcsv($handle, ['Order Masuk (Pending)', $pendingCount]);
            fputcsv($handle, ['Dalam Pengerjaan (Proses/Diagnosa/Repair)', $processCount]);
            fputcsv($handle, ['Selesai Diperbaiki (Done)', $completedCount]);
            fputcsv($handle, ['Dibatalkan (Cancelled)', $cancelledCount]);
            fputcsv($handle, ['Retur / Refund', $refundedCount]);
            fputcsv($handle, ['Total Keseluruhan Order Periode Ini', $allTickets->count()]);
            fputcsv($handle, []);

            // Section 4: Detail Order & Tiket Servis
            fputcsv($handle, ['=== 3. DETAIL DAFTAR ORDER & TIKET SERVIS ===']);
            fputcsv($handle, [
                'No',
                'ID Tiket',
                'Tanggal Masuk',
                'Nama Pelanggan',
                'No. WhatsApp',
                'Model / Perangkat',
                'Keluhan Kerusakan',
                'Daftar Sparepart & Jasa Terpakai',
                'Total Modal (HPP)',
                'Subtotal Tagihan',
                'Diskon Voucher',
                'Total Tagihan Akhir',
                'Status Servis',
                'Status Pembayaran'
            ]);

            $no = 1;
            foreach ($allTickets as $ticket) {
                $itemDescriptions = $ticket->items->map(function ($item) {
                    $type = $item->is_spare_part ? 'Part' : 'Jasa';
                    return "[{$type}] {$item->description} (Qty: {$item->quantity} @ Rp " . number_format($item->price, 0, ',', '.') . ")";
                })->implode('; ');

                $totalHpp = $ticket->items->sum(fn($i) => $i->capital_price * $i->quantity);

                fputcsv($handle, [
                    $no++,
                    $ticket->id,
                    $ticket->created_at->format('d/m/Y H:i'),
                    $ticket->customer_name,
                    $ticket->customer_wa,
                    $ticket->device_model,
                    $ticket->issue_description,
                    $itemDescriptions ?: 'Belum ada item',
                    $totalHpp,
                    $ticket->subtotal,
                    $ticket->discount_amount ?? 0,
                    $ticket->total_cost,
                    $ticket->status,
                    $ticket->payment_status
                ]);
            }
            fputcsv($handle, []);

            // Section 5: Detail Arus Kas & Biaya Operasional
            fputcsv($handle, ['=== 4. DETAIL TRANSAKSI ARUS KAS & BIAYA OPERASIONAL (NON-ORDER) ===']);
            fputcsv($handle, [
                'No',
                'Tanggal Transaksi',
                'Tipe',
                'Kategori',
                'Judul Transaksi',
                'Nominal (IDR)',
                'Metode Pembayaran',
                'Petugas Pencatat',
                'Keterangan / Catatan'
            ]);

            $noTrx = 1;
            foreach ($financialTransactions as $trx) {
                fputcsv($handle, [
                    $noTrx++,
                    $trx->transaction_date->format('d/m/Y'),
                    $trx->type === 'income' ? 'Pemasukan (+)' : 'Pengeluaran (-)',
                    $trx->category,
                    $trx->title,
                    $trx->type === 'income' ? $trx->amount : -$trx->amount,
                    strtoupper($trx->payment_method),
                    $trx->user?->name ?? 'Sistem',
                    $trx->description ?? '-'
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function render()
    {
        $relevantTickets = $this->applyDateFilter(Ticket::query())->with('items')->where(function ($q) {
            $q->where('payment_status', 'paid')
              ->orWhereIn('status', ['cancelled', 'refunded'])
              ->orWhere('payment_status', 'refunded');
        })->get();
        
        $sparepartProfit = 0;
        $serviceProfit = 0;
        $sparepartRevenue = 0;
        $sparepartCapital = 0;
        $serviceRevenue = 0;
        $serviceCapital = 0;
        $orderTotalDiscount = 0;
        $cancelledLoss = 0;

        foreach ($relevantTickets as $ticket) {
            $tSparepartRev = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->price * $i->quantity);
            $tSparepartCap = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->capital_price * $i->quantity);
            
            $tServiceRev = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->price * $i->quantity);
            $tServiceCap = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->capital_price * $i->quantity);

            $isCancelledOrRefunded = in_array($ticket->status, ['cancelled', 'refunded']) || $ticket->payment_status === 'refunded';

            if ($isCancelledOrRefunded) {
                if ($ticket->payment_status === 'paid') {
                    // Paid cancellation or partial fee
                    $subtotal = $tSparepartRev + $tServiceRev;
                    $discount = $ticket->discount_amount ?? 0;
                    $orderTotalDiscount += $discount;
                    $sparepartRevenue += $tSparepartRev;
                    $serviceRevenue += $tServiceRev;

                    if ($subtotal > 0 && $discount > 0) {
                        $serviceDiscount = $discount * ($tServiceRev / $subtotal);
                        $sparepartDiscount = $discount * ($tSparepartRev / $subtotal);
                        $serviceProfit += ($tServiceRev - $serviceDiscount) - $tServiceCap;
                        $sparepartProfit += ($tSparepartRev - $sparepartDiscount) - $tSparepartCap;
                    } else {
                        $serviceProfit += $tServiceRev - $tServiceCap;
                        $sparepartProfit += $tSparepartRev - $tSparepartCap;
                    }
                } else {
                    // Revenue is 0 / refunded, used capital turns into direct negative profit
                    $sparepartProfit -= $tSparepartCap;
                    $serviceProfit -= $tServiceCap;
                    $cancelledLoss += ($tSparepartCap + $tServiceCap);
                }

                $sparepartCapital += $tSparepartCap;
                $serviceCapital += $tServiceCap;
            } else {
                $sparepartRevenue += $tSparepartRev;
                $sparepartCapital += $tSparepartCap;
                $serviceRevenue += $tServiceRev;
                $serviceCapital += $tServiceCap;

                $subtotal = $tSparepartRev + $tServiceRev;
                $discount = $ticket->discount_amount ?? 0;
                $orderTotalDiscount += $discount;

                if ($subtotal > 0 && $discount > 0) {
                    $serviceDiscount = $discount * ($tServiceRev / $subtotal);
                    $sparepartDiscount = $discount * ($tSparepartRev / $subtotal);
                    
                    $serviceProfit += ($tServiceRev - $serviceDiscount) - $tServiceCap;
                    $sparepartProfit += ($tSparepartRev - $sparepartDiscount) - $tSparepartCap;
                } else {
                    $serviceProfit += $tServiceRev - $tServiceCap;
                    $sparepartProfit += $tSparepartRev - $tSparepartCap;
                }
            }
        }

        $otherIncome = (float) $this->applyDateFilter(FinancialTransaction::query(), 'transaction_date')->where('type', 'income')->sum('amount');
        $otherExpense = (float) $this->applyDateFilter(FinancialTransaction::query(), 'transaction_date')->where('type', 'expense')->sum('amount');
        $orderGrossProfit = $sparepartProfit + $serviceProfit;
        $netBusinessProfit = ($orderGrossProfit + $otherIncome) - $otherExpense;

        $lowStockSpareParts = SparePart::with('type')
            ->where('stock', '<=', 1)
            ->orderBy('stock', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('livewire.admin.dashboard', [
            'pending' => $this->applyDateFilter(Ticket::query())->where('status', 'pending')->count(),
            'process' => $this->applyDateFilter(Ticket::query())->whereIn('status', ['diagnosing', 'repairing', 'waiting_approval', 'received', 'payment_verification'])->count(),
            'completed' => $this->applyDateFilter(Ticket::query())->where('status', 'done')->count(),
            'cancelledCount' => $this->applyDateFilter(Ticket::query())->where('status', 'cancelled')->count(),
            'refundedCount' => $this->applyDateFilter(Ticket::query())->where('status', 'refunded')->count(),
            'revenue' => $this->applyDateFilter(Ticket::query())->where('payment_status', 'paid')->sum('total_cost'),
            'sparepartProfit' => $sparepartProfit,
            'serviceProfit' => $serviceProfit,
            'sparepartRevenue' => $sparepartRevenue,
            'sparepartCapital' => $sparepartCapital,
            'serviceRevenue' => $serviceRevenue,
            'serviceCapital' => $serviceCapital,
            'orderTotalDiscount' => $orderTotalDiscount,
            'cancelledLoss' => $cancelledLoss,
            'orderGrossProfit' => $orderGrossProfit,
            'otherIncome' => $otherIncome,
            'otherExpense' => $otherExpense,
            'netBusinessProfit' => $netBusinessProfit,
            'lowStockSpareParts' => $lowStockSpareParts,
            'chartData' => $this->getChartData(),
        ]);
    }
}
