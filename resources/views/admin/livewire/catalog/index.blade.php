<div class="col-12">
    @include('admin.livewire.catalog.update')
    @include('admin.livewire.catalog.create')

    <h2 class="page-title">{{ __('Catalog List') }}</h2>
    <div class="row">

        <!-- Bordered table -->
        <div class="col-md-12 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label for="perPage" class="col-sm-4 col-form-label">{{ __('Per Page') }}</label>
                                <div class="col-sm-8">
                                    <select class="custom-select" id="perPage" wire:model="per_page">
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <input type="text" placeholder="{{ __('Type to search') }}" class="form-control" wire:model.debounce.500ms="query">
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn mb-2 btn-primary" data-toggle="modal"
                                    data-target="#createModal" data-whatever="@mdo">
                                {{ __('Create new') }}
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <select wire:model.defer="p_category" wire:change="p_categoryChanged($event.target.value)" class="form-control form-control-sm">
                                    <option selected value="">{{ __('Select Category') }}</option>
                                    @foreach($categories as $item)
                                        <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name_en'] }}</option>
                                    @endforeach
                                </select>
                                @error('p_category') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select wire:model="category" class="form-control form-control-sm">
                                    <option selected value="">{{ __('Select Sub Category') }}</option>
                                    @if($child_categories)
                                        @foreach($child_categories as $child_category)
                                            <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name_en'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('category') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->title }}</td>
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
