<?php
/**
 * Name: TopicLogic.php.
 * Author: hp <xcf-hp@foxmail.com>
 * Date: 2020-01-10 14:05
 * Description: TopicLogic.php.
 */

namespace App\Logic;


use App\Model\Topic;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TopicLogic extends BaseLogic
{
    public function getTopicList($page=1,$limit=20,$category_id=0){
        $model = Topic::query()
            ->orderBy('create_time','DESC')
            ->where('delete_time',0)
            ->where(function ($query)use ($category_id){
                if(!empty($category_id)){
                    $query->where(['category_id'=>(int)$category_id]);
                }
            })
//            ->from(DB::raw('`topics` FORCE INDEX (`create_time`)'))
            ->select(['id','title','excerpt','user_id','category_id','reply_count','view_count','create_time'])
            ->with('replies')
            ->with('user')
            ->paginate($limit,['*'],'page',$page);
        return $model;
    }

    public function generateTestTopic(){
        //生成用户
        ini_set ('memory_limit', '1024M');
        $topicList = Topic::query()->where('id','<=',100)->pluck('title')->toArray();
        $bodyList = Topic::query()->where('id','<=',100)->pluck('body')->toArray();
        $excerptList = Topic::query()->where('id','<=',100)->pluck('excerpt')->toArray();
        for($j=0;$j<10;$j++){
            for($i=0;$i<5000;$i++){
                $uuid = Str::uuid();
                $insertUser[] = [
                    'name'=>Str::random(5),
                    'phone'=>rand(10000000000,19999999999),
                    'email'=>Str::random(10).'@abc.com',
                    'weixin_openid'=>$uuid,
                    'avatar'=>'http://larabbs.test/uploads/images/avatars'.time().'.png',
                    'introduction'=>Str::random(10).' '.Str::random(3).' '.Str::random(8).'.',
                    'create_time'=>time(),
                    'password'=>'$2y$10$1NWqa9Jbg7LXU4kamiM9Buh.6vrEZkmy3tTgPOvsjtriIoNL3l5SS',
                    'remember_token'=>Str::uuid()
                ];
                echo '正在创建第'.$i.'个用户'.PHP_EOL;
                $whereUid[] = $uuid;
            }
            User::query()->insert($insertUser);
            //发布话题
            $user_ids = User::query()->whereIn('weixin_openid',$whereUid)->pluck('id')->toArray();
            unset($whereUid);
            foreach ($user_ids as $k=>$v){
                $randTitle = array_rand($topicList,2);
                $randExcerpt = array_rand($excerptList,2);
                $randBodyKey = array_rand($bodyList);
                $insertTopic[$k] = [
                    'title'=>$topicList[$randTitle[0]].' '.$topicList[$randTitle[1]],
                    'body'=>$bodyList[$randBodyKey],
                    'user_id'=>$v,
                    'category_id'=>rand(1,4),
                    'excerpt'=>$excerptList[$randExcerpt[0]].' '.$excerptList[$randExcerpt[1]],
                    'create_time'=>time()-rand(10000,99999)
                ];
                echo '正在发布第'.$k.'条话题'.PHP_EOL;
            }
            Topic::query()->insert($insertTopic);
            unset($insertTopic,$uuid,$insertUser,$user_ids,$randTitle,$randExcerpt,$randBodyKey,$insertTopic);
            echo '生成完第'.$j.'批'.PHP_EOL;
            sleep(2);
        }



    }
}