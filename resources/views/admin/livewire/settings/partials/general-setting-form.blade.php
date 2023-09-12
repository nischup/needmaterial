@php
    $isEnable = \Illuminate\Support\Arr::get($settings, 'general.' . $general['id'] .'.is_enable')
@endphp
<div class="row align-items-center">
    <div class="col-auto">
        <strong class="mb-2">{{ $general['title'] }}</strong><br>
    </div> <!-- .col -->
    <div class="col">

        @if ( $general['title'] == 'MAIL')
        <div class="form-group">
            <input class="form-control form-control-sm"
                   type="text"
                   wire:model.defer="settings.security.{{ $general['id'] }}.mailer_name"
                   placeholder="{{ $general['title'] }} Name">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                   type="text"
                   wire:model.defer="settings.security.{{ $general['id'] }}.mailer_host"
                   placeholder="{{ $general['title'] }} Host">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                type="text"
                wire:model.defer="settings.security.{{ $general['id'] }}.mailer_port"
                placeholder="{{ $general['title'] }} Port">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                type="text"
                wire:model.defer="settings.security.{{ $general['id'] }}.mailer_username"
                placeholder="{{ $general['title'] }} Username">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                type="text"
                wire:model.defer="settings.security.{{ $general['id'] }}.mailer_password"
                placeholder="{{ $general['title'] }} Password">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                type="text"
                wire:model.defer="settings.security.{{ $general['id'] }}.mailer_encryption"
                placeholder="{{ $general['title'] }} Encryption">
        </div>
        @elseif($general['title'] == 'Twilio')
        <div class="form-group">
            <input class="form-control form-control-sm"
                   type="text"
                   wire:model.defer="settings.security.{{ $general['id'] }}.sid"
                   placeholder="{{ $general['title'] }} SID">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                   type="text"
                   wire:model.defer="settings.security.{{ $general['id'] }}.auth_token"
                   placeholder="{{ $general['title'] }} Auth Token">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                   type="text"
                   wire:model.defer="settings.security.{{ $general['id'] }}.verify_sid"
                   placeholder="{{ $general['title'] }} Verify SID">
        </div>
        <div class="form-group">
            <input class="form-control form-control-sm"
                   type="text"
                   wire:model.defer="settings.security.{{ $general['id'] }}.whatsapp_from"
                   placeholder="{{ $general['title'] }} WhatsApp From">
        </div>
        @elseif($general['title'] == 'User Notification')
            <div class="form-group">
                <input class="form-control form-control-sm"
                       type="text"
                       wire:model.defer="settings.security.{{ $general['id'] }}.diameter"
                       placeholder="{{ $general['title'] }} (New auction diameter)">
            </div>        

        @else
        @endif
    </div> <!-- .col -->

</div> <!-- .row -->
