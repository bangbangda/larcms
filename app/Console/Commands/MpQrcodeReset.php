<?php

namespace App\Console\Commands;

use App\Jobs\ResetMpQrcodeUrl;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class MpQrcodeReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mp:qrcode-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '重新获取带参数二维码';

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
        Customer::select('id')->orderBy('id')->limit(10)->chunk(100, function ($users) {
            ResetMpQrcodeUrl::dispatch(Arr::pluck($users, 'id'));
        });

        return 0;
    }
}
