<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\TicketItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin', ['title' => 'Dashboard Overview'])]
class Dashboard extends Component
{
    public $dateFilter = 'all';

    public function applyDateFilter($query)
    {
        return match ($this->dateFilter) {
            'today' => $query->whereDate('created_at', today()),
            'week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'year' => $query->whereYear('created_at', now()->year),
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

    public function render()
    {
        $paidTickets = $this->applyDateFilter(Ticket::query())->with('items')->where('payment_status', 'paid')->get();
        
        $sparepartProfit = 0;
        $serviceProfit = 0;

        foreach ($paidTickets as $ticket) {
            $ticketSparepartRevenue = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->price * $i->quantity);
            $ticketSparepartCapital = $ticket->items->where('is_spare_part', true)->sum(fn($i) => $i->capital_price * $i->quantity);
            
            $ticketServiceRevenue = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->price * $i->quantity);
            $ticketServiceCapital = $ticket->items->where('is_spare_part', false)->sum(fn($i) => $i->capital_price * $i->quantity);

            $subtotal = $ticketSparepartRevenue + $ticketServiceRevenue;
            $discount = $ticket->discount_amount ?? 0;

            if ($subtotal > 0 && $discount > 0) {
                // Apportion discount based on revenue share
                $serviceDiscount = $discount * ($ticketServiceRevenue / $subtotal);
                $sparepartDiscount = $discount * ($ticketSparepartRevenue / $subtotal);
                
                $serviceProfit += ($ticketServiceRevenue - $serviceDiscount) - $ticketServiceCapital;
                $sparepartProfit += ($ticketSparepartRevenue - $sparepartDiscount) - $ticketSparepartCapital;
            } else {
                $serviceProfit += $ticketServiceRevenue - $ticketServiceCapital;
                $sparepartProfit += $ticketSparepartRevenue - $ticketSparepartCapital;
            }
        }

        return view('livewire.admin.dashboard', [
            'pending' => $this->applyDateFilter(Ticket::query())->where('status', 'pending')->count(),
            'process' => $this->applyDateFilter(Ticket::query())->whereIn('status', ['diagnosing', 'repairing', 'waiting_approval'])->count(),
            'completed' => $this->applyDateFilter(Ticket::query())->where('status', 'done')->count(),
            'revenue' => $this->applyDateFilter(Ticket::query())->where('payment_status', 'paid')->sum('total_cost'),
            'sparepartProfit' => $sparepartProfit,
            'serviceProfit' => $serviceProfit,
            'chartData' => $this->getChartData(),
        ]);
    }
}
