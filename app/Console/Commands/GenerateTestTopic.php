<?php

namespace App\Console\Commands;

use App\Logic\TopicLogic;
use Illuminate\Console\Command;

class GenerateTestTopic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:topic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成测试数据';

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
        TopicLogic::instance()->generateTestTopic();
    }
}
