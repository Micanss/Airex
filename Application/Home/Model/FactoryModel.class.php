<?php 
namespace Home\Model;

/**
* 工厂模型
*/
class FactoryModel
{
	private static $userModel;		//User模型
	private static $topicModel;		//Topic模型

	static function createUserModel(){
		if (!self::$userModel) {
			self::$userModel = new \Home\Model\UserModel();
		}
		return self::$userModel;
	}

	static function createTopicModel(){
		if (!self::$topicModel) {
			self::$topicModel = new \Home\Model\TopicModel();
		}
		return self::$topicModel;
	}
}