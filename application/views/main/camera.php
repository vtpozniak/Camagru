<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<div class="w3-main w3-padding-large" style="margin-left:40%">
	<span class="w3-button w3-top w3-white w3-xxlarge w3-text-grey w3-hover-text-black" style="width:auto;right:0;" onclick="openNav()"><i class="fa fa-bars"></i></span>
</div>
<body class="w3-theme-l5">
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
	<div class="w3-row">
		<div class="w3-col m12">
				<div class="w3-row-padding" id="portfolio">
				<hr class="w3-opacity">
				<div class="w3-row-padding" style="margin:0 16px">
					<div class="w3-third">
						<video style="display: none" id="video" width="640" height="480" autoplay ></video>
						<canvas style="margin-left: 300px;" id="canvas" width="640" height="480"></canvas>
						<button class="btn btn-primary" style="width: 640px;height: 50px;margin-left: 300px;" id="snap">POST</button>
						<a href="/camera" class="btn btn-primary" style="width: 640px;height: 30px;margin-left: 300px;" id="snap">RESET</a>
						<img src="" id="imgs" alt="">
						<form style="display: none" method="POST" id="photoPublic" action="/photo/new">
							<input type="text" name="photo" id="newPhoto">
						</form>
						<script type="text/javascript">
							var video = document.getElementById('video');
							var imgs = document.getElementById('imgs');
							if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
								navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
									video.srcObject = stream;
									video.play();
								});
							}
							var canvas = document.getElementById('canvas');
							var context = canvas.getContext('2d');
							var video = document.getElementById('video');
							var imges = new Image();
							var c_width = canvas.offsetWidth;
							var c_height = canvas.offsetHeight;
							imges.src = "/public/images/stic2.png";
							var stic = [
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							{"startX": c_width/2, "startY": c_height/2, "width": 100, "height": 100,"move": 1, "img": new Image(), "activ": 0},
							];
							setInterval(function() {
								context.clearRect(0, 0, 640, 480);
								context.drawImage(video, 0, 0, 640, 480);
								stic.forEach(elem => {
									context.drawImage(elem.img, elem.startX - (elem.width / 2), elem.startY - (elem.height / 2), elem.width, elem.height);
								})
							});
							canvas.onclick = function(evt){
								stic.forEach(elem => {
									if (elem.move == 1)
									{
										elem.move = 0;
									}
									if (elem.activ == 1)
									{
										elem.move = 1;
									}

								})
							}
							canvas.onmousemove = function(evt) {
								stic.forEach(elem => {
									if (elem.move == 1)
									{
										elem.startY = evt.pageY - canvas.offsetTop;
										elem.startX = evt.pageX - canvas.offsetLeft;
									}

								})
							};
							canvas.onmousewheel = function(evt){
								if (evt.deltaY < 0){
								stic.forEach(elem => {
									if (elem.move == 1)
									{
										elem.width /= 1.05;
										elem.height /= 1.05;
									}

								})
								}
									
								else{
								stic.forEach(elem => {
									if (elem.move == 1)
									{
										elem.width *= 1.05;
										elem.height *= 1.05;
									}

								})

								}
							}
							function onClick(id) {
								stic[id].img.src = `/public/images/stic${id}.png`;
								stic[id].move = 1;
							};
								document.getElementById("snap").addEventListener("click", function() {
								if (video.paused == true)
								{
									video.play();
								}
								else
								{
									video.pause();
								}
								document.getElementById("newPhoto").value = canvas.toDataURL();
								document.getElementById("photoPublic").submit();
							});
						</script>

				</div>
				<div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
					<span class="w3-button w3-black w3-xlarge w3-display-topright">×</span>
					<div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
						<img id="img01" class="w3-image">
						<p id="caption"></p>
					</div>
				</div>
				<div class="w3-col"; style="margin-left: 10% ">
				<img src="/public/images/stic0.png" style="width:100px" onclick="onClick(0)" alt="">
					<img src="/public/images/stic1.png" style="width:100px" onclick="onClick(1)" alt="">
					<img src="/public/images/stic2.png" style="width:100px" onclick="onClick(2)" alt="">
					<img src="/public/images/stic3.png" style="width:100px" onclick="onClick(3)" alt="">
					<img src="/public/images/stic4.png" style="width:100px" onclick="onClick(4)" alt="">
					<img src="/public/images/stic5.png" style="width:100px" onclick="onClick(5)" alt="">
					<img src="/public/images/stic6.png" style="width:100px" onclick="onClick(6)" alt="">
					<img src="/public/images/stic7.png" style="width:100px" onclick="onClick(7)" alt="">
					<img src="/public/images/stic8.png" style="width:100px" onclick="onClick(8)" alt="">
				</div>
			</div>
		</div>
	</div>
</div>
</div>

</body>