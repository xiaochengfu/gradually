<?php

namespace App\Console\Commands;

use App\Model\Topic;
use App\Service\TopicHotCache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class CacheTopicHot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:topicHot';

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
     * @return mixed
     */
    public function handle()
    {
        Redis::del('topic_hot_ids');
        $list = Topic::query()
            ->orderBy('id','DESC')
            ->where('delete_time',0)
            ->select(['id','title','excerpt','user_id','category_id','reply_count','view_count','create_time'])
            ->with('replies')
            ->with('user')
            ->limit(200)
            ->get()
            ->toArray();
        $ids = array_column($list,'id');
        TopicHotCache::instance()->TopicIdsCache($ids);
        //根据id缓存内容序列
        foreach ($list as $key=>$value){
            Redis::set('topic_hot_detail:'.$value['id'],json_encode($value));
        }
    }
}
