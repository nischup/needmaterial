<div class="modal fade" wire:ignore.self id="createModal" tabindex="-1" role="dialog" aria-labelledby="varyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varyModalLabel">{{ __('New Subscription') }}</h5>
                <button type="button" class="close" wire:click.prevent="cancel()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>{{ __('Subscription Name') }}</label>
                        <input type="text" wire:model="name" class="form-control input-sm"  placeholder="{{ __('Name') }}">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>  

                    <div class="row">
                        <div class="col-md-12">
                             <div class="form-group">
                                <label>{{ __('User Type') }}</label>
                                <select wire:model="user_type" class="form-group form-control" onchange="showDiv('hidden_div', this)">
                                    <option value="" selected> Select User Type</option>
                                    <option value="CUSTOMER"> Customer </option>
                                    <option value="SUPPLIER"> Supplier </option>
                                </select>
                            </div> 
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label>{{ __('Service Type') }}</label>
                                     <input type="text" wire:model="buying_service_type" value="BUYING" class="form-control input-sm"  placeholder="{{ __('BUYING') }}" readonly>
                            {{--     <select wire:model="buying_service_type" class="form-group form-control">
                                    <option value="" selected> Select Type Buying</option>
                                    <option value="BUYING" selected> Buying </option>
                                </select> --}}
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('No of Buy Request') }}</label>
                                <input type="number" wire:model="no_of_buy_req" class="form-control input-sm" min="0"  placeholder="0">
                            </div>  
                        </div>
                    </div>                    

                    <div class="row" wire:ignore id="supplier_div" style="display: none">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Service Type') }}</label>
                                <input type="text" wire:model="selling_service_type" value="SELLING" class="form-control input-sm"  placeholder="{{ __('SELLING') }}" readonly>
                              {{--   <select wire:model="selling_service_type" class="form-group form-control">
                                    <option value="" selected > Select Type Selling</option>
                                    <option value="SELLING" selected> Selling </option>
                                </select> --}}
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('No of Sell Request') }}</label>
                                <input type="number" wire:model="no_of_sell_req" class="form-control input-sm" min="0"  placeholder="0">
                            </div>   
                        </div>
                    </div>                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Service Type') }}</label>
                                 <input type="text" wire:model="quot_service_type" value="QUOTATION" class="form-control input-sm"  placeholder="{{ __('QUOTATION') }}" readonly>
                             {{--    <select wire:model="quot_service_type" class="form-group form-control">
                                    <option value="" selected > Select Type Quotation</option>
                                    <option value="QUOTATION" selected> QUOTATION </option>
                                </select> --}}
                            </div>   
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('No of Quotation Request') }}</label>
                                <input type="number" wire:model="no_of_quot_req" class="form-control input-sm" min="0"  placeholder="0">
                            </div>   
                        </div>
                    </div>                    

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('Service Type') }}</label>
                                 <input type="text" wire:model="quot_service_type" value="ADVERTISING" class="form-control input-sm"  placeholder="{{ __('ADVERTISING') }}" readonly>
                          {{--       <select wire:model="advertising_service_type" class="form-group form-control">
                                    <option value="" selected > Select Type Advertising</option>
                                    <option value="ADVERTISING" selected> ADVERTISING </option>
                                </select> --}}
                            </div>   
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('No of Advertising Request') }}</label>
                                <input type="number" wire:model="no_of_adver_req" class="form-control input-sm" min="0"  placeholder="0">
                            </div>  
                        </div>
                    </div>      

                    <div class="form-group">
                        <label>{{ __('No of Month') }}</label>
                        <input type="number" wire:model="no_of_month" class="form-control input-sm"  placeholder="{{ __('Month') }}">
                        @error('no_of_month') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>  

                    <div class="form-group">
                        <label>{{ __('Fees') }}</label>
                        <input type="number" wire:model="fees" class="form-control input-sm"  placeholder="{{ __('Fees') }}">
                        @error('fees') <span class="text-danger">{{ $message }}</span>@enderror
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

        function showDiv(divId, element)
        {
            // alert(element.value);
            if (element.value === "SUPPLIER")
                  $('#supplier_div').show();
            else{
                $('#supplier_div').hide();
            }
            // document.getElementById(divId).style.display = element.value === "SUPPLIER" ? 'block' : 'none';
        }
    </script>
@endpush
