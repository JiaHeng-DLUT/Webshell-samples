<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/29
 * Time: 11:10
 */

namespace App\Traits;


use App\Models\ClientUser;
use App\Models\UserModel;
use Illuminate\Support\Facades\Redis;

trait ResponseJson
{

    /**
     * @var int
     */
    private $code = 1;

    /**
     * @var array
     */
    private $data = null;

    /**
     * @var string
     */
    private $info = 'OK';

    protected $times = 2;


    /**
     * @return array
     * ajax 返回格式
     */
    public function ajaxResponse()
    {
        return [
            'code'=>$this->code,
            'info'=>$this->info,
            'data'=>$this->data
        ];
    }
    /**
     * @param $param
     * @param $value
     */
    public function set($param, $value)
    {
        $this->$param = $value;
    }

    /**
     * json数据格式返回
     * @param $code
     * @param string $info
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function json($code,$info='success',$data=null)
    {
        return response()->json(['code'=>$code,'info'=>$info,'data'=>$data]);
    }




}