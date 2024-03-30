<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <!-- ==============================================
    Basic Page Needs
    =============================================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @php
    
        $default_page =  $page_title;

        $new_time = \App\Models\Parameter::getValue('modal_news_seconds');

        if(isset($pages)){
            if(isset($page_index)){
                $page = $pages[$page_index];
            }
        }

        if(isset($og_folder) && $og_folder){
           $final_og_file = "https://wisdom.ge".Storage::url('images/'.$og_folder.'/'.$og_file);
        }else{
            $final_og_file = $og_file;
        }


        
    @endphp

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page_title }}</title>
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content='{{$page_description ?? $default_page }}'>
    <meta name="keywords" content="{{$page_keywords ?? $default_page }}" />
    <meta name="author" content="applications.ge">


    <meta property="og:title" content="{{$page['title'] ?? $default_page}}" />
    <meta property="og:description" content="{{$page_description ?? $default_page}}" />
    <meta property="og:url" content="{{$og_url ?? "https://wisdom.ge/"}}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{!!$final_og_file!!}" />



    
    @yield('styles')

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="{{asset('css/main.css')}}?d61">
    <link rel="stylesheet" href="{{asset('css/share.css')}}?d1">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">




</head>
<!--end::Head-->
<!--begin::Body-->
<body>


    <button type="button" id="modal" class="btn btn-primary" data-toggle="modal" data-target="#newsModal" style="display: none">
        Launch demo modal
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 60px">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><span id="news-title"></span></h5>
            </div>
            <div class="modal-body" id="modal-body">

                ...

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"  id="closeNew" onclick="seenNew()">Close</button>
            </div>
        </div>
        </div>
    </div>

    <div style="
    position: fixed;
    height: 70px;
    width: 100%;
    z-index: 9999999;
    background: #F5F5F5;
    border-bottom: 1px solid rgba(0,0,0,.125);
    ">
    <div style="position: relative; height: 100%">

    
        <div class="container" style="height: 100%;">
            <div style="display:flex; height:100%; justify-content:space-between;align-items: center;">

                <div style="height: 100%;display: flex;align-items: center;">     
                    <a href="/" id="logo_link">
                        <h1 style="margin:0;padding:0;display:flex; align-items:center; justify-content:center"><img style="margin-right:10px" width="50" src="{{ asset('assets/images/owl-x1.png') }}" alt="">{{ \App\Models\Parameter::getValue('logo_title') }}</h1>
                    </a>
                </div>

                <div id="menu-right-side" style="display: flex;">
                    <div class="contacts">
                        <a href="/contact-us" style="margin-right: 4px; margin-top:3px;"><img width="40px" src="{{ asset('assets/images/info.png') }}" alt=""></a>
                    </div>
                    <div class="menu_button_position" data-show-nav="false">
                        <button class="menu_button">
                            <span></span>
                        </button>
                    </div>
                    <div id="desktop-menu-buttons">

                        <div class="desktop-menu-item">
                            <a href="/authors">Authors</a>
                        </div>

                        <div class="desktop-menu-item">
                            <a href="/stories">Stories</a>
                        </div>

                        <div  style="
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        margin-left: 10px;">
                            <a href="/contact-us"><img width="40px" src="{{ asset('assets/images/info.png') }}" alt=""></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="mobile-menu-items">

            <div class="mobile-menu-item" style="border-top: 2px solid #cac7c7">
                <a href="/authors">Authors</a>
            </div>

            <div class="mobile-menu-item">
                <a href="/stories">Stories</a>
            </div>
        </div>
    </div>
</div>


   
    

    <div style="    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    padding-top: 70px;">
        @yield('body')

    </div>

    
    
    



    <div id="custom_tooltip" style="position: absolute; z-index:2147483647; display: none; pointer-events: none">
        <div class="custom_tooltip_renderer">
            <span class="custom_tooltip_wrapper" style="display: inline-block">
                <div class="custom_tooltip-text"></div>
            </span>
        </div>
    </div>
	

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="{{ asset('admin/assets/plugins/custom/helpers/AlertHelper.js') }}"></script>    
    @yield('headerScripts')
    <script>
	var operators = {
		'+': function(a, b) { return a + b },
		'-': function(a, b) { return a - b },
		'<': function(a, b) { return a < b },
		'>': function(a, b) { return a > b }
	};


	</script>
	
	
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-904EYJQB3L"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-904EYJQB3L');
    </script>
	
	






    <script src="{{asset('js/main.js')}}?d12"></script>
    <script>
        var _token = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': _token
            }
        });

    </script>
    @stack('scripts')





    
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-D3GDP8WTKV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-D3GDP8WTKV');

    
    let external = 1;
    let new_time = @json($new_time);
    window.csrfToken = '{{ csrf_token() }}';

</script>

<script src="{{ asset('admin/assets/js/news.js') }}"></script>

<script>
    function checkWindowSize() {
    if (window.innerWidth > 1000) {
        document.querySelector(".menu_button").classList.remove("is-active");
        document.querySelector("#mobile-menu-items").classList.remove("is-active");
    }
  }
  window.addEventListener('resize', checkWindowSize);
  checkWindowSize();
</script>

</body>
<!--end::Body-->
</html>
