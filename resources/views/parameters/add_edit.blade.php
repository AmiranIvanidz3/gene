@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_key = old('key');
            $item_value = old('value');
            $item_description = old('description');
            $form_action = '/'.env('ADMIN_URL').'/parameters';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_key = $item->key;
            $item_value = $item->value;
            $item_description = $item->description;
            $form_action = '/'.env('ADMIN_URL').'/parameters/'.$item->id;
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
                        <label>Key <span class="text-danger">*</span></label>
                        <input id="key" type="text" onchange="checkIfColor(this)" value="{{ $item_key }}"  class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}" name="key" placeholder="Key"/>
                        @if($errors->has('key'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('key') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Value <span class="text-danger">*</span></label>
                        <textarea type="text" rows="5" class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value" placeholder="Value">{{ $item_value }}</textarea>
                        @if($errors->has('value'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('value') }}</strong>
                            </div>
                        @endif
                    </div>


                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" value="{{ $item_description }}"  class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" placeholder="Description"/>
                        @if($errors->has('description'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
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
<script>

const item_value = @json($item_value);
const value_input = document.getElementById('value');
const key_input = document.getElementById('key');
let color_appeared = false;
function checkIfColor(key){
    
    if (key.value.indexOf('color') > -1 && color_appeared == false ){
        color_appeared = true;
        value_input.type = 'color';
        value_input.value = item_value;
    }

    if(key.value.indexOf('color') == -1){
        color_appeared = false;
        value_input.type = 'text';
        value_input.value = item_value;
    }
}
@if($title == 'Edit')
    checkIfColor(key_input);
@endif


</script>
@endsection