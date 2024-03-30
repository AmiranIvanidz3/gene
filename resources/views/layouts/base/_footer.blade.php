{{-- Footer --}}

<div class="footer bg-white py-4 d-flex flex-lg-column " id="kt_footer">
    <!--begin::Container-->
    <div
        class=" container-fluid  d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2">2024&copy;</span>
            <a href="https://caritas.ge/" target="_blank"
               class="text-dark-75 text-hover-primary">Caritas</a>
        </div>
        <!--end::Copyright-->

        <!--begin::Nav-->
        <div class="nav nav-dark">
            {{--                                <a href="http://keenthemes.com/metronic" target="_blank"--}}
            {{--                                    class="nav-link pl-0 pr-5">About</a>--}}
            {{--                                <a href="http://keenthemes.com/metronic" target="_blank" class="nav-link pl-0 pr-5">Team</a>--}}
            {{--                                <a href="http://keenthemes.com/metronic" target="_blank"--}}
            {{--                                    class="nav-link pl-0 pr-0">Contact</a>--}}
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Container-->
</div>




<div class="modal fade c-modal" id="skeleton-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="skeleton-modal-label" style="font-size:14px; font-weight: bold"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="skeleton-modal-content">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <div id="skeleton-modal-footer" style="display:inline-block"></div>
            </div>
        </div>
    </div>
</div>



<div id="custom_tooltip" style="position: absolute; z-index:2147483647; display: none">
    <div class="custom_tooltip_renderer">
        <span class="custom_tooltip_wrapper" style="display: inline-block">
            <div class="custom_tooltip-text"></div>
        </span>
    </div>
</div>
