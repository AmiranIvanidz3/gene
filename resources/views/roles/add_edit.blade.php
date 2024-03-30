@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php
            $title =  env('CREATE_NEW');
            $role_name = old('name');

            $form_action = 'roles';
            ?>
        @else
            <?php
            $title = 'Edit';
            $role_name = $role->name;

            $form_action = 'roles/'.$role->id;
            ?>
        @endif
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">
                                          <a class="btn mr-5 go-back" onclick="history.back()"><i class='flaticon2-back'></i></a>
                    {{$title}}
                </h3>
            </div>
            <!--begin::Form-->
            <form class="form" method="POST" action="{{ adminUrl($form_action) }}">
                @if ($action == 'edit')
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $role_name }}"  class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name"/>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group permissions_group">
                        <div class="form-group row">
                            <div class=" col-lg-4 col-md-9 col-sm-12">
                                <select class="form-control select2" id="kt_select2_1" >
                                    <option value="0">Select Similar Role</option>
                                    @foreach($roles as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                          
                        </div>

                        <div class="form-group">
                            <input class="ml-2" id="check_all"  style="scale:2" type="checkbox" onclick="checkAll(event)" value="0">
                            <label class="ml-3" for="check_all" >Check All</label>
                        </div>
                   
                      
        
                        @if ($action == 'edit')
                            <h4>{{$role->name}}'s permissions</h4>
                        @endif

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
                                    <input class="permission" type="checkbox" @if($action == 'edit' && $role->hasPermissionTo($permission)) checked='checked' @endif value="{{$permission->name}}" name="permissions[]"/>
                                    <span></span>
                                    {{$permission->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                    @csrf
                </div>
            </form>
            <!--end::Form-->

        </div>

    </div>
    <script>
        let checked = [];
        const checkboxes = document.querySelectorAll('.permission');
        function checkAll(event){
            event.target.value == 0 ? event.target.value = 1 : event.target.value = 0; 
            if(event.target.value == 1) {
                checked = [];
                checkboxes.forEach(checkbox => {
                    if(checkbox.checked){
                        checked.push(checkbox.value)
                    }
                    checkbox.checked = true;
                });
            }else{
                checkboxes.forEach(function(checkbox){
                    if(checked.includes(checkbox.value)){
                    checkbox.checked = true;
                    }else{
                        checkbox.checked=false;
                    }
                });
            } 
        }
    </script>
    <!--end::Container-->
@endsection
