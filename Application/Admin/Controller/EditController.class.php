<?php
namespace Admin\Controller;
use Think\Controller;
class EditController extends BaseController {
	function logined(){
		$this->display(logined);
	}
	/*
	*@param where (必要属性) array 关键字段(eq){"0":{key:value}}
	*@param field (必要属性如果不提交则认为不查询任何) array 需要查询字段，类型为{"0":value,……}
	*@param from (必要属性) string 查询的表（后端检验）
	*@param pagination (必要属性) int 分页
	*@param page int 页码
	*@return list 
	*/
	function query(){
		$where=I("post.where");
		$field=I("post.field");
		$from=I("post.from");
		$page=I("post.page",1);
		$pagination=I("post.pagination",20);
		//设定查询内容
		foreach($where as $i){
			$map[$i["key"]] = $i["value"];
		}
		//初始化返回
		$returns=array();
		if(in_array($from,array("orders","positions","postor","usr"))){
			$returns=getDataByKeyWords($type,$map,$from,$pagination,$field,$page);
			$res=array(response=>"query",status=>"1","list"=>$returns["list"],page=>$page,maxPage=>$returns["max"]);
		}else{
			$res=array(response=>"fail",status=>"2");
		}
		$this->ajaxReturn(json_encode($res),'JSON');
	}
	/*
	* @param id (必要属性) int 
	* @param type (必要属性) string 操作类型 包括以下几种类型{update,delete,add}
	* @param field (如果为更新则是必要属性，填空则不操作任何字段) array 需要操作的字段，类型为{"0"=>{field,value},……}
	* @param from (必要属性) string 查询的类型（后端检验）
	*/
	function edit(){
		//有限判定是否为有效操作
		if(isset($type)){
			$where["id"]=I("post.id");
			$field=I("post.field");
			$from=I("post.from");
			$type=I("post.type");
			//设置查询对象
			foreach($type as $i){
				$data[$i["field"]] = $i["value"];
			}
			$model = M($table);
			$model->create($data);
			$res=array(response=>"操作完成");
			if($type="update"){
				//更新操作
				$model_result=$model->where($where)->save($data);
				
			}elseif($type="delete"){
				//输出操作
				$model_result=$model->delete($where["id"]);
				
			}elseif($type="add"){
				//添加操作
				$model_result=$model->add($data);
				
			}else{
				$res=array(response=>"unaccess edit",status=>"3");
			}
			$res["status"]=$model_result;
		}else{
			$res=array(response=>"unset type",status=>"2");
		}
		
		$this->ajaxReturn(json_encode($res),'JSON');
	}
	
}


