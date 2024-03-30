@extends('layouts.main')
@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_name = old('name');
            $item_minute = old('minute');
            $item_procedure_type_id = old('procedure_type_id');
            $form_action = '/'.env('ADMIN_URL').'/procedures';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_name = $item->name;
            $item_minute = $item->minute;
            $item_procedure_type_id = $item->procedure_type_id;
            $form_action = '/'.env('ADMIN_URL').'/procedures/'.$item->id;
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
            <form class="form" method="POST" action="{{$form_action}}">
                @if ($action == 'edit')
                    @method('PUT')
                @endif
                <div class="card-body">

                    <div class="form-group mb-5">
                        <label>Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name" value="{{ $item_name }}"></input>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group mb-5">
                        <label>Minute</label>
                        <input type="text" class="form-control {{ $errors->has('minute') ? 'is-invalid' : '' }}" name="minute" placeholder="Minute" value="{{ $item_minute }}"></input>
                        @if($errors->has('minute'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('minute') }}</strong>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="kt_select2_1">Procedure type</label>
                        <select class="form-control select2" id="kt_select2_1" name="procedure_type_id" >
                            <option value="0">Select Type</option>
                            @foreach($procedure_types as $procedure_type)
                                <option {{ $procedure_type->id == $item_procedure_type_id ? 'selected' : '' }} value="{{ $procedure_type->id }}" >{{$procedure_type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($errors->has('procedure_type_id'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('procedure_type_id') }}</strong>
                        </div>
                    @endif

                <div class="card-footer">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    @csrf
                </div>
            </form>
            <!--end::Form-->

        </div>

    </div>
    <!--end::Container-->
@endsection