@extends('layouts.external.app')


@section('body')

<style>
  .multiline-truncate{
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Number of lines to show */
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  grid-gap: 20px;
}


#text_search {
    padding-left:40px;
    background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath fill='gray' d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 13px center;
}
.search-section{
      display:flex;
      position:relative;
    }
@media only screen and (max-width: 767px) {
    #author_id{
      margin-bottom:10px; 
    }
    .search-section{
      display:block;
    }
}
@media only screen and (max-width: 767px) {
    .reset{
      top:50px !important;
    }

}
.reset{
      position:absolute;
      right:80px;
      top:6px;
      display:none;
    } 
    


</style>

<div class="container mt-4 mb-5">
  <div class="card">

    <div class="card-header">
      <div class="card-title d-flex  justify-content-between">
        <h4>{{ $reels_title }}</h4>
        <div class="d-flex">
          {{-- @if(isset($languages))
            @foreach ($languages as $language)
                <div class="desktop-menu-item {{ $language->name }}-item">
                    <a href="/{{ $language->name }}/stories">{{ Str::upper($language->title) }}</a>
                </div>
            @endforeach
          @endif --}}
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="cards">

        @foreach($reels as $reel)
        
          <div class="card">
            <div class="card-header d-flex align-items-center" style="padding:0;height:70px;">
              <h5 class="m-2">
                <a class="d-flex align-items-center" href="{{ str_replace(' ', '-',$reel->video->author->name)}}">
                  @isset($reel->video->author->profile) 
                    <img height="60" width="60" style="border-radius:50%; margin-right:10px" src="{{ Storage::url('images/authors/'.$reel->video->author->profile) }}">
                  @endisset
                  <p class="m-0"> {{ $reel->video->author->name}}</p>
                 
                </a>
              </h5>
                
            </div>
    
            <div class="card-body">
              @php
                $slug = Str::slug($reel->title, '-', null);
              @endphp
                <h5><a class="multiline-truncate" href="/{{ $reel->id."/". $slug }}">{{ $reel->title }}</a></h5>
            </div>
    
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="mt-3">
    {{$reels->appends(request()->input())->links()}}
  </div>

</div>
<script>
  @if(isset($lang))
        let lang = @json($lang);
        const lang_link = document.querySelector(`.desktop-menu-item.${lang}-item a`);
        lang_link.style.backgroundColor = '#2a68e5';
        lang_link.style.color = 'white';
    @endif
      const link = document.querySelector(`.desktop-menu-item.stories-item a`);
    link.style.backgroundColor = '#2a68e5';
    link.style.color = 'white';
</script>
@endsection


