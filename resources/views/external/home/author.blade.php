@extends('layouts.external.app')


@section('body')


<style>

  .arrow {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    margin-right:1.5vw;
    z-index:-1; 
    transition:0.1s;
    transform: rotate(180deg);
  }
  
  #text_search {
      padding-left:40px;
      background: transparent url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath fill='gray' d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E") no-repeat 13px center;
  }
  .author-reset{
    position:absolute;
    right:10px;
    top:6px;
  }
  .highlighted {
  background-color: <?php echo $search_color; ?>;
}
  
  
  </style>



<div class="container mt-4 mb-5">

  <form action="{{ route('search') }}" method="GET" class="search-form">

    <div class="w-100 search-conatiner" style="display: flex; position:relative">
      <div class="d-flex" style="flex: 2">
        <input type="text" placeholder="Search" name="text_search" id="text_search" class="form-control" value="{{ $text_search ?? ""}}">

        <input type="hidden" name="from" value="author">

      </div>

      <div class="form-group half-width">
        <button class="author-reset btn-close" onclick="resetReels(event)" type="submit">
          <i class="flaticon2-plus"></i>
        </button>
      </div>
    
    </div>
  
  </form>
  <div class="mt-4">
    <x-author :author="$author"/>
  </div>

  </div>
</div>

<script>
  function displayReels(event, video_id){
    console.log(video_id)
    let reels_container = document.querySelector(`.reels-container-${video_id}`);
    reels_container.style.display = reels_container.style.display === 'none'? 'block' : 'none';
  }

  function flipImg(event) {
    const imgElement = event.currentTarget.querySelector('img');
    imgElement.style.transform = imgElement.style.transform === "rotate(0deg)" ? "rotate(180deg)" : "rotate(0deg)";
}



function filterReels() {
  const filterText = document.getElementById('text_search').value.toLowerCase();
  const allVideos = document.querySelectorAll('.card.mb-3');

  allVideos.forEach(videoCard => {
    let hasMatchingReel = false;
    const videoReels = videoCard.querySelectorAll('.list-group-item');

    videoReels.forEach(reel => {
      const reelTitle = reel.querySelector('.reel-title').textContent.toLowerCase();
      const matchIndex = reelTitle.indexOf(filterText);

      if (matchIndex !== -1) {
        hasMatchingReel = true;
        const beforeMatch = reelTitle.substring(0, matchIndex);
        const matchText = reelTitle.substring(matchIndex, matchIndex + filterText.length);
        const afterMatch = reelTitle.substring(matchIndex + filterText.length);

        // Apply highlighting to the matching text within the reel title
        reel.querySelector('.reel-title').innerHTML = `${beforeMatch}<span class="highlighted">${matchText}</span>${afterMatch}`;
        reel.style.display = 'block';
      } else {
        // Reset the innerHTML to the original content and hide reels without matches
        reel.querySelector('.reel-title').innerHTML = reelTitle;
        reel.style.display = 'none';
      }
    });

    // Set the video card's display based on whether there are matching reels
    if (hasMatchingReel) {
      videoCard.style.display = 'block';
    } else {
      videoCard.style.display = 'none';
    }
  });
  checkReset();
}




document.getElementById('text_search').addEventListener('input', filterReels);

function resetReels(event) {
  event.preventDefault();
  document.getElementById('text_search').value = '';
  filterReels();
}

// Reset Button Side --START--
const reset = document.querySelector('.author-reset');
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



</script>

@endsection
