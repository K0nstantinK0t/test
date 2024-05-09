<?php

namespace App\Console\Commands;

use App\Models\Incomes;
use App\Models\Orders;
use App\Models\Sales;
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
    protected const incomesPath = 'api/incomes';
    protected const salesPath = 'api/sales';
    protected const ordersPath = 'api/orders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Да я знаю, что лучше бы было сделать отдельный класс и, например,
        //  унаследовать от него разные которые будут выполнять спецефические
        // запросы, но так быстрее
        $this->getStocks();
        $this->getIncomes();
        $this->getSales();
        $this->getOrders();
    }
    private function getStocks()
    {
        $page = 1;
        $ch = curl_init();
        do {
            // Установка URL
            curl_setopt($ch, CURLOPT_URL, self::hostname . 'api/stocks?' .
                http_build_query([
                    'dateFrom' => date('Y-m-d'),
                    'dateTo' => date('Y-m-d'),
                    'page' => $page,
                    'key' => config('api.key'),
                    'limit' => config('api.limit')
                ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Выполнение запроса cURL
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            foreach ($response['data'] as $stock) {
                Stocks::create($stock);
            }
            $page++;
        } while ($response['meta']['current_page'] <= $response['meta']['last_page']);
        curl_close($ch);
    }


    private function getIncomes()
    {
        $page = 1;
        $ch = curl_init();
        do{
            // Установка URL
            curl_setopt($ch, CURLOPT_URL, self::hostname.'api/incomes?'.
                http_build_query([
                    'dateFrom' => '0000-01-01',
                    'dateTo' => date('Y-m-d'),
                    'page' => $page,
                    'key' => config('api.key'),
                    'limit' => config('api.limit')
                ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Выполнение запроса cURL
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            foreach ($response['data'] as $stock){
                Incomes::create($stock);
            }
            $page++;
        }while($response['meta']['current_page'] <= $response['meta']['last_page']);
        curl_close($ch);

    }
    private function getSales()
    {
        $page = 1;
        $ch = curl_init();
        do{
            // Установка URL
            curl_setopt($ch, CURLOPT_URL, self::hostname.'api/sales?'.
                http_build_query([
                    'dateFrom' => '0000-01-01',
                    'dateTo' => date('Y-m-d'),
                    'page' => $page,
                    'key' => config('api.key'),
                    'limit' => config('api.limit')
                ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Выполнение запроса cURL
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            foreach ($response['data'] as $stock){
                Sales::create($stock);
            }
            $page++;
        }while($response['meta']['current_page'] <= $response['meta']['last_page']);
        curl_close($ch);

    }
    private function getOrders()
    {
        $page = 1;
        $ch = curl_init();
        do{
            // Установка URL
            curl_setopt($ch, CURLOPT_URL, self::hostname.'api/orders?'.
                http_build_query([
                    'dateFrom' => '0000-01-01',
                    'dateTo' => date('Y-m-d'),
                    'page' => $page,
                    'key' => config('api.key'),
                    'limit' => config('api.limit')
                ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Выполнение запроса cURL
            $response = curl_exec($ch);
            $response = json_decode($response, true);
            foreach ($response['data'] as $stock){
                Orders::create($stock);
            }
            $page++;
        }while($response['meta']['current_page'] <= $response['meta']['last_page']);
        curl_close($ch);

    }
}
