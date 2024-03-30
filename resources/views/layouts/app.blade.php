<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\Parameter::getValue('admin_title') }}</title>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!--begin::Page Vendors Styles(used by this page)-->

        <link href="{{ asset('admin/assets/css/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles-->


        <!--begin::Global Theme Styles(used by all pages)-->
        <link href="{{ asset('admin/assets/css/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/assets/css/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->

        <link href="{{ asset('admin/assets/css/light-base.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/assets/css/light-menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/assets/css/dark-brand.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admin/assets/css/dark-aside.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Layout Themes-->

        <!--begin::Page Custom Styles(used by this page)-->
        <link href="{{ asset('admin/assets/css/wizard-3.css') }}" rel="stylesheet" type="text/css"/>
        <!--end::Page Custom Styles-->


        {{-- Select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        {{-- edn::Select2 --}}


        <!--custom css-->
        <link href="{{ asset('admin/assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
        <!--end::custom css-->

        <!--combo and icons css-->
        <link href="{{ asset('admin/assets/css/comboStyle.css') }}" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.0.45/css/materialdesignicons.min.css">
        <!--end::combo and icons css-->

        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

        {{-- <link rel="stylesheet" href="sweetalert2/dist/sweetalert2.css"> --}}

        <link href="{{ asset('admin/assets/css/jstree.bundle.css') }}" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="{{asset('css/share.css')}}?d2">

        @yield('styles')
        <!-- Scripts -->
        {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script> --}}
    </head>
    <!--begin::Body-->
    <body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">



        @yield('body')

        {{-- sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>




        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="{{ asset('admin/assets/js/plugins.bundle.js') }}"></script>
        <script src="{{ asset('admin/assets/js/prismjs.bundle.js') }}"></script>
        <script src="{{ asset('admin/assets/js/scripts.bundle.js') }}"></script>
        <!--end::Global Theme Bundle-->

        <!--begin::Page Vendors(used by this page)-->
{{--        <script src="{{ asset('assets/js/fullcalendar.bundle.js') }}"></script>--}}
{{--        <script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM"></script>--}}
{{--        <script src="{{ asset('assets/js/gmaps.js') }}"></script>--}}
        <!--end::Page Vendors-->

        <!--begin::Page Scripts(used by this page)-->
        <script src="{{ asset('admin/assets/js/widgets.js') }}"></script>
        <!--end::Page Scripts-->


        <!--begin::Page Scripts(used by select2)-->
        <script src="{{ asset('admin/assets/js/select2.js') }}"></script>
        <!--end::Page Scripts-->


        <!--begin::Page Scripts(used by dual-listbox)-->
        <script src="{{ asset('admin/assets/js/dual-listbox.js') }}"></script>
        <!--end::Page Scripts-->


        <script>
            var admin_url = @json(env('ADMIN_URL'));
        </script>

        <!--begin::custom js-->
        <script src="{{ asset('admin/assets/js/custom.js') }}?V10"></script>
        <!--end::Page Scripts-->



        <!--begin::combo js-->
        <script src="{{ asset('admin/assets/js/comboTreePlugin.js') }}"></script>
        <!--end::combo Scripts-->


        <!--begin::custom js-->
        <script src="{{ asset('admin/assets/js/bootstrap-datepicker.js') }}"></script>
        <!--end::Page Scripts-->

        <script src="{{ asset('admin/assets/plugins/custom/helpers/AlertHelper.js') }}"></script>



        {{-- Select2 --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        {{-- edn::Select2 --}}

        <!--begin::Page Scripts(used by this page)-->
        {{-- <script src="{{ asset('assets/js/sweetalert2.js') }}"></script> --}}
        <!--end::Page Scripts-->


        <script src="{{ asset('admin/assets/js/jstree.bundle.js') }}"></script>

        <script type="text/javascript" src="{{ asset('admin/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin/assets/plugins/custom/helpers/DataTableHelper.js?2') }}"></script>



        <script>

        var successAlertCallback = {{isset($success_callback_js) ? 'true' : 'false'}} ? function(){
            $('html, body').animate({
                scrollTop: $('#kt_wizard_v3').offset().top + 200
            }, 1000);
            // console.log('IT WOOOOOOOOOORKS');
        } : null;


            $('#kt_sweetalert_demo_8').click(function (e) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.value) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                });
            });


            $('.tag-input').select2({
                tags: true,
            });

            // SET UP TOKEN TO SEND IN HEADER FOR EVERY JQUERY AJAX CALL
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });
            $(document).ready(function(){
                @if($errors->has('errorAlert')) AlertHelper.errorAlert('{{ $errors->first('errorAlert') }}'); @endif
                @if($errors->has('successAlert')) AlertHelper.successAlert('{{ $errors->first('successAlert') }}'); @endif
                @if($errors->has('errorNotice')) AlertHelper.errorNotice('', '{{ $errors->first('errorNotice') }}'); @endif
                @if($errors->has('successNotice')) AlertHelper.successNotice('', '{{ $errors->first('successNotice') }}', successAlertCallback ? successAlertCallback : null); @endif
            });

            @yield('js')

        </script>

        @yield('js_scripts')
        @stack('scripts')

    </body>
</html>
