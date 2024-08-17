<?php

namespace App\Http\Livewire;

use App\Models\Auction;
use App\Models\Brand;
use App\Models\CatalogueImage;
use App\Models\Category;
use App\Models\Unit;
use App\Models\MadeIn;
use App\Models\User;
use App\Models\UserProfile;
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
use Carbon\Carbon;
use App\Mail\BidSubmissionSuccessful;
use Illuminate\Support\Facades\Mail;

class NewAuction extends Component
{
    use WithFileUploads;

    public $category_column, $category, $neighbour_column, $brand_column, $unit_column, $made_column;
    public $child_categories = [];
    public $child_categories_data = [];
    public $cities = [];
    public $neighbourhoodies = [];
    public $title, $featured, $description, $product_title, $brand, $unit, $is_exact_item, $delivery_address, $lat, $long, $start_time, $end_time;
    public $delivery_cost_included, $delivery_time, $credit_days, $payment_type, $vat, $delivery_date;
    public $service_type, $is_open_bid = 1;
    public $products = [];
    public $catalogues = [];
    public $neighbourhood_list = [];
    public $supplier_list = [];
    public $product, $brands, $made_in, $units, $suppliers, $countries, $country, $city, $neighbourhood, $selectedSuppliers, $thumbnail;
    public $selectedProducts = [];
    public $images = [];
    public $addingNewProduct = false, $updatingProductKey = false;
    public $comment, $p_category, $catalog_category, $catalog_title;
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
            'title' => 'nullable|unique:auctions,title',
            'description' => 'nullable',
            'start_time' => 'required',
            'end_time' => 'required',
            'delivery_date' => 'nullable|date',
            'delivery_time' => 'nullable',
            'payment_type' => 'required',
            'credit_days' => 'required_if:payment_type,Credit',
            // 'credit_days' => 'required_if:payment_type,Credit|integer|min:1',

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

            $concatenatedTitles = '';
            $allTitles = [];
            foreach ($this->selectedProducts as $selectedProduct) {
                if (isset($selectedProduct['catalogue']) && $selectedProduct['catalogue'] != null) {
                    $product = Catalogue::with('category')->where('id', $selectedProduct['catalogue'])->first();
                    // $product_title = $product ? $product->title : null;
                    $category_name = $product->category ? $product->category->name_en : null;

                    if ($category_name) {
                        $randomNumber = rand(1000, 9999); // Adjust the range as needed
                        $allTitles[] = $category_name;
                    }
                }
            }

            if (!empty($allTitles)) {
                $concatenatedTitles = implode(', ', $allTitles) . '-' . date('Y-m-d') . '-' . $randomNumber;
            }

            $auction = Auction::create([
                'user_id' => auth()->user()->id,
                'service_type' => $this->service_type,
                'is_open_bid' => $this->is_open_bid,
                // 'title' => $title,
                'title' => $concatenatedTitles,
                'featured' => $this->featured,
                // 'slug' => Str::slug($title),
                'slug' => Str::slug($concatenatedTitles),
                'description' => $this->description,
                'delivery_address' => $this->delivery_address,
                'lat' => $this->lat,
                'long' => $this->long,
                'comment' => $this->comment,
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'included_delivery_cost' => $this->delivery_cost_included ? 1 : 0,
                'delivery_time' => $this->delivery_time,
                'payment_type' => $this->payment_type,
                'vat' => $this->vat ? 1 : 0,
                'delivery_date' => $this->delivery_date
            ]);

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


            $allproducts = [];
            $list = [];
            foreach ($this->selectedProducts as $selectedProduct) {
                $product = Catalogue::where('id', $selectedProduct['catalogue'])->first();
                $product_title = $product ? $product->title : null;

                $unit = Unit::where('id', $selectedProduct['unit'])->first();
                $unit_title = $unit ? $unit->title_en : null; 

                if (isset($selectedProduct['is_exact_item']) && $selectedProduct['is_exact_item'] == 1) {
                    if (isset($selectedProduct['brand'])) {
                        $brand = Brand::where('id', $selectedProduct['brand'])->first();
                        $brand_title = $brand ? $brand->title_en : "N/A";
                    } else {
                        $brand_title = "N/A";
                    }
                } else {
                    $brand_title = "N/A";
                }

                $quantity = $selectedProduct['quantity'];
                $brand_type = $selectedProduct['is_exact_item'] == 1 ? 'exact brand' : 'any brand';

                $allproducts[] = [
                    'product_title' => $product_title,
                    'unit' => $unit_title,
                    'brand' => $brand_title,
                    'quantity' => $quantity,
                    'brand_type' => $brand_type,
                    'images' => $selectedProduct['images'],
                ];    

            }


            $data = array(
                'title' => $auction['title'],
                'slug' => $auction['slug'],
                'start_time' => $auction['start_time'],
                'end_time' => $auction['end_time'],
                'products' => $allproducts,
            );

            // dd($data);

            $loged_user_email = auth()->user()->email;

            $auction = Auction::with(['products.catalogue.images', 'unit'])->where('id', $auction->id)->first();

            if ($this->is_open_bid == 1) {
                $em_data = UserProfile::where('country', $this->country)->where('city', $this->city)->where('neighbourhood', $this->neighbourhood)->get();
                $emailsToSendOpenUser = [];
                foreach ($em_data as $profile) {
                    $email = $profile->user->email;
                    $emailsToSendOpenUser[] = $email;
                }
                    // dd($emailsToSendOpenUser);
                    if(!empty($emailsToSendOpenUser)){
                        foreach ($emailsToSendOpenUser as $email) {
                            Mail::send('emails.auction-creation-supplier-notifiaction', $data, function($message) use ($email) {
                                $message->to($email)
                                    ->subject('Auction Created in Your Area, Bid Now');
                            });
                        }
                    }
            }        

            if ($this->selectedSuppliers) {
                $supplier_email_data = User::whereIn('id', $this->selectedSuppliers)->get();
                $auctionService->storeSelectedSuppliers($auction->id, $this->selectedSuppliers);
                $emailsToSend = $supplier_email_data->pluck('email');
                // dd($emailsToSend);
                if(!empty($emailsToSend)){
                    foreach ($emailsToSend as $email) {
                        Mail::send('emails.auction-creation-supplier-notifiaction', $data, function($message) use ($email) {
                            $message->to($email)
                                ->subject('Auction Created in Your Area, Bid Now');
                        });
                    }
                }
            }


            if(!empty($loged_user_email)){
                Mail::send('emails.mail', $data, function($message) use ($loged_user_email) {
                    $message->to($loged_user_email)
                        ->subject('Your Auction Created, Check Now');
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


    public function product_categoryChanged($value)
    {
         if (!$value) {
            return;
        }

        // dd($value);

        $this->child_categories_data = Category::select('id', $this->category_column, 'name_en')->where('parent_id', $value)->get()->toArray();
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
            'parent_category_id' => $this->catalog_category,
            'category_id' => $this->category,
            'title' => $this->catalog_title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            // 'user_id' => auth()->user()->id,
        ]);

        $this->storeImages($catalogue->id, $this->images);

        $this->resetForm();
        $this->dispatchBrowserEvent('closeModal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Catalog created successfully!']);
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
        $this->neighbourhoodies = [];
        if (!$cityId) {
            return;
        }

        $this->neighbour_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('neighbourhoods', $this->neighbour_column))
        {
            $this->neighbour_column = 'name_en';
        }

        // $this->suppliers = User::role(User::SUPPLIER_ROLE_NAME)
        //     ->whereHas('profile')
        //     ->with('profile', function ($q) use ($cityId) {
        //         $q->where('city', $cityId);
        //     })->get();   

        $this->neighbourhoodies = Neighbourhood::select('id', $this->neighbour_column, 'name_en')->where('city_id', $cityId)->get()->toArray();

    }


    public function neighborhoodToSupplier($neighbourhood_id)
    {

        $this->suppliers = [];
        if (!$neighbourhood_id) {
            return;
        } 


        $this->suppliers = User::with('profile.company')->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
             ->where('neighbourhood', $neighbourhood_id)
               ->whereHas('roles', function($q){
                   $q->where("name", User::SUPPLIER_ROLE_NAME);
               })
             ->select('users.name', 'users.email', 'users.phone', 'user_profiles.company_phone')
             ->get();     
        // dd($this->suppliers);


    }

    // public function catalogueChanged($value, $key)
    // {
    //     if (!$value) {
    //         $this->catalogueImages = null;
    //         $this->selectedProducts[$key]['images'] = [];
    //         $this->selectedProducts[$key]['description'] = '';
    //         return;
    //     }

    //     $catalogue = Catalogue::with('images')->find($value);
    //     $this->selectedProducts[$key]['description'] = $catalogue->description;
    //     if ($catalogue->images) {
    //         $this->selectedProducts[$key]['images'] = $catalogue->images->toArray();
    //     }
    // }

    public function catalogueChanged($value, $key)
    {
        if (!$value) {
            $this->catalogueImages = null;
            $this->selectedProducts[$key]['images'] = [];
            $this->selectedProducts[$key]['description'] = '';
            return;
        }

        if ($value === 'other') {
            $this->selectedProducts[$key]['description'] = ''; // Clear the description for custom input
            $this->selectedProducts[$key]['images'] = []; // Clear images for custom input
            $this->selectedProducts[$key]['product_title'] = ''; // Clear product title for custom input
        } else {
            $catalogue = Catalogue::with('images')->find($value);
            if ($catalogue) {
                $this->selectedProducts[$key]['description'] = $catalogue->description;
                if ($catalogue->images) {
                    $this->selectedProducts[$key]['images'] = $catalogue->images->toArray();
                }
            }
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

        $this->neighbour_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('neighbourhoods', $this->neighbour_column))
        {
            $this->neighbour_column = 'name_en';
        }


        $this->brand_column = 'title_' . app()->getLocale();
        if (!Schema::hasColumn('brands', $this->brand_column))
        {
            $this->brand_column = 'title_en';
        }   

        $this->unit_column = 'title_' . app()->getLocale();
        if (!Schema::hasColumn('units', $this->unit_column))
        {
            $this->unit_column = 'title_en';
        }  

        $this->made_column = 'name_' . app()->getLocale();
        if (!Schema::hasColumn('made_ins', $this->made_column))
        {
            $this->made_column = 'name_en';
        }

        $this->categories = Category::select('id', $this->category_column, 'name_en')->where('parent_id', 0)->get()->toArray();
        $this->brands = Brand::select('id', $this->brand_column, 'title_en')->get();
        $this->units = Unit::select('id', $this->unit_column, 'title_en')->get();
        $this->made_in = MadeIn::select('id', $this->made_column, 'name_en')->get();
        $this->countries = Country::whereIn('id', ['19','194','231'])->get();
        $this->neighbourhood_list = Neighbourhood::select('id', $this->neighbour_column, 'name_en')->get();

       $this->suppliers = User::with('profile.company')
           ->whereHas('roles', function($q){
               $q->where("name", User::SUPPLIER_ROLE_NAME);
           })->get();


        $this->addRow(); // Add the initial product row
        $this->start_time = Carbon::now()->format('Y-m-d\TH:i');   // Set default value to the current date and time
        $this->end_time = Carbon::now()->addDays(3)->format('Y-m-d\TH:i');   // Set default value to the 3 days later end date and time

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
