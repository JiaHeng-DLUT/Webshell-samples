<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-10-26
 * Time: 09:41
 */

namespace App\Traits;


trait Upload
{
    /**
     * 上传图片文件
     * @param $request
     * @param $key
     * @param $img_path
     * @return array|bool|int|string
     */
    public function uploadImg($request,$key,$img_path){
        $file = $request->file($key);
        $data = $request->all();
        $rules = [
            "{$key}" => 'max:10240',
        ];
        $messages = [
            "{$key}.max" => '文件过大,文件大小不得超出10MB',
        ];
        $validator = Validator($data, $rules, $messages);
        if (!$validator->fails()) {
            $allowed_extensions = ["png", "jpg", "gif","jpeg"];
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return ['error' => 'You may only upload png, jpg or gif.'];
            }
            $extension = $file->getClientOriginalExtension();
            $this->makeDirs($img_path);
            //name:/2017/201701/20170101/000001.png
            $fileName = time() . rand(1000, 9999) . '.' . $extension;
            $file->move($img_path, $fileName);
            $res = substr($img_path . $fileName,strpos($img_path . $fileName,'upload'));
        } else {
            $res = 2;
        }
        return $res;
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage($request,$key)
    {
        //上传文件最大大小,单位M
        $maxSize = 5;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg","jpeg",'bmp','PNG','JPG','JPEG','BMP'];
        //返回信息json
        $data = ['code'=>4000, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file($key);

        //检查文件是否上传完成
        if ($file->isValid()){
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                $this->set('type',$this->badRequest);
                $this->set('info','error');
                $this->set('data',$data['msg']);
            }
            //检测图片大小
            if ($file->getClientSize() > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                $this->set('type',$this->badRequest);
                $this->set('info','error');
                $this->set('data',$data['msg']);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            $this->set('type',$this->badRequest);
            $this->set('info','error');
            $this->set('data',$data['msg']);
        }
        $res = $request->file($key)->store('images/file','public');
        $request->file($key)->move(env('FILE_PATH'));
        if($res){
            $this->set('data',$res);
        }else{
            $this->set('type',$this->badRequest);
            $this->set('info','error');
            $this->set('data',$data['msg']);
        }
        return $this->jsonResponse();
    }

    /**
     * 迭代创建文件夹
     * @param $dir
     * @return bool
     */
    public function makeDirs($dir){
        if(!is_dir($dir)){
            if(!$this->makeDirs(dirname($dir))){
                return false;
            }
            if(!mkdir($dir,0777)){
                return false;
            }
        }
        return true;
    }
}