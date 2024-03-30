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
  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    grid-gap: 20px;
  }
  
  
  
  </style>

<div class="container">
  <div class="card mt-4">

    <div class="card-header">
      <div class="card-title d-flex justify-content-between">
        <h4>Authors</h4>
          <div class="d-flex">
            {{-- @if(isset($languages))
              @foreach ($languages as $language)
                  <div class="desktop-menu-item {{ $language->name }}-item">
                      <a href="/{{ $language->name }}/authors">{{ Str::upper($language->title) }}</a>
                  </div>
              @endforeach
            @endif --}}
          </div>
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
</div>


<script>

      @if(isset($lang))
        let lang = @json($lang);
        const lang_link = document.querySelector(`.desktop-menu-item.${lang}-item a`);
        lang_link.style.backgroundColor = '#2a68e5';
        lang_link.style.color = 'white';
      @endif

      const link = document.querySelector(`.desktop-menu-item.authors-item a`);
      link.style.backgroundColor = '#2a68e5';
      link.style.color = 'white';
</script>
@endsection


