<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{

    protected $casts=[
        'register_channels'=>'json',
        'register_platforms'=>'json',
        'apply_loans'=>'json',
        'not_apply_loans'=>'json',
        'last_login_platforms'=>'json',
        'last_apply_loans'=>'json',
    ];

    protected $fillable=['name','register_at_type','register_at_abstract_start','register_at_abstract_end','register_at_relative_num',
        'register_at_relative_unit','register_at_relative_type','register_channels','register_platforms','all_login_day_start',
        'all_login_day_end','all_apply_num_start','all_apply_num_end','apply_loans','not_apply_loans','last_active_at_type',
        'last_active_at_abstract_start','last_active_at_abstract_end','last_active_at_relative_num','last_active_at_relative_unit',
        'last_active_at_relative_type','last_login_platforms','last_apply_loans','last_apply_loan_at_type','last_apply_loan_at_abstract_start',
        'last_apply_loan_at_abstract_end','last_apply_loan_at_relative_num','last_apply_loan_at_relative_unit','last_apply_loan_at_relative_type'];



    public function snapshot(){

        return $this->hasMany(UserModelSnapshot::class,'user_model_id','id');
    }


    //生成快照
    public function createSnapshot($type){ //type:1=>新增模型,2=>修改模型,3=>刷新模型,4=>凌晨3点定时任务
        $member=$this->getMember();
        UserModelSnapshot::create([
            'user_model_id'=>$this->id,
            'refresh_type'=>$type,
            'client_user_ids'=>$member->pluck('id')->all(),
            'client_user_num'=>$member->count(),
            'config'=>$this->select()->where('id',$this->id)->get()->toArray(),
            'created_at'=>$type!=4?time():date('Y-m-d 03:00:00',time()),
            'updated_at'=>$type!=4?time():date('Y-m-d 03:00:00',time())
        ]);
        return true;
    }


    //计算快照对应的注册用户
    public function getMember(){


        $query=Member::select('id','phone');
//        dd($this);
        //注册时间
        if($this->register_at_type==1){
            $query->where('created_at','>=',$this->register_at_abstract_start)
                ->where('created_at','<=',$this->register_at_abstract_end);
        }
        if($this->register_at_type==2){
            $day=1;
            switch ($this->register_at_relative_unit){
                case 'day':$day;break;
                case 'week':$day=$day*7;break;
                case 'month':$day=$day*30;break;
                case 'year':$day=$day*365;break;
                default:$day;
            }
            $all_day=intval($this->register_at_relative_num)*$day;
            if($this->register_at_relative_type==1){ //以前
                $query->where('created_at','<=',(time()-$all_day*24*3600));
            }else{ //以内
                $query->where('created_at','>=',(time()-$all_day*24*3600));
            }
        }
        //注册渠道
        if($this->register_channels[0]){
            $query->whereIn('channel_code',explode(',',$this->register_channels[0]));
        }


        //注册平台
        if($this->register_platforms[0]){
            $query->whereIn('platform_register',explode(',',$this->register_platforms[0]));
        }

        //累计登陆天数
        if($this->all_login_day_start){
            $query->where('login_count','>=',$this->all_login_day_start);
        }
        if($this->all_login_day_end){
            $query->where('login_count','<=',$this->all_login_day_end);
        }
        //累计申请数
        if($all_apply_num_start=$this->all_apply_num_start){
            $query->whereHas('applies',function ($query) use ($all_apply_num_start){
                $query->select(DB::raw('count(id),mid'))->groupBy('mid')->havingRaw("count(id) >= $all_apply_num_start");
            });
        }
        if($all_apply_num_end=$this->all_apply_num_end){
            $query->whereHas('applies',function ($query) use ($all_apply_num_end){
                $query->select(DB::raw('count(id),mid'))->groupBy('mid')->havingRaw("count(id) <= $all_apply_num_end");
            });
        }
        //申请过的产品
        if($apply_loans=$this->apply_loans[0]){
            $query->whereHas('applies',function ($query) use ($apply_loans){
                $query->whereIn('product_id',explode(',',$apply_loans[0]));
            });
        }
        //未申请过的产品
        if($not_apply_loans=$this->not_apply_loans[0]){
            $query->whereHas('applies',function ($quyer) use ($not_apply_loans){
                $quyer->whereNotIn('product_id',explode(',',$not_apply_loans[0]));
            });
        }
        //最后活跃时间
        if($this->last_active_at_type==1){
            $query->where('updated_at','>=',$this->last_active_at_abstract_start)
                ->where('updated_at','<=',$this->last_active_at_abstract_end);
        }
        if($this->last_active_at_type==2){
            $day=1;
            switch ($this->last_active_at_relative_unit){
                case 'day': $day;break;
                case 'week': $day=$day*7;break;
                case 'month': $day=$day*30;break;
                case 'year': $day=$day*365;break;
                default: $day;
            }
            $all_day=intval($this->last_active_at_relative_num)*$day;
            if($this->last_active_at_relative_type==1){ //以前
                $query->where('updated_at','<=',(time()-$all_day*24*3600));
            }else{ //以内
                $query->where('updated_at','>=',(time()-$all_day*24*3600));
            }
        }
        //最后登陆平台
        if($this->last_login_platforms[0]){
            $query->whereIn('platform_login',explode(',',$this->last_login_platforms[0]));
        }
        //最后申请过的产品
        if($last_apply_loans=$this->last_apply_loans[0]){
            $query->whereHas('applies',function ($query) use ($last_apply_loans){
                $query->whereIn('product_id',explode(',',$last_apply_loans[0]))->orderBy('created_at','desc')->limit(1);
            });
        }
        //最后申请产品时间
        if($this->last_apply_loan_at_type==1){
            $last_apply_loan_at_abstract_start=$this->last_apply_loan_at_abstract_start;
            $last_apply_loan_at_abstract_end=$this->last_apply_loan_at_abstract_end;
            $query->whereHas('applies',function ($query) use ($last_apply_loan_at_abstract_start,$last_apply_loan_at_abstract_end){
                $query->where('created_at','>=',$last_apply_loan_at_abstract_start)
                    ->where('created_at','<=',$last_apply_loan_at_abstract_end)
                    ->orderBy('created_at','desc')->limit(1);
            });
        }
        if($this->last_apply_loan_at_type==2){
            $day=1;
            switch ($this->last_apply_loan_at_relative_unit){
                case 'day': $day;break;
                case 'week': $day=$day*7;break;
                case 'month': $day=$day*30;break;
                case 'year': $day=$day*365;break;
                default: $day;
            }
            $all_day=intval($this->last_apply_loan_at_relative_num)*$day;
            if($this->last_apply_loan_at_relative_type==1){ //以前
                $query->whereHas('applies',function ($query) use ($all_day){
                    $query->where('created_at','<=',(time()-$all_day*24*3600))->orderBy('created_at','desc')->limit(1);
                });
            }else{ //以内
                $query->whereHas('applies',function ($query) use ($all_day){
                    $query->where('created_at','>=',(time()-$all_day*24*3600))->orderBy('created_at','desc')->limit(1);
                });
            }
        }
        $clientUsers=$query->get();
        return $clientUsers;
    }
}
