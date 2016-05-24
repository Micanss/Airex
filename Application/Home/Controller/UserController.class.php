<?php 
namespace Home\Controller;
use Home\Controller\BaseController;

/**
* 用户控制器
*/
class UserController extends BaseController
{	
	public function index(){
		if (checkLogin()) {
			$this->redirect("login",0);
		}
		$this->redirect("userInfo",0);
	}

	public function login(){
		$this->display();
	}

	public function register(){
		$this->display();
	}

	public function userInfo(){
		$this->show('hello world');
	}
}