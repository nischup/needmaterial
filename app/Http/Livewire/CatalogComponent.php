<?php

namespace App\Http\Livewire;

use App\Models\CatalogueImage;
use App\Models\Category;
use App\Models\Catalogue;
use App\Models\Brand;
use App\Services\ImageService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CatalogComponent extends Component
{
    use WithPagination,WithFileUploads;

    public $editing = false;
    public $creating = false;
    public $data, $title, $description, $p_category, $category;
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
        $catalog_list = new Catalogue();

        if ($this->query) {
            $catalog_list = $catalog_list->where('title','LIKE','%'. $this->query .'%');
        }

        if ($this->p_category) {
            $catalog_list = $catalog_list->where('parent_category_id', $this->p_category);
        }

        if ($this->category) {
            $catalog_list = $catalog_list->where('category_id', $this->category);
        }

        return view('admin.livewire.catalog.index', [
            'list' => $catalog_list->orderBy('id', 'desc')->paginate($this->per_page)
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
    }

    private function resetInput()
    {
        $this->title = null;
        $this->selectedRoles = [];

        $this->dispatchBrowserEvent('clearSelect');
    }

    public function store()
    {
        $this->validate([
            'category' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'images' => 'required|min:1',
        ]);

        $catalogue = Catalogue::create([
            'parent_category_id' => $this->p_category,
            'category_id' => $this->category,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
        ]);

        $this->storeImages($catalogue->id, $this->images);

        $this->resetForm();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Catalog created successfully!']);
    }

    public function resetForm()
    {
        $this->title = '';
        $this->category = '';
        $this->p_category = '';
        $this->description = '';
        $this->images = '';
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

        $catalogue = \App\Models\Catalogue::with('images')->find($id);
        $this->title = $catalogue->title;
        $this->description = $catalogue->description;
        $this->oldImages = $catalogue->images;
        $this->p_category = $catalogue->parent_category_id;
        $this->category = $catalogue->category_id;

        $this->child_categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', $catalogue->parent_category_id)->get()->toArray();
    }

    public function update()
    {
        $this->validate([
            'category' => 'required',
            'title' => 'required',
            'description' => 'nullable'
        ]);

        \App\Models\Catalogue::find($this->editing)->update([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'parent_category_id' => $this->p_category,
            'category_id' => $this->category,
        ]);

        if ($this->images && count($this->images)) {
            $this->storeImages($this->editing, $this->images);
        }

        // session()->flash('message', __('Catalogue updated successfully.'));

        // $this->editing = false;
        // $this->showAll();

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Catalog updated successfully!']);
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
        $catalogue =\App\Models\Catalogue::with('images')->find($id);
        foreach ($catalogue->images as $image) {
            $path = public_path('storage/' . $image->src_original);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        CatalogueImage::where('catalogue_id', $id)->delete();

        $catalogue->delete();

      $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Catalog Deleted successfully!']);
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

        $this->child_categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', $value)->get()->toArray();
    }

    public function mount()
    {
        $this->category_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('categories', $this->category_column))
        {
            $this->category_column = 'name_en';
        }

        $this->categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', 0)->get()->toArray();
    }
}
