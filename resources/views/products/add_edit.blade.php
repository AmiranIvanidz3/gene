@extends('layouts.main')
@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_unit_type_id = old('unit_type_id');
            $item_product_type_id = old('product_type_id');
            $item_code = old('code');
            $item_bar_code = old('bar_code');
            $item_internal_code = old('internal_code');
            $item_name = old('name');
            $form_action = '/'.env('ADMIN_URL').'/products';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_name = $item->name;
            $item_unit_type_id = $item->unit_type_id;
            $item_product_type_id = $item->product_type_id;
            $item_code = $item->code;
            $item_bar_code = $item->bar_code;
            $item_internal_code = $item->internal_code;
            $form_action = '/'.env('ADMIN_URL').'/products/'.$item->id;
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
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name" value="{{ $item_name }}"></input>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                        </div>
    
                        <div class="form-group col-md-6">
                            <label for="kt_select2_1">Unit Type</label>
                            <select class="form-control select2" id="kt_select2_1" name="unit_type_id" >
                                <option value="0">Select Unit Type</option>
                                @foreach($unit_types as $unit_type)
                                    <option {{ $unit_type->id == $item_unit_type_id ? 'selected' : '' }} value="{{ $unit_type->id }}" >{{$unit_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('unit_type_id'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('unit_type_id') }}</strong>
                            </div>
                        @endif

                        <div class="form-group col-md-6">
                            <label for="kt_select2_1">Product Type</label>
                            <select class="form-control select2" id="kt_select2_2" name="product_type_id" >
                                <option value="0">Select Unit Type</option>
                                @foreach($product_types as $product_type)
                                    <option  {{ $product_type->id == $item_product_type_id ? 'selected' : '' }} value="{{$product_type->id}}">{{$product_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('product_type_id'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('product_type_id') }}</strong>
                            </div>
                        @endif

                        
                    <div class="form-group col-md-6">
                        <label>Code</label>
                        <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" placeholder="Code" value="{{ $item_code }}"></input>
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('code') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label>Bar Code</label>
                        <input type="text" class="form-control {{ $errors->has('bar_code') ? 'is-invalid' : '' }}" name="bar_code" placeholder="Bar Code" value="{{ $item_bar_code }}"></input>
                        @if($errors->has('bar_code'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('bar_code') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label>Internal Code</label>
                        <input type="text" class="form-control {{ $errors->has('internal_code') ? 'is-invalid' : '' }}" name="internal_code" placeholder="Internal Code Code" value="{{ $item_internal_code }}"></input>
                        @if($errors->has('internal_code'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('bar_code') }}</strong>
                            </div>
                        @endif
                    </div>
    

                    </div>

                   
                    

                 

                  

                    
                  

                





                
                    
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