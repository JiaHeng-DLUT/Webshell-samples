<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    public function uploadImage(Request $request)
    {

        //上传文件最大大小,单位M
        $maxSize = 5;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg","jpeg",'bmp','PNG','JPG','JPEG','BMP'];
        //返回信息json
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()){
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getClientSize() > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }

        $res = $request->file('file')->store('images/file','public');

//        $newFile = date('Y-m-d')."_".time()."_".uniqid().".".$file->getClientOriginalExtension();
//        $disk = QiniuStorage::disk('qiniu');
//        $res = $disk->put($newFile,file_get_contents($file->getRealPath()));
        if($res){
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => $res,
                'url'   => $res
            ];
        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }

    //apk上传
    public function uploadApk(Request $request)
    {

        //上传文件最大大小,单位M
        $maxSize = 50;
        //支持的上传图片类型
        $allowed_extensions = ["apk"];
        //返回信息json
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()){
            //检测图片类型
            $ext = $file->getClientOriginalExtension();

            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getClientSize() > $maxSize*1024*1024){
                $data['msg'] = "文件大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }

        $destinationPath = public_path() .'/app/public/images/apk/';
        $extension = $file->getClientOriginalExtension();
        $this->mkDirs($destinationPath);
        $fileName = time() . rand(1000, 9999) . '.' . $extension;
        $file->move($destinationPath, $fileName);
        $res = str_replace(public_path() .'/app/public/','',$destinationPath . $fileName);

        if($res){
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => $res,
                'url'   => $res
            ];
        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }


    public function mkDirs($dir){
        if(!is_dir($dir)){
            if(!$this->mkDirs(dirname($dir))){
                return false;
            }
            if(!mkdir($dir,0777)){
                return false;
            }
        }
        return true;
    }




    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 通用图片上传：大小限制5M
     */
    public function commonUpload(Request $request)
    {

        //上传文件最大大小,单位M
        $maxSize = 5;
        //支持的上传图片类型
        $allowed_extensions = ["png", "jpg", "jpeg"];
        //返回信息json
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        $file = $request->file('file');

        //检查文件是否上传完成
        if ($file->isValid()){
            //检测图片类型
            $ext = $file->getClientOriginalExtension();
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的图片";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getClientSize() > $maxSize*1024*1024){
                $data['msg'] = "图片大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }

        $res = $request->file('file')->store('images/file','public');

//        $newFile = date('Y-m-d')."_".time()."_".uniqid().".".$file->getClientOriginalExtension();
//        $disk = QiniuStorage::disk('qiniu');
//        $res = $disk->put($newFile,file_get_contents($file->getRealPath()));
        if($res){
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => $res,
                'url'   => $res
            ];
        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }


    public function uploadFile(Request $request){

        $file = $request->file('file');
        $maxSize = 10;
        $type=$request->input('type');
        $allowed_extensions = ["png", "jpg", "gif","JPEG","PNG","JPG","JPEG","GIF","txt"];
        $ext = $file->getClientOriginalExtension();
        $excel_extensions=['xls','xlsx','csv'];
        if($type=='excel'){
            if(!in_array($ext,$excel_extensions)){
//                return response()->json(['code'=>1,'msg'=>'Excel文件格式错误']);
            }
            $allowed_extensions=array_merge($allowed_extensions,$excel_extensions);
        }
        $data = ['code'=>200, 'msg'=>'上传失败', 'data'=>''];
        //检查文件是否上传完成
        if ($file->isValid()){
            //检测图片类型
            if (!in_array(strtolower($ext),$allowed_extensions)){
                $data['msg'] = "请上传".implode(",",$allowed_extensions)."格式的文件";
                return response()->json($data);
            }
            //检测图片大小
            if ($file->getClientSize() > $maxSize*1024*1024){
                $data['msg'] = "文件大小限制".$maxSize."M";
                return response()->json($data);
            }
        }else{
            $data['msg'] = $file->getErrorMessage();
            return response()->json($data);
        }

        $originName=$file->getClientOriginalName();
        $path = $file->storeAs(
            'public/file/'.$type, date('YmdHis').rand(1000,9999).'.'.$ext
        );
        if($path){
            $data = [
                'code'  => 0,
                'msg'   => '上传成功',
                'data'  => ['path'=>$path,'originName'=>$originName]
            ];
        }else{
            $data['data'] = $file->getErrorMessage();
        }
        return response()->json($data);
    }
}
