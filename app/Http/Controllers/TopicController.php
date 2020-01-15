<?php
/**
 * Name: TopicController.php.
 * Author: hp <xcf-hp@foxmail.com>
 * Date: 2020-01-10 13:46
 * Description: TopicController.php.
 */

namespace App\Http\Controllers;


use App\Logic\TopicLogic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index(Request $request){
        $page = $request->input('page',1);
        $limit = $request->input('limit',20);
        $category_id = $request->input('category_id',0);
        $result = TopicLogic::instance()->getTopicList($page,$limit,$category_id);
        return response()->json($result);
    }

    public function v2(Request $request){
        $page = $request->input('page',1);
        $limit = $request->input('limit',20);
        $category_id = $request->input('category_id',0);
        $result = TopicLogic::instance()->getTopicListV2($page,$limit,$category_id);
        return response()->json($result);
    }

    public function v3(Request $request){
        $page = $request->input('page',1);
        $limit = $request->input('limit',20);
        $category_id = $request->input('category_id',0);
        $result = TopicLogic::instance()->getTopicListV3($page,$limit,$category_id);
        return response()->json($result);
    }

    public function topicIds(Request $request){
        $category_id = $request->input('category_id',0);
        $result = TopicLogic::instance()->getTopicIds($category_id);
        return response()->json($result);
    }
}