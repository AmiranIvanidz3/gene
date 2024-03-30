@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_name= old('name');
            $item_personal_id = old('personal_id');
            $item_physical_address = old('physical_address');
            $item_legal_address	 = old('legal_address');
            $item_phone = old('phone');
            $item_mobile_phone = old('mobile_phone');
            $item_comment = old('comment');
            $form_action = '/'.env('ADMIN_URL').'/providers';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_name = $item->name;
            $item_personal_id = $item->personal_id;
            $item_physical_address = $item->physical_address;
            $item_legal_address = $item->legal_address;
            $item_phone = $item->phone;
            $item_mobile_phone = $item->mobile_phone;
            $item_comment= $item->comment;
            $form_action = '/'.env('ADMIN_URL').'/providers/'.$item->id;
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
                        <label>Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name" value="{{ $item_name }}"></input>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Personal ID</label>
                        <input type="text" class="form-control {{ $errors->has('personal_id') ? 'is-invalid' : '' }}" name="personal_id" placeholder="Personal ID"value="{{ $item_personal_id }}"></input>
                        @if($errors->has('personal_id'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('personal_id') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Physical Address</label>
                        <input type="text" class="form-control {{ $errors->has('physical_address') ? 'is-invalid' : '' }}" name="physical_address" placeholder="Physical Address" value="{{ $item_physical_address }}"></input>
                        @if($errors->has('physical_address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('physical_address') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Legal Address</label>
                        <input type="text" class="form-control {{ $errors->has('legal_address') ? 'is-invalid' : '' }}" name="legal_address" placeholder="Legal Address"value="{{ $item_legal_address }}"></input>
                        @if($errors->has('legal_address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('legal_address') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" placeholder="Phone" value="{{ $item_phone }}"></input>
                        @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Mobile Phone</label>
                        <input type="text" class="form-control {{ $errors->has('mobile_phone') ? 'is-invalid' : '' }}" name="mobile_phone" placeholder="Mobile Phone" value="{{ $item_mobile_phone }}"></input>
                        @if($errors->has('mobile_phone'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('mobile_phone') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Comment</label>
                        <input type="text" class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Comment" value="{{ $item_comment }}"></input>
                        @if($errors->has('comment'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('comment') }}</strong>
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