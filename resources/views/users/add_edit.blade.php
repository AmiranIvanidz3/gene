@extends('layouts.main')
@section('content')
    @if ($action == 'add')
        <?php
        $title =  env('CREATE_NEW');
        $user_name = old('name');
        $user_last_name = old('last_name');
        $user_email = old('email');
        $user_role_id = old('role_id');
        $user_playlists = old('playlists');
        $form_action = 'users';
        $from_profile = false;
        if(isset($_GET['profile'])){
            $from_profile = $_GET['profile'];
        }
        ?>
    @else
        <?php
     
        $title = 'Edit';
        $user_name = $user->name;
        $user_last_name = $user->last_name;
        $user_email = $user->email;
        $user_playlists = $user->playlists->pluck('id')->toArray();
        $user_role_id = ($user->roles->pluck('id'))->toArray() ?? null;
        $user_role_id = array_map(function($item) {
            return [$item];
        }, $user_role_id);
        $user_reset = $user->reset;
        $form_action = 'users/'.$user->id;
        $from_profile = false;
        if(isset($_GET['profile'])){
            $from_profile = $_GET['profile'];
            $form_action = 'users/'.$user->id.'?profile=true';
        }
        ?>
    @endif


<div class=" container ">
    <div class="card card-custom">
        <div class="card-body p-0">
            <!--begin: Wizard-->
            <div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
                <!--begin: Wizard Nav-->
                @if(!$from_profile)
                    <div class="wizard-nav">
                        <div class="wizard-steps px-8 py-8 py-lg-3">
                            <!--begin::Wizard Step 1 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-label">
                                    <h3 class="wizard-title">
                                        <span>1.</span> Basic Info
                                    </h3>
                                    <div class="wizard-bar"></div>
                                </div>
                            </div>
                            <!--end::Wizard Step 1 Nav-->

                            <!--begin::Wizard Step 2 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <h3 class="wizard-title">
                                        <span>2.</span> @if ($action == 'edit') {{$user->name}}'s @endif Permissions
                                    </h3>
                                    <div class="wizard-bar"></div>
                                </div>
                            </div>
                            <!--end::Wizard Step 2 Nav-->
                        </div>
                    </div>
                @endif
                <!--end: Wizard Nav-->
                <!--begin: Wizard Body-->
                <div class="row px-8 px-lg-10">
                    <div class="col-xl-12">
                        <!--begin: Wizard Form-->
                        <form class="form"  id="kt_form" method="POST" action="{{ adminUrl($form_action) }}">
                            @if ($action == 'edit')
                                @method('PUT')
                            @endif
                            @csrf
                            <!--begin: Wizard Step 1-->
                            <div data-wizard-type="step-content" data-wizard-state="current">
                                <div class="form-group" @if($from_profile) style="padding-top:50px; @endif ">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $user_name }}"  class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name"/>
                                    @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Last Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $user_last_name }}" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" name="last_name" placeholder="Last Name"/>
                                    @if($errors->has('last_name'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ $user_email }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" placeholder="Email"/>
                                    @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="Password"/>
                                    @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label>Repeat password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control {{ $errors->has('password_repeat') ? 'is-invalid' : '' }}" name="password_repeat" placeholder="Repeat Password"/>
                                    @if($errors->has('password_repeat'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('password_repeat') }}</strong>
                                        </div>
                                    @endif
                                </div>
                               
                                @if($action == 'edit')
                                    @role('Admin')
                                        <div class="form-group">
                                            <label class="d-block">Reset</label>
                                            <input value="1"  name="reset" {{ $user_reset == 1 ? 'checked' : "" }} style="margin:0;width:30px; height:30px;" type="checkbox"/>
                                        </div>
                                    @endrole
                                @endif
                                <div class="form-group">
                                    @if($from_profile)
                                    <button class="btn btn-primary">Submit</button>
                                    @endif
                                </div>
                            </div>

                            <!--end: Wizard Step 1-->
                            <!--begin: Wizard Step 2-->
                            <div data-wizard-type="step-content">
                                <div class="form-group permissions_group">
                                    <label class="col-form-label">Select user's role <span class="text-danger">*</span></label>
                                    <div class="form-group row">
                                        <div class=" col-lg-4 col-md-9 col-sm-12">
                                            <select class="form-control select select2 {{ $errors->has('role_id') ? 'is-invalid' : '' }}" id="kt_select2_1" name="role_id[]" value="[]" onchange="checkOptions();" multiple>
                                                <option  value="">Select Role</option>
                                                @foreach($roles as $role)
                                                   
                                                  <option value="{{$role->id}}" {{$action != 'edit' && $role->name == "User" ? 'selected' : ''}} @if($action == "edit") @foreach($user_role_id as $x) {{ $role->id == $x[0] ? 'selected' : "" }} @endforeach @endif>{{$role->name}}</option>


                                                @endforeach
                                              
                                            </select>
                                            @if($errors->has('role_id'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('role_id') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                   
                                    <?php
                                    $group_name_current = '';
                                    ?>  
                                    <div class="row" id="test">
                                        <div class="col-sm">
                                      
                                             @foreach($permissions as $permission)
                                                <?php
                                                list($group_name, $permission_action) = explode(':', $permission->name);
                                                $group_name_title = str_replace('_', ' ', ucwords($group_name));
                                                ?>
                                                @if($group_name_current != $group_name)
                                                    <h6 class="permissions_group_title">{{$group_name_title}}</h6>
                                                @endif
                                                <?php
                                                $group_name_current = $group_name;
                                                ?>
                                                <div class="checkbox-inline">
                                                    <label class="checkbox checkbox-success">
                                                        <input type="checkbox" @if($action == 'edit' && $user->hasPermissionTo($permission)) checked='checked' @elseif($action != 'edit' && $role_user->hasPermissionTo($permission)) checked='checked' @endif disabled="disabled" value="{{$permission->name}}" name="permissions[]"/>
                                                        <span></span>
                                                        {{$permission->name}}
                                                    </label>
                                                </div>
                                            @endforeach 

                                        </div>
                                           
                                        
                                    </div>
                        



                            </div>
                            <!--end: Wizard Step 2-->


                            <!--begin: Wizard Actions-->
                            @if(!$from_profile)
                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-light-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-prev">
                                            Previous
                                        </button>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-submit">
                                            Submit
                                        </button>
                                        <button type="button" class="btn btn-primary font-weight-bold text-uppercase px-9 py-4" data-wizard-type="action-next">
                                            Next
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <!--end: Wizard Actions-->
                        </form>
                        <!--end: Wizard Form-->
                        <br><br><br>
                    </div>
                </div>
                <!--end: Wizard Body-->
            </div>
            <!--end: Wizard-->
        </div>
    </div>
</div>

@endsection
@section('js_scripts')

    <!--begin::Page Scripts(used by wizard)-->
    <script>

        "use strict";
        var KTWizard3 = function() {
            var e, t, i, a = [];
            return {
                init: function() {
                    e = KTUtil.getById("kt_wizard_v3"), t = KTUtil.getById("kt_form"), (i = new KTWizard(e, { startStep: 1, clickableSteps: !0 })).on("change", (function(e) { if (!(e.getStep() > e.getNewStep())) { var t = a[e.getStep() - 1]; return t && t.validate().then((function(t) { "Valid" == t ? (e.goTo(e.getNewStep()), KTUtil.scrollTop()) : Swal.fire({ text: "Sorry, looks like there are some errors detected, please try again.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn font-weight-bold btn-light" } }).then((function() { KTUtil.scrollTop() })) })), !1 } })), i.on("changed", (function(e) { KTUtil.scrollTop() })), i.on("submit", (function(e) {
                        var i = a[e.getStep() - 1];
                        i && i.validate().then((function(e) { "Valid" == e ? t.submit() : Swal.fire({ text: "Sorry, looks like there are some errors detected, please try again.", icon: "error", buttonsStyling: !1, confirmButtonText: "Ok, got it!", customClass: { confirmButton: "btn font-weight-bold btn-light" } }).then((function() { KTUtil.scrollTop() })) }))
                    })), a.push(FormValidation.formValidation(t, { fields: { address1: { validators: { notEmpty: { message: "Address is required" } } }, postcode: { validators: { notEmpty: { message: "Postcode is required" } } }, city: { validators: { notEmpty: { message: "City is required" } } }, state: { validators: { notEmpty: { message: "State is required" } } }, country: { validators: { notEmpty: { message: "Country is required" } } } }, plugins: { trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap({ eleValidClass: "" }) } })), a.push(FormValidation.formValidation(t, { fields: { package: { validators: { notEmpty: { message: "Package details is required" } } }, weight: { validators: { notEmpty: { message: "Package weight is required" }, digits: { message: "The value added is not valid" } } }, width: { validators: { notEmpty: { message: "Package width is required" }, digits: { message: "The value added is not valid" } } }, height: { validators: { notEmpty: { message: "Package height is required" }, digits: { message: "The value added is not valid" } } }, packagelength: { validators: { notEmpty: { message: "Package length is required" }, digits: { message: "The value added is not valid" } } } }, plugins: { trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap({ eleValidClass: "" }) } })), a.push(FormValidation.formValidation(t, { fields: { delivery: { validators: { notEmpty: { message: "Delivery type is required" } } }, packaging: { validators: { notEmpty: { message: "Packaging type is required" } } }, preferreddelivery: { validators: { notEmpty: { message: "Preferred delivery window is required" } } } }, plugins: { trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap({ eleValidClass: "" }) } })), a.push(FormValidation.formValidation(t, { fields: { locaddress1: { validators: { notEmpty: { message: "Address is required" } } }, locpostcode: { validators: { notEmpty: { message: "Postcode is required" } } }, loccity: { validators: { notEmpty: { message: "City is required" } } }, locstate: { validators: { notEmpty: { message: "State is required" } } }, loccountry: { validators: { notEmpty: { message: "Country is required" } } } }, plugins: { trigger: new FormValidation.plugins.Trigger, bootstrap: new FormValidation.plugins.Bootstrap({ eleValidClass: "" }) } }))
                }
            }
        }();
        jQuery(document).ready((function() { KTWizard3.init() }));

    </script>
  
    @include('users.users_functions')
    
@endsection
