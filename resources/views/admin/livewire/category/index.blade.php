<div class="col-12">
    @include('admin.livewire.category.update')
    @include('admin.livewire.category.create')

    <h2 class="page-title">{{ __('Category List') }}</h2>
    <div class="row">

        <!-- Bordered table -->
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="perPage" class="col-sm-4 col-form-label">{{ __('Per Page') }}</label>
                                <div class="col-sm-4">
                                    <select class="custom-select" id="perPage" wire:model="per_page">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label for="type" class="col-sm-4 col-form-label">{{ __('Type') }}</label>
                                <div class="col-sm-6">
                                    <select class="custom-select" id="type" wire:model="type">
                                        <option value="0">All</option>
                                        <option value="1">Parent Categories</option>
                                        <option value="2">Child Categories</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <input type="text" placeholder="{{ __('Type to search') }}" class="form-control" wire:model.debounce.500ms="query">
                            </div>
                        </div>
                        <div class="col-md-3 text-right">
                            <button type="button" class="btn mb-2 btn-primary" data-toggle="modal"
                                    data-target="#createModal" data-whatever="@mdo">
                                {{ __('Create new') }}
                            </button>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Parent') }}</th>
                            <th>{{ __('English Name') }}</th>
                            <th>{{ __('Arabic Name') }}</th>
                            <th>{{ __('Urdu Name') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->parent ? $row->parent->name_en : '' }}</td>
                                <td>{{ $row->name_en }}</td>
                                <td>{{ $row->name_ar }}</td>
                                <td>{{ $row->name_ur }}</td>
{{--                               <td>--}}
{{--                                    @foreach($row->categories as $category)--}}
{{--                                        <span class="badge badge-primary">{{ $category->name_en }}</span>--}}
{{--                                    @endforeach--}}
{{--                                </td>--}}
                                <td>
                                    <button wire:click="edit({{$row->id}})" data-toggle="modal"
                                            data-target="#updateModal" class="btn btn-sm btn-outline-danger py-0">{{ __('Edit') }}
                                    </button>
                                    |
                                    <button wire:click="destroy({{$row->id}})"
                                            class="btn btn-sm btn-outline-danger py-0">{{ __('Delete') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $list->links() }}
                </div>
            </div>
        </div> <!-- Bordered table -->
    </div> <!-- end section -->
</div> <!-- .col-12 -->
