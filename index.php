<?php include 'config.php'; ?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css" />
		<link rel="stylesheet" type="text/css" href="css/jpcs-social.css" />
		<link rel="stylesheet" type="text/css" href="css/jpcs.css" />
		<link rel="stylesheet" href="/js/fancybox/jquery.fancybox.css?v=2.1.4" />

		<meta name="viewport" content="width=800, user-scalable=no">

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
		<script src="/js/fancybox/jquery.fancybox.pack.js?v=2.1.4" type="text/javascript"></script>
	</head>
	<body>

		<a href="/"><img src="/img/jpcs-white.png" style="left: 140px; top: 140px; position: fixed; height: 80px;" /></a>
		<div id="img-row">
			<div class="spinner">
  <div class="rect1"></div>
  <div class="rect2"></div>
  <div class="rect3"></div>
  <div class="rect4"></div>
  <div class="rect5"></div>
</div>
		</div>
		

		<script type="text/javascript">


			var img = Array();
			var current_img = 0;
			<?php
				foreach (array_reverse(glob('img/photos/thumbs/*')) as $key => $value) {

					echo 'img.push(Array());' .PHP_EOL;
					echo 'img[img.length-1]["img"] = new Image();' . PHP_EOL;
					echo 'img[img.length-1]["img"].src="'.$value.'";' . PHP_EOL;

					$main = explode('/', $value);
					$main = $main[sizeof($main) - 1];


					$exif = exif_read_data($value);
					echo 'img[img.length-1]["exif"] = ' . json_encode($exif) . ';' . PHP_EOL;
					echo 'img[img.length-1]["exif"]["lens_name"] = "'.$exif["UndefinedTag:0xA434"].'";'.PHP_EOL;
					echo 'img[img.length-1]["exif"]["full_res"] = "'.$main.'";'.PHP_EOL;
				}
			?>


			document.onreadystatechange = function (e){
				if (document.readyState == 'complete')
				{
					$('.spinner').hide();
					var realwidth = 140;
					for (var i = 0; i < img.length; i++) {

						img[i]["img"].style.position = "absolute";
						img[i]["img"].style.height = 400;

						img[i]["img"].style.marginRight = 20;
						img[i]["img"].onclick = function () {console.log("clicked");};


						img[i]["img"].id = 'img'+i;

						var has_exif = false;
						var info_span = '<span>';
						if (img[i]["exif"].FocalLength)
						{
							has_exif = true;
							info_span +=    'Focal Length: '+(img[i]["exif"].FocalLength+"").slice(0,-2)+'mm<br />';
						}

						if (img[i]["exif"].ExposureTime)
						{
							var time = img[i]["exif"].ExposureTime;
							if (eval(time) > 1)
							{
								time = eval(time);
							}
							info_span +=    'Shutter Speed: '+time+' sec<br />';
						}

						if (img[i]["exif"].ISOSpeedRatings)
							info_span +=    'ISO: '+img[i]["exif"].ISOSpeedRatings+'<br />';

						if (img[i]["exif"].FNumber)
							info_span +=    'Aperture: f/'+eval(img[i]["exif"].FNumber) +'<br />';

						if (img[i]["exif"].Model)
							info_span += 	 img[i]["exif"].Model+"<br />";

						if (img[i]["exif"]["lens_name"])
							info_span += img[i]["exif"]["lens_name"];
						
						if (!has_exif)
							info_span += 'No EXIF Information Found :(';
						info_span += '</span>';

						$('#img-row').append('<div style="position: absolute; top:260px; height: 500px; width: 800px; left: '+realwidth+'px;" class="img'+i+'"><a class="fancybox" rel="group" href="img/photos/fullres/'+img[i]['exif']['full_res']+'">'+ img[i]["img"].outerHTML+'</a>'+info_span+'</div>');

						realwidth += 400.0/(img[i]["img"].height)*(img[i]["img"].width) + 20;

						$('#img-row').css('width', realwidth+'px');

					};
					$(".fancybox").fancybox({
						openEffect	: 'none',
						closeEffect	: 'none',
						arrows : false,
						nextClick : false,
						mousewheel : false,
						loop : false,
						keys : false
					});
				}
			}
			$(function() {

				$("body").mousewheel(function(event, delta) {

					this.scrollLeft -= (delta * 30);

					event.preventDefault();

				});

			});

		</script>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', '<?php echo GA_ACCOUNT; ?>']);
			_gaq.push(['_trackPageview']);

			(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>

	</body>
</html>
