@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if(isset($add_result) && $add_result==true)
            <div class="alert alert-success">Added successfully</div>
        @endif
        @if(isset($update_result) && $update_result==true)
            <div class="alert alert-success">Updated successfully</div>
        @endif
        
        @can('task:add')
            <a href="/users/create" class="btn btn-success">
                <i class="flaticon2-plus"></i> Add 
            </a>
        @endif
        
        <table class="table table-hover">
            <tr>
                <th>Drag</th>
                <th>ID</th>
                <th>Role</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($users as $user)
                <tr data-item-id="{{$user->id}}">
                    <td style="width:30px;user-select:none"><i class="fas fa-expand-arrows-alt"></i></td>
                    <td>{{ $user->id }}</td>
                    <td>
                        <?php
                        $roles = $user->getRoleNames();
                        ?>
                        <ul>
                            @foreach ($roles as $role)
                                <li>
                                    {{$role}}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td><a href="/users/{{ $user->id }}">{{ $user->name }}</a></td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><a href="/users/{{ $user->id }}/edit">Edit</a></td>
                    <td>Delete</td>
                </tr>
            @endforeach
        </table>
    </div>
    <!--end::Container-->
@endsection


@section('js_scripts')

<script src="{!! asset('js/table_drag.js') !!}"></script>


<script>
    table_drag.drag('.table-hover', 'item-id', '{{url('users/action/reorder')}}', function(response){
        console.log(response);
    });
</script>
    
@endsection
