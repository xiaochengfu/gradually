<?php
/**
 * Name: Replies.phpp.
 * Author: hp <xcf-hp@foxmail.com>
 * Date: 2020-01-10 14:17
 * Description: Replies.phpp.
 */

namespace App\Model;


class Replies extends BaseModel
{
    protected $table = 'replies';

    public function user(){
        return $this->hasOne(User::class,'id','user_id')
            ->select(['id','name','avatar']);
    }
}