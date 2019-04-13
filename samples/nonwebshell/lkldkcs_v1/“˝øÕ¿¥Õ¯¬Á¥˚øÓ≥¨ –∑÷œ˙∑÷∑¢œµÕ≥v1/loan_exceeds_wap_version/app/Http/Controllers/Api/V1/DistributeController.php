<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\BasesController;
use App\Models\App;
use App\Models\Apply;
use App\Models\Article;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DistributeController extends BaseController
{


    /**
     * 文章独立详情
     * @param $id
     * @return array
     */
    public function article($id){
        $exist = Article::find($id,['id','content']);
        if($exist){
            $this->set('data',$exist);
        }else{
                $this->set('type',$this->noContent);
                $this->set('info','文章不存在');
            }
        return $this->jsonResponse();
    }


}
