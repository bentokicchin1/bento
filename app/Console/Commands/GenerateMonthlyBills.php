<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Model\User;
use App\Model\Order;
use App\Model\BillPayment;
use App\Services\BillingService;
use DB;

class GenerateMonthlyBills extends Command
{
    private $billingService;
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
    public function __construct(BillingService $billingService)
    {
        parent::__construct();
        $this->billingService = $billingService;
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
            $lastMonth = date('m',strtotime('this month'));
            $allUsers = User::where("id", 1)->where("users.deleted_at", NULL)->where("users.suspended",'no')->get()->toArray();
            foreach ($allUsers as $key => $user) {
                $orders = Order::getOrderDetails($user['id']);
                if(!empty($orders)){
                    unset($orders['total']);
                    $this->billingService->sendGeneratedBills($user,$orders);
                }
                exit;
            }
        } catch (Exception $e) {
            return $e->getRawMessage();
        }
    }
}
