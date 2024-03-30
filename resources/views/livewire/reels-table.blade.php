<div class="col-12 mt-5">
    <style>
       table {
         
        }
    </style>
            <div class="row mb-3 d-flex">
                <div class="col-3 d-flex align-items-center">
                    Search: 
                    <input wire:model.live.debounce.300ms="search"  type="text" class="form-control ml-4">

                    
                </div>  
                @foreach ($users as $x)
                <h1>{{ $x }}</h1>
                    
                @endforeach
                <div class="d-flex align-items-center">
                    <div  wire:loading>
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-bordered table-responsive">
                        <thead>
                            <tr>
                                @include('livewire.includes.table-sortable-th',[
                                    'name' => 'id',
                                    'displayName' => 'ID / Video'
                                ])
                                @include('livewire.includes.table-sortable-th',[
                                    'name' => 'author_name',
                                    'displayName' => 'Video Author'
                                ])
                                @include('livewire.includes.table-sortable-th',[
                                    'name' => 'reel_statuses_id',
                                    'displayName' => 'Status'
                                ])
                                @include('livewire.includes.table-sortable-th',[
                                    'name' => 'title',
                                    'displayName' => 'title'
                                ])
                                @include('livewire.includes.table-sortable-th',[
                                    'name' => 'from',
                                    'displayName' => 'From - To'
                                ])
                                 @include('livewire.includes.table-sortable-th',[
                                    'name' => 'from',
                                    'displayName' => 'Start...End / Comment'
                                ])
                                 @include('livewire.includes.table-sortable-th',[
                                    'name' => 'from',
                                    'displayName' => 'Content Lenght / Story'
                                ])
                                 @include('livewire.includes.table-sortable-th',[
                                    'name' => 'from',
                                    'displayName' => 'Published At'
                                ])
                                <th style="font-weight:normal">
                                    Actions
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr wire:key="{{ $user->id }}" class="border-b dark:border-gray-700">
                                    <td>
                                        <p>Reel: {{ $user->id }}</p>
                                        <p>Video: {{ $user->video_id }}</p>
                                    </td>
                                    <td>
                                        {{ $user->author_name }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                          
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <select wire:change="changeStatus({{ $user->id }}, $event.target.value)" id="status_selector" class="form-select">
                                                @foreach ($statuses as $status)
                                                    <option {{ $user->reel_statuses_id == $status->id ? "selected" : "" }} value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $user->title }}
                                    </td>
                                    <td>
                                        {{ $user->from }} - {{ $user->to }}
                                    </td>
                                    <td>
                                        <p>
                                            {{ $user->start }}
                                                {{ $user->start && $user->end ? "..." : "" }}
                                            {{ $user->end }}
                                        </p>
                                        <p class="text-danger">
                                            {{ $user->comment }}
                                        </p>
                                    </td>

                                    <td>
                                        <p>{{ $user->content_length ? $user->content_length : "" }}</p>
                                        <p class="text-danger">
                                            {{ $user->story ? $user->story : "" }}
                                        </p>
                                    </td>

                                    <td>{{ $user->published_at }}</td>
                                    
                                 
                                    <td>
                                        <div>
                                            <a href="{{ route('reels.edit', ['reel' => $user->id]) }}" class="btn btn-sm btn-clean btn-icon" title="Edit"><i class="la la-edit"></i></a>
                                            <button
                                            onclick="confirm('Are you sure you want to delete  ?') || event.stopImmediatePropagation()"
                                            wire:click="delete({{ $user->id }})"
                                            class="btn btn-sm btn-clean btn-icon" title="Delete"><i class="la la-remove"></i></button>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900">Per Page</label>
                            <select wire:model.live='perPage'
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    {{ $users->links() }}
                </div>
</div>
