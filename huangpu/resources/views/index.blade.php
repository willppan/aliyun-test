<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>广州市黄埔区 广州开发区2020年公开招聘政府雇员 管理后台</title>
	<style>
		html{
			background-color: white;
		}
		.top{
			background: rgb(57,117,222);
			width: 100%;
		}
		
		.banner{
			padding: 10px 25%;
			margin: 0 auto;
		}
		*{
			margin: 0;
			padding: 0;
		}
		.mid{
			padding: 20px 20%;
			min-height: 500px
		}
		tr{
			border:1px solid #578ae3;
		}
		td{
			font-size: 13px;
			padding: 2px 15px;
			/*font-weight: bold;*/
			border: 1px solid #578ae3;
			text-align: center;
		}
		th{
			min-width: 100px;
			font-size: 14px;
			padding: 2px 15px;
			background-color: #578ae3;
			border: 1px solid #578ae3;
			text-align: center;
		}
		select {
			/*Chrome和Firefox里面的边框是不一样的，所以复写了一下*/
			border: solid 1px #b5b5b5;
			border-radius: 5px;

			/*很关键：将默认的select选择框样式清除*/
			appearance:none;
			-moz-appearance:none;
			-webkit-appearance:none;

			/*在选择框的最右侧中间显示小箭头图片*/
			background-size: 15px;
			background-repeat: no-repeat;
			background-position: right center;
			background-attachment:scroll;


			/*为下拉小箭头留出一点位置，避免被文字覆盖*/
			padding:5px 18px 5px 15px;
		}

	</style>
</head>
<body>
		<div class="top">
			<div class="banner">
				<p style="width: 100%;text-align: center;color: white;font-size: 24px">广州市黄埔区 广州开发区2020年公开招聘政府雇员 </p>
				<p style="width: 100%;text-align: center;color: white;font-size: 24px">管理后台</p>
			</div>
		</div>

		<div class="mid">
			<p>网站总计访问量： <span id="total_visit"></span></p>
			<div>
				<div style="width: 100%;text-align: left;margin-top: 30px;position: relative;">
					<p style="color: #b5b5b5;font-size: 14px;padding-left: 5px;position: absolute;left: 0px;top: -23px">单位名称</p>
					<select id="company">
						<option value="">--请选择单位名称--</option>
						<option>中共广州市黄埔区委办公室、中共广州开发区工作委员会办公室、广州开发区管委会办公室</option>
						<option>广州市黄埔区信访局</option>
						<option>广州市黄埔区人才交流服务中心、广州开发区人才交流服务中心</option>
						<option>黄埔区委组织部、广州开发区党工委组织部</option>
						<option>广州市黄埔区工业和信息化局</option>
						<option>广州开发区国有资产监督管理局</option>
						<option>广州开发区行政服务管理中心 广州市黄埔区政务服务中心</option>
						<option>中共广州市黄埔区纪律检查委员会、中共广州开发区纪律检查工作委员会、黄埔区监察委</option>
						<option>广州开发区金融工作局</option>
						<option>广州市黄埔区科学技术局</option>
						<option>广州开发区黄埔临港经济区管理委员会</option>
						<option>中国国际贸易促进委员会广州市黄埔区委员会</option>
						<option>广州市黄埔区商务局（广州开发区商务局）</option>
						<option>黄埔区人大常委会办公室</option>
						<option>广州开发区营商环境改革局</option>
						<option>广州开发区政策研究室</option>
						<option>广州市黄埔区统计调查队</option>
						<option>广州市黄埔区农畜牧业管理综合执法大队</option>
						<option>中新广州知识城开发建设办公室</option>
						<option>广州市黄埔区住房和城乡建设局</option>
						<option>广州市黄埔区建设工程质量安全监督站</option>
						<option>广州开发区房地产管理所</option>
						<option>广州市黄埔区城市管理和综合执法局</option>
						<option>广州市黄埔区卫生健康局</option>
					</select>
				</div>

				<div style="width: 100%;text-align: left;margin-top: 30px;position: relative;">
					<div style="float: left;position: relative;margin-right: 25px">
						<p style="color: #b5b5b5;font-size: 14px;padding-left: 5px;position: absolute;left: 0px;top: -23px">预约日期</p>
						<select id="date">
							<option value="">--请选择预约日期--</option>
							<option>9月2日</option>
							<option>9月3日</option>
							<option>9月4日</option>
						</select>
					</div>

					<div style="float: left;position: relative;">
						<p style="color: #b5b5b5;font-size: 14px;padding-left: 5px;position: absolute;left: 0px;top: -23px">预约场次</p>
						<select id="term">
							<option value="">--请选择预约场次--</option>
							<option>上午9:00-11:30</option>
							<option>下午14:00-17:00</option>
						</select>
					</div>


					<div style="text-align: center;margin-top:40px;">
						<span id="btn" style="padding: 6px 20px;background-color: #3c76e1;color:white;border-radius: 5px;">搜索</span>
						<span id="exbtn" style="padding: 6px 20px;background-color: #3c76e1;color:white;border-radius: 5px;margin-left: 30px;">导出列表</span>
					</div>


				</div>
			</div>
			<div style="clear: both"></div>
			<div>
				<table id="data" style="border-collapse:collapse;border:1px solid #578ae3;margin-top: 30px;width: 100%">

				</table>
			</div>
		</div>
		<div style="margin-top:100px;width: 100%;text-align: center;">
			<p class="ziti">Copyright © 2006-2020 Liepin campus. All Rights Reserved.</p>
            <p class="ziti">猎聘校园 版权所有</p>
		</div>
</body>
<script src="https://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
	var count_url = "{{url('count')}}";
	var list_url = "{{url('list')}}";
	var export_url = "{{url('export')}}";
	var success_url = "{{url('login')}}";

	$(function(){

		$.ajax({
            type: 'get',
            url: count_url,
            data: JSON.stringify(),
            xhrFields: {
       			withCredentials: false    // 前端设置是否带cookie
		    },
            contentType: "application/json;charset=utf-8",
            dataType:'json',
            success: function(res){
                if(res.code == 0){
                	$('#total_visit').html(res.data.num);
                }else{
					alert('用户未登录！');
					window.location.href=success_url
				}
            }
        });


		$.ajax({
			type: 'get',
			url: list_url,
			data: JSON.stringify(),
			xhrFields: {
				withCredentials: false    // 前端设置是否带cookie
			},
			contentType: "application/json;charset=utf-8",
			dataType:'json',
			success: function(res){
				if(res.code == 0){
					var table_data = '<tr><th>姓名</th><th>手机号</th><th>身份证</th><th>单位名称</th><th>预约日期</th><th>预约场次</th></tr>';
					$.each(res.data,function(k,v){
						table_data += '<tr><td>'+v.name+'</td><td>'+v.phone+'</td><td>'+v.id_card+'</td><td>'+v.company+'</td><td>'+v.date+'</td><td>'+v.term+'</td></tr>';
					});
					$('#data').html(table_data);
				}else{
					alert('用户未登录！');
					window.location.href=success_url
				}
			}
		});
	});
	$('#btn').on('click', function() {
		var data = {
			'company':$('#company').val(),
			'date':$('#date').val(),
			'term':$('#term').val(),
		};
		$.ajax({
			type: 'get',
			url: list_url,
			data: data,
			xhrFields: {
				withCredentials: false    // 前端设置是否带cookie
			},
			contentType: "application/json;charset=utf-8",
			dataType:'json',
			success: function(res){
				if(res.code == 0){
					var table_data = '<tr><th>姓名</th><th>手机号</th><th>身份证</th><th>单位名称</th><th>预约日期</th><th>预约场次</th></tr>';
					$.each(res.data,function(k,v){
						table_data += '<tr><td>'+v.name+'</td><td>'+v.phone+'</td><td>'+v.id_card+'</td><td>'+v.company+'</td><td>'+v.date+'</td><td>'+v.term+'</td></tr>';
					});
					$('#data').html(table_data);
				}else{
					alert('用户未登录！');
					window.location.href=success_url
				}
			}
		});
	});

	$('#exbtn').on('click', function() {
		company = $('#company').val();
		date = $('#date').val();
		term = $('#term').val();
		window.location.href=export_url+'?company='+company+'&date='+date+'&term='+term;
	});


</script>
</html>




