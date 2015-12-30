<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="/public/css/metro.css" rel="stylesheet">
    <link href="/public/css/metro-icons.css" rel="stylesheet">
	
	<script src="/public/script/jquery-2.1.4.min.js"></script>
    <script src="/public/script/metro.js"></script>
	<script src="/public/script/public.js"></script>
	<title>快件签收演示页面</title>
	<script>
		$(document).ready( function(){
			//function checkOrder(){
			$("#userid").keyup(function(){
				var userid = $("#userid").prop("value");
				if(userid.length<=6)return false;
					$.ajax({
						type: "post",
						url: "/index.php/import/getUncheckList",
						data: {"usrId":userid},
						dataType: "json",
						success:
							function(data){
								//data=eval('('+data+')');
								loadInfo(data);
							}
					});
			});
			var userid = $("#userid").prop("value");
			if(userid.length<=6)return false;
				$.ajax({
					type: "post",
					url: "/index.php/import/getUncheckList",
					data: {"usrId":userid},
					dataType: "json",
					success:
						function(data){
							//data=eval('('+data+')');
							loadInfo(data);
						}
				});
		});
	</script>
	<script>
		function loadInfo(data) {
	        $("#import").html("");//清空info内容
			var json = eval('('+data+')');
			$.each(json.result, function(i, item) {
				$("#import").append(
						"<tr></tr>"+
						"<tr>"+
							"<td  style='text-align: center;'>"+
								"<label class='input-control checkbox'>"+
									"<input type='checkbox' class='uncheck' id='check_" + i + "'"+" value='"+item.orderid+"'>"+
									"<span class='check'></span>"+
									"<span class='caption'></span>"+
								"</label>"+
							"</td>"+ 
							"<td>" + item.orderid + "</td>"+
							"<td>" + item.importtime + "</td>"+
							"<td>" + item.positionid +"</td>"+
						"/<tr>");
			});
		}
	</script>
	<script>
		function checkPost(){
			var list= new Array();
			var param=document.getElementsByClassName('uncheck');
			$.each(param, function(i, item) {
				if(item.checked==true){
					list.push(item.value);
				}
			});
			if(list.length==0)return false;
			$.ajax({
				type: "post",
				url: "/index.php/import/checkList",
				data: {'checkOrder':list,'usrId':$("#userid").prop("value")},
				dataType: "json",
				success:
					function(data){
							var json = eval('('+data+')');
							if(json.status==1)
								location.reload();
					}
			});
		}
		
	</script>
</head>
<body>
<div class="padding20" style="width:40%;">
	<div class="input-control text full-size" data-role="input">
		<label for="userid">userid</label>
		<input type="text" name ="usrId" id="userid"  value="">
		<button type="button" class="button" onclick="checkPost()">取件</button>
	</div>
	<table class="table border bordered">
		<th>未收取快件单</th>
		<tr>
			<td  style="text-align: center;"><label class="input-control checkbox small-check">
				<input type="checkbox" disabled>
				<span class="check"></span>
				<span class="caption"></span>
                </label>
			</td>
			<td>订单号</td>
			<td>录入时间</td>
			<td>库存位置</td>
		</tr>
		<tbody id="import">
			<tr></tr>
		</tbody>
	</table>
</div>
</body>
</html>