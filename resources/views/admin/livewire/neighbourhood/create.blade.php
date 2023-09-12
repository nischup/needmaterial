<div class="modal fade" wire:ignore.self id="createModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyModalLabel">{{ __('New Neighbourhood') }}</h5>
                <button type="button" class="close" wire:click.prevent="cancel()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>{{ __('Select Country') }}</label>
                        <select class="form-control" id="p_category" wire:model.defer="country_id" wire:click="p_categoryChanged($event.target.value)">
                            <option selected >{{ __('Select Country') }}</option>
                            @foreach($categories as $item)
                                <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name'] }}</option>
                            @endforeach
                        </select>
                        @error('country_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="category">{{ __('Select City') }}</label>
                        <select class="form-control" id="category" wire:model.defer="city_id">
                            <option selected>{{ __('Select City') }}</option>
                            @if($child_categories)
                                @foreach($child_categories as $child_category)
                                    <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('city_id') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>


                    <div class="form-group">
                        <label>{{ __('Enter Neighbourhood') }}</label>
                        <input type="text" wire:model="title" class="form-control input-sm"  placeholder="{{ __('Title') }}">
                        @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn mb-2 btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <button wire:click.prevent="store()" class="btn btn-primary">{{ __('Submit') }}</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select2Create').select2({
                theme: 'bootstrap4',
                multiple: true,
                width: 'resolve',
                placeholder: "{{ __('Select a role') }}",
                allowClear: true,
            }).on('change', function (e) {
                livewire.emit('rolesChanged', $("#select2Create").val())
            })

            window.addEventListener('clearSelect', (e) => {
                $('#select2Create').val([]);
                $('#select2Create').trigger('change');
            });
        });
    </script>
@endpush
