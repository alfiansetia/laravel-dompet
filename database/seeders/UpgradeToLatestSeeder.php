<?php

namespace Database\Seeders;

use App\Models\Capital;
use App\Models\Expenditure;
use App\Models\Transaksi;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpgradeToLatestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo 'Starting Upgrade!' . PHP_EOL;
        try {
            DB::beginTransaction();
            echo 'Starting Transaksi!' . PHP_EOL;
            $transactionsPerDay = Transaksi::select(DB::raw('DATE(date) as day'), 'id', 'date')
                ->orderBy('id')
                ->get()
                ->groupBy('day');
            foreach ($transactionsPerDay as $date => $item) {
                $li = 1;
                foreach ($item as $i) {
                    $i->update([
                        'number' => 'TRX' . date('ymd', strtotime($date)) . str_pad($li, 3, 0, STR_PAD_LEFT)
                    ]);
                    $li++;
                }
            }

            echo 'Starting Capital!' . PHP_EOL;
            $capital = Capital::select(DB::raw('DATE(date) as day'), 'id', 'date')
                ->orderBy('id')
                ->get()
                ->groupBy('day');
            foreach ($capital as $date => $item) {
                $lii = 1;
                foreach ($item as $i) {
                    $i->update([
                        'number' => 'CAP' . date('ymd', strtotime($date)) . str_pad($lii, 3, 0, STR_PAD_LEFT)
                    ]);
                    $lii++;
                }
            }

            echo 'Starting Expenditure!' . PHP_EOL;
            $expend = Expenditure::select(DB::raw('DATE(date) as day'), 'id', 'date')
                ->orderBy('id')
                ->get()
                ->groupBy('day');
            foreach ($expend as $date => $item) {
                $liii = 1;
                foreach ($item as $i) {
                    $i->update([
                        'number' => 'EXP' . date('ymd', strtotime($date)) . str_pad($liii, 3, 0, STR_PAD_LEFT)
                    ]);
                    $liii++;
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            echo 'Error : ' . $e->getMessage();
            echo PHP_EOL;
        }
        echo 'Done!' . PHP_EOL;
    }
}
