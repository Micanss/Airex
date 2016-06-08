<?php 
namespace Home\Controller;

use Home\Controller\BaseController;
// use Home\Model\FactoryModel;
/**
* 主题控制器
*/
class TopicController extends BaseController
{
	
	public $Topic;
	function __construct()
	{
		parent::__construct();
		if (!checkLogin()) {
			$this->redirect("User/login",'',0);
		}
		$this->Topic = D('Topic');
	}

	public function index(){
		$this->redirect("Index/index",0);
	}

	/**
	 * 发布新主题
	 */
	public function add(){
		if (IS_POST) {
			$data['title'] = I('post.title','','trim');
			$data['content'] = I('post.content','','trim');
			$data['node_id'] = I('post.node_id','','intval');
			$data['cat_id'] = D('Node')->getCatIdByNodeId($data['node_id']);
			$data['uid'] = session('uid');
			if ($this->Topic->addTopic($data)) {
				$this->success('发布主题成功');
			}else{
				$this->error('发布新主题失败,请稍后重试');
			}
		}else{
			$Node = D('Node');
			$nodes = $Node->getAllNodes();
			$hotNodes = $Node->getHotNodes();
			$this->assign('nodes',$nodes);
			$this->assign('hotNodes',$hotNodes);
			$this->display('new');
		}
	}

	/**
	 * 主题详情
	 * @return [type] [description]
	 */
	public function detail(){
		$tid = I('get.tid','','intval');
		if (!$this->Topic->checkTid($tid)) {
			$this->error('传输参数错误');
		}
		$topicInfo = $this->Topic->getDataById($tid);		//根据tid获取详情
		$commentInfo = $this->Topic->getCommentById($tid);	//根据tid获取评论
		$data = D('Index')->getUserInfo();			//获取登陆用户信息
		$this->assign('topicInfo',$topicInfo);
		$this->assign('commentInfo',$commentInfo);
		$this->assign('data',$data);
		$this->display();
		//var_dump($topicInfo);
	}

	/**
	 * 追加主题内容
	 * @return [type] [description]
	 */
	public function append(){
		if (IS_POST) {
			$content = I('post.append','','trim') == '' ?
												 $this->error('追加信息不能为空') :
												 I('post.append','','trim');
			$tid = I('post.tid','','intval');
			if (!$this->Topic->checkTid($tid)) {
				$this->error('不要修改tid值');
			}
			if (!$this->Topic->appendContent($tid,$content)) {
				$this->error($this->Topic->getError());
			}
		}else{
			$this->display();
		}
	}

}