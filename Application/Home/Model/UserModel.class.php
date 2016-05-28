<?php
namespace Home\Model;

use Think\Model;

/**
 * 用户模型类.
 * Author:Patrick95 (lawcy@qq.com)
 * Date:2016/5/27
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 */
class UserModel extends Model{

    //自动验证注册表单
    protected $_validate = array(
        array('user_name','require','用户名不能为空',1),
        array('user_name','/^\w+$/','用户名不合法(只能包含英文、数字、下划线)',1),
        array('user_name','','用户名已被占用',1,'unique'),
        array('password','require','密码不能为空',1),
        array('email','require','Email不能为空',1),
        array('email','','Email已被占用',1,'unique'),
        array('email','email','Email格式不正确',1),
    );

    //AJAX检查用户名是否占用
    public function check_username($username){

        $data = $this->where("user_name='$username'")->find();
        if($data){
            $msg = array('occupied'=>1);
            return json_encode($msg);
        }else{
            $msg = array('occupied'=>0);
            return json_encode($msg);
        }

    }


    //AJAX检查邮箱是否占用
    public function check_email($email){

        $data = $this->where("email='$email'")->find();
        if($data){
            $msg = array('occupied'=>1);
            return json_encode($msg);
        }else{
            $msg = array('occupied'=>0);
            return json_encode($msg);
        }

    }


    //新增用户
    public function user_register($userinfo){
        $userinfo['password'] = $this->password_hasher($userinfo['password']); //用户密码加密
        if($this->create($userinfo)){
            if ($this->add()) {
                session('user',$userinfo['user_name']); //session 注册后进入已登录状态
                return true;
            }
        }

    }

    //用户登录 返回0没有此用户 返回1登录成功 返回2密码错误
    public function user_login($userinfo){
        $username = $userinfo['user_name'];
        $password = $this->password_hasher($userinfo['password']); //将密码加密 与数据库比对
        $data = $this->where('user_name = "'.$username.'"')->find();
        if($data){
            if($password == $data['password']){
                session('user',$data['user_name']); // 将已登录用户名加入SESSION
                return 1;
            }else{
                return 2;
            }
        }else{
            return 0;
        }
    }

    //用户密码加密函数
    public function password_hasher($password){
        //加密思路：原始密码->MD5(32)->sha1(40)->截取前32位
        return substr(sha1(md5($password)),0,32);
    }
	
}