<?php
namespace Home\Controller;
use Think\Controller;
class GetController extends Controller {
	/*
	*�˿���������ajax��ȡ�������͵�����
	*��������֤��Ϣ���ڵ��������
	*��������ѭgetXXX
	*/
	/*sdas
	*��ȡ�û�����
	*�������:@param token�����ƣ�
	*����ֵ@return response��������Ϣ��ʾ����status�������жϱ��룩��name���û����ƣ�
	*˵��:0:���ݴ���ʧ�ܣ�1:�û����Ʒ��سɹ���2:�û����Ʒ���ʧ��
	*/
	public function getUsrName(){
		$token=I('post.token');
		if(isThisTokenL($token)){
			$map['Id'] = getTokenKey($token);
			$usrs = M('usr');
			$res=array(response=>"���ݴ���ʧ��,����ϵ����Ա�Խ�����⡣�������:0��",status=>"0");
			if($usrs->create($usr_info)){
				$list=$usrs->where($map)->find();
				$res=array(response=>$map['Id'],status=>"1",name=>$list['name']);
			}
		}else{
			//$this->redirect("/login/login");
		}
		$this->ajaxReturn(json_encode($res),'JSON');
	}
	/*
	*��ȡ�û����ʼ�����
	*�������:@param token�����ƣ�
	*����ֵ@return response��������Ϣ��ʾ����status�������жϱ�s�룩��checkedCount��uncheckedCount
	*/
	public function getOrderNumber(){
		$token=I('post.token');
		if(isThisTokenL($token)){
			$map['usrId'] = getTokenKey($token);
			$map['haveSAR'] = "0";
			$orders = M('orders');
			$uncheckedCount=$orders->where($map)->select();
			$map['haveSAR'] = "1";
			$checkedCount=$orders->field(array('orderId','orderInfo','exportTime','postorId'))->where($map)->select();
			$res=array(response=>"�û��ǳ�",status=>"1",checkedCount=>count($checkedCount),uncheckedCount=>count($uncheckedCount));
		}else{
			//$this->redirect("/login/login");
		}
		$this->ajaxReturn(json_encode($res),'JSON');
	}
	/*
	*��ȡ��δ�ռ��б�
	*�������:@param int page @param string token
	*����ֵ@return array orders
	*/
	public function getUnchecked(){
		$token=I('post.token');
		$res=$token;
		if(isThisTokenL($token)){
			$map['usrId'] = getTokenKey($token);
			$map['haveSAR'] = "0";
			$orders = M('orders');
			$orderlist=$orders->field(array('orderId','orderInfo','positionId','importTime','postorId'))->where($map)->select();
			$res=array(response=>"�û��ǳ�",status=>"1",orders=>$orderlist);
		}else{
			//$this->redirect("/login/login");
		}
		$this->ajaxReturn(json_encode($res),'JSON');
	}
	/*
	*��ȡ�Ѿ��ռ��б�
	*�������:@param int page @param string token
	*����ֵ@return array orders
	*/
	public function getChecked(){
		$token=I('post.token');
		$res=$token;
		if(isThisTokenL($token)){
			$map['usrId'] = getTokenKey($token);
			$map['haveSAR'] = "1";
			$orders = M('orders');
			$orderlist=$orders->where($map)->select();
			$res=array(response=>"�û��ǳ�",status=>"1",orders=>$orderlist);
		}else{
			//$this->redirect("/login/login");
		}
		$this->ajaxReturn(json_encode($res),'JSON');
	}
	/*
	*��ȡload��ҳ��
	*�������:@param page
	*����ֵ@return html
	*/
	public function load(){
		$page=I('get.page');
		$this->display($page);
	}
	

}