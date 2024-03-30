@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_mother_id = old('mother_id');
            $item_father_id = old('father_id');
            $item_name = old('name');
            $item_surname = old('surname');
            $item_gender_id	 = old('gender_id');
            $item_birth_date = old('birth_date');
            $item_personal_number = old('personal_number');
            $item_about = old('about');
            $item_comment = old('comment');
            $item_died= old('died');
            $form_action = '/'.env('ADMIN_URL').'/people';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_mother_id = $item->mother_id;
            $item_father_id = $item->father_id;
            $item_name = $item->name;
            $item_surname = $item->surname;
            $item_gender_id = $item->gender_id;
            $item_birth_date = $item->birth_date;
            $item_personal_number = $item->personal_number;
            $item_about = $item->about;
            $item_comment = $item->comment;
            $item_died = $item->died;
            $form_action = '/'.env('ADMIN_URL').'/people/'.$item->id;
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
                <div class="card-body row">

       

                    <div class="form-group col-lg-3 col-md-4">
                        <label for="kt_select2_1">Father</label>
                        <select class="form-control select2" id="kt_select2_5" name="father_id" >
                            <option value="0">Select Father</option>
                            @foreach($fathers as $father)
                                <option {{ $father->id == $item_father_id ? 'selected' : '' }} value="{{ $father->id }}" >{{$father->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($errors->has('father'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('father') }}</strong>
                        </div>
                    @endif

                    <div class="form-group  col-lg-3 col-md-4  ">
                        <label for="kt_select2_2">Mother</label>
                        <select class="form-control select2" id="kt_select2_4" name="mother_id" >
                            <option value="0">Select Mother</option>
                            @foreach($mothers as $mother)
                                <option {{ $mother->id == $item_mother_id ? 'selected' : '' }} value="{{ $mother->id }}" >{{$mother->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($errors->has('mother_id'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('mother_id') }}</strong>
                        </div>
                    @endif


                    <div class="form-group  col-lg-3 col-md-4  ">
                        <label>Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="Name" value="{{ $item_name }}"></input>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </div>
                        @endif
                    </div>

                  
                    <div class="form-group  col-lg-3 col-md-4  ">
                        <label>Surname</label>
                        <input type="text" class="form-control {{ $errors->has('surname') ? 'is-invalid' : '' }}" name="surname" placeholder="surname" value="{{ $item_surname }}"></input>
                        @if($errors->has('surname'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('surname') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group  col-lg-3 col-md-4  ">
                        <label for="kt_select2">Gender</label>
                        <select class="form-control select2" id="kt_select2_1" name="gender_id" >
                            <option value="0">Select Gender</option>
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                            
                        </select>
                    </div>
                    @if($errors->has('gender_id'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('gender_id') }}</strong>
                        </div>
                    @endif

                    <div class="form-group  col-lg-3 col-md-4">
                        <label>Birth Date</label>
                        <input type="date" class="form-control {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" name="birth_date" placeholder="birth_date" value="{{ $item_birth_date }}"></input>
                        @if($errors->has('birth_date'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('birth_date') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group  col-lg-3 col-md-4  ">
                        <label>Personal Number</label>
                        <input type="text" class="form-control {{ $errors->has('personal_number') ? 'is-invalid' : '' }}" name="personal_number" placeholder="Personal number" value="{{ $item_personal_number }}"></input>
                        @if($errors->has('personal_number'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('personal_number') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group  col-lg-3 col-md-4  ">
                        <label>About</label>
                        <input type="text" class="form-control {{ $errors->has('about') ? 'is-invalid' : '' }}" name="about" placeholder="about" value="{{ $item_about }}"></input>
                        @if($errors->has('about'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('about') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group  col-lg-3 col-md-4  ">
                        <label>Comment</label>
                        <input type="text" class="form-control {{ $errors->has('comment') ? 'is-invalid' : '' }}" name="comment" placeholder="Comment" value="{{ $item_comment }}"></input>
                        @if($errors->has('comment'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex col-12">
                        <div class="form-group">
                            <label class="d-block">Died</label>
                            <input style="width:38px; height:38px;" onclick="displayDiedCheckbox(event)" type="checkbox" class="death-checkbox {{ $errors->has('death_checkbox') ? 'is-invalid' : '' }}" name="death_checkbox" placeholder="death_checkbox"></input>
                        </div>

                        <div class="form-group death-date  col-lg-3 col-md-4" style="display:none">
                            <label for="" class="d-block">Death Date</label>
                            <input type="date" class="form-control {{ $errors->has('died') ? 'is-invalid' : '' }}" name="died" placeholder="died" value="{{ $item_died}}"></input>
                            @if($errors->has('died'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('died') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                   
                </div>
                    
                <div class="form-group card-footer">
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    @csrf
                </div>
            </form>
            <!--end::Form-->

        </div>

    </div>
    <!--end::Container-->

    <script>
        let death_date = document.querySelector(".death-date")
        function displayDiedCheckbox(event = null){
            if(event == null && @json($item_died) !== null){
                death_date.style.display = "block"
                $(".death-checkbox").prop("checked", true);
            }
            if(event.target.checked){
                death_date.style.display = "block"
            }else{
                death_date.style.display = "none"
            }
        }
        displayDiedCheckbox()
    </script>
@endsection