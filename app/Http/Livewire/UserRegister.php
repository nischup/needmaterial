<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Twilio\Rest\Client;

class UserRegister extends Component
{
    public $users, $email, $password, $password_confirmation, $name, $phone;
    public $business_type = 1;
    public $company_name, $new_company_name, $user_type, $companies, $terms = 1;

    public function render()
    {
        return view('frontend.livewire.register');
    }

    public function register()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
            'phone' => ['required', 'min:6', 'unique:users'],
            'terms' => ['required', 'in:1'],
            'user_type' => ['required', 'in:1,2'],
            "new_company_name" => "required_if:company_name,==,other"
        ], [
            'terms.in' => 'You need to agree the terms and condition for continue',
            'terms.required' => 'You need to agree the terms and condition for continue',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'phone' => $this->phone,
            'is_individual' => $this->business_type == 1 ? 1 : 0,
            'user_type' => $this->user_type,
        ]);

        if ($this->user_type == 2) {
            $company = Company::firstOrCreate([
                'name' => $this->new_company_name ? $this->new_company_name : $this->company_name
            ]);

            $user->profile()->updateOrCreate([], [
                'company_id' => $company->id,
            ]);
        }

        $customerRole = Role::where('name', 'customer')->first();

        if ($this->user_type == User::CUSTOMER) {
            $user->assignRole($customerRole);
        } else {
            $supplierRole = Role::where('name', 'supplier')->first();
            $user->assignRole($customerRole);
            $user->assignRole($supplierRole);
        }

        event(new Registered($user));

        $this->sendOtpVerificationCode($this->phone);

        session()->flash('message', __('Your registration successfully done. Please verify your mobile number'));

        return redirect()->route('phone.verify')->with('phone', $this->phone);
    }

    public function updatedBusinessType()
    {
        $this->dispatchBrowserEvent('reApplySelect2');
    }

    public function countryChanged($value)
    {
        $this->cities = City::select('id', 'name')->where('country_id', $value)->get();
    }

    public function p_categoryChanged($value)
    {
        $this->child_categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', $value)->get()->toArray();
    }

    public function mount()
    {
        $this->companies = Company::get();
    }

    private function sendOtpVerificationCode($phone)
    {
        $otp = rand(100000, 999999);

        $url = "https://sms.solutionsclan.com/api/sms/send";
        $data = [
            "apiKey"=> "A000362a883636e-a000-4a09-9fd5-39594941d09d",
            "contactNumbers"=> $phone,
            "senderId"=> "8809612440713",
            "textBody"=> "One time Password (OTP) for your Auction.com is ".$otp
        ];

        $response = Http::post($url, $data);
        if ($response->successful()) {
            Session::put('OTP', $otp);
        } else {
            logger('Invalid phone verification request');
            logger($response->body());
        }
    }
}
