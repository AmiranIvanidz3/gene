@extends('layouts.external.app')
@section('body')
<style>
  .highlight {
    background-color: #FFFF00;
  }

  .card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 10px;
  }
</style>

<div>
  <div class="container mt-4">

    <input type="text" placeholder="Search" name="text_search" id="text_search" oninput="filterReels()" class="form-control mb-4">

    <div class="card" style="flex:2.5">
      <div class="card-header">
        <h5>#{{ $topic }}</h5>
      </div>
      <div class="card-body card-container topic-reels">
        @foreach ($reels as $reel)
        <div class="card">
          <div class="card-header d-flex align-items-center" style="padding:0;height:70px;">
            <h5 class="m-2">
              <a class="d-flex align-items-center" href="/{{ Str::slug($reel->video->author->name, '-', null) }}">

                <img height="60" width="60" style="border-radius:50%; margin-right:10px" src="{{ Storage::url('images/authors/'.$reel->video->author->profile) }}">
                <p class="m-0 author">{{ $reel->video->author->name }}</p>
              </a>
            </h5>
          </div>
          <div class="card-body" style="display:flex; flex-direction:column; justify-content:space-between">
            <h5 class="reel-title" data-original-title="{{ $reel->title }}">
              <a href="/{{ $reel->id }}/{{ Str::slug($reel->title, '-', null) }}">
                <span class="reel-title-text">{{ $reel->title }}</span>
              </a>
            </h5>
          </div>
        </div>

        @endforeach
      </div>
    </div>
  </div>
</div>

<script>
   function filterReels() {
    const filterText = document.getElementById('text_search').value.toLowerCase();
    const allReelTitles = document.querySelectorAll('.reel-title');

    allReelTitles.forEach(reelTitle => {
      const originalTitle = reelTitle.getAttribute('data-original-title');
      const titleText = originalTitle.toLowerCase(); // Convert to lowercase for comparison
      if (titleText.includes(filterText)) {
        // Highlight matching text
        reelTitle.querySelector('.reel-title-text').innerHTML = originalTitle.replace(new RegExp(filterText, 'gi'), match => `<span class="highlight">${match}</span>`);
        reelTitle.parentNode.parentNode.style.display = 'block'; // Show the parent card
      } else {
        // Reset highlighting and hide card if no match
        reelTitle.innerHTML = originalTitle;
        reelTitle.parentNode.parentNode.style.display = 'none';
      }
    });
  }
</script>
@endsection
