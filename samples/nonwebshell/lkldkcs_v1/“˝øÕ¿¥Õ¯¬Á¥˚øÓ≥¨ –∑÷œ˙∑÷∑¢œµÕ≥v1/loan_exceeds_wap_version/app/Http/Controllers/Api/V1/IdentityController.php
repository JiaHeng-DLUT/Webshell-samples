<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\Member;
use App\Models\RealInformation;
use App\Traits\Identity;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IdentityController extends BaseController
{
    use Upload;
    use Identity;

    /**
     * 识别身份信息
     * @param Request $request
     * @return array
     */
    public function recognitionInfo(Request $request)
    {
        /***正面***/
        if ($request->hasFile('card_face')) {//文件上传
            $result = $this->uploadImg($request, 'card_face',$this->img_path);
            if ($result == 2 || (!empty($result['error']))){// 2=>图片大小超出范围
                $this->set('type',$this->badRequest);
                $this->set('info','图片上传失败');
                $this->set('data',$result);
            }else{//正常
                $phone = $request->phone;
                //上传图片
                $path_face = str_replace("\\", '/', $result);//正面
                //识别身份证
                $res = $this->distinguishID($path_face);
                if ($res['code'] == 200) {//识别成功
                    $id_number = json_decode($res['data'], true)['num'];
                    $real_name = json_decode($res['data'], true)['name'];
                    //验证身份证信息是否和电话号码匹配
                    $phone_ID = $this->phoneMatchID($id_number, $phone, $real_name);
                    if ($phone_ID['status'] == "01") {//匹配成功
                        $save_path = 'images/file/'.str_replace($this->img_path,'',$result);
                        //保存数据库
                        $user = Member::where('phone', $phone)->first();
                        $r = RealInformation::create([
                            'mid' => $user->id,
                            'card_face' => $save_path,
                            'real_name' => json_decode($res['data'], true)['name'],
                            'id_number' => json_decode($res['data'], true)['num'],
                            'info' => json_decode($res['data'], true),
                        ]);
                        $first = [
                            'rid'=>$r->id,
                            'status'=>0,
                            'pic_url' => $save_path,
                            'real_name' => json_decode($res['data'], true)['name'],
                            'id_number' => json_decode($res['data'], true)['num'],
                        ];
                         $this->set('data',$first);
                    } else {//匹配失败
                        $this->set('type',$this->noContent);
                        $this->set('info','证件与手机号不匹配');
                        $this->set('data',$phone_ID);
                    }
                } else {//识别失败
                    $this->set('type',$this->noContent);
                    $this->set('info','请上传正确证件');
                    $this->set('data',$res['code'] . '===' . $res['info']);
                }
            }
        }else{//未上传
            Log::info('---card_face---'.$request->hasFile('card_face'));
        }
        /***反面***/
        if($request->hasFile('card_back')){//文件上传
            $result = $this->uploadImg($request, 'card_back',$this->img_path);
            if ($result == 2 || (!empty($result['error']))){// 2=>图片大小超出范围, 异常
                $this->set('type',$this->badRequest);
                $this->set('info','获取对象中值失败');
                $this->set('data',$result);
            }else{//正常
                $path_back = str_replace("\\", '/', $result);//反面
                //修改当前用户数据
                $res = RealInformation::where('id',$request->rid)->first();
                if ($res){
                    $save_path = 'images/file/'.str_replace($this->img_path,'',$result);
                    $r = RealInformation::where('id',$request->rid)->update([
                        'card_back' => $save_path,
                        'status'=>0,
                    ]);
                    $data = [
                        'save_status'=>$r,
                        'pic_url'=>$save_path,
                    ];
                    $this->set('data',$data);
                }else{
                    $this->set('type',$this->noContent);
                    $this->set('info','信息核对错误,请重试');
                }
            }
        }else{//未上传
            Log::info('---card_back---'.$request->hasFile('card_back'));
        }
        return $this->jsonResponse();
    }


    /**
     * 保存身份信息
     * @param Request $request
     * @return array
     */
    public function saveInfo(Request $request)
    {
        $res = RealInformation::where('id',$request->rid)->first();
        if ($res){
            $linkage = explode(',',$request->input('linkage'));//城市三级联动
            $province=0; $city=0; $district=0;
            if (count($linkage)){
                $province = (int)$linkage[0];
                $city = (int)$linkage[1];
                $district = (int)$linkage[2];
            }
            //保存用户信息
            RealInformation::where('id',$request->rid)->update([
                'quota'=>$request->input('quota',''),
                'repay'=>$request->input('repay',''),
                'province'=>$province,
                'city'=>$city,
                'district'=>$district,
                'address'=>$request->input('address',''),
                'contact'=>$request->input('contact',''),
                'contact_phone'=>$request->input('contact_phone',''),
                'contact_relation'=>$request->input('contact_relation',''),
                'status'=>1,
            ]);
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','信息核对错误,请重试');
        }
        return $this->jsonResponse();
    }
}
