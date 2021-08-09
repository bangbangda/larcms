<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\TransferLog;
use EasyWeChat\Factory;
use Illuminate\Console\Command;
use App\Jobs\SendWechatRedPack;
use Illuminate\Support\Facades\DB;

class WechatSendRedPack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechat:send-red-pack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        // 查询发送失败红包
        $reSendData = TransferLog::whereNull('payment_no')->where('created_at', '<', now()->toDateTimeString())
            ->where('customer_id', '117')
            ->select('customer_id', DB::raw('sum(amount) as s_amount'))
            ->groupBy('customer_id')
            ->having('s_amount', '>', 100)
            ->get();

        foreach ($reSendData as $data) {
            $customer = Customer::find($data->customer_id);

            SendWechatRedPack::dispatch([
                'mp_openid' => $customer->mp_openid,
                'amount' => $data['s_amount'],
                'customer_id' => $data->customer_id,
            ]);
        }

        return 0;
    }
}
