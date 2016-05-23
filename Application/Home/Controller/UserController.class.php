<?php 
namespace Home\Controller;
use Home\Controller\BaseController;

/**
* 用户控制器
*/
class UserController extends BaseController
{
	/**
	 *
	 * 验证码生成
	 */
	public function captcha(){
		$Verify = new \Think\Verify();
		$Verify->fontSize = 30;
		$Verify->length   = 4;
		$Verify->useNoise = false;
		$Verify->entry();
	}


	public function login(){
		$this->display();
	}



	public function register(){

		$this->display();
	}
}