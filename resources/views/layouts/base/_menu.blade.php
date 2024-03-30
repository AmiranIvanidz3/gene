{{-- Menu --}}


<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4 " data-menu-vertical="1" data-menu-scroll="1"
         data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav ">


           
                <li id ="resources" class="menu-item @if(isset($menu['resources'])) menu-item-open menu-item-here @endif" menu-item-submenu aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon flaticon-map"></i>
                        <span class="menu-text">ცნობარები</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu "><i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li  class="menu-item  menu-item-parent" aria-haspopup="true">
                                                    <span class="menu-link">
                                                        <span class="menu-text">ცნობარები</span>
                                                    </span>
                            </li>

                            <li class="menu-item @if(isset($menu['resources']['people'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('people') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text">People</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

            @can('log:view')

                <li  id ="logs" class="menu-item @if(isset($menu['logs'])) menu-item-open menu-item-here @endif" menu-item-submenu aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon flaticon-search"></i>
                        <span class="menu-text">Logs</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu "><i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li  class="menu-item  menu-item-parent" aria-haspopup="true">
                                                    <span class="menu-link">
                                                        <span class="menu-text">Logs</span>
                                                    </span>
                            </li>

                                @role('Admin')
                                    <li class="menu-item @if(isset($menu['logs']['log-news'])) menu-item-here @endif" aria-haspopup="true">
                                        <a href="{{ adminUrl('log-news') }}" class="menu-link">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Modal News</span>
                                        </a>
                                    </li>
                                @endrole

                                <li class="menu-item @if(isset($menu['logs']['logs'])) menu-item-here @endif" aria-haspopup="true">
                                    <a href="{{ adminUrl('logs') }}" class="menu-link">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text">Actions</span>
                                    </a>
                                </li>
                                
                        </ul>
                    </div>
                </li>
            @endcan 
            @can('log:view')

                <li id ="ip-logs" class="menu-item @if(isset($menu['ip-logs'])) menu-item-open menu-item-here @endif" menu-item-submenu aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon flaticon-ip"></i>
                        <span class="menu-text">IPs</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu "><i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li  class="menu-item  menu-item-parent" aria-haspopup="true">
                                                    <span class="menu-link">
                                                        <span class="menu-text">IPs</span>
                                                    </span>
                            </li>
                                
                            <li class="menu-item @if(isset($menu['ip-logs']['group-log-ip'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('group-log-ip/ip') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text">Group IPs</span>
                                </a>
                            </li>
                    

                            <li class="menu-item @if(isset($menu['ip-logs']['date-group-log-ip'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('group-log-ip/date') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text">Group Date IPs</span>
                                </a>
                            </li>

                            <li class="menu-item @if(isset($menu['ip-logs']['excluded-ips'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('excluded-ips') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text">Excluded IPs</span>
                                </a>
                            </li>
                        
                            <li class="menu-item @if(isset($menu['ip-logs']['excluded-ip-requests'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('ip-requests') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    <span class="menu-text">Excluded IP Requests</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
            @endcan

            @can('log:view')

                <li  id ="ua-logs" class="menu-item @if(isset($menu['ua-logs'])) menu-item-open menu-item-here @endif" menu-item-submenu aria-haspopup="true" data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <i class="menu-icon flaticon-browser"></i>
                        <span class="menu-text">User Agents</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu "><i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            <li  class="menu-item  menu-item-parent" aria-haspopup="true">
                                                    <span class="menu-link">
                                                        <span class="menu-text">User Agents</span>
                                                    </span>
                            </li>
                                <li class="menu-item @if(isset($menu['ua-logs']['group-log-ua'])) menu-item-here @endif" aria-haspopup="true">
                                    <a href="{{ adminUrl('group-log-ua/ua') }}" class="menu-link ">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Group User Agents</span>
                                    </a>
                                </li>
                        
                                <li class="menu-item @if(isset($menu['ua-logs']['date-group-log-ua'])) menu-item-here @endif" aria-haspopup="true">
                                    <a href="{{ adminUrl('group-log-ua/date') }}" class="menu-link ">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Group Date User Agents</span>
                                    </a>
                                </li>
                    
                                <li class="menu-item @if(isset($menu['ua-logs']['excluded-user-agents'])) menu-item-here @endif" aria-haspopup="true">
                                    <a href="{{ adminUrl('excluded-user-agents') }}" class="menu-link ">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Excluded User Agents</span>
                                    </a>
                                </li>
                            
                                <li class="menu-item @if(isset($menu['ua-logs']['excluded-user-agent-requests'])) menu-item-here @endif" aria-haspopup="true">
                                    <a href="{{ adminUrl('excluded-user-agent-requests') }}" class="menu-link ">
                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                        <span class="menu-text">Excluded User Agent Requests</span>
                                    </a>
                                </li>
                            

                        </ul>
                    </div>
                </li>
            @endcan
          
             @canany(['user:view', 'role:view', 'permission:view','project:view' ])
                <li id="settings" class="menu-item @if(isset($menu['Settings'])) menu-item-open menu-item-here @endif" menu-item-submenu aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-icon flaticon-cogwheel-2"></i>
                    <span class="menu-text">Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu "><i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item  menu-item-parent" aria-haspopup="true">
                                                <span class="menu-link">
                                                    <span class="menu-text">Settings</span>
                                                </span>
                        </li>

                        @role('Admin')
                            <li class="menu-item @if(isset($menu['Settings']['modal-news'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('modal-news') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                <span class="menu-text">Modal News</span>
                                </a>
                            </li>
                        @endrole

                        @can('parameter:view')
                            <li class="menu-item @if(isset($menu['Settings']['Parameters'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('parameters') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    {{-- flaticon2-console --}}
                                    <span class="menu-text">Parameters</span>
                                </a>
                            </li>
                        @endcan
                        
                        @can('user:view')
                        <li class="menu-item @if(isset($menu['Settings']['Users'])) menu-item-here @endif" aria-haspopup="true">
                            <a href="{{ adminUrl('users') }}" class="menu-link ">
                                <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                <span class="menu-text">Users</span>
                            </a>
                        </li>
                        @endcan
                    
                        @can('role:view')
                            <li class="menu-item @if(isset($menu['Settings']['Roles'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('roles') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    {{-- flaticon2-console --}}
                                    <span class="menu-text">Roles</span>
                                </a>
                            </li>
                        @endcan

                        @can('permission:view')
                            <li class="menu-item @if(isset($menu['Settings']['Permission'])) menu-item-here @endif" aria-haspopup="true">
                                <a href="{{ adminUrl('permissions') }}" class="menu-link ">
                                    <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                    {{-- flaticon2-console --}}
                                    <span class="menu-text">Permissions</span>
                                </a>
                            </li>
                        @endcan

                        </li>
                    </ul>
                </div>
                </li>
            @endcanany



        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>
<script>
    let menu_id = 0;
    $(".menu-toggle").click(function(element) {
        let parent = element.currentTarget.parentElement
        if(menu_id != parent.id && parent.id != 'x'){
            parent.classList.remove('menu-item-open')
            $("[menu-item-submenu]").removeClass("menu-item-open");
            menu_id = parent.id;
        }
    });
</script>
