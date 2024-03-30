@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_name= old('name');
            $item_address = old('address');
            $form_action = '/'.env('ADMIN_URL').'/stocks';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_name = $item->name;
            $item_address = $item->address;
            $form_action = '/'.env('ADMIN_URL').'/stocks/'.$item->id;
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

                    <div class="form-group">
                        <label>Name <span class="text-danger">*</span></label>
                        <input id="name" type="text" value="{{ $item_name}}"  class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name"/>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Address <span class="text-danger">*</span></label>
                        <input id="address" type="text"  value="{{ $item_address }}"  class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" placeholder="Address"/>
                        @if($errors->has('address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
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