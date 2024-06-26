<div class="modal fade" wire:ignore.self id="createModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyModalLabel">{{ __('New Brand') }}</h5>
                <button type="button" class="close" wire:click.prevent="cancel()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>{{ __('EN Name') }}</label>
                        <input type="text" wire:model="title_en" class="form-control input-sm"  placeholder="{{ __('Name En') }}">
                        @error('title_en') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>  

                    <div class="form-group">
                        <label>{{ __('AR Name') }}</label>
                        <input type="text" wire:model="title_ar" class="form-control input-sm"  placeholder="{{ __('Name Ar') }}">
                        @error('title_ar') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>  

                    <div class="form-group">
                        <label>{{ __('UR Name') }}</label>
                        <input type="text" wire:model="title_ur" class="form-control input-sm"  placeholder="{{ __('Name Ur') }}">
                        @error('title_ur') <span class="text-danger">{{ $message }}</span>@enderror
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
