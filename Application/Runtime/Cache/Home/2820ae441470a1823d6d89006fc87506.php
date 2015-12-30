<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script src="/Public/script/jquery-2.1.4.min.js"></script>
<script>	
	function demo(){
		$("#pre").fadeOut();
		$("#demo").fadeIn(3000);
	}
	function hideDemo(){
		$("#demo").hide();
	}
	$(function(){
        $('.import').click(function(){
			var params = $("#importTable").serialize();
			$.post(
				"/index.php/import/va", 
				params,
				function(data){
					json = eval('('+data+')');
					if(json.status==1){
						window.location="/index.php/import/detail?orderId="+json.orderId;
					}else{
						alert('error');
					}
			});
		});
	});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>这是一个邮件录入的demo演示</title>
</head>
<body onload="hideDemo()">
<div id ="pre">
<h3>这是一个邮件录入的demo演示</h3>
<p>  在本个演示用，提交了对于录入阶段表单，该表单主要信息包括
	<p>
		<ol>
  			<li>快递员信息</li>
  				<ul>
 					<li>快递员编号</li>
 				</ul>
 			<li>包裹信息</li>
 				<ul>
 					<li>包裹编号</li>
 					<li>包裹信息</li>
 					<li>收件人姓名</li>
 					<li>收件人手机号码</li>
 				</ul>
 			<li>仓库信息</li>
 				<ul>
 					<li>仓库编号</li>
 				</ul>
	</ol>
</p>
<input value = "单击此处开始demo预演" type = "button" onClick="demo()">
</div>
<div id ="demo">
	<h3>这是一个递交表单，这里的开放action接口可以通过终端递交相同的request请求来获得数据</h3>
	<form id="importTable" type="post" onsubmit="return false" action="#">
		<table>
			
			<tr>
				<td>postor id</td><td><input name="postorId"></td>
			</tr>
			<tr>
				<td>ordeId</td><td><input name="orderId"></td>
			</tr>
			<tr>
				<td>usrPhoneNumber</td><td><input name="usrPhoneNumber"></td>
			</tr>
			<tr>
				<td>usrId</td><td><input name="usrId"></td>
			</tr>
			<tr>
				<td>usrName</td><td><input name="usrName"></td>
			</tr>
			<tr>
				<td>orderInfo</td><td><input name="orderInfo"></td>
			</tr>
			<tr>
				<td>positionId</td><td><input name="positionId"></td>
			</tr>
		</table>
		<div >
			<button class="import">录入</button>
		</div>
	</form>
</div>
</body>
</html>