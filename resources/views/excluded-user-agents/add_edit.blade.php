@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_user_agent = old('user_agent');
            $item_comment = old('comment');
            $form_action = '/'.env('ADMIN_URL').'/excluded-user-agents';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_user_agent = $item->user_agent;
            $item_comment = $item->comment;
            $form_action = '/'.env('ADMIN_URL').'/excluded-user-agents/'.$item->id;
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
            <form class="form" method="POST" action="{{$form_action}}" enctype="multipart/form-data">
                @if ($action == 'edit')
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="form-group">
                        <label>User Agent<span class="text-danger">*</span></label>
                        <textarea type="text" class="form-control {{ $errors->has('user_agent') ? 'is-invalid' : '' }}" name="user_agent" placeholder="User Agent">{{ $item_user_agent }}</textarea>
                        @if($errors->has('user_agent'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('user_agent') }}</strong>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label>Comment </label>
                        <textarea class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" placeholder="Comment" name="comment">{{$item_comment}}</textarea>
                        @if($errors->has('comment'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                

                <div class="card-footer">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    {{-- <a href="/control-standards" class="btn btn-secondary">Cancel</a> --}}
                    @csrf
                </div>
            </form>
            <!--end::Form-->

        </div>

    </div>
    <!--end::Container-->
@endsection