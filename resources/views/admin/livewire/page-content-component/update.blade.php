<div class="modal fade" wire:ignore.self id="updateModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyModalLabel">{{ __('Update Page Content') }}</h5>
                <button type="button" class="close" wire:click.prevent="cancel()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>{{ __('Page Name') }}</label>
                        <select class="form-control" id="p_category" wire:model.defer="page_name_id">
                            <option selected >{{ __('Select Page') }}</option>
                            <option value="1" >{{ __('Terms & Condition') }}</option>
                            <option value="2" >{{ __('About Us') }}</option>
                            <option value="3" >{{ __('Contact Us') }}</option>
                            <option value="4" >{{ __('Privacy Policy') }}</option>
                        </select>
                        @error('page_name_id') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>                     

                
                    <div class="form-group">
                        <label>{{ __('Details') }}</label>
                        <textarea type="text" wire:model="page_details_en" class="form-control input-sm"  placeholder="{{ __('Details En') }}"></textarea>
                        @error('page_details_en') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>   

                    <div class="form-group">
                        <label>{{ __('Details') }}</label>
                        <textarea type="text" wire:model="page_details_ar" class="form-control input-sm"  placeholder="{{ __('Details Ar') }}"></textarea>
                        @error('page_details_ar') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>   

                    <div class="form-group">
                        <label>{{ __('Details') }}</label>
                        <textarea type="text" wire:model="page_details_ur" class="form-control input-sm"  placeholder="{{ __('Details Ur') }}"></textarea>
                        @error('page_details_ur') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                         
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn mb-2 btn-secondary" data-dismiss="modal">Close</button>
                <button wire:click.prevent="update()" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select2Update').select2({
                theme: 'bootstrap4',
                multiple: true,
                width: 'resolve',
                placeholder: 'Select a role',
                allowClear: true,
            }).on('change', function (e) {
                livewire.emit('rolesChanged', $("#select2Update").val())
            })

            window.addEventListener('clearSelect', (e) => {
                $('#select2Update').val([]);
                $('#select2Update').trigger('change');
            });

            window.addEventListener('showPreviousRoles', (e) => {
                $('#select2Update').val(e.detail.roles);
                $('#select2Update').trigger('change');
            });
        });
    </script>
@endpush
