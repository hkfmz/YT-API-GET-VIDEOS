<?php
    $baseUrl = 'https://www.googleapis.com/youtube/v3/';
    // https://developers.google.com/youtube/v3/getting-started
    $apiKey = 'AIzaSyB_2_4yH8sz_WfBYt39hGgdFi5kLLJ8QtA';
    // If you don't know the channel ID see below
    $channelId = 'UC6xa4ATj7MiusIm3UgXTM0g';

    $params = [
        'id'=> $channelId,
        'part'=> 'contentDetails',
        'key'=> $apiKey
    ];
    $url = $baseUrl . 'channels?' . http_build_query($params);
    $json = json_decode(file_get_contents($url), true);

    $playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

    $params = [
        'part'=> 'snippet',
        'playlistId' => $playlist,
        'maxResults'=> '50',
        'key'=> $apiKey
    ];
    $url = $baseUrl . 'playlistItems?' . http_build_query($params);
    $json = json_decode(file_get_contents($url), true);

    $videos = [];
    foreach($json['items'] as $video)
        $videos[] = $video['snippet']['resourceId']['videoId'];

    while(isset($json['nextPageToken'])){
        $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
        $json = json_decode(file_get_contents($nextUrl), true);
        foreach($json['items'] as $video)
            $videos[] = $video['snippet']['resourceId']['videoId'];
    }
    // var_dump($videos);
    //https://www.youtube.com/watch?v=Y3k3ke1DoPM
    // echo json_encode($videos);

foreach ($videos as $video)
{
    echo "<a href='https://www.youtube.com/watch?v=".$video."' target='_blank'>https://www.youtube.com/watch?v=".$video."</a><br><br>";
}