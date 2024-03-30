@extends('layouts.main')

@section('content')
<div class=" container ">
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Role: {{$role->name}}
            </h3>
        </div>
        
        <div class="card-body">
            <div class="form-group">
                <h4>{{$role->name}}'s permissions</h4>
                <?php
                $group_name_current = '';
                ?>
                @foreach($permissions as $permission)
                    <?php
                    list($group_name, $permission_action) = explode(':', $permission->name);
                    $group_name_title = str_replace('_', ' ', ucwords($group_name));
                    ?>
                    @if($group_name_current != $group_name)
                        <br>
                        <h5>{{$group_name_title}}</h5>
                    @endif
                    <?php
                    $group_name_current = $group_name;
                    ?>
                    <div class="checkbox-inline">
                        <label class="checkbox checkbox-success">
                            <input type="checkbox" @if($role->hasPermissionTo($permission)) checked='checked' @endif disabled="disabled" value="{{$permission->name}}" name="permissions[]"/>
                            <span></span>
                            {{$permission->name}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!--end::Container-->
@endsection
