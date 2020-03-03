<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="w3-main w3-padding-large">
<nav class="w3-sidebar w3-hide-medium w3-hide-small" style="width:40%">
	<div class="bgimg"></div>
</nav>
<nav class="w3-sidebar w3-black w3-animate-right w3-xxlarge" style="display:none;padding-top:150px;right:0;z-index:2" id="mySidebar">
	<a href="javascript:void(0)" onclick="closeNav()" class="w3-button w3-black w3-xxxlarge w3-display-topright" style="padding:0 10px;">
		<i class="fa fa-remove"></i>
	</a>
	<div class="w3-bar-block w3-center">
		<a href="" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">Home</a>
		<a href="http://127.0.0.1:8080/register" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">REGISTER</a>
		<a href="http://127.0.0.1:8080/login" class="w3-bar-item w3-button w3-text-grey w3-hover-black" onclick="closeNav()">LOGIN</a>
	</div>
</nav>
<div class="w3-main" style="margin-left:40%">
	<header class="w3-container w3-center" style="padding:128px 16px" id="home">
		<h1 class="camtxt"><b>CAMAGRU</b></h1>
	</header>
	<div class="w3-padding-32 w3-content" id="portfolio">
		<hr class="w3-opacity">
		<div class="w3-row-padding" style="margin:0 -16px">
			<div class="col-sm-12 d-flex flex-wrap " style="margin:10 -16px">
				<?php $len = ceil($photos[1][0]['post_count'] / 6); ?>	
				<?php foreach ($photos[0] as $value): ?>
				<div class="col-sm-6" >
					<div class="img-container">
						
					<img src="/<?php echo $value['photo'] ?>">
					</div>
					<form action="/comment/new" method="POST">
						<input class="text" type="text" name="comment" cols="30" row="10" placeholder="Comment" required=""></input>
						<button class="btn btn-primary" type="submit" name="id" value="<?php echo $value['id'] ?>">Comment</button>
					</form>
					<form action="/like/new" method="POST">
						<button class="btn btn-primary" style="width: 63px;height: 26px" type="submit" name="id" value="<?php echo $value['id'] ?>"><img src="../../public/images/like.png" style="width: 20px;height: 20px;"><?php echo $value['lileCount']?></button>
					</form>
					<hr>
					<div style="height: 50px; overflow: hidden auto;">
						<?php foreach ($value['comment'] as $v): ?>
						<p class="txt"><?php echo "{$v['user_name']} {$v['comment']} {$v['data']}" ?></p>
						<?php endforeach; ?>							
					</div>
				</div>
				<?php endforeach; ?>
			</div>
			<div class="col-sm-12" style="margin-top -12px;margin-left: 12px ">
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

