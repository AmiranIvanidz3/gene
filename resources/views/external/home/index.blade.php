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

.highlighted {
  background-color: <?php echo $search_color; ?>;
}
    


</style>

<div class="container mt-4 mb-5">
  
  <div class="mb-4"> 
   
    <form action="{{ route('search') }}" method="GET" class="search-form">

      <div class="w-100 search-container search-section" style="position:static">
        
        <select onchange="changeLocation(this)" name="author_id" id="author_id" class="form-control" style="flex:2; margin-right:10px">
          <option value="" >Select Author</option>
          @foreach ($authors as $item)
              <option value="{{$item->id}}" @if(isset($_GET['author_id']) && $_GET['author_id'] == $item->id) selected @endif>{{$item->name}} ({{$item->reels_count}}) </option>
          @endforeach
        </select>

        <div class="section-2" style="display:flex; flex:8">
          <div class="d-flex" style="flex: 10">
            <input type="text" oninput="checkReset()" placeholder="Search" name="text_search" id="text_search" class="form-control" value="{{ $text_search ?? ""}}" style="flex:16; margin-right:10px">
          </div>

          <div class="form-group half-width">
            <a class="reset btn-close" onclick="test(event)">
              <i class="flaticon2-plus"></i>
            </a>
          </div>


           <div class="form-group half-width search-div" style="flex:0">
            <button type="submit" id="search" class="btn btn-primary">ძებნა</button>
          </div>

        </div>
        
      
      </div>

    </form>
  </div>
  
  <div class="card mb-4">

    <div class="card-header">
      <div class="card-title">
        <h4>Topics</h4>

      </div>
    </div>
    <div class="card-body"  style="display:flex; flex-wrap:wrap">
    
       
        @foreach($topics as $topic)

      <a class="bg-primary text-light" style="  
        border-radius: 10px;
        padding: 5px 9px; margin-left:5px; margin-right:5px;margin-bottom:10px;" href="topic/{{ $topic->name  }}">#{{ $topic->name }}</a>
        @endforeach
      
     
    </div>
  </div>

  <div class="card">

    <div class="card-header">
      <div class="card-title d-flex justify-content-between">
        <h4>Latest</h4>
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
                  <p class="m-0 author"> {{ $reel->video->author->name}}</p>
                </a>
              </h5>
                
            </div>
    
            <div class="card-body" style="display:flex; flex-direction:column; justify-content:space-between">
             
              @php
                $slug = Str::slug($reel->title, '-', null);
              @endphp
                <h5><a class="multiline-truncate" href="/{{ $reel->id."/". $slug }}">{{ $reel->title }}</a></h5>
                @if(false)
                  <div style="display:flex;justify-content:space-between" class="platforms mt-3" style="height:32px;">
                    @foreach ($reel->platforms as $platform)
                      @if($platform->pivot->url)
                        <a target="_blank" href="{{ $platform->pivot->url }}">
                          <img width="32" src="{{ asset('assets/images/platforms/'.$platform->logo) }}" alt="">
                        </a>
                      @endif
                    @endforeach
                  </div>
                @endif
            </div>
    
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="mt-3">
    {{$reels->appends(request()->input())->links()}}
  </div>

  <div class="card mt-5">

    <div class="card-header">
      <div class="card-title">
        <h4>Authors</h4>

      </div>
    </div>
    <div class="card-body">
      <div class="cards">
        @foreach($authors as $author)

        @php
          $words = explode(' ', $author->name);
          $first_name = $words[0];
          $last_name = $words[1];
        @endphp

          <div class="card">
            <div class="card-header d-flex align-items-center" style="padding:0; height:129px;">
              @isset($author->profile) 
              <a href="{{ str_replace(' ', '-', $author->name)}}">
                <img class="m-3" style="border-radius:50%; width:100px;height:100px;" src="{{ Storage::url('images/authors/'.$author->profile) }}">
              </a>
                
              @endisset
              <h5 @empty($author->profile) class="m-3" @endempty>
                <a href="{{ str_replace(' ', '-', $author->name)}}">
                  <p>{{ $first_name }} </p>
                  <p>{{ $last_name }}</p>
                </a>

              </h5>
            </div>
          </div>



          
        @endforeach
      </div>
    </div>
  </div>  

    {{-- amirani --}}

    <div class="card mt-5">
      <div class="card-header">
        <div class="card-title d-flex justify-content-between">
          <h4>Reels</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="cards">
          @foreach($unpublished_reels as $unpublished_reel)
            <div class="card">
              <div class="card-header d-flex align-items-center" style="padding:0;height:70px;">
                <h5 class="m-2">
                  <a class="d-flex align-items-center" href="{{ str_replace(' ', '-',$unpublished_reel->video->author->name)}}">
                    @isset($unpublished_reel->video->author->profile) 
                      <img height="60" width="60" style="border-radius:50%; margin-right:10px" src="{{ Storage::url('images/authors/'.$unpublished_reel->video->author->profile) }}">
                    @endisset
                    <p class="m-0 author"> {{ $unpublished_reel->video->author->name}}</p>
                  </a>
                </h5>
              </div>
              <div class="card-body" style="display:flex; flex-direction:column; justify-content:space-between">
                @php
                  $slug = Str::slug($unpublished_reel->title, '-', null);
                @endphp
                  <h5>
                    <a class="multiline-truncate" href="/{{ $unpublished_reel->id."/". $slug }}">{{ $unpublished_reel->title }}</a>
                  </h5>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    
  <br>
  <br>
  <br>
 
</div>

<script>
  
@if(isset($lang))
  let lang = @json($lang);
  const link = document.querySelector(`.desktop-menu-item.${lang}-item a`);
  link.style.backgroundColor = '#2a68e5';
  link.style.color = 'white';
@endif

function changeLocation(selectElement) {
  var selectedIndex = selectElement.selectedIndex;
  var selectedOption = selectElement.options[selectedIndex];

  if (selectedOption.value) {
    var [first_name, last_name] = selectedOption.innerHTML
      .replace(/\([^)]*\)/, '')
      .split(' ');

    window.location.href = `/${first_name}-${last_name}`;
    // window.open(url,); Opens New Tab
  }
}
function test(event){
  event.preventDefault();
  window.location.href = "/";
}

// Reset Button Side --START--
const reset = document.querySelector('.reset');
const text_search = document.getElementById('text_search');
checkReset();
function checkReset(){
  if(text_search.value.length > 0){
    reset.style.display = 'block'
  }else{
    reset.style.display = 'none'
  }
}
// Reset Button Side --END--
filterReels()
function filterReels() {
  const searchText = document.getElementById('text_search').value.toLowerCase();
  const allReels = document.querySelectorAll('.multiline-truncate');
  const allAuthor = document.querySelectorAll('.author');
  const regex = new RegExp(searchText, "g");

  allReels.forEach(function(reel){
    let text = reel.innerText;
    const highlightedText = text.replace(regex, `<span class="highlighted">${searchText}</span>`);
    reel.innerHTML = highlightedText;
  })

  allAuthor.forEach(function(author){
    let text = author.innerText;
    const highlightedText = text.replace(regex, `<span class="highlighted">${searchText}</span>`);
    author.innerHTML = highlightedText;
  })
}


      


      
</script>

@endsection


