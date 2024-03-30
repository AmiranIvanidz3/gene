@extends('layouts.main')

@section('content')
    <!--begin::Container-->
    <div class=" container ">
        @if ($action == 'add')
            <?php 
            $title =  env('CREATE_NEW');
            $item_url = old('url');
            $item_platform_id = old('platform_id');
            $item_project_id = old('project_id');
            $item_comment = old('comment');
            $form_action = '/'.env('ADMIN_URL').'/accounts';
            ?>
        @else
            <?php 
            $title = 'Edit';
            $item_url= $item->url;
            $item_platform_id= $item->platform_id;
            $item_project_id= $item->project_id;
            $item_comment= $item->comment;
           
           
            $form_action = '/'.env('ADMIN_URL').'/accounts/'.$item->id;
            ?>
        @endif
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">
                                          <a class="btn mr-5 go-back" onclick="history.back()"><i class='flaticon2-back'></i></a>
                    {{$title}}
                </h3>
                {{-- @if (isset($item_logo))
                    <img
                        class="mt-3" 
                        src="{{asset('assets/images/projects/'.$item_logo)}}"
                        style="max-width: 50px; max-height: 50px;"
                        alt="">
                        
                @endif --}}

            </div>
            <!--begin::Form-->
            <form class="form" method="POST" action="{{$form_action}}" enctype="multipart/form-data">
                @if ($action == 'edit')
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleSelect">Project <span class="text-danger">*</span></label>
                        <select name="project_id"  id="exampleSelect"  class="form-control {{ $errors->has('project_id') ? 'is-invalid' : '' }}">
                            <option selected value="" >Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"  {{ $item_project_id== $project->id ? 'selected' : '' }}>{{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('project_id'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('project_id') }}</strong>
                            </div>
                        @endif
                    </div>


                    <div class="form-group">
                        <label for="exampleSelect">Platform <span class="text-danger">*</span></label>
                        <select  name="platform_id"  id="exampleSelect"  class="form-control {{ $errors->has('platform_id') ? 'is-invalid' : '' }}">
                            <option selected value="">Select Platform</option>
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}"  {{ $item_platform_id== $platform->id ? 'selected' : '' }}>{{ $platform->name }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('platform_id'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('platform_id') }}</strong>
                            </div>
                         @endif
                    </div>


                    <div class="form-group">
                        <label>URL <span class="text-danger">*</span></label>
                        <input type="text" value="{{$item_url }}"  class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" name="url" placeholder="URL"/>
                        @if($errors->has('url'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('url') }}</strong>
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