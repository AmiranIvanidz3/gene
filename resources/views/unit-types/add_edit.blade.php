@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_name = old('name');
            $item_short_name = old('short_name');
            $item_code = old('code');
            $item_comment = old('comment');
            $form_action = '/'.env('ADMIN_URL').'/unit-types';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_name = $item->name;
            $item_short_name = $item->short_name;
            $item_code = $item->code;
            $item_comment = $item->comment;
            $form_action = '/'.env('ADMIN_URL').'/unit-types/'.$item->id;
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
                        <input value="{{ $item_name }}" type="text" class="form-control {{ $errors->has('xx1') ? 'is-invalid' : '' }}" name="name" placeholder="name"></input>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Short Name</label>
                        <input type="text" class="form-control {{ $errors->has('short_name') ? 'is-invalid' : '' }}" name="short_name" placeholder="Short Name" value="{{ $item_short_name }}"></input>
                        @if($errors->has('short_name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('short_name') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" name="code" placeholder="Code" value="{{ $item_code }}"></input>
                        @if($errors->has('code'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('code') }}</strong>
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