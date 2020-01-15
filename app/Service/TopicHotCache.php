<?php
/**
 * Name: TopicHotCache.php.
 * Author: hp <xcf-hp@foxmail.com>
 * Date: 2020-01-15 16:12
 * Description: TopicHotCache.php.
 */

namespace App\Service;


use App\Logic\BaseLogic;
use Illuminate\Support\Facades\Redis;

class TopicHotCache extends BaseLogic
{
    public function TopicIdsCount(){
        return Redis::zcard('topic_hot_ids');
    }

    public function TopicIdsCache($ids){
        foreach ($ids as $sort=>$v){
            Redis::zadd('topic_hot_ids',$sort,$v);
        }
    }

    public function getTopicIdsPage($page,$limit){
        $offset = ($page == 1?0:$page-1) * $limit;
        $ids = Redis::zrange('topic_hot_ids',$offset,$page*$limit-1);
        return $ids;
    }
}