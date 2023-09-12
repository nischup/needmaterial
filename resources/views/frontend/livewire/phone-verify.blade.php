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
            <label for="phone_number"><i class="far fa-envelope"></i></label>
            <input type="text" wire:model.defer="phone_number" id="phone_number" placeholder="{{ __('Phone') }}">
        </div>
        @error('phone_number') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30">
        <div class="form-group mb-0">
            <label for="verification_code"><i class="fas fa-lock"></i></label>
            <input type="text" wire:model.defer="verification_code" id="verification_code" placeholder="{{ __('Verification Code') }}">
        </div>
        @error('verification_code') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="form-group">
        <a href="#" wire:click.prevent="resend">{{ __('Resend?') }}</a>
    </div>

    <div class="form-group mb-0">
        <button type="button" wire:click.prevent="verify" class="custom-button">{{ __('Verify') }}</button>
    </div>
</form>
