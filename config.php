<?php
define("YOUTUBE_API_KEY", "PUT HERE YOUR API KEY");
define("API_CHANNEL_LIST", "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id={CHANNEL_ID}&key={YOUR_API_KEY}");
define("API_PLAYLISTITEMS_LIST", "https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId={PLAYLIST_ID}&key={YOUR_API_KEY}");