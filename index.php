<?php include 'config.php'; ?>

<html>
	<head>
		<script type="text/javascript">
			// var _gaq = _gaq || [];
			// _gaq.push(['_setAccount', '<?php echo GA_ACCOUNT; ?>']);
			// _gaq.push(['_trackPageview']);

			// (function() {
			// var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			// ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			// var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			// })();
		</script>

		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="css/jpcs-social.css" />
		<link rel="stylesheet" type="text/css" href="css/jpcs.css" />

		
	</head>
	<body>
	
		<img src="img/jpcs_white.png" style="left: 140px; top: 140px; position: fixed; height: 80px;" />
		<div id="img-row"></div>

			
		

		<script type="text/javascript">
			

			var img = Array();
			var current_img = 0;
			<?php
				foreach (array_reverse(glob('img/photos/thumbs/*')) as $key => $value) {

					echo 'img.push(Array());' .PHP_EOL;
					echo 'img[img.length-1]["img"] = new Image();' . PHP_EOL;
					echo 'img[img.length-1]["img"].src="'.$value.'";' . PHP_EOL;
					echo 'img[img.length-1]["exif"] = ' . json_encode(exif_read_data($value)) . ';' . PHP_EOL;

				}
			?>
		
		
			document.onreadystatechange = function (e){
				if (document.readyState == 'complete')
				{
					var realwidth = 140;
					for (var i = 0; i < img.length; i++) {
						// img[i]["img"].style.left = realwidth;
						// img[i]["img"].style.top = 260;
						img[i]["img"].style.position = "absolute";
						img[i]["img"].style.height = 400;
						
						img[i]["img"].style.marginRight = 20;
						img[i]["img"].onclick = function () {console.log("clicked");};
						
						
						img[i]["img"].id = 'img'+i;
						document.getElementById('img-row').innerHTML += '<div style="position: absolute; top:260px; height: 500px; width: 800px; left: '+realwidth+'px;" class="img'+i+'">'+ img[i]["img"].outerHTML+'<span>Focal Length: '+img[i]["exif"].FocalLength+'<br />Shutter Speed: '+img[i]["exif"].ExposureTime+'<br />ISO: '+img[i]["exif"].ISOSpeedRatings+'<br />'+img[i]["exif"].Model+'</span></div>';
					
						realwidth += 400.0/(img[i]["img"].height)*(img[i]["img"].width) + 20;
						
					};
					console.log(img);
				}
			}

		</script>

	</body>
</html>