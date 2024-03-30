@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_title = old('title');
            $item_description = old('description');
            $item_from = old('from');
            $item_to = old('to');
            $item_active = old('active');
            $form_action = '/'.env('ADMIN_URL').'/modal-news';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_name = $item->name;
            $item_title = $item->title;
            $item_description = $item->description;
            $item_from = $item->from ? (new DateTime($item->from))->format('Y-m-d') : "";
            $item_to = $item->to ?  (new DateTime($item->to))->format('Y-m-d') : "";
            $item_active = $item->active;
            $form_action = '/'.env('ADMIN_URL').'/modal-news/'.$item->id;
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
                        <label>Title <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $item_title}}"  class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" placeholder="Name"/>
                        @if($errors->has('title'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="d-block">Description</label>
                        <textarea  id="summernote" name="description" placeholder="Description" id="description" class="form-control  {{ $errors->has('title') ? 'is-invalid' : '' }}">{{ $item_description }}</textarea>
                        @if($errors->has('description'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div style="display:flex">

                        <div class="form-group mr-5" style="flex:1">
                            <label class="d-block">From</label>
                            <input  value="{{ $item_from }}" name="from" type="date" class="form-control  {{ $errors->has('from') ? 'is-invalid' : '' }}">
                            @if($errors->has('from'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('from') }}</strong>
                            </div>
                            @endif
                        </div>

                        <div class="form-group" style="flex:1">
                            <label class="d-block">To</label>
                            <input  value="{{ $item_to }}" name="to" type="date" class="form-control  {{ $errors->has('to') ? 'is-invalid' : '' }}">
                            @if($errors->has('to'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('to') }}</strong>
                            </div>
                            @endif
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="d-block">Active</label>
                        <input name="active" onchange="checkbox(event)" checked  value="1" style="width:30px;height:30px" type="checkbox" class="{{ $errors->has('active') ? 'is-invalid' : '' }}">
                        @if($errors->has('active'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('active') }}</strong>
                        </div>
                        @endif
                    </div>
                    
                </div>

                    
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    {{-- <a href="/control-standards" class="btn btn-secondary">Cancel</a> --}}
                    @csrf
                </div>
                
            </form>
            <!--end::Form-->

        </div>

    </div>
    <!--end::Container-->
    <script>
        $(document).ready(function() {
              $('#summernote').summernote();
          });
  
  </script>
  
@endsection

