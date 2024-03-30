@extends('layouts.main')


@section('content')
<div class=" container ">
    <div class="card card-custom">
        <div class="card-header card-header-tabs-line nav-tabs-line-3x">
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                    <li class="nav-item mr-3">
                        <a class="nav-link active" data-toggle="tab" href="#general">
                            <span class="nav-icon">
                                <span class="svg-icon"><i class="la la-info"></i></span>
                            </span>
                            <span class="nav-text font-size-lg">{{ 'General' }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <form id="kt_form" class="form" method="post" action="{{ Url('settings/security') }} ">
                @csrf
                <div class="tab-content">
                    <div class="tab-pane show active" id="general" role="tabpanel">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">{{ 'Mandatory password change' }}</label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input data-switch="true" type="checkbox"  name="password_change" {{ $config['password']['change'] == 1 ? 'checked' : '' }} value="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">{{ 'Interval between mandatory password change' }}</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <input id="kt_touchspin_1" type="text" class="form-control" value="{{ $config['password']['interval'] }}" name="password_interval" placeholder="Select time"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">{{ 'Password repeat' }}</label>
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <input data-switch="true" name="password_repeat" type="checkbox" {{ $config['password']['repeat'] == 1 ? 'checked' : '' }} value="1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-3 col-sm-12">{{ 'Repeat password after' }}</label>
                                <div class="col-lg-4 col-md-9 col-sm-12">
                                    <input id="kt_touchspin_1" type="text" class="form-control" value="{{ $config['password']['limit'] }}" name="password_limit" placeholder="Select time"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-9 ml-lg-auto">
                            <button type="submit" class="btn btn-primary mr-2">{{ 'Save' }}</button>
                            <button type="reset" class="btn btn-light-primary">{{ 'Cancel' }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js_scripts')
    <!--begin::Page Scripts(used by this page)-->
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-touchspin.js') }}"></script>
    <!--end::Page Scripts-->
    <!--begin::Page Scripts(used by this page)-->
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-switch.js') }}"></script>
    <!--end::Page Scripts-->
@endsection
