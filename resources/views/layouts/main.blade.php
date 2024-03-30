@extends('layouts.app')

@section('body')

        <!--begin::Main-->
        <!--begin::Header Mobile-->
        @include('layouts.base._header-mobile')
        <!--end::Header Mobile-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">

                <!--begin::Aside-->
                <div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto" id="kt_aside">
                    <!--begin::Brand-->
                         @include('layouts.base._brand')
                    <!--end::Brand-->

                    <!--begin::Aside Menu-->
                         @include('layouts.base._menu')
                    <!--end::Aside Menu-->
                </div>
                <!--end::Aside-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                        @include('layouts.partials._header_fixed')
                    <!--end::Header-->

                    <!--begin::Content-->
                         @include('layouts.base._content')
                    <!--end::Content-->

                    <!--begin::Footer-->
                         @include('layouts.base._footer')
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Main-->

        <!-- begin::User Panel-->
            @include('layouts.partials._user_panel')
        <!-- end::User Panel-->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!--begin::Scrolltop-->
             @include('layouts.partials._scrolltop')
        <!--end::Scrolltop-->

        @php
            $new_time = \App\Models\Parameter::getValue('modal_news_seconds');
        @endphp

        <button type="button" id="modal" class="btn btn-primary" data-toggle="modal" data-target="#newsModal" style="display: none">
            Launch demo modal
        </button>
        
        <!-- Modal -->
        <div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        {{-- {!!is_int($var) ? $var : '\''.$var.'\''!!}; --}}
        <script>

            let external = 0;
            let new_time = @json($new_time);
            window.csrfToken = '{{ csrf_token() }}';

            var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
            @if(isset($jsVars))
                @foreach($jsVars as $name => $var)
                    var {{$name}} = {!!$var!!};
                @endforeach
            @endif
        
        </script>

        <script src="{{ asset('admin/assets/js/news.js') }}"></script>

        <!--begin::Global Config(global config for global JS scripts)-->
         {{-- <script src="{{ asset('assets/js/global-config.js') }}"></script> --}}
        <!--end::Global Config-->


@endsection
