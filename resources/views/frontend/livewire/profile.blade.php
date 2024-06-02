@push('styles')
    <style>
        .dash-pro-item .dash-pro-body li .info-name {
            width: 200px;
        }

        .dash-pro-item .dash-pro-body li .info-value {
            width: calc(100% - 200px);
        }
    </style>
@endpush
<div class="row">
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

    <div class="col-12">
        <div class="dash-pro-item mb-30 dashboard-widget">
            <div class="header">
                <h4 class="title">{{ __('Personal Details') }}</h4>
                <span class="edit" wire:click="updateBasicInfo"><i class="fa fa-hdd"></i> Update</span>
            </div>
            <ul class="dash-pro-body">
                <li>
                    <div class="info-name">{{ __('Name') }}</div>
                    <div class="info-value">
                        <input type="text" class="form-control form-control-sm" wire:model.defer="name">
                        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
                <li>
                    <div class="info-name">Email</div>
                    <div class="info-value">
                        <input type="email" class="form-control form-control-sm" wire:model.defer="email">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
                <li>
                    <div class="info-name">Phone</div>
                    <div class="info-value">
                        <input type="text" class="form-control form-control-sm" wire:model.defer="phone">
                        @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-12">
        <div class="dash-pro-item mb-30 dashboard-widget">
            <div class="row" style="margin-bottom:20px;">
                <div class="col-md-8"><h4 class="title">Account Settings </h4> </div>
                <div class="col-md-4">
                    <a href="{{ route('frontend.view-profile') }}" style="margin-left:15px;"> <i class="fa fa-eye"></i> View </a>
                    <a href="#" style="margin-left:15px;" class="edit" wire:click.prevent="updateAccountSetting"><i class="fa fa-hdd"></i> Update </a>
                </div>
            </div>
            <ul class="dash-pro-body">
                @if(!$is_individual)
                <li>
                    <div class="info-name">Company</div>
                    <div class="info-value">
                        <select class="form-select" id="company-name" wire:ignore>
                            <option value="">{{ __('Select company') }}</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->name }}" @if($company->name == $current_company_name) selected @endif>{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
                @endif
                @if($countries)
                <li>
                    <div class="info-name">Country</div>
                    <div class="info-value">
                        <select class="form-select pl-3" id="countrySelect" wire:model.defer="country" wire:click="countryChanged($event.target.value)">
                            <option value="">{{ __('Select Country') }}</option>
                            @foreach($countries as $item)
                                <option value="{{ $item->id }}" wire:key="country-{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('country') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
                <li>
                    <div class="info-name">City</div>
                    <div class="info-value">
                        <select class="form-select pl-3" id="citySelect" wire:model.defer="city" wire:click="cityChangedToneighbor($event.target.value)">
                            <option value="">{{ __('Select city') }}</option>
                            @foreach($cities as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('city') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>                

                <li>
                    <div class="info-name">Neighbourhood</div>
                    <div class="info-value">
                        <select class="form-select pl-3" id="citySelect" wire:model.defer="neighbourhood">
                            <option value="">{{ __('Select neighbourhood') }}</option>
                            @foreach($neighbourhoodies as $item)
                                <option value="{{ $item->id }}"> {{ $item[$neighbor_column] ?? $item['name_en'] ?? $neighbor_column['name_en'] }} </option>
                            @endforeach
                        </select>
                        @error('neighbourhood') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
           {{--       <li>
                    <div class="info-name">Neighbourhood </div>
                    <div class="info-value">
                        <input type="text" class="form-control form-control-sm" wire:model.defer="neighbourhood">
                        @error('neighbourhood') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li> --}}

                @endif
                @if(!$is_individual)
                    <li>
                        <div class="info-name">Registration No #</div>
                        <div class="info-value">
                            <input type="text" class="form-control form-control-sm" wire:model.defer="registration">
                            @error('registration') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </li>
                    <li>
                        <div class="info-name">
                            {{ __('Registration Copy') }}
                            @if($reg_copy_doc_download)
                            <a href="{{ $reg_copy_doc_download }}" target="_blank">
                                <small>
                                {{ __('Download Current File') }}
                                </small>
                            </a>
                            @endif
                        </div>
                        <div class="info-value">
                            <input type="file" id="reg_copy_doc" wire:model="reg_copy_doc">
                            <div wire:loading wire:target="reg_copy_doc">{{ __('Uploading') }}...</div>
                        </div>
                    </li>
                    <li>
                        <div class="info-name">{{ __('VAT Copy') }}
                            @if($vat_copy_doc_download)
                                <a href="{{ $vat_copy_doc_download }}" target="_blank">
                                    <small>
                                        {{ __('Download Current File') }}
                                    </small>
                                </a>
                            @endif
                        </div>
                        <div class="info-value">
                            <input type="file" id="vat_copy_doc" wire:model="vat_copy_doc">
                            <div wire:loading wire:target="vat_copy_doc">{{ __('Uploading') }}...</div>
                        </div>
                    </li>
                    <li>
                        <div class="info-name">Company Phone</div>
                        <div class="info-value">
                            <input type="text" class="form-control form-control-sm" wire:model.defer="company_phone">
                            @error('company_phone') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    </li>
                @endif
                @if (auth()->user()->user_type == 2)
                    <li>
                        <div class="info-name"> {{ __('Select Category') }} </div>
                        <div class="info-value">

                                <select multiple class="form-control" id="profile_category" wire:model.defer="parent_category_id">
                                    <option selected>{{ __('Select Category') }}</option>
                                    @foreach($categories as $item)
                                        <option value="{{ $item['id'] }}">{{ $item[$category_column] ? $item[$category_column] : $item['name_en'] }}</option>
                                    @endforeach
                                </select>

                                

                                @error('selectedCat') <span class="text-danger error">{{ $message }}</span>@enderror

                        </div>
                    </li>
    {{--                 <li>
                        <div class="info-name"> {{ __('Select Sub Category') }} </div>
                        <div class="info-value">
                            <select class="form-select pl-3" id="sub_category_id" wire:model.defer="sub_category_id">
                                <option selected>{{ __('Select Sub Category') }}</option>
                                @if($child_categories)
                                    @foreach($child_categories as $child_category)
                                        <option value="{{ $child_category['id'] }}">{{ $child_category[$category_column] ? $child_category[$category_column] : $child_category['name_en'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </li> --}}
                @endif


            </ul>
        </div>

        <input type="hidden" wire:model="company_name" id="company_name" />

    </div>

    <div class="col-12">
        <div class="dash-pro-item dashboard-widget">
            <div class="header">
                <h4 class="title">Security</h4>
                <span class="edit" wire:click="updateSecurityInfo"><i class="fa fa-hdd"></i> Update</span>
            </div>
            <ul class="dash-pro-body">
                <li>
                    <div class="info-name">Current Password</div>
                    <div class="info-value">
                        <input type="password" class="form-control form-control-sm" wire:model="current_password">
                        @error('current_password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
                <li>
                    <div class="info-name">New password</div>
                    <div class="info-value">
                        <input type="password" class="form-control form-control-sm" wire:model="password">
                        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>
                <li>
                    <div class="info-name">Confirm new password</div>
                    <div class="info-value">
                        <input type="password" class="form-control form-control-sm" wire:model="password_confirmation">
                        @error('password_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // document.addEventListener('livewire:load', function () {
    //     $('#profile_category').select2({
    //         multiple: true,
    //         width: 'resolve',
    //         height: 'resolve',
    //         placeholder: "{{ __('Select Category') }}"
    //     }).on('change', function () {
    //         @this.set('parent_category_id', $(this).val());
    //     });
    // });
    
     function initSelect2() {
            $('#profile_category').select2({
                multiple: true,
                width: 'resolve',
                height: 'resolve',
                placeholder: "{{ __('Select Category') }}"
            }).on('select2:select', function (e) {
                @this.set('parent_category_id', $('#profile_category').val());
            });
        }

        initSelect2();

        window.addEventListener('reApplySelect2', event => {
            initSelect2();
        });
</script>


@endpush
