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
                            <span class="nav-text font-size-lg">{{ 'Change password' }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <form id="kt_form" class="form" method="post" action="{{ adminUrl('profile/change/password') }} "enctype="multipart/form-data" >
                @csrf
                <div class="tab-content">
                    <div class="tab-pane show active" id="general" role="tabpanel">
                        <div class="card-body">
                            <div class="form-group mb-8">
                                <div class="alert alert-custom alert-default" role="alert">
                                    <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
                                    @if(Auth::user()->reset == 1)
                                    <div class="alert-text text-danger">
                                        {{ 'Please change temporary password' }}
                                    </div>
                                    @elseif(ConfigHelper::value('password', 'change'))
                                        @if(Helper::daysInterval(Auth::user()->password_date) > ConfigHelper::value('password', 'interval'))
                                            <div class="alert-text text-danger">
                                                {{ 'You must change password after given period' }}
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 text-right">
                                    {{ 'Current password' }}<span class="text-danger"> *</span>
                                </label>
                                <div class="col-lg-9">
                                    <input class="form-control @if($errors->has('current_password')) is-invalid @endif" type="password" name="current_password" placeholder=" {{ 'Current password' }}">
                                    <div class="invalid-feedback">@if($errors->has('current_password')) {{ $errors->first('current_password') }} @endif</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 text-right">
                                    {{ 'New password' }}<span class="text-danger"> *</span>
                                </label>
                                <div class="col-lg-9">
                                    <input class="form-control @if($errors->has('new_password')) is-invalid @endif" type="password" name="new_password" placeholder=" {{ 'New password' }}">
                                    <div class="invalid-feedback">@if($errors->has('new_password')) {{ $errors->first('new_password') }} @endif</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3 text-right">
                                    {{ 'Re type new password' }}<span class="text-danger"> *</span>
                                </label>
                                <div class="col-lg-9">
                                    <input class="form-control @if($errors->has('new_password_confirmation')) is-invalid @endif" type="password" name="new_password_confirmation" placeholder=" {{ 'Re type new password' }}">
                                    <div class="invalid-feedback">@if($errors->has('new_password_confirmation')) {{ $errors->first('new_password_confirmation') }} @endif</div>
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
