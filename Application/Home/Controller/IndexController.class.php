<?php
namespace Home\Controller;

use Home\Controller\BaseController;
use Home\Model\FactoryModel;

class IndexController extends BaseController
{
    public function index(){
    	$Cate = FactoryModel::createCategoryModel();
    	$categorys = $Cate->getCategorys();
    	$catName = I('get.cat');
    	$nodes= $Cate->getNodeByCatName($catName);

    	// var_dump($categorys);
    	// var_dump($nodes);

        // $this->display();
    }
}