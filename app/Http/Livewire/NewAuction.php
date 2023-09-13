<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Brand;
use App\Models\CatalogueImage;
use App\Models\Category;
use App\Models\Unit;
use App\Models\MadeIn;
use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\Neighbourhood;
use App\Models\Catalogue;
use App\Services\AuctionService;
use App\Services\ImageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Twilio\Rest\Client;
use App\Mail\BidSubmissionSuccessful;
use Illuminate\Support\Facades\Mail;

class NewAuction extends Component
{
    use WithFileUploads;

    public $category_column, $category;
    public $child_categories = [];
    public $cities = [];
    public $title, $featured, $description, $product_title, $brand, $unit, $is_exact_item, $delivery_address, $lat, $long, $start_time, $end_time;
    public $delivery_cost_included, $vat, $delivery_date;
    public $service_type, $is_open_bid = 1;
    public $products = [];
    public $catalogues = [];
    public $neighbourhoodies = [];
    public $product, $brands, $made_in, $units, $suppliers, $countries, $city, $selectedSuppliers, $thumbnail;
    public $selectedProducts = [];
    public $addingNewProduct = false, $updatingProductKey = false;
    public $comment, $p_category;
    public $catalogueImages, $productNewImages;

    public $newProduct = [
        'p_category' => '',
        'category' => '',
        'catalogue' => '',
        'product_title' => '',
        'brand' => '',
        'price' => '',
        'unit' => '',
        'made_in' => '',
        'quantity' => '',
        'description' => '',
        'images' => []
    ];

    public function resetForm()
    {
        $this->newProduct = [
            'p_category' => '',
            'category' => '',
            'catalogue' => '',
            'product_title' => '',
            'brand' => '',
            'price' => '',
            'unit' => '',
            'made_in' => '',
            'quantity' => '',
            'description' => '',
            'images' => []
        ];
    }

    public function render()
    {
        return view('frontend.livewire.new-auction');
    }

    public function storeAuction(AuctionService $auctionService, ImageService $imageService)
    {
        $this->validate([
            'service_type' => 'required',
            'title' => 'required|unique:auctions,title',
            'description' => 'nullable',
            'start_time' => 'required',
            'end_time' => 'required',
            'delivery_date' => 'nullable|date',

            'selectedProducts.*.catalogue' => 'required|numeric',
            'selectedProducts.*.quantity' => 'required|numeric',
            'selectedProducts.*.product_title' => 'nullable',
            'selectedProducts.*.brand' => 'nullable',
            'selectedProducts.*.unit' => 'required',
            'selectedProducts.*.is_exact_item' => 'required'
        ], [
            'selectedProducts.*.catalogue.required' => 'Required',
            'selectedProducts.*.quantity.required' => 'Required',
            'selectedProducts.*.product_title.required' => 'Required',
            'selectedProducts.*.unit.required' => 'Required',
            'selectedProducts.*.is_exact_item.required' => 'Required'
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
                'featured' => $this->featured,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'delivery_address' => $this->delivery_address,
                'lat' => $this->lat,
                'long' => $this->long,
                'comment' => $this->comment,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'included_delivery_cost' => $this->delivery_cost_included ? 1 : 0,
                'vat' => $this->vat ? 1 : 0,
                'delivery_date' => $this->delivery_date
            ]);


            $auctionService->storeSelectedSuppliers($auction->id, $this->selectedSuppliers);

            $auctionService->storeAuctionProducts($auction->id, $this->selectedProducts);

            //TODO:: notify users based on location
            //auth()->user()->notify(new \App\Notifications\NewAuction($auction));
            
            // $accountSid = 'ACff2f4f87ebb45c369dc243f54044eb9d';
            // $authToken = '062908fb278e0ef65bdcb66da9f9143a';
            // // $senderNumber = 'whatsapp:+12568672270';
            // $senderNumber = 'whatsapp:+14155238886';
            
            
            // $client = new Client($accountSid, $authToken);
            // $message = $client->messages->create(
            //     // 'whatsapp:+8801686844781', // Recipient's WhatsApp number
            //     'whatsapp:+8801613514109', // Recipient's WhatsApp number
            //     [
            //         'from' => $senderNumber,
            //         'body' => 'New Auction Submitted to your area! Bid Now, Message Sent from needmaterials.com',
            //     ]
            // );

            // Mail::to('ahsabbir23@gmail.com')->send(new BidSubmissionSuccessful());

            $data = array(
                'title' => $auction['title'],
                'slug' => $auction['slug'],
                'start_time' => $auction['start_time'],
                'end_time' => $auction['end_time']
            );

           $loged_user_email = auth()->user()->email;

            if(!empty($loged_user_email)){
                Mail::send('emails.mail', $data, function($message) use ($loged_user_email) {
                    $message->to($loged_user_email)
                        ->subject('Auction Created From needmaterials.com');
                });
            }



            session()->flash('message', __('Auction Created successfully.'));
            DB::commit();
        } catch (\Exception $e) {
            session()->flash('error', __('Something went wrong! please try again'));
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            session()->flash('error', __('Something went wrong! please try again'));
            DB::rollback();
            throw $e;
        }

        return redirect()->route('frontend.newAuction');
    }

    public function p_categoryChanged($value, $key)
    {
        $this->catalogues[$key] = null;
        $this->catalogueImages = null;
        $this->selectedProducts[$key]['images'] = [];

        if (!$value) {
            return;
        }

        $this->child_categories[$key] = Category::select('id', $this->category_column, 'name_en')->where('parent_id', $value)->get()->toArray();
    }

    public function categoryChanged($value, $key)
    {
        $this->catalogueImages = null;
        $this->selectedProducts[$key]['images'] = [];

        if (!$value) {
            return;
        }

        $this->catalogues[$key] = Catalogue::select('id', 'title')
            ->where('category_id', $value)
            ->get()->toArray();
    }


    public function countryChanged($value)
    {
        $this->cities = [];
        if (!$value) {
            return;
        }

        $this->cities = City::where('country_id', $value)->get()->toArray();
    }

    public function cityChanged($cityId)
    {
        $this->suppliers = null;
        if (!$cityId) {
            return;
        }

        $this->suppliers = User::role(User::SUPPLIER_ROLE_NAME)
            ->whereHas('profile')
            ->with('profile', function ($q) use ($cityId) {
                $q->where('city', $cityId);
            })->get();   

        $this->neighbourhoodies = Neighbourhood::select('id', 'title')->where('city_id', $cityId)->get();

    }

    public function catalogueChanged($value, $key)
    {
        if (!$value) {
            $this->catalogueImages = null;
            $this->selectedProducts[$key]['images'] = [];
            $this->selectedProducts[$key]['description'] = '';
            return;
        }

        $catalogue = Catalogue::with('images')->find($value);
        $this->selectedProducts[$key]['description'] = $catalogue->description;
        if ($catalogue->images) {
            $this->selectedProducts[$key]['images'] = $catalogue->images->toArray();
        }
    }

    public function catalogueImageManageDone($productKey)
    {
        if ($this->productNewImages) {
            $imageService = new ImageService();

            foreach ($this->productNewImages as $image) {
                $this->selectedProducts[$productKey]['images'][] = ['src_original' => $imageService->saveImage($image)];
            }

            $this->productNewImages = null;
        }
    }

    public function imageDelete($productKey,$imageKey)
    {
        unset($this->selectedProducts[$productKey]['images'][$imageKey]);
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
        $this->made_in = MadeIn::get();
        $this->countries = Country::whereIn('id', ['19','194','231'])->get();
        $this->neighbourhoodies = Neighbourhood::select('id', 'title')->get();
//        $this->suppliers = User::with('profile.company')
//            ->whereHas('roles', function($q){
//                $q->where("name", User::SUPPLIER_ROLE_NAME);
//            })->get();
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
    }

    public function editProduct($key)
    {
        $this->resetForm();

        $this->newProduct = $this->selectedProducts[$key];

        $this->updatingProductKey = $key;
    }

    public function removeProduct($key)
    {
        unset($this->selectedProducts[$key]);
    }

    public function updateProduct()
    {
        $this->selectedProducts[$this->updatingProductKey] = $this->newProduct;
    }
}
