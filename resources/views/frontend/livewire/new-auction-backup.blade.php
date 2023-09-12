@push('styles')

@endpush
<div>
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

        <div class="mb-30">
            <div class="form-group mb-0">
                <label for="service_type"> {{ __('Service Type') }}</label>
                <select class="form-select form-control-sm" wire:model.defer="service_type" id="service_type">
                    <option value="">Select Service Type</option>
                    <option value="{{ \App\Models\Auction::BUYING_SERVICE }}">BUYING</option>
                    @if(auth()->user()->hasRole('supplier'))
                    <option value="{{ \App\Models\Auction::SELLING_SERVICE }}" selected>SELLING</option>
                    @endif
                    <option value="{{ \App\Models\Auction::QUOTATION_SERVICE }}" selected>QUOTATION</option>
                </select>
            </div>
            @error('service_type') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>

        <div class="row mb-20">
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input class="form-check-input" name="is_open_bid" type="radio" wire:model.defer="is_open_bid" value="1" id="is_open_bid" style="height: auto">
                    <label class="form-check-label" for="is_open_bid">Open Bid</label>
                </div>
                @error('is_open_bid') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
            <div class="col-md-6">
                <div class="form-group mb-0">
                    <input class="form-check-input" name="is_open_bid" type="radio" wire:model.defer="is_open_bid" value="0" id="closed_bid" style="height: auto">
                    <label class="form-check-label" for="closed_bid">Close Bid</label>
                </div>
                @error('is_open_bid') <span class="text-danger error">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="row mb-20">

            <div class="col-md-3">
                <div class="mb-30" wire:ignore id="country_div" style="display: none">
                    <label for="country"> {{ __('Country') }}</label>
                    <select id="country" class="form-control">
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">
                                {{  $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>        
            </div>

            <div class="col-md-3">
                <div class="mb-30" wire:ignore id="city_div" style="display: none">
                    <label for="city"> {{ __('City') }}</label>
                    <select id="city" class="form-control">
                        @foreach($city as $ct)
                            <option value="{{ $ct->id }}">
                                {{ $ct->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedSuppliers') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>        
            </div>        

            <div class="col-md-3">
                <div class="mb-30" wire:ignore id="neighborhood_div" style="display: none">
                    <label for="neighborhood"> {{ __('Neighborhood') }}</label>
                     <input type="text" class="input-group-sm" id="neighborhood" placeholder="">
                    @error('selectedSuppliers') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>        
            </div>

            <div class="col-md-3">
                <div class="mb-30" wire:ignore id="suppliers_div" style="display: none">
                    <label for="suppliers"> {{ __('Target suppliers') }}</label>
                    <select id="suppliers" class="form-control">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">
                                {{ $supplier->profile ? ($supplier->profile->company ? $supplier->profile->company->name : $supplier->name) : $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('selectedSuppliers') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>

        </div>

        <div class="mb-30">
            <div class="form-group mb-0">
                <label for="title">{{ __('Auction Title') }}</label>
                <input type="text" class="input-group-sm" id="title" wire:model.defer="title" placeholder="">
            </div>
            @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>

        <div class="mb-30">
            <div class="form-group mb-0" wire:ignore>
                <label for="description_input">{{ __('Auction Description') }}</label>
                <textarea id="editor" rows="5"></textarea>
            </div>
            @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
{{-- 
        <table class="table table-responsive-sm w-100">
                <thead>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Sub Category') }}</th>
                    <th>{{ __('Catalogue') }}</th>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Brand') }}</th>
                    <th>{{ __('Unit') }}</th>
                    <th>{{ __('Brand Type') }}</th>
                    <th>{{ __('Made in') }}</th>
                    <th>{{ __('Quantity') }}</th>
                    <th>{{ __('Images') }}</th>
                    <th width="10%">{{ __('Action') }}</th>
                </thead>
            <tbody  style="border: 1px solid #c6cdd3;">
            @foreach($selectedProducts as $key => $item)
                <tr>
                    <td>
                        <div class="form-group">
                            <select wire:model.defer="selectedProducts.{{$key}}.p_category" wire:change="p_categoryChanged($event.target.value,{{$key}})" class="form-control form-control-sm">
                                <option selected value="">{{ __('Select Category') }}</option>
                             @foreach($categories as $item)
                                <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name_en'] }}</option>
                            @endforeach
                            </select>
                            @error('selectedProducts.'.$key.'.p_category') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select wire:model.defer="selectedProducts.{{$key}}.category" wire:change="categoryChanged($event.target.value,{{$key}})" class="form-control form-control-sm">
                               <option selected value="">{{ __('Select Sub Category') }}</option>
                                @if($child_categories && $child_categories[$key])
                                    @foreach($child_categories[$key] as $child_category)
                                        <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name_en'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('selectedProducts.'.$key.'.category') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <select wire:model.defer="selectedProducts.{{$key}}.catalogue" wire:change="catalogueChanged($event.target.value,{{$key}})" class="form-control form-control-sm">
                                <option selected value="" disabled>{{ __('Select Catalog Product') }}</option>
                                @if($catalogues && $catalogues[$key])
                                    @foreach($catalogues[$key] as $catalogue)
                                        @if($catalogue)
                                            <option value="{{ $catalogue['id'] }}">{{ $catalogue['title'] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @error('selectedProducts.'.$key.'.catalogue') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                    <td style="width: 100px;">
                        <div class="form-group">
                        <input type="text" wire:model.defer="selectedProducts.{{$key}}.product_title" class="form-control form-control-sm" placeholder="Title">
                            @error('selectedProducts.'.$key.'.product_title') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </td>       

                    <td style="width: 100px;">
                        <div class="form-group">
                            <select wire:model.defer="selectedProducts.{{$key}}.brand" class="form-control form-control-sm">
                                <option value="" selected disabled> Select Brand</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                @endforeach
                            </select>
                            @error('selectedProducts.'.$key.'.brand') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                    <td style="width: 100px;">
                        <div class="form-group">
                            <select wire:model.defer="selectedProducts.{{$key}}.unit" class="form-control form-control-sm">
                                <option value="" selected disabled> Select Unit </option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                                @endforeach
                            </select>
                            @error('selectedProducts.'.$key.'.unit') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                    <td>
                        <select  wire:model.defer="selectedProducts.{{$key}}.is_exact_item" class="form-control form-control-sm">
                            <option value="" selected disabled> Select Brand Type </option>
                            <option value="0">{{ __('Any Brand') }}</option>
                            <option value="1">{{ __('Exact Brand') }}</option>
                       
                    </select>

                        @error('selectedProducts.'.$key.'.is_exact_item') <span class="text-danger error">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <select wire:model.defer="selectedProducts.{{$key}}.made_in" class="form-control form-control-sm">
                            <option value="" selected disabled> Select Made In </option>
                                @foreach($made_in as $made_data)
                                    <option value="{{ $made_data->id }}">{{ $made_data->name }}</option>
                                @endforeach
                            </select>

                        @error('selectedProducts.'.$key.'.made_in') <span class="text-danger error">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        <input type="number" wire:model.defer="selectedProducts.{{$key}}.quantity" class="form-control form-control-sm" placeholder="Quantity">
                        @error('selectedProducts.'.$key.'.quantity') <span class="text-danger error">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        @if($selectedProducts[$key]['catalogue'])
                            <button type="button" class="btn btn-sm" wire:click="showCatalogueImageModal({{$key}})" style="height: unset; width: unset"><i style="color:green;" class="fa fa-eye" aria-hidden="true"></i></button>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm" wire:click="removeProduct({{$key}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table> --}}


       <div class="row mb-30" >

        @foreach($selectedProducts as $key => $item)

        <div class="auction-product" style="border: 1px solid #c6cdd3;">
            
      
        <div class="row">
            <div class="col-md-2">
                 <div class="form-group  mb-0">
                    <label>{{ __('Category') }}:</label>
                    <select wire:model.defer="selectedProducts.{{$key}}.p_category" wire:change="p_categoryChanged($event.target.value,{{$key}})" class="form-control form-control-sm">
                        <option selected value="">{{ __('Select Category') }}</option>
                     @foreach($categories as $item)
                        <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name_en'] }}</option>
                    @endforeach
                    </select>
                    @error('selectedProducts.'.$key.'.p_category') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label>{{ __('Sub Category') }}:</label>
                   <select wire:model.defer="selectedProducts.{{$key}}.category" wire:change="categoryChanged($event.target.value,{{$key}})" class="form-control form-control-sm">
                               <option selected value="">{{ __('Select Sub Category') }}</option>
                                @if($child_categories && $child_categories[$key])
                                    @foreach($child_categories[$key] as $child_category)
                                        <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name_en'] }}</option>
                                    @endforeach
                                @endif
                    </select>
                    @error('selectedProducts.'.$key.'.category') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label>{{ __('Catalogue') }}:</label>
                   <select wire:model.defer="selectedProducts.{{$key}}.catalogue" wire:change="catalogueChanged($event.target.value,{{$key}})" class="form-control form-control-sm">
                                <option selected value="">{{ __('Select Catalog Product') }}</option>
                                @if($catalogues && $catalogues[$key])
                                    @foreach($catalogues[$key] as $catalogue)
                                        @if($catalogue)
                                            <option value="{{ $catalogue['id'] }}">{{ $catalogue['title'] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                    </select>
                    @error('selectedProducts.'.$key.'.catalogue') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
            </div>  

            <div class="col-md-2">
                  <label>{{ __('Title') }}:</label>
               <div class="form-group">
                <input type="text" wire:model.defer="selectedProducts.{{$key}}.product_title" class="form-control form-control-sm" placeholder="Title">
                    @error('selectedProducts.'.$key.'.product_title') <span class="text-danger error">{{ $message }}</span> @enderror
                </div> 
            </div>

            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label>{{ __('Brand') }}:</label>
                    <select wire:model.defer="selectedProducts.{{$key}}.brand" class="form-control form-control-sm">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                            @endforeach
                    </select>
                    @error('selectedProducts.'.$key.'.brand') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
            </div>     

            <div class="col-md-2">
                <div class="form-group mb-0">
                    <label>{{ __('Brand Type') }}:</label>
                       <select  wire:model.defer="selectedProducts.{{$key}}.is_exact_item" class="form-control form-control-sm">
                        <option value="" selected disabled> Select Brand Type </option>
                        <option value="0">{{ __('Any Brand') }}</option>
                        <option value="1">{{ __('Exact Brand') }}</option>
                    </select>
                    @error('selectedProducts.'.$key.'.is_exact_item') <span class="text-danger error">{{ $message }}</span> @enderror
                </div>
            </div>     
           
        </div>

        <br>
        <div class="row">

                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <label>{{ __('Unit') }}:</label>
                             <select wire:model.defer="selectedProducts.{{$key}}.unit" class="form-control form-control-sm">
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->title }}</option>
                                @endforeach
                            </select>
                            @error('selectedProducts.'.$key.'.unit') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div> 

                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <label>{{ __('Made In') }}:</label>
                                <select wire:model.defer="selectedProducts.{{$key}}.made_in" class="form-control form-control-sm">
                            <option value="" selected disabled> Select Made In </option>
                                @foreach($made_in as $made_data)
                                    <option value="{{ $made_data->id }}">{{ $made_data->name }}</option>
                                @endforeach
                            </select>

                             @error('selectedProducts.'.$key.'.made_in') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>            

                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <label>{{ __('Quantity') }}:</label>
                            <input type="number" wire:model.defer="selectedProducts.{{$key}}.quantity" class="form-control form-control-sm" placeholder="Quantity">
                                @error('selectedProducts.'.$key.'.quantity') <span class="text-danger error">{{ $message }}</span> @enderror
                        </div>
                    </div>            

                    <div class="col-md-2">
                        <div class="form-group mb-0">
                            <label>{{ __('Description') }}:</label>
                            <textarea class="form-control"></textarea>
                            @error('delivery_date') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>            

                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label>{{ __('Images') }}:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    @if($catalogueImages)
                                      @foreach($catalogueImages as $key => $image)
                                        <tr>
                                            <td><img src="{{ isset($image['src']) ? $image['src'] : asset('storage/' . $image['src_original']) }}" width="50px" alt=""></td>
                                            <td><a href="#" wire:click.prevent="imageDelete({{ $key }})">Del</a></td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </div>
                               
                                <div class="col-md-7">
                                    <input type="file" accept="image/*" multiple id="images" wire:model="productNewImages">
                                </div>
                            </div>
                        </div>
                    </div>     

                    <div class="col-md-1">
                        <div class="form-group mb-0">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm" wire:click="removeProduct({{$key}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>

                    </div>
                    <br>
                    @endforeach

                </div>

            <br>

                @error('products') <span class="text-danger error">{{ $message }}</span>@enderror
                <div class="mb-30" style="width: unset; text-align: right">
                    <button type="button" data-toggle="modal"
                            wire:click="addRow"
                            class="btn btn-primary btn-sm"
                            style="height: unset; width: unset"
                    >{{ __('Add Products') }}</button>
                </div>


                <div class="mb-30" wire:ignore>
                    <div class="form-group mb-0">
                        <label for="address-input">{{ __('Delivery Address') }}:</label>
                        <input type="text" class="map-input" placeholder="{{ __('Delivery Address') }}" id="address-input">
                        @error('delivery_address') <span class="text-danger error">{{ $message }}</span>@enderror
                        <div id="address-map-container" style="width:100%;height:400px;" class="pt-2">
                            <div style="width: 100%; height: 100%" id="address-map"></div>
                        </div>
                    </div>
                </div>

                <input type="hidden" wire:model.lazy="delivery_address" id="address" value="" />
                <input type="hidden" wire:model.lazy="lat" id="address-latitude" value="0" />
                <input type="hidden" wire:model.lazy="long" id="address-longitude" value="0" />

                <div class="mb-30">
                    <div class="form-group mb-0">
                        <label for="comment">{{ __('Comment') }}:</label>
                        <textarea placeholder="{{ __('Comment') }}" wire:model.defer="comment" rows="2" style="height: unset"></textarea>
                        @error('comment') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-30">

                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label>{{ __('Start time') }}:</label>
                            <input type="datetime-local" class="form-control" placeholder="{{ __('Start time') }}" wire:model.defer="start_time"/>
                            @error('start_time') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label>{{ __('End time') }}:</label>
                            <input type="datetime-local" class="form-control" placeholder="{{ __('End time') }}" wire:model.defer="end_time"/>
                            @error('end_time') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label>{{ __('Delivery Date') }}:</label>
                            <input class="form-control" type="date" wire:model.defer="delivery_date" placeholder="{{ __('Delivery Date') }}">
                            @error('delivery_date') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row mb-30">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <input class="form-check-input" type="checkbox" wire:model.defer="delivery_cost_included" style="height: auto" id="delivery_cost_included"><label>{{ __('With Delivery Charge') }}</label>
                            @error('delivery_cost_included') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                          <div class="form-group mb-0">
                            <input class="form-check-input" type="checkbox" wire:model.defer="vat" style="height: auto" id="vat"><label>{{ __('With VAT') }}</label>
                            @error('vat') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0">

                    <button type="button" wire:click.prevent="storeAuction" class="custom-button">{{ __('Save') }}</button>

                </div>
            </form>

            <!-- Modal -->
            <div class="model__add__product" id="catalogueImagesModal" wire:ignore.self>
                <div class="d-flex justify-content-center align-items-center">
                    <div class="model rounded">
                        <div class="modal-header">
                            <div class=" d-flex">
                                <h5>Manage images nn</h5>
                                <div style="font-size: 30px; cursor: pointer; position: absolute; right: 30px;" id="close__model">&times;</div>
                            </div>
                        </div>
                        <div class="modal-body">
                            @if($catalogueImages)
                                <table class="table table-sm">
                                    <thead>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($catalogueImages as $key => $image)
                                        <tr>
                                            <td>{{ isset($image['id']) ? $image['id'] : '' }}</td>
                                            <td><img src="{{ isset($image['src']) ? $image['src'] : asset('storage/' . $image['src_original']) }}" width="50px" alt=""></td>
                                            <td><a href="#" wire:click.prevent="imageDelete({{ $key }})">Delete</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif

                            @if ($productNewImages && count($productNewImages))
                                {{ __('Photo Preview') }}:
                                @foreach ($productNewImages as $image)
                                    <img class="img-thumbnail" src="{{ $image->temporaryUrl() }}" style="height: 100px">
                                @endforeach
                            @endif

                            <div class="form-group">
                                <label for="images">{{ __('New Images') }}</label>
                                <input type="file" accept="image/*" multiple id="images" wire:model="productNewImages">
                                <div wire:loading wire:target="images">{{ __('Uploading') }}...</div>
                                @error('images') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer d-flex">
                            <button type="button" class="btn btn-secondary w-auto" data-dismiss="modal"
                                    id="close__models">Cancel</button>
                            <button type="button" class="btn btn-primary w-auto" wire:click="catalogueImageManageDone">Done</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal end-->
        </div>

  </div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // START MAP RELATED JS
        function initialize() {
            $('form').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
            const locationInputs = document.getElementsByClassName("map-input");

            const autocompletes = [];
            const geocoder = new google.maps.Geocoder;
            for (let i = 0; i < locationInputs.length; i++) {

                const input = locationInputs[i];
                const fieldKey = input.id.replace("-input", "");
                const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

                let latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
                let longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

                const map = new google.maps.Map(document.getElementById('address-map'), {
                    center: {lat: latitude, lng: longitude},
                    zoom: 13
                });

                var infoWindow = new google.maps.InfoWindow({map: map});

                const marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP,
                    position: {lat: latitude, lng: longitude},
                });

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        var pos = {
                            lat: latitude,
                            lng: longitude
                        };

                        console.log('Location found.');
                        map.setCenter(pos);

                        marker.setPosition(pos);
                        marker.setVisible(true);
                    }, function() {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }

                marker.setVisible(isEdit);

                const autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.key = fieldKey;
                autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
            }

            for (let i = 0; i < autocompletes.length; i++) {
                const input = autocompletes[i].input;
                const autocomplete = autocompletes[i].autocomplete;
                const map = autocompletes[i].map;
                const marker = autocompletes[i].marker;

                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    marker.setVisible(false);
                    const place = autocomplete.getPlace();

                    //get the autocompletes text
                    @this.set('delivery_address', $('#address-input').val());

                    geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            const lat = results[0].geometry.location.lat();
                            const lng = results[0].geometry.location.lng();
                            setLocationCoordinates(autocomplete.key, lat, lng);
                        }
                    });

                    if (!place.geometry) {
                        window.alert("No details available for input: '" + place.name + "'");
                        input.value = "";
                        return;
                    }

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                });
            }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            console.log(pos);
            browserHasGeolocation ? console.log('Error: The Geolocation service failed.') : console.log('Error: Your browser doesn\'t support geolocation.');
        }

        function setLocationCoordinates(key, lat, lng) {
            const latitudeField = document.getElementById(key + "-" + "latitude");
            const longitudeField = document.getElementById(key + "-" + "longitude");
            latitudeField.value = lat;
            longitudeField.value = lng;

            @this.set('lat', lat);
            @this.set('long', lng);
        }
        // END MAP RELATED JS
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_map_api_key') }}&libraries=places&callback=initialize" async defer></script>
    <script src="https://cdn.tiny.cloud/1/17ycczrflflupm9i12k8e0q2tp8gua0mlhkzcb1kkbirlaxv/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#editor',
            init_instance_callback: function (editor) {
                var freeTiny = document.querySelector('.tox .tox-notification--in');
                freeTiny.style.display = 'none';
            },
            menubar: false,
            statusbar: false,
            plugins: 'autoresize anchor autolink charmap code codesample directionality fullpage help hr image imagetools insertdatetime link lists media nonbreaking pagebreak preview print searchreplace table template textpattern toc visualblocks visualchars',
            toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help fullscreen ',
            skin: 'bootstrap',
            toolbar_drawer: 'floating',
            min_height: 200,
            autoresize_bottom_margin: 16,
            onchange_callback : "loadTextEditorContent",
            setup: (editor) => {
                editor.on('init', () => {
                    editor.getContainer().style.transition = "border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out"
                });
                editor.on('focus', () => {
                    editor.getContainer().style.boxShadow = "0 0 0 .2rem rgba(0, 123, 255, .25)",
                        editor.getContainer().style.borderColor = "#80bdff"
                });
                editor.on('blur', () => {
                    editor.getContainer().style.boxShadow = "",
                        editor.getContainer().style.borderColor = ""
                });
                editor.on('change', function (e) {
                    loadTextEditorContent(editor.getContent());
                    console.log('change event fired');
                });
            }
        });

        window.addEventListener('showCatalogueImages', (e) => {
            $('#catalogueImagesModal').show();
        });

        window.addEventListener('hideCatalogueImages', (e) => {
            $('#catalogueImagesModal').hide();
        });

        function loadTextEditorContent(contents) {
            @this.set('description', contents, true);
        }

        $('#close__model').click(function () {
            $('#catalogueImagesModal').hide();
        });
        $('#close__models').click(function () {
            $('#catalogueImagesModal').hide();
        });

        $("input[name$='is_open_bid']").click(function() {
            let is_open_bid = $(this).val();
            if(is_open_bid == 0) {
                $('#country_div').show();
                $('#city_div').show();
                $('#suppliers_div').show();
                $('#neighborhood_div').show();
            } else {
                $('#country_div').hide();
                $('#city_div').hide();
                $('#suppliers_div').hide();
                $('#neighborhood_div').hide();
            }
        });

        function initSelect2() {
            $('#suppliers').select2({
                multiple: true,
                width: 'resolve',
                height: 'resolve',
                placeholder: "{{ __('Select suppliers') }}"
            }).on('select2:select', function (e) {
                @this.set('selectedSuppliers', $('#suppliers').val());
            });
        }

        initSelect2();

        window.addEventListener('reApplySelect2', event => {
            initSelect2();
        });
    </script>
@endpush













