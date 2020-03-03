<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<body class="w3-theme-l5">
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
	<a class="w3-bar-item w3-button w3-padding-large">My Profile</a>
</div>
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
	<div class="w3-row">
		<div class="w3-col m3">
			<div class="w3-card w3-round w3-white">
				<div class="w3-container ">
					<h4 class="w3-center namtxt"><?php echo ($_SESSION['users']['name']) ?></h4>
					<p class="w3-center"><img src="../../public/images/in8.jpg" type=file class="w3-circle" style="height:106px;width:146px" alt="Avatar"></p>
					<div class="download image">
						<form action="/post/new" method=post enctype="multipart/form-data">
							<input type=file name=upfile>
							<input type=submit name=upload value="Download imeg">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="w3-col m9 w3-padding-32 w3-content">
	 		<div class="w3-col m12">
				<div class="w3-card w3-round w3-white">
					<div class="w3-container w3-padding">
						<form>
							
						<p contenteditable="true" class="w3-border w3-padding"></p>
						</form>
						<button type="button" class="w3-button w3-theme"><i class="fa fa-pencil"></i>  Post</button>
					</div>
				</div>
			</div>
		
			<hr>
			<div class="col-sm-12 d-flex flex-wrap " style="margin:10 -16px">
				<?php 
				$len = ceil($photos[1][0]['post_count'] / 6); ?>	
				<?php foreach ($photos[0] as $value): ?>
				<div class="col-sm-6" >
					<div class="img-container">
					<img src="/<?php echo $value['photo']?>">
					</div>
					<button class="btn btn-primary" style="width: 63px;height: 26px" type="submit" name="id" value="<?php echo $value['id'] ?>"><img src="../../public/images/like.png" style="width: 20px;height: 20px;"><?php echo $value['lileCount']?></button>
						<div style="height: 50px; overflow: hidden auto;">
						<?php foreach ($value['comment'] as $v): ?>
						<p class="txt"><?php echo "{$v['user_name']} {$v['comment']} {$v['data']}" ?></p>
						<?php endforeach; ?>							
					</div>
					<hr>					
				</div>
				<?php endforeach; ?>

			</div>
			<div class="col-sm-12" style="margin-top -12px;">
				<nav>
				  <ul class="pagination">
				  <?php for($i = 1; $i <= $len; $i++){ ?>
				    <li><a href="?page=<?= $i ?>"><?= $i ?></a></li>
				  <?php } ?>
				  </ul>
				</nav>
			</div>
		</div>
	</div>
</div>
</body>

