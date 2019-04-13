<?php
namespace app\ajax\controller;

class User extends Base
{
     public function initialize()
    {

	    parent::initialize();
        // 下面防当前初始化内容
	 }
	//关注
    public function follow()
    {

      if($this->request->isAjax()){
  		if(!session('uid')){
         return error_json('请登录后操作！');
  		}	
       $uid  = $this->request->param('uid');
       if($uid == $this->user->uid){
         return error_json('不能关注自己！');
       }
      
       $data['follow_who']  = $uid;
       $data['who_follow']  = $this->user->uid;
       $data['create_time'] = time();
      
      $where['follow_who']  = $uid;
      $where['who_follow']  = $this->user->uid;
      $follow = model('follow')->infoData($where);
      if($follow){
          model('follow')->delData($where);
          return success_json('关注成功！');  
      }else{
          model('follow')->addData($data);
          return success_json('关注成功！');   
      }

      }
    }

 //点赞
     public function zan()
    {
    	 if($this->request->isAjax()){

         $id  = $this->request->param('id');
		if(!session('uid')){
           return error_json('请登录后操作！');
		}
		if(empty($id)){
           return error_json('评论不存在！');
		}
		$uid =  $this->user->uid;
       $map[] = ['type_id','=',intval($id)];
       $map[] = ['uid','=',$uid];
       $res = model('zan')->infoData($map);


       if(!empty($res)){
       $data['uid']  = $this->user->uid;
       $data['create_time'] = time();
       $data['type']    = 1; //评论点赞
       $data['type_id'] = intval($id); //评论id
       $data['status']   = 1;
       model('zan')->addData($data);
       model('article_comment')->where(['comment_id'=>intval($id)])->setInc('zan',1);
       return success_json('已点赞！','',1000);
       

      }else{
         $where['type_id'] = intval($id); //评论id
         $where['uid'] = $this->user->uid;
         model('zan')->delData($data);
         model('article_comment')->where(['comment_id'=>intval($id)])->setDec('zan',1);
         return success_json('已取消点赞！','',1001);
       
      }


     
     }
   
    }

//收藏
    public function collect()
    {
      if($this->request->isAjax()){
        $id  = $this->request->param('id');
  		if(!session('uid')){
        return error_json('请登录后操作！');
  		}
  		$id  = $this->request->param('id');
  		if(empty($id)){
        return error_json('文章不存在！');
  		}
  		$map['uid'] = $this->user->uid;
  		$map['article_id'] = intval($id);
  		$collect = model('collect')->infoData($map);
      if(!empty($collect)){
         $where['article_id']  = intval($id);
         $where['uid'] = $this->user->uid;
         model('Collect')->delData($where);
         return success_json('已取消收藏！','',1001);        
      }else{
         $data['uid'] = $this->user->uid;
         $data['article_id']  = intval($id);
         $data['create_time'] = time();
         model('Collect')->addData($data);
         return success_json('已收藏！','',1000);  
      }


       }
    }

      //评论
    public function comment()
    {
	   if($this->request->isAjax()){
	 
	
	      if(empty($this->user->uid)){
	         return  error_json('请登录后评论！');
	      }
	   
	      $param = $this->request->param();
	      if(empty($param['aid'])){
	       return    error_json('评论错误！');
	      }
         

	     if(empty($param['content'])){
	         return  success_json('请输入评论内容！');
	     }
	      //验证
	      

	      $data['article_id']  = intval($param['aid']);
          $data['pid']         = intval($param['pid']);
	      $data['content']     = $param['content'];

	      $data['nickname'] = $this->user->nickname; //登陆用户昵称
	      $data['uid']      = $this->user->uid; //登陆用户uid
	      $data['create_time'] = time();
	      $data['ip']       = get_client_ip();
	   
      //判断是否开启了审核
        if($this->settings['article']['comment_audit_status'] ==1){
          $data['status'] = 0;  //待审核
          $msg= '评论成功，等待审核后显示！';

        }else{
          $msg= '评论成功！';
          $data['status'] = 1;  //正常显示
        }   
	      model('articleComment')->addData($data);
	      //更新评论数量
	      $where['aid'] =  intval($param['aid']);

	      model('article')->where($where)->setInc('comment',1);
	      return success_json($msg);
	     }
    }
//


}
