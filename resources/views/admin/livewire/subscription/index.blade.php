<div class="col-12">
    @include('admin.livewire.subscription.update')
    @include('admin.livewire.subscription.create')

    <h2 class="page-title">{{ __('Subscription List') }}</h2>
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

                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Buying Service Type') }}</th>
                            <th>{{ __('Buy Request') }}</th>                            
                            <th>{{ __('Selling Service Type') }}</th>
                            <th>{{ __('Sell Request') }}</th>                            
                            <th>{{ __('Quotation Service Type') }}</th>
                            <th>{{ __('Quotation Request') }}</th>
                            <th>{{ __('No of Month') }}</th>
                            <th>{{ __('Fees') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->buying_service_type }}</td>
                                <td>{{ $row->no_of_buy_req }}</td>                                
                                <td>{{ $row->selling_service_type }}</td>
                                <td>{{ $row->no_of_sell_req }}</td>                                
                                <td>{{ $row->quot_service_type }}</td>
                                <td>{{ $row->no_of_quot_req }}</td>
                                <td>{{ $row->no_of_month }}</td>
                                <td>{{ $row->fees }}</td>
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
