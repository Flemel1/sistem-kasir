<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use NumberFormatter;
use stdClass;

class Dashboard extends Component
{
    public $timeFrame = 'weekly';

    private function getPercentageCurrentRevenue()
    {
        $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);

        $todayRevenue = Order::whereDate('created_at', Carbon::today())->sum('total_payment');

        $yesterdayRevenue = Order::whereDate('created_at', Carbon::yesterday())->sum('total_payment');

        $percentage = 0;

        if ($yesterdayRevenue != 0) {
            $percentage = $todayRevenue * 100 / $yesterdayRevenue - 100;
        }

        return [
            'today_revenue' => $formatter->formatCurrency($todayRevenue, 'IDR'),
            'percentage' => $percentage
        ];
    }

    private function getPercentageCurrentTransaction()
    {
        $todayTransaction = Order::whereDate('created_at', Carbon::today())->count();

        $yesterdayTransaction = Order::whereDate('created_at', Carbon::yesterday())->count();

        $percentage = 0;

        if ($yesterdayTransaction != 0) {
            $percentage = $todayTransaction * 100 / $yesterdayTransaction - 100;
        }

        return [
            'today_transaction' => $todayTransaction,
            'percentage' => $percentage
        ];
    }

    private function sumGroupByMenu()
    {
        $numberOfMenusSold = OrderDetail::select('product_id', 'products.product_name', DB::raw('SUM(amount) as total'))
            ->without('product')
            ->join('products', 'products.id', '=', 'product_id')
            ->groupBy('product_id', 'products.product_name')
            ->get();

        return $numberOfMenusSold;
    }

    #[On('get-revenue-by-timeframe')]
    public function sumReveneuGroupByTimeFrame()
    {
        $datas = [];

        if ($this->timeFrame == 'yearly') {
            $rawDate = Carbon::now()->year;

            $yearlyDataRaw = Order::query()
                ->whereYear('created_at', $rawDate)
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(total_payment) as total')
                )
                ->groupBy('month')
                ->orderBy('month', 'ASC')
                ->get();

            $period = Carbon::now()->subDays(6)->daysUntil(Carbon::now());

            for ($i = 1; $i <= 12; $i++) {
                $obj = new stdClass();
                $obj->x = Carbon::create()->month($i)->format('F');
                $data = $yearlyDataRaw->firstWhere('month', $i);
                $obj->y = $data ? $data->total : 0;

                $datas[] = $obj;
            }
        } else if ($this->timeFrame == 'monthly') {
            $rawDate = Carbon::now()->subDays(30)->startOfDay();

            $monthlyDataRaw = Order::query()
                ->whereYear('created_at', ">=", $rawDate)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total_payment) as total')
                )
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();

            $period = Carbon::now()->subDays(30)->daysUntil(Carbon::now());

            foreach ($period as $date) {
                $obj = new stdClass();
                $dateString = $date->format('Y-m-d');
                $obj->x = $date->format('d');
                $dayData = $monthlyDataRaw->firstWhere('date', $dateString);
                $obj->y = $dayData ? $dayData->total : 0;

                $datas[] = $obj;
            }
        } else {
            $rawDate = Carbon::now()->subDays(7)->startOfDay();

            $monthlyDataRaw = Order::query()
                ->whereYear('created_at', ">=", $rawDate)
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total_payment) as total')
                )
                ->groupBy('date')
                ->orderBy('date', 'ASC')
                ->get();

            $period = Carbon::now()->subDays(7)->daysUntil(Carbon::now());

            foreach ($period as $date) {
                $obj = new stdClass();
                $dateString = $date->format('Y-m-d');
                $obj->x = $date->format('D');
                $dayData = $monthlyDataRaw->firstWhere('date', $dateString);
                $obj->y = $dayData ? $dayData->total : 0;

                $datas[] = $obj;
            }
        }


        $this->dispatch('get-revenue-by-timeframe-db', [
            'datas' => $datas
        ]);
    }


    public function render()
    {
        $revenueSummary = $this->getPercentageCurrentRevenue();
        $transactionSummary = $this->getPercentageCurrentTransaction();
        $numberOfMenusSold = $this->sumGroupByMenu();
        $shifts = Shift::all();

        return view('livewire.dashboard', compact(
            'revenueSummary',
            'transactionSummary',
            'numberOfMenusSold',
            'shifts'
        ));
    }
}
