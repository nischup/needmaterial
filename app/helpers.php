<?php

use App\Events\ActivityLoggerEvent;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Nwidart\Modules\Facades\Module;
use Modules\Language\Entities\Translation;

//https://spatie.be/docs/laravel-activitylog/v4/basic-usage/logging-activity
if (! function_exists('activity_log')) {
    function activity_log($userModel, $event, $log) {
        ActivityLoggerEvent::dispatch([
            'userModel' => $userModel,
            'event' => $event,
            'log' => $log,
        ]);
    }
}

if (! function_exists('module_enabled')) {
    function module_enabled($module) {
        if(Module::has($module) && Module::find($module)->isStatus(1)) {
            return true;
        }

        return false;
    }
}

if (! function_exists('get_locales')) {
    function get_locales() {
        return Cache::remember('locales.cache', 3600, function () {
            $locales = config('app.locales');
            $locales = array_map('strtolower', $locales);
            if(module_enabled('ActivityLog')) {
                $translations = Translation::groupBy('locale')->pluck('locale')->toArray();
                $translations = array_map('strtolower', $translations);
                return array_unique(array_merge($translations, $locales));
            }
            return $locales;
        });
    }
}

if (! function_exists('get_menus')) {
    function get_menus() {
        if (config('app.env') != 'production') {
            Cache::forget('menus.cache');
        }
        return Cache::remember('menus.cache', 3600, function () {
            return config('tinydash.menu');
        });
    }
}

if (! function_exists('get_user_profile_photo')) {
    function get_user_profile_photo($user) {
        return $user->profile_photo_path
            ? Storage::disk(profilePhotoDisk())->url($user->profile_photo_path)
            : defaultProfilePhotoUrl($user->name);
    }
}

if (! function_exists('profilePhotoDisk')) {
    function profilePhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }
}

if (! function_exists('defaultProfilePhotoUrl')) {
    function defaultProfilePhotoUrl($name) {
        $name = trim(collect(explode(' ', $name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }
}

if (! function_exists('profileStatusCompleted')) {
    function profileStatusCompleted() {
        $profile = UserProfile::where('user_id', auth()->user()->id)->first();

        if (!$profile) {
            return false;
        } else {
            if (auth()->user()->is_individual) {
                // if (auth()->user()->email && $profile->country && $profile->city) {
                if ($profile->country && $profile->city) {
                    return true;
                } else {
                    return false;
                }
            } else {
                // if (auth()->user()->email && $profile->registration && $profile->company_phone) {
                if ($profile->registration && $profile->company_phone) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}
