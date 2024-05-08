<?php

namespace App\Console\Commands;

use App\Models\Stocks;
use Illuminate\Console\Command;
class GetInformation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-information';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes data from origin';
    protected const hostname = 'http://89.108.115.241:6969/';
    protected const stocksPath = 'api/stocks??dateFrom=2024-05-08&dateTo=&page=1&key=E6kUTYrYwZq2tN4QEtyzsbEBk3ie&limit=100';
    protected const incomesPath = 'api/incomes';
    protected const salesPath = 'api/sales';
    protected const ordersPath = 'api/orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->getStocks();
    }
    private function getStocks()
    {
        $ch = curl_init();
        // Установка URL
        curl_setopt($ch, CURLOPT_URL, $this::hostname.$this::stocksPath);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Выполнение запроса cURL
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        foreach ($response['data'] as $stock){
            Stocks::create($stock);
        }
        curl_close($ch);

    }
}
