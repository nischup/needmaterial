<form>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($categories)
        <div class="row mb-30">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <select class="form-select pl-3" wire:model="p_category" wire:click="p_categoryChanged($event.target.value)">
                        <option selected disabled>{{ __('Select Category') }}</option>
                        @foreach($categories as $item)
                            <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name_en'] }}</option>
                        @endforeach
                    </select>
                </div>
                @error('p_category') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <select class="form-select pl-3" wire:model="category">
                        <option selected>Select Sub Category</option>
                        @if($child_categories)
                            @foreach($child_categories as $child_category)
                                <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name_en'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @error('category') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        </div>
    @endif

    <div class="mb-30">
        <div class="form-group mb-0">
            <input type="text" wire:model="title" placeholder="{{ __('Title') }}">
        </div>
        @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30">
        <div class="form-group mb-0">
            <textarea type="text" wire:model="description" rows="2" id="description" placeholder="Description"></textarea>
        </div>
        @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="row mb-30">
        <div class="col-md-6">
            <div class="form-group mb-0">
                <input type="text" wire:model="brand" placeholder="{{ __('Brand') }}">
            </div>
            @error('brand') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <input type="text" wire:model="quantity" placeholder="{{ __('Quantity') }}">
            </div>
            @error('quantity') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="mb-30">
        <div class="form-group mb-0">
            <select class="form-select pl-3" wire:model="unit" aria-label="Unit">
                <option selected>Select Unit</option>
                <option value="1">Kilogram</option>
                <option value="2">Meter</option>
            </select>
        </div>
        @error('unit') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30">
        <div class="form-group mb-0">
            <input type="text" wire:model="made_in" placeholder="{{ __('Made in') }}">
        </div>
        @error('made_in') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="row mb-30">
        <div class="col-md-6">
            <div class="form-group mb-0">
                <input class="form-check-input" type="checkbox" wire:model="is_exact_item" id="is_exact_item" style="height: auto">
                <label class="form-check-label" for="is_exact_item">Exact Item</label>
            </div>
            @error('is_exact_item') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <input class="form-check-input" type="checkbox" wire:model="best_price" id="best_price" style="height: auto">
                <label class="form-check-label" for="best_price">Best Price</label>
            </div>
            @error('best_price') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    </div>

        <div class="mb-30">
            <div class="form-group mb-0">
                <input type="file" placeholder="{{ __('Photo') }}">
            </div>
            @error('photo') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="mb-30">
            <div class="form-group mb-0">
                <input type="text" placeholder="{{ __('Delivery Address') }}">
            </div>
        </div>

        <div class="mb-30">
            <div class="form-group mb-0">
                <input type="text" placeholder="{{ __('City') }}">
            </div>
        </div>

        <div class="mb-30">
            <div class="form-group mb-0">
                <input type="text" placeholder="{{ __('Area') }}">
            </div>
        </div>

        <div class="row mb-30">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input type="datetime-local" class="form-control" placeholder="{{ __('Start date') }}"/>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input type="datetime-local" class="form-control" placeholder="{{ __('End date') }}"/>
                </div>
            </div>
        </div>
        <div class="row mb-30">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input class="form-check-input" type="checkbox" style="height: auto" id="delivery_cost_included">
                    <label class="form-check-label" for="delivery_cost_included">With Delivery cost</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input class="form-control" type="date" placeholder="Delivery Date">
                </div>
            </div>
        </div>
    <div class="form-group mb-0">
        <button type="button" wire:click.prevent="store" class="custom-button">Save</button>
    </div>
</form>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select2Register').select2({
                theme: 'bootstrap4',
                multiple: true,
                width: 'resolve',
                placeholder: "{{ __('Select a role') }}",
                allowClear: true,
            }).on('change', function (e) {
                livewire.emit('categoryChanged', $("#select2Create").val())
            });

            window.addEventListener('clearSelect', (e) => {
                $('#select2Register').val([]);
                $('#select2Register').trigger('change');
            });
        });
    </script>
@endpush