@extends('layouts.main')
@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_quantity = old('quantity');
            $item_procedure_id = old('procedure_id');
            $item_visit_id  = old('visit_id ');
            $form_action = '/'.env('ADMIN_URL').'/procedures_done';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_visit_id= $item->visit_id;
            $item_quantity = $item->quantity;
            $item_procedure_id  = $item->procedure_id;
            $form_action = '/'.env('ADMIN_URL').'/procedures_done/'.$item->id;
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
                        <label>Quantity</label>
                        <input type="numbers" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" name="quantity" placeholder="Quantity" value="{{ $item_quantity }}"></input>
                        @if($errors->has('quantity'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </div>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="kt_select2_1">Procedure</label>
                        <select class="form-control select2" id="kt_select2_1" name="procedure_id" >
                            <option value="0">Select Type</option>
                            @foreach($procedures as $procedure)
                                <option {{ $procedure->id == $item_procedure_id ? 'selected' : '' }} value="{{ $procedure->id }}" >{{$procedure->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($errors->has('procedure_id'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('procedure_id') }}</strong>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="kt_select2_3">Visit</label>
                        <select class="form-control select2" id="kt_select2_3" name="visit_id" >
                            <option value="0">gasaketebelia ak</option>
                            <option value="1">visit1</option>
                            <option value="2">visit2</option>
                            
                            {{-- @foreach($procedures as $procedure)
                                <option {{ $procedure->id == $item_procedure_id ? 'selected' : '' }} value="{{ $procedure->id }}" >{{$procedure->name}}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    @if($errors->has('visit_id'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('visit_id') }}</strong>
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