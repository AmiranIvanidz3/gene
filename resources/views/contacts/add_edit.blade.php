@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title = env('CREATE_NEW');
            $item_name = old('name');
            $item_phone_number= old('phone_number');
            $item_email= old('email');
            $item_message= old('message');
            $form_action = '/'.env('ADMIN_URL').'/contacts';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_name = $item->name;
            $item_phone_number = $item->phone_number;
            $item_email = $item->email;
            $item_message = $item->message;
            $form_action = '/'.env('ADMIN_URL').'/contacts/'.$item->id;
            ?>
        @endif
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">
                    Contacts
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
                        <input type="text" value="{{ $item_name }}"  class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="name"/>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text"   class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" name="phone_number" placeholder=" " value="{{$item_phone_number}}"/>
                        @if($errors->has('phone_number'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text"   class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" placeholder=" " value="{{$item_email}}"/>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <input type="phone_number"   class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" placeholder=" " value="{{$item_message}}"/>
                        @if($errors->has('message'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('message') }}</strong>
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


@section('js_scripts')

    


@endsection