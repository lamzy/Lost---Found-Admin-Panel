<?php 
require_once "Mobile_Detect.php";
require_once "functions_front.php";
 $table="items";
 $from="0";
 $searchoption=' <ul class="dropdown-menu" role="menu" id="dropdownmenu">
                <li>
                  <a href="javascript:void(0)" data="name">姓名</a>
                </li>
                <li>
                  <a href="javascript:void(0)" data="num">卡号</a>
                </li>
                <li>
                  <a data="college" href="javascript:void(0)">学院</a>
                </li>
                <li>
                  <a data="contact" href="javascript:void(0)">联系方式</a>
                </li>
              </ul>';
 $detect=new Mobile_Detect();
if ($detect->
isMobile()) {
  jumpUrl("index.php");
  die();
 }
  
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
	<title>Lost & Found</title>
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/timeline_com.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>

	<?php require "nav.php"?>
	<div class="hold"></div>
	<div class="container-fluid">

		<div class="content">
			<article>
				<h3>电脑版建设中！</h3>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title">即将改变传统失物招领</p>
						</a>
						<p class="brief">
							<span class="text-green"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title">摒弃微信微博分散的信息</p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title">手机电脑统一样式，统一体验</p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title">失物与招领分开，方便查找</p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title">支持搜索功能</p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title">简单易用，友好的用户界面</p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title">深圳大学学生会 NewScript @lam</p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>

			</article>
			<article>
				<h3>敬请期待</h3>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title"></p>
						</a>
						<p class="brief">
							<span class="text-green"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-yello"></span>
					<aside>
						<a href="#">
							<p class="title"></p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-blue"></span>
					<aside>
						<a href="#">
							<p class="title"></p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-red"></span>
					<aside>
						<a href="#">
							<p class="title"></p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-purple"></span>
					<aside>
						<a href="#">
							<p class="title"></p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
				<section>
					<span class="point-time point-green"></span>
					<aside>
						<a href="#">
							<p class="title"></p>
						</a>
						<p class="brief">
							<span class="text-yellow"></span>
						</p>
					</aside>
				</section>
			</article>
		</div>

	</div>

	<hr />
	<footer class="footer">
		<p class="text-white">© 2015 深圳大学学生会 NewScript @lam @cm</p>
		<p class="pull-right">
			<a href="#" class="text-white">Back to top</a>
		</p>
	</footer>

	<script src="js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/front.js"></script>

</body>
</html>