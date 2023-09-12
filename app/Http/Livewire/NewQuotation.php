<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Models\User;
use App\Services\AuctionService;
use App\Services\ImageService;
use App\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewQuotation extends Component
{

    use WithFileUploads;

    public $category_column, $category;
    public $child_categories = [];
    public $title, $description, $brand, $unit, $is_exact_item, $delivery_address, $lat, $long, $start_time, $end_time;
    public $delivery_cost_included, $delivery_date;
    public $service_type, $is_open_bid = 1;
    public $products = [];
    public $catalogues = [];
    public $product, $brands, $units, $suppliers, $selectedSuppliers, $thumbnail;
    public $selectedProducts = [];
    public $addingNewProduct = false, $updatingProductKey = false;
    public $comment, $p_category;

    public $newProduct = [
        'p_category' => '',
        'category' => '',
        'catalogue' => '',
        'brand' => '',
        'price' => '',
        'unit' => '',
        'made_in' => '',
        'quantity' => ''
    ];

    public function resetForm()
    {
        $this->newProduct = [
            'p_category' => '',
            'category' => '',
            'catalogue' => '',
            'brand' => '',
            'price' => '',
            'unit' => '',
            'made_in' => '',
            'quantity' => ''
        ];
    }

    public function render()
    {
        return view('frontend.livewire.new-quotation');
    }

    public function storeAuction(AuctionService $auctionService, ImageService $imageService)
    {
        $this->validate([
            'service_type' => 'required',
            'title' => 'required|unique:auctions,title',
            'description' => 'required',
            'is_exact_item' => 'required',
            'thumbnail' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'delivery_date' => 'nullable|date',

            'selectedProducts.*.catalogue' => 'required|numeric',
            'selectedProducts.*.quantity' => 'required|numeric',
            'selectedProducts.*.brand' => 'required',
            'selectedProducts.*.unit' => 'required',
            'selectedProducts.*.price' => 'required'
        ], [
            'selectedProducts.*.catalogue.required' => 'Required',
            'selectedProducts.*.quantity.required' => 'Required',
            'selectedProducts.*.brand.required' => 'Required',
            'selectedProducts.*.unit.required' => 'Required',
            'selectedProducts.*.price.required' => 'Required'
        ]);

        if (!count($this->selectedProducts)) {
            $this->addError('products', 'Please add at least one product');
            return;
        }

        DB::beginTransaction();

        try {
            $auction = Auction::create([
                'user_id' => auth()->user()->id,
                'service_type' => $this->service_type,
                'is_open_bid' => $this->is_open_bid,
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'exact_item_require' => $this->is_exact_item,
                'delivery_address' => $this->delivery_address,
                'lat' => $this->lat,
                'long' => $this->long,
                'comment' => $this->comment,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'included_delivery_cost' => $this->delivery_cost_included ? 1 : 0,
                'delivery_date' => $this->delivery_date,
                'thumbnail' => $imageService->saveImage($this->thumbnail)
            ]);


            $auctionService->storeSelectedSuppliers($auction->id, $this->selectedSuppliers);

            $auctionService->storeAuctionProducts($auction->id, $this->selectedProducts);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }

        session()->flash('message', __('Auction stored successfully.'));

        return redirect()->route('frontend.newAuction');
    }

    public function p_categoryChanged($value, $key)
    {
        $this->child_categories[$key] = Category::select('id', $this->category_column, 'name_en')->where('parent_id', $value)->get()->toArray();
    }

    public function categoryChanged($value, $key)
    {
        $this->catalogues[$key] = \App\Models\Catalogue::select('id', 'title')
            ->where('category_id', $value)
            ->where('user_id', auth()->user()->id)
            ->get()->toArray();
    }


    public function mount()
    {
        $this->category_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('categories', $this->category_column))
        {
            $this->category_column = 'name_en';
        }

        $this->categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', 0)->get()->toArray();
        $this->brands = Brand::get();
        $this->units = Unit::get();
        $this->suppliers = User::with('profile.company')
            ->whereHas('roles', function($q){
                $q->where("name", User::SUPPLIER_ROLE_NAME);
            })->get();
    }

    public function addRow()
    {
        $this->selectedProducts[] = $this->newProduct;
        $this->child_categories[] = [];
        $this->catalogues[] = [];
    }

    public function addProduct()
    {
        $this->validate([
            'newProduct.quantity' => 'required|numeric',
            'newProduct.brand' => 'required',
            'newProduct.unit' => 'required',
            'newProduct.price' => 'required'
        ], [
            'newProduct.quantity.required' => 'The product quantity field is required.'
        ]);

        array_push($this->selectedProducts, $this->newProduct);

        $this->resetForm();

        $this->dispatchBrowserEvent('closeProductsModal');
    }

    public function openProductForm()
    {
        $this->resetForm();

        $this->updatingProductKey = false;
        $this->addingNewProduct = true;
    }

    public function closeNewProduct()
    {
        $this->resetForm();

        $this->dispatchBrowserEvent('closeProductsModal');
    }

    public function editProduct($key)
    {
        $this->resetForm();

        $this->newProduct = $this->selectedProducts[$key];

        $this->updatingProductKey = $key;

        $this->dispatchBrowserEvent('showProductsModal');
    }

    public function removeProduct($key)
    {
        unset($this->selectedProducts[$key]);
    }

    public function updateProduct()
    {
        $this->selectedProducts[$this->updatingProductKey] = $this->newProduct;

        $this->dispatchBrowserEvent('closeProductsModal');
    }
}
