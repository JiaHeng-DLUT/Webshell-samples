<?php
namespace  App\Traits;
use Excel;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/27
 * Time: 15:22
 */
trait CustomExcel
{
    /**
     * @param $title
     * @param $cellData
     * 数据导出
     */
    public function excelExport($title,$cellData){
        ini_set('memory_limit','500M');
        set_time_limit(0);//设置超时限制为0分钟
        if($cellData)
        {
            Excel::create($title,function($excel) use ($cellData){
                $excel->sheet('score', function($sheet) use ($cellData){
                    $sheet->rows($cellData);
                });
            })->export('xls');
            die;
        }
    }

    /**
     * @param $file
     * @return string
     * excel 数据导入
     */
    public function getExcelData($request){
        if($request->file) {
            $file = $_FILES;
            $excel_file_path = $file['file']['tmp_name'];
            $res = [];
            $mobile = '';
            Excel::load($excel_file_path, function ($reader) use (&$res) {
                $reader = $reader->getSheet(0);
                $res = $reader->toArray();
            });
            if ($res) {
                foreach ($res as $k => $item) {
                    if($k > 0) {
                        $mobile .= ',' . $item[1];
                    }
                }
            }
            return response()->json(['code'=>0,'data'=>trim($mobile,','),'message'=>'成功']);
        }else{
            return response()->json(['code'=>1,'message'=>'没有文件','data'=>'']);
        }
    }
}