@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
    <style>
        .iti.iti--allow-dropdown{
            width: 100% !important;
        }
    </style>
@endpush
<form class="login-form">
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
            <label for="name"><i class="far fa-user"></i></label>
            <input type="text" wire:model.defer="name" id="name" placeholder="{{ __('Name') }}">
        </div>
        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30">
        <div class="form-group mb-0" wire:ignore>
            <input type="text" wire:model.defer="phone" id="phone" placeholder="Mobile">
        </div>
        @error('phone') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30">
        <div class="form-group mb-0">
            <select class="form-select pl-3" wire:model.defer="user_type" aria-label="Default select example">
                <option selected>{{ __('Select Type') }}</option>
                <option value="{{ \App\Models\User::CUSTOMER }}" selected>{{ __('Customer') }}</option>
                <option value="{{ \App\Models\User::SUPPLIER }}">{{ __('Supplier') }}</option>
            </select>
        </div>
        @error('user_type') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30">
        <div class="form-group mb-0">
            <select class="form-select pl-3" wire:model="business_type" aria-label="Business Type">
                <option value="1" selected>{{ __('Individual') }}</option>
                <option value="2">{{ __('Company') }}</option>
            </select>
        </div>
        @error('business_type') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30"  @if($business_type == 1) style="display: none" @endif>
        <div class="form-group mb-0" wire:ignore>
            <select class="form-select pl-3" id="company-name" aria-label="Company Name" style="height: 50px">
                <option value="">{{ __('Select company') }}</option>
                @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
                <option value="Other">{{ __('Other') }}</option>
            </select>
        </div>
        @error('company_name') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    @if($company_name == 'Other')
    <div class="mb-30">
        <div class="form-group mb-0" wire:ignore>
            <input class="pl-3" type="text" wire:model.defer="new_company_name" id="new_company_name" placeholder="Enter company name">
        </div>
        @error('new_company_name') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>
    @endif

    <div class="row mb-30">
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="password"><i class="fas fa-lock"></i></label>
                <input type="password" wire:model.defer="password" id="password" placeholder="Password">
                <span class="pass-type"><i class="fas fa-eye"></i></span>
            </div>
            @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <div class="form-group mb-0">
                <label for="password_confirmation"><i class="fas fa-lock"></i></label>
                <input type="password" wire:model.defer="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
                <span class="pass-type"><i class="fas fa-eye"></i></span>
            </div>
            @error('password_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
        </div>
    </div>

    <div class="mb-30">
        <div class="form-group checkgroup mb-0">
            <input type="checkbox" wire:model.defer="terms" id="check"><label for="check">I have read and agree to the <a href="{{ route('terms-condition') }}"> Terms and Conditions </a> </label>
        </div>
        @error('terms') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>


    <div class="form-group mb-0">
        <button type="button" wire:click.prevent="register" class="custom-button">{{ __('Register') }}</button>
    </div>
</form>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        $(document).ready(function() {
            function initSelect2() {
                $('#company-name').select2({
                    tags: false,
                    width: 'resolve',
                    height: 'resolve',
                    placeholder: "{{ __('Select company') }}"
                }).on('select2:select', function (e) {
                    @this.set('company_name', e.params.data.text);
                });
            }
            window.addEventListener('reApplySelect2', event => {
                initSelect2();
            });

            const input = document.querySelector("#phone");
            window.intlTelInput(input);
        });
    </script>
@endpush
