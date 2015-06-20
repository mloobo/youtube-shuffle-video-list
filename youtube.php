<?php
require_once 'config.php';

class Youtube{
	/**
	 * YOUTUBE_API_KEY is stored in config.php
	 * @var string
	 */
	private $youtubeApiKey = YOUTUBE_API_KEY;
	private $channelList = array();
	private $numMinVideosReturn = 4;
	
	public function __construct($channelList){
		$this->channelList = $channelList;
	}
	
	private function __getApiCall($url){
		return file_get_contents($url);
	}
	
	private function __getApiCallJson($url){
		return json_decode($this->__getApiCall($url));
	}
	
	private function __getUrlChannelList($channelId){
		return str_replace(array("{CHANNEL_ID}", "{YOUR_API_KEY}"), array($channelId, $this->youtubeApiKey), API_CHANNEL_LIST);
	}
	
	private function __getUrlPlaylisitemsList($playListId){
		return str_replace(array("{PLAYLIST_ID}", "{YOUR_API_KEY}"), array($playListId, $this->youtubeApiKey), API_PLAYLISTITEMS_LIST);
	}
	
	public function getVideos($num=4, $shuffle=true){
		if ($num <= 0){
			$num = $this->numMinVideosReturn;
		}
		// Get the playlists ids
		$playLists = $this->getPlayListsFromChannelList($this->channelList);
		// Get the video ids from all playlists
		$videos = $this->getVideosFromPlayLists($playLists);
		// We shuffle the video list
		if ($shuffle){
			// Randomize
			shuffle($videos);
		}
		// Return the number of videos
		return array_slice($videos, 0, $num);
	}
	
	/**
	 * Returns the playlist ids from the channel list
	 * @param array $channelList array("channelid1", "channelid2")
	 * @return array<string>
	 */
	public function getPlayListsFromChannelList($channelList){
		$playlists = array();
		foreach ($channelList as $channelId){
			$playlists = array_merge($playlists, $this->getPlaylistsFromChannel($channelId));
		}
		return $playlists;
	}
	
	public function getPlaylistsFromChannel($channelId){
		// GET the JSON data for channelId
		$channelListResponse = $this->__getApiCallJson($this->__getUrlChannelList($channelId));
		$playlists = get_object_vars($channelListResponse->items[0]->contentDetails->relatedPlaylists);
		foreach ($playlists as $name => $value){
			$playListIds[] = $value;
		}
		return $playListIds;
	}
	
	public function getVideosFromPlayLists($playLists){
		$videoIds = array();
		foreach ($playLists as $playListId){
			$videoIds = array_merge($videoIds, $this->getVideosFromPlayList($playListId));
		}
		return $videoIds;
	}
	
	public function getVideosFromPlayList($playListId){
		$playlistItemListResponse = $this->__getApiCallJson($this->__getUrlPlaylisitemsList($playListId));
		$videoIds = array();
		foreach ($playlistItemListResponse->items as $item){
			$videoIds[] = $item->contentDetails->videoId; 
		}
		return $videoIds;
	}
	
	public function setChannelList($channelList){
		$this->channelList = $channelList;
	}
	
	public function setYoutubeApiKey($youtubeApiKey){
		$this->youtubeApiKey = $youtubeApiKe;
	}
}