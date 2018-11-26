<?php
/*
*	get_youtube_embed returns embed code for a youtube video given its id.
*/
function youtube($youtube_video_id, $autoplay=false)
{
	$embed_code = "";
 
	if($autoplay)
		$embed_code = '<embed src="http://www.youtube.com/v/'.$youtube_video_id.'&rel=1&autoplay=1" pluginspage="http://adobe.com/go/getflashplayer" type="application/x-shockwave-flash" quality="high" width="320" height="180" bgcolor="#ffffff" loop="false"></embed>';
	else
		$embed_code = '<embed src="http://www.youtube.com/v/'.$youtube_video_id.'&rel=1" pluginspage="http://adobe.com/go/getflashplayer" type="application/x-shockwave-flash" quality="high" width="320" height="180" bgcolor="#ffffff" loop="false"></embed>';
	return $embed_code;
}
?>