<?php

namespace App\Http\Livewire;


use App\Models\BannerAdImage;
use App\Models\Category;
use App\Models\BannerAd;
use App\Models\Brand;
use App\Services\ImageService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BannerComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $editing = false;
    public $creating = false;
    public $data, $title, $description, $ref_link;
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
        $banner_list = new BannerAd();

        if ($this->query) {
            $banner_list = $banner_list->where('title','LIKE','%'. $this->query .'%');
        }

        return view('admin.livewire.banner.index', [
            'list' => $banner_list->orderBy('id', 'desc')->paginate($this->per_page)
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
            'ref_link' => 'nullable',
            'title' => 'required',
            'description' => 'nullable',
            'images' => 'required|min:1',
        ]);

        $banner = BannerAd::create([
            'title' => $this->title,
            'ref_link' => $this->ref_link,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
        ]);

        $this->storeImages($banner->id, $this->images);

        $this->resetForm();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Banner Ad created successfully!']);
    }

    public function resetForm()
    {
        $this->title = '';
        $this->ref_link = '';
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

        $banner = \App\Models\BannerAd::with('images')->find($id);
        $this->title = $banner->title;
        $this->ref_link = $banner->ref_link;
        $this->description = $banner->description;
        $this->oldImages = $banner->images;
    }

    public function update()
    {
        $this->validate([
            'ref_link' => 'nullable',
            'title' => 'required',
            'description' => 'nullable'
        ]);

        \App\Models\BannerAd::find($this->editing)->update([
            'title' => $this->title,
            'ref_link' => $this->ref_link,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
        ]);

        if ($this->images && count($this->images)) {
            $this->storeImages($this->editing, $this->images);
        }

        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Banner Ad updated successfully!']);
    }

    public function imageDelete($id, $key)
    {
        $image = BannerAdImage::find($id);

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
        $banner =\App\Models\BannerAd::with('images')->find($id);
        foreach ($banner->images as $image) {
            $path = public_path('storage/' . $image->src_original);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        BannerAdImage::where('banner_ad_id', $id)->delete();

        $banner->delete();

      $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Banner Ad Deleted successfully!']);
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
                'banner_ad_id' => $productId,
                'src' => $imageService->saveImage($image),
            ];
        }


        BannerAdImage::insert($list);
    }

}
