<?php
/**
 * Name: Topic.php.
 * Author: hp <xcf-hp@foxmail.com>
 * Date: 2020-01-10 14:02
 * Description: Topic.php.
 */

namespace App\Model;


class Topic extends BaseModel
{
    public function replies(){
        return $this->hasMany(Replies::class,'topic_id','id')
            ->select(['topic_id','user_id','content','create_time'])
            ->with('user');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id')
            ->select(['id','name','avatar']);
    }
}