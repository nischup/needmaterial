<!-- Modal -->
<div wire:ignore.self class="modal fade" id="manageProductsModal" tabindex="-1" role="dialog" aria-labelledby="manageProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageProductsModalLabel">{{ __('Add auction products') }}</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="brand">{{ __('Brand') }}</label>
                                <select wire:model="newProduct.brand" class="form-control form-control-sm" id="brand">
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                    @endforeach
                                </select>
                                @error('newProduct.brand') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">{{ __('Price') }}</label>
                                <input type="number" wire:model="newProduct.price" class="form-control form-control-sm" id="price" placeholder="Enter price">
                                @error('newProduct.price') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit">{{ __('Unit') }}</label>
                                <select wire:model="newProduct.unit" class="form-control form-control-sm" id="unit">
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                                    @endforeach
                                </select>
                                @error('newProduct.unit') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="made_in">{{ __('Made in') }}</label>
                                <input type="text" wire:model="newProduct.made_in" class="form-control form-control-sm" id="made_in" placeholder="Made in">
                                @error('newProduct.made_in') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="quantity">{{ __('Quantity') }}</label>
                                <input type="number" wire:model="newProduct.quantity" class="form-control form-control-sm" id="quantity" placeholder="Quantity">
                                @error('newProduct.quantity') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group" role="group" style="width: 100%">
                    <button type="button" wire:click.prevent="closeNewProduct()" style="height: unset" class="btn btn-secondary btn-sm close-btn" data-dismiss="modal">Close</button>
                    @if($updatingProductKey !== false)
                        <button type="button" wire:click.prevent="updateProduct()" style="height: unset" class="btn btn-primary btn-sm close-modal">{{ __('Save changes') }}</button>
                    @else
                        <button type="button" wire:click.prevent="addProduct()" style="height: unset" class="btn btn-primary btn-sm close-modal">{{ __('Save changes') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
