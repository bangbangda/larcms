<?php

namespace App\Console\Commands;

use App\Models\Question;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportAuestionAndAnswer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:qa';

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
        $config = ['path' => '/Users/haoliang/Downloads'];
        $excel = new \Vtiful\Kernel\Excel($config);

        // 读取测试文件
        $allData = $excel->openFile('qa.xlsx')
            ->openSheet()
            ->setSkipRows(1);

        while (($data = $excel->nextRow([
                \Vtiful\Kernel\Excel::TYPE_STRING,
                \Vtiful\Kernel\Excel::TYPE_STRING,
            ])) !== null) {
            $question = Question::create([
                'type' => $data[0],
                'content' => $data[1],
                'correct_answer' => $data[3],
            ]);

            for ($i = 5; $i < 10; $i ++) {
                if (! $data[$i]) {
                    break;
                }
                $question->answers()->create([
                    'content' => $data[$i]
                ]);
            }
        }

        return 1;
    }
}
