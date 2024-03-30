
<style>
  .card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 10px;
  }
</style>

<div id="author_video_reels" class="card" {{ $attributes->merge(['style' => $css]) }}>
    <div class="card-header">
      <h5 class="m-2 d-flex align-items-center">
          @isset($author->profile) 
            <img height="60" width="60" style="border-radius:50%; margin-right:10px" src="{{ Storage::url('images/authors/'.$author->profile) }}">
          @endisset
          <a href="/{{ Str::slug($author->name, '-', null) }}">
            <p class="m-0"> {{ $author->name}}</p>
          </a>
          
      </h5>
    </div>
    <div class="card-body">
      @foreach ($author->videos as $video )
      @if(count($video->reels) !== 0)
        <div class="card mb-3">
          <div class="card-header d-flex align-items-center" style="cursor:pointer; " onclick="displayReels(event, @json($video->id));flipImg(event)">
            <h5 style="margin:0; padding:0;">
              <img width="20" class="arrow video-arrow-{{ $video->id }} }}" src="{{ asset('assets/images/down-arrow.png') }}" alt="">
              {{ $video->title }}
            </h5>
          </div>
          <div class="card-body reels-container reels-container-{{ $video->id }}" style="display:block">
            <ul class="list-group list-group-flush">
              <div class="@if(!isset($actualvideo)) card-container @endif">
                @foreach($video->reels as $reel)
                @if (isset($actualvideo) && $video->id == $actualvideo)
                <li class="list-group-item border-0 border-bottom">
                    <img width="32" src="{{ asset('assets/images/play-button.png') }}" alt="">
                      <span style="cursor:context-menu" class="reel-title">
                        <span style="background-color:#cdf1f5; border-radius:10px;" class="p-1">{{ $reel->from }}</span> 
                        @if(isset($actualreel) && $reel->id == $actualreel)
                          <span class="reel-title">
                            {{ $reel->title }}
                          </span>
                        @else
                        <a href="/{{ $reel->id."/".Str::slug($reel->title, '-', null) }}">
                          <span class="reel-title">
                            {{ $reel->title }}
                          </span>
                        </a>
                        @endif

                      </span>
                  </li>
                  @elseif(isset($actualvideo))
                    <li class="list-group-item border-0 border-bottom rounded">
                      <a href="/{{ $reel->id."/".Str::slug($reel->title, '-', null) }}">
                        <img width="32" src="{{ asset('assets/images/play-button.png') }}" alt="">
                          <span class="reel-title">
                            {{ $reel->title }}
                        </span>
                      </a>
                    </li>
                  @else
                  <li class="list-group-item border rounded">
                    <a href="/{{ $reel->id."/".Str::slug($reel->title, '-', null) }}">
                      <img width="32" src="{{ asset('assets/images/play-button.png') }}" alt="">
                        <span class="reel-title">
                          {{ $reel->title }}
                      </span>
                    </a>
                  </li>
                  @endif
                  
                
                @endforeach
              </div>
            </ul>
          </div>
        </div>
      @endif
      @endforeach
    </div>
  </div>
