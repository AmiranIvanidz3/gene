@extends('layouts.external.app')
@php
  $actual_video_id = $reel->video_id;
  $actual_reel_id = $reel->id;
// Used For Youtube Video Iframe --START--
function timeStringToSeconds($timeString) {
    $timeParts = explode(':', $timeString);

    $seconds = 0;

    if (count($timeParts) == 3) {
        // Format: hh:mm:ss
        $seconds += intval($timeParts[0]) * 3600; // Hours to seconds
        $seconds += intval($timeParts[1]) * 60;   // Minutes to seconds
        $seconds += intval($timeParts[2]);        // Seconds
    } elseif (count($timeParts) == 2) {
        // Format: mm:ss
        $seconds += intval($timeParts[0]) * 60;   // Minutes to seconds
        $seconds += intval($timeParts[1]);        // Seconds
    } elseif (count($timeParts) == 1) {
        // Format: ss
        $seconds += intval($timeParts[0]);        // Seconds
    } else {
        // Invalid format
        return false;
    }

    return $seconds;
}
  $videoId = $reel->video->video_id;
  $startSeconds = $reel->from;
  $from = timeStringToSeconds($startSeconds);
  $url = "https://www.youtube.com/embed/{$videoId}?start={$from}";

  $converted_text = nl2br($reel->content);
  $small_text = $converted_text;
  $text_len = mb_strlen($converted_text);

  $more = false;

  if($text_len > $letters_count){
    $small_text = mb_substr($converted_text, 0, $letters_count, 'UTF-8');
    $small_text .= "...";
    $more = true;
  }



@endphp

@section('body')
<style>
  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    grid-gap: 20px;
  }
  .arrow {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    margin-right:1.5vw;
    z-index:-1; 
    transition:0.1s
  }
  .video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    height: 0;
  }
  .video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  @media screen and (max-width: 991px) {
  #content {
    display:block !important;
  }
  #author_video_reels{
    margin-left:0px !important;
    margin-top:21px;
  }

}
</style>

<div class="container mt-4">
  <div id="content" style="display:flex;">

    <div class="card" style="flex:3.5;">
      <div class="card-header">
        <div class="card-title">
          <div class="platforms">
            @foreach ($reel->platforms as $platform)
              @if($platform->pivot->url)
                <a style="margin-right:10px;" target="_blank" href="{{ $platform->pivot->url }}">
                  <img width="32" src="{{ asset('assets/images/platforms/'.$platform->logo) }}" alt="">
                </a>
              @endif
            @endforeach
          </div>
        </div>
      </div>

      <div class="card-body">

        <div class="d-flex align-items-center justify-content-center video-container">
          <iframe src="{{ $url }}" frameborder="0" allowfullscreen></iframe>  
        </div>
        <div class="card-footer">
          <h2>{{ $reel->title." - ".$reel->video->author->name }}</h2>
          <p class="text-justify" id="reel-content">{!!$small_text!!} @if($more) <span onclick="showMoreText()" style="cursor: pointer">More</span> @endif</p>
        </div>



      </div>
    </div>
    @php
      $author_css = 'flex:2.5; margin-left:21px';
    @endphp
      <x-author :author="$author_reels"  :actualreel="$actual_reel_id" :actualvideo="$actual_video_id" :css="$author_css"/>
  </div>
</div>
<script>
  
let converted_text = @json($converted_text);

function showMoreText(){
  document.getElementById('reel-content').innerHTML = converted_text;
}

function displayReels(event, video_id){
  let reels_container = document.querySelector(`.reels-container-${video_id}`);
  reels_container.style.display = reels_container.style.display === 'none'? 'block' : 'none';
}

function flipImg(event) {
  const imgElement = event.currentTarget.querySelector('img');
  imgElement.style.transform = imgElement.style.transform === "rotate(0deg)" ? "rotate(180deg)" : "rotate(0deg)";
}

checkReelContainer(@json($actual_video_id));

function checkReelContainer(video_id){
  let containers = document.querySelectorAll(".reels-container")
  containers.forEach(function(container){
    container.style.display="none"
  })
  document.querySelector(`.reels-container-${video_id}`).style.display = "block";

  let arrows = document.querySelectorAll(".arrow")
  arrows.forEach(function(arrow){
    arrow.style.transform = "rotate(0deg)"
  })
  document.querySelector(`.video-arrow-${video_id}`).style.transform = "rotate(180deg)";


}

</script>

@endsection





