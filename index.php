<?php require_once 'youtube.php'; ?>
<?php 
$youtubeChannelListIds = array(
		"UCQSNL5GqRAWLBuIMB6tIIbg",//ROXY
		"UCblfuW_4rakIf2h6aqANefA" //REDBULL
);
$numVideos = 4;
$shuffleVideos = true;
$youtube = new Youtube($youtubeChannelListIds);
$videos = $youtube->getVideos($numVideos, $shuffleVideos);
//var_dump($videos);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Show random videos from youtube channels</title>
</head>
<body>
<ul>
	<?php foreach ($videos as $video_id) {?>
	<li><a
		href="http://www.youtube.com/embed/<?php echo $video_id; ?>"
		title="Click to see video"> <img
			src="http://i.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg"
			alt="http://i.ytimg.com/vi/<?php echo $video_id; ?>/0.jpg" />
	</a></li>
	<?php } ?>
</ul>
</body>
</html>