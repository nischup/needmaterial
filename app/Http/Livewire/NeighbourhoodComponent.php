<?php

namespace App\Http\Livewire;

use App\Models\CatalogueImage;
use App\Models\Category;
use App\Models\Catalogue;
use App\Models\Brand;
use App\Models\Country;
use App\Models\City;
use App\Models\Neighbourhood;
use App\Services\ImageService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class NeighbourhoodComponent extends Component
{

     use WithPagination,WithFileUploads;

    public $editing = false;
    public $creating = false;
    public $data, $name_en, $name_ur, $name_ar, $description, $country_id, $city_id;
    public $images = [];
    public $oldImages = [];
    public $category_column;
    public $child_categories;

    public array $selectedRoles = [];
    public $per_page = 10;
    public $query = '';

    protected $paginationTheme = 'bootstrap';



    public function render()
    {
        $nbrh_list = new Neighbourhood();

        if ($this->query) {
            $nbrh_list = $nbrh_list->where('name_en','LIKE','%'. $this->query .'%');
        }

        if ($this->country_id) {
            $nbrh_list = $nbrh_list->where('country_id', $this->country_id);
        }

        if ($this->city_id) {
            $nbrh_list = $nbrh_list->where('city_id', $this->city_id);
        }

        return view('admin.livewire.neighbourhood.index', [
            'list' => $nbrh_list->orderBy('id', 'desc')->paginate($this->per_page)
        ]);

         // return view('admin.livewire.neighbourhood');
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->name_en = null;
        $this->selectedRoles = [];

        $this->dispatchBrowserEvent('clearSelect');
    }

    public function store()
    {
        $this->validate([
            'country_id' => 'required',
            'city_id' => 'required',
            'name_en' => 'required',
        ]);

        $catalogue = Neighbourhood::create([
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'name_en' => $this->name_en,
            'name_ur' => $this->name_ur,
            'name_ar' => $this->name_ar,
        ]);

        $this->resetForm();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Neighbourhood created successfully!']);
    }

    public function resetForm()
    {
        $this->name_en = '';
        $this->country_id = '';
        $this->city_id = '';
    }

    public function createNew()
    {
        $this->resetForm();
        $this->creating = true;
    }


    public function edit($id)
    {
        $this->resetForm();
        $this->creating = false;
        $this->editing = $id;

        $catalogue = \App\Models\Neighbourhood::find($id);
        $this->country_id = $catalogue->country_id;
        $this->city_id = $catalogue->city_id;
        $this->name_en = $catalogue->name_en;
        $this->name_ur = $catalogue->name_ur;
        $this->name_ar = $catalogue->name_ar;

        $this->child_categories = City::select('id', 'name')->where('country_id', $catalogue->parent_category_id)->get()->toArray();
    }

    public function update()
    {
        $this->validate([
            'category' => 'required',
            'name_en' => 'required',
            'description' => 'nullable'
        ]);

        \App\Models\Neighbourhood::find($this->editing)->update([
            'name_en' => $this->name_en,
            // 'slug' => Str::slug($this->name_en),
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
        ]);

        // session()->flash('message', __('Catalogue updated successfully.'));

        // $this->editing = false;
        // $this->showAll();

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Neighbourhood updated successfully!']);
    }

    public function imageDelete($id, $key)
    {
        $image = CatalogueImage::find($id);

        $path = public_path('storage/' . $image->src_original);
        if (file_exists($path)) {
            unlink($path);
        }

        $image->delete();

        $this->oldImages->forget($key);

        session()->flash('message', __('Image delete successfully.'));
    }

    public function destroy($id)
    {
       
        Neighbourhood::where('id', $id)->update(['status' => 1]);

        // $catalogue->delete();

      $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Neighbourhood Deleted successfully!']);
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

       public function paginationView()
    {
        return 'admin.pagination';
    }

    public function storeImages($productId, $images)
    {
        $imageService = new ImageService();

        foreach ($images as $image) {
            $list[] = [
                'catalogue_id' => $productId,
                'src' => $imageService->saveImage($image),
            ];
        }


        CatalogueImage::insert($list);
    }

    public function p_categoryChanged($value)
    {
        if (!$value) {
            return;
        }

        $this->child_categories = City::select('id', 'name')->where('country_id', $value)->get()->toArray();
    }

    public function mount()
    {
        // $this->category_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('categories', $this->category_column))
        {
            $this->category_column = 'name';
        }

        $this->categories = Country::select('id', 'name')->whereIn('id', ['19','194','231'])->get()->toArray();
    }
}
