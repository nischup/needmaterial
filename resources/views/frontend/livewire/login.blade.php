<form class="login-form" method="POST" {{ route('login') }}>
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
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
            <div class="alert alert-danger">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="mb-30">
        <div class="form-group mb-0">
            <label for="login"><i class="fas fa-phone-alt"></i></label>
            <input type="text" wire:model.defer="login" id="login" placeholder="{{ __('Email/Phone') }}">
        </div>
        @error('login') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    <div class="mb-30">
        <div class="form-group mb-0">
            <label for="password"><i class="fas fa-lock"></i></label>
            <input type="password" wire:model.defer="password" id="password" placeholder="{{ __('Password') }}">
            <span class="pass-type"><i class="fas fa-eye"></i></span>
        </div>
        @error('password') <span class="text-danger error">{{ $message }}</span>@enderror
    </div>

    @if (Route::has('password.request'))
        <div class="form-group">
            <a href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
        </div>
    @endif

    <div class="form-group mb-0">
        <button type="button" wire:click.prevent="authenticate" class="custom-button">{{ __('Log in') }}</button>
    </div>
</form>
