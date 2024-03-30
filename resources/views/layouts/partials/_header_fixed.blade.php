
<div id="kt_header" class="header  header-fixed ">
    <!--begin::Container-->
    <div class=" container-fluid  d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="kt_header_menu"
                 class="header-menu header-menu-mobile  header-menu-layout-default ">
                 <ul id="desktop" class="breadcrumb breadcrumb-desktop  breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <h5 class="breadcrumb-desktop text-dark font-weight-bold my-1 mr-5 page-title">
                  
                    </h5>
                    <li class="breadcrumb-desktop breadcrumb-item">
                        <i class="menu-icon"></i>
                    </li>

                    <li class="breadcrumb-desktop breadcrumb-item">
                        <a class="breadcrumb-desktop text-muted" href=""></a>
                    </li>

                    

                </ul>
               
            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->

        <!--begin::Topbar-->
        <div class="topbar" style="display: block; margin-top:10px;">


            <!--begin::User-->
            <div class="topbar-item">
                <div class="user_desktop btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                     id="kt_quick_user_toggle">
                                        <span
                                        class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">{{Auth::user()->roles[0]->name}},</span>
                                        <span
                        class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->name }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                                            <span class="symbol-label font-size-h5 font-weight-bold">
                                                {{ ucfirst(substr(Auth::user()->name , 0, 1)); }}{{ ucfirst(substr(Auth::user()->last_name , 0, 1)); }}
                                            </span>
                                        </span>
                </div>
            </div>

            <div>
                <span class="ml-5" id="loading-animation" style="display: none; float:right; margin-top:20px; margin-right:10px;"><img style="width: 35px" src="{{ asset('assets/images/loading.gif') }}" alt="Loading" /></span>
            </div>

            <!--end::User-->
        </div>
      
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
