<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Model\User;
use App\Model\Order;
use DB;

class GenerateMonthlyBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerateMonthlyBills:generateMonthlyBills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto generates and sends mothly bill on Email/SMS to all users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
                DB::enableQueryLog();
                $lastMonth = date('m',strtotime('last month'));
                $allUsers = User::where("users.deleted_at", NULL)->get()->toArray();
                foreach ($allUsers as $key => $user) {
                    $orders = Order::where('user_id',$user['id'])
                            ->whereRaw('MONTH(order_date)='.$lastMonth)->get()
                            ->where("orders.deleted_at", NULL)->toArray();
                    echo "<pre/>";
                    print_r($orders);
                }
                exit;
        } catch (Exception $e) {
            return $e->getRawMessage();
        }
    }
}
