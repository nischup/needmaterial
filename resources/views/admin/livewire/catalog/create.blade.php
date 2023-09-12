<div class="modal fade" wire:ignore.self id="createModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyModalLabel">{{ __('New Catalog') }}</h5>
                <button type="button" class="close" wire:click.prevent="cancel()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>{{ __('Select Category') }}</label>
                        <select class="form-control" id="p_category" wire:model.defer="p_category" wire:click="p_categoryChanged($event.target.value)">
                            <option selected >{{ __('Select Category') }}</option>
                            @foreach($categories as $item)
                                <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name_en'] }}</option>
                            @endforeach
                        </select>
                        @error('p_category') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="category">{{ __('Select Sub Category') }}</label>
                        <select class="form-control" id="category" wire:model.defer="category">
                            <option selected>{{ __('Select Sub Category') }}</option>
                            @if($child_categories)
                                @foreach($child_categories as $child_category)
                                    <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name_en'] }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('category') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>


                    <div class="form-group">
                        <label>{{ __('Enter Name') }}</label>
                        <input type="text" wire:model="title" class="form-control input-sm"  placeholder="{{ __('Title') }}">
                        @error('title') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control form-control-sm" id="description" wire:model.defer="description" placeholder="Enter description"></textarea>
                        @error('description') <span class="text-danger error">{{ $message }}</span> @enderror
                    </div>

                     @if($editing && count($oldImages))
                        <table class="table table-sm">
                            <thead>
                            <th>Previous Image</th>
                            <th>Action</th>
                            </thead>
                            <tbody>
                            @foreach($oldImages as $key => $image)
                            <tr>
                                <td><img src="{{ $image->src }}" width="50px" alt=""></td>
                                <td><a href="#" wire:click.prevent="imageDelete({{ $image->id }}, {{ $key }})">Delete</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if ($images && count($images))
                        {{ __('Photo Preview') }}:
                        @foreach ($images as $image)
                            <img class="img-thumbnail" src="{{ $image->temporaryUrl() }}" style="height: 100px">
                        @endforeach
                    @endif

                    <div class="form-group">
                        <label for="images">{{ __('Images') }}</label>
                        <input type="file" multiple id="images" wire:model="images">
                        <div wire:loading wire:target="images">{{ __('Uploading') }}...</div>
                        @error('images') <span class="text-danger error">{{ $message }}</span> @enderror
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
