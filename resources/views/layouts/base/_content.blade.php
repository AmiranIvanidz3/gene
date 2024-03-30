{{-- Content --}}
<style>
    @media screen and (max-width:991px){
        .subheader{
            display:block !important;
        }
    }
</style>
<div  class="content  d-flex flex-column flex-column-fluid">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6  subheader-solid" style="display:none;">
        <div
            class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div style="display:none" class="d-flex align-items-center flex-wrap mr-1">

                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    
                    <!--end::Page Title-->

                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-mobile  breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <h5 class="breadcrumb-mobile text-dark font-weight-bold my-1 mr-5 page-title">
                      
                        </h5>
                        <li class="breadcrumb-mobile breadcrumb-item">
                            <i class="menu-icon"></i>
                        </li>

                        <li class="breadcrumb-mobile breadcrumb-item">
                            <a class="breadcrumb-mobile text-muted" href=""></a>
                        </li>

                        

                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->

            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Actions-->
                @if(isset($buttons) && count($buttons) > 0)
                    
                        @foreach($buttons as $button)
                            @if(isset($button['url']))
                            <a {{isset($button['target']) && $button['target'] == true ? 'target="_blank"' : '' }} class="text-muted" href="{{ url($button['url']) }} "> @endif
                                <button @if (isset($button['disabled']) && $button['disabled'] ) disabled @endif style="right: 40px; margin-left:5px " class="btn btn-default btn-success" id="@if(isset($button['id'])){{$button['id']}}@endif"> {{$button['title']}}</button>
                                @if(isset($button['url'])) </a> @endif
                        @endforeach
                   
                @endif
                <!--end::Actions-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">

        @yield('content')

    </div>
    <!--end::Entry-->
    <script>
        function generateBreadcrumbs() {
            const breadcrumbMobile =  document.querySelector(".breadcrumb-mobile");
            const breadcrumbDesktop =  document.getElementById('desktop');
            const currentURL = window.location.href;    
            const iconHTML = document.querySelector('.menu-item-here .menu-icon').outerHTML;
            const pageTitle = document.querySelector('.menu-item-here .menu-text').innerText;
            const linkName = document.querySelector('.menu-item-here .menu-item-here .menu-text').innerText;
            const link = document.querySelector('.menu-item-here .menu-item-here .menu-link').href
            const submenuName = document.querySelector('.menu-item.menu-item-here .submenu')

            if(submenuName){
                const submenuLink = document.querySelector(".menu-item.menu-item-here.submenu .menu-link").href
                breadcrumbMobile.innerHTML += `
                <li class="breadcrumb-mobile breadcrumb-item">
                            <a class="breadcrumb-mobile submenu-text-muted text-muted" href=""></a>
                </li>
                `

                breadcrumbDesktop.innerHTML += `
                <li class="breadcrumb-desktop breadcrumb-item">
                            <a class="breadcrumb-desktop submenu-text-muted text-muted" href=""></a>
                </li>
                `
                
               
                document.querySelector('.breadcrumb-mobile .submenu-text-muted').innerText = submenuName.innerText
                document.querySelector('.breadcrumb-mobile .submenu-text-muted').href = submenuLink

                document.querySelector('.breadcrumb-desktop .submenu-text-muted').innerText = submenuName.innerText
                document.querySelector('.breadcrumb-desktop .submenu-text-muted').href = submenuLink

                
                
            }
            
            

            document.querySelector(".breadcrumb-mobile.page-title").innerHTML = pageTitle;
            document.querySelector(".breadcrumb-mobile.breadcrumb-item .menu-icon").innerHTML = iconHTML;
            document.querySelector(".breadcrumb-mobile.breadcrumb-item .text-muted").innerText = linkName;
            document.querySelector(".breadcrumb-mobile.breadcrumb-item .text-muted").href = link;

            document.querySelector(".breadcrumb-desktop.page-title").innerHTML = pageTitle;
            document.querySelector(".breadcrumb-desktop.breadcrumb-item .menu-icon").innerHTML = iconHTML;
            document.querySelector(".breadcrumb-desktop.breadcrumb-item .text-muted").innerText = linkName;
            document.querySelector(".breadcrumb-desktop.breadcrumb-item .text-muted").href = link;

           

           
            if(currentURL.endsWith("/create")){
                breadcrumbMobile.innerHTML += `<li class="breadcrumb-item">{{ env('create_new') }}</li>`;
            }else if (currentURL.endsWith("/edit")){
                breadcrumbMobile.innerHTML += `<li class="breadcrumb-item">Edit</li>`;
            }else if (currentURL.endsWith("/show")){
                breadcrumbMobile.innerHTML += `<li class="breadcrumb-item">Show</li>`;
            }
        }
        generateBreadcrumbs();
    </script>
</div>
