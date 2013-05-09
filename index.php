<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Gifonacci</title>
	<meta property="og:title" content="Gifonacci" />
	<meta property="og:description" content="Générez un gif en pixelisant une image selon la suite de fibonacci" />
	<meta property="og:image" content="gif/animegif7.gif" />
	<meta property="og:url" content="dégradez une image selon la suite de fibonacci." />        
	<meta name="description" content="Générez un gif en pixelisant une image selon la suite de fibonacci">
	<link type="text/plain" rel="author" href="humans.txt" />
	<link rel="stylesheet" type="text/css" href="css.css">
	<style type="text/css">body{padding: 89px;}</style>
	
</head>
<body>
<h1>Gifonacci: dégradez une image selon la suite de fibonacci.</h1>
<?php
$items=scandir('gif');

// print_r($items);
foreach ($items as $key => $value) {
	if ($value != "." && $value!="..") {
		echo "<img src='gif/".$value."' alt='Fibonagif by vandy vincent'>";
	}
	if ($key=='4') {
		echo "<iframe src=\"DivisionRaster.php\"></iframe>";
	}
	elseif ($key=='8') {
		echo "<div class='twit'><a href=\"https://twitter.com/share\" class=\"twitter-share-button\" data-via='vandyvincent' data-url='http://vincentvandy.be/gifonacci' data-text='Je viens de créer un gif animé selon la suite de fibonacci' data-size='large' data-count='vertical' data-hashtags='gif' data-lang=\"fr\">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"https://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script></div>";
	}
}
?>
</body>
</html>

