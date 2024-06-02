<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\User;
use App\Models\Neighbourhood;
use App\Models\UserProfile;
use App\Services\DocumentUploadService;
use Livewire\Component;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Profile extends Component
{
    use WithPagination, WithFileUploads;
    public $user;
    public $companies;

    public $name, $email, $phone, $photo, $is_individual;
    public $company_id, $registration, $vat, $country, $company_name, $sub_category_id, $company_phone, $current_company_name;
    public $current_password, $password, $password_confirmation;
    public $countries;
    public $cities = [];
    public $selectedCat;
    public $neighbourhoodies = [];
    public $parent_category_id = [];
    public $city;
    public $reg_copy_doc, $reg_copy_doc_download, $vat_copy_doc, $vat_copy_doc_download;
    public $neighbourhood;
    public $category_column, $neighbor_column, $child_categories;

    public function render()
    {
        $this->dispatchBrowserEvent('reApplySelect2');

        return view('frontend.livewire.profile');
    }

    public function resetInput()
    {
        $this->company_id = null;
        $this->company_name = null;
    }

    public function mount()
    {
        $this->user = User::with('profile.company')->find(auth()->user()->id);

        $parent_category_id = optional($this->user->profile)->parent_category_id;
        if ($parent_category_id) {
            $parent_category_id = explode(',', $parent_category_id);
        }

        $this->neighbor_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('neighbourhoods', $this->neighbor_column))
        {
            $this->neighbor_column = 'name_en';
        }  

        $this->category_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('categories', $this->category_column))
        {
            $this->category_column = 'name_en';
        }

        $this->companies = Company::get();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->is_individual = $this->user->is_individual;
        $this->current_company_name = optional(optional($this->user->profile)->company)->name;
        $this->country = optional($this->user->profile)->country;
        $this->city = optional($this->user->profile)->city;
        $this->neighbourhood = optional($this->user->profile)->neighbourhood;
        $this->parent_category_id = $parent_category_id;
        $this->sub_category_id = optional($this->user->profile)->sub_category_id;
        $this->reg_copy_doc_download = optional($this->user->profile)->reg_copy_doc_download;
        $this->vat_copy_doc_download = optional($this->user->profile)->vat_copy_doc_download;
        $this->company_phone = optional($this->user->profile)->company_phone;
        $this->registration = optional($this->user->profile)->registration;

        $this->countries = Country::select('id', 'name')->get();
        $this->cities = City::select('id', 'name')->where('country_id', $this->country)->get();
        $this->neighbourhoodies = Neighbourhood::select('id', $this->neighbor_column, 'name_en')->get();

     

        $this->categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', 0)->get()->toArray();

        $this->dispatchBrowserEvent('changeCountry');
    }

    public function updateBasicInfo()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'phone' => ['required', 'min:6', 'unique:users,phone,' . $this->user->id],
        ]);

        auth()->user()->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        session()->flash('message', __('Profile updated successfully.'));
    }

    public function updateSecurityInfo()
    {
        $this->validate([
            'current_password' => ['required','current_password'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        auth()->user()->update([
            'password' => bcrypt($this->password)
        ]);

        session()->flash('message', __('Password updated successfully.'));
    }

    public function countryChanged($value)
    {
        $this->cities = City::select('id', 'name')->where('country_id', $value)->get();
    }

    public function cityChangedToneighbor($value)
    {
        $this->neighbor_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('neighbourhoods', $this->neighbor_column))
        {
            $this->neighbor_column = 'name_en';
        } 

        $this->neighbourhoodies = Neighbourhood::select('id', $this->neighbor_column, 'name_en')->where('city_id', $value)->get();
    }

    public function updateAccountSetting(DocumentUploadService $documentUploadService)
    {
        $this->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
        ]);

        if (!$this->company_name) {
            $this->company_name = $this->current_company_name;
        }

        if ($this->company_name) {
            $company = Company::firstOrCreate([
                'name' => $this->company_name
            ]);

            $company_id = $company->id;
        } else {
            $company_id = null;
        }

        if ($this->parent_category_id) {
            $parent_category_ids = implode(',', array_values($this->parent_category_id));
        } else {
            $parent_category_ids = null;
        }

        $data = [
            'company_id' => $company_id,
            'country' => $this->country,
            'city' => $this->city,
            'neighbourhood' => $this->neighbourhood,
            'registration' => $this->registration,
            'parent_category_id' => $parent_category_ids,
            'sub_category_id' => $this->sub_category_id,
            'company_phone' => $this->company_phone
        ];

        if ($this->reg_copy_doc) {
            $data['reg_copy_doc'] = $documentUploadService->saveFile($this->reg_copy_doc);
        }

        if ($this->vat_copy_doc) {
            $data['vat_copy_doc'] = $documentUploadService->saveFile($this->vat_copy_doc);
        }


        $profile = UserProfile::where('user_id', $this->user->id)->first();

        if ($profile) {
            $profile->update($data);
        } else {
            UserProfile::create(array_merge(['user_id' =>  $this->user->id], $data));
        }

        session()->flash('message', __('Profile updated successfully.'));
    }


    public function p_categoryChanged($value)
    {
        $this->child_categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', $value)->get()->toArray();
    }

}
