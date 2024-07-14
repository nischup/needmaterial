<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\AuctionBidProduct;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Subscription;
use App\Models\Neighbourhood;
use App\Models\CatalogueImage;
use App\Models\Unit;
use App\Models\MadeIn;
use App\Models\Favorite;
use App\Models\UserProfile;
use App\Models\PageContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Str;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class PagesController extends Controller
{
    public function home()
    {
        $products = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price');
        }])->join('auctions', 'auctions.id', '=', 'auction_products.auction_id')
            ->withCount('bids')
            ->where('auctions.end_time', '>', Carbon::now())
            ->whereNull('winner_id') // Add this line to filter products with a winner
            ->orderBy('id', 'DESC')
            ->take(20)
            ->get()->map(function ($product) {
                $product['lowest_bid'] = $product->bids->min('price');
                $product['highest_bid'] = $product->bids->max('price');
                return $product;
            });

        $featured_products = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price');
        }])->join('auctions', 'auctions.id', '=', 'auction_products.auction_id')
            ->withCount('bids')
            ->where('auctions.end_time', '>', Carbon::now())
            ->whereNull('winner_id') // Add this line to filter products with a winner
            ->where('auctions.featured', 1)
            ->orderBy('id', 'DESC')
            ->take(20)
            ->get()->map(function ($featured_products) {
                $featured_products['lowest_bid'] = $featured_products->bids->min('price');
                return $featured_products;
            });

        $categories = Category::with(['catalogues' => function($query) {
            $query->with('products.auction', function ($qw) {
                $qw->orderBy('id', 'DESC');
            })->whereHas('products')
                ->withCount('products')
                ->with('products.thumbnail');
        }])->withCount(['catalogues as catalogue_with_product_count' => function ($q) {
                $q->whereHas('products');
            }])
            ->where('parent_id', 0)
            ->get();

        return view('frontend.home', [
            'products' => $products,
            'featured_products' => $featured_products,
            'categories' => $categories
        ]);
    }

    public function phoneVerify()
    {
        return view('auth.verify-phone')
            ->with(['phone' => session('phone')]);
    }

    public function dashboard()
    {
        $active_products = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price');
        }])->join('auctions', 'auctions.id', '=', 'auction_products.auction_id')
            ->withCount('bids')
            ->where('auctions.end_time', '>', Carbon::now())
            ->orderBy('id', 'DESC')
            ->take(12)
            ->get()->map(function ($product) {
                $product['lowest_bid'] = $product->bids->min('price');
                $product['highest_bid'] = $product->bids->max('price');
                return $product;
            });

        $active_products_count = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price');
        }])->join('auctions', 'auctions.id', '=', 'auction_products.auction_id')
            ->withCount('bids')
            ->where('auctions.end_time', '>', Carbon::now())
            ->count();

            // dd($active_products_count);

        $notification_products = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price');
      }])
            ->join('auctions', 'auctions.id', '=', 'auction_products.auction_id')
            ->join('auction_target_suppliers', 'auction_target_suppliers.auction_id', '=', 'auctions.id')
            ->withCount('bids')
            ->where('auctions.end_time', '>', Carbon::now())
            ->where('auction_target_suppliers.supplier_id', '=', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->take(12)
            ->get()->map(function ($product) {
                $product['lowest_bid'] = $product->bids->min('price');
                $product['highest_bid'] = $product->bids->max('price');
                return $product;
            });

        $won_products = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price', 'auction_bid_products.quantity as bid_qty');
        }])
            ->withCount('bids')
            ->where('winner_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->take(12)
            ->get()->map(function ($product) {
                $product['lowest_bid'] = $product->bids->min('price');
                return $product;
            });

        $won_products_count = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price', 'auction_bid_products.quantity as bid_qty');
        }])
            ->withCount('bids')
            ->join('auction_bid_products', 'auction_bid_products.auction_product_id', '=', 'auction_products.id')
            ->where('winner_id', auth()->user()->id)
            ->count();
            // dd($won_products_count);


        $favourote_count = Favorite::where('user_id', auth()->user()->id)->count();

        $categories = Category::with(['catalogues' => function($query) {
            $query->with('products.auction', function ($qw) {
                $qw->orderBy('id', 'DESC');
            })->whereHas('products')
                ->withCount('products')
                ->with('products.thumbnail');
        }])->withCount(['catalogues as catalogue_with_product_count' => function ($q) {
                $q->whereHas('products');
            }])
            ->where('parent_id', 0)
            ->get();

        return view('frontend.dashboard', [
            'active_products' => $active_products,
            'active_products_count' => $active_products_count,
            'notification_products' => $notification_products,
            'won_products' => $won_products,
            'won_products_count' => $won_products_count,
            'favourote_count' => $favourote_count,
            'categories' => $categories,
        ]);
    }

    public function profile()
    {
        return view('frontend.profile');
    }

    public function viewProfile()
    {
        $profile = UserProfile::with('company')
            ->select('user_profiles.*', 'countries.id', 'countries.name as country_name', 'cities.id', 'cities.name as city_name')
            ->join('countries', 'countries.id', '=', 'user_profiles.country')
            ->join('cities', 'cities.id', '=', 'user_profiles.city')
            ->where('user_profiles.user_id', auth()->user()->id)
            ->first();
        
        // $categories = explode(',',  $profile->parent_category_id);
        
        
        if ($profile !== null) {
            if ($profile->parent_category_id !== null) {
                $categories = explode(',', $profile->parent_category_id);
            } else {
                // Handle the case where $profile->parent_category_id is null
                // You can set $categories to an empty array or take appropriate action.
                $categories = [];
            }
        } else {
            // Handle the case where $profile itself is null
            // You can set $categories to an empty array or take appropriate action.
            $categories = [];
        }
        

        
        
        
        // $cat_arr = array();
        // foreach($categories as $key=>$val)
        // {
        //     $vl = preg_replace('#[^\w()/.%\-&]#', "", $val);
        //     $cat_arr[$vl] = $vl;
        // }

        $neighbour = Neighbourhood::where('id', $profile->neighbourhood)->first();
        $cat = Category::whereIn('id', $categories)->get();
        return view('frontend.view-profile', compact('profile', 'cat','neighbour'));
    }

    public function newAuction()
    {
        if (!profileStatusCompleted()) {
            session()->flash('error', __('You must complete your profile before creating auctions'));
            return redirect()->route('frontend.profile');
        }

        return view('frontend.new-auction');
    }

    public function newQuotation()
    {
        return view('frontend.new-quotation');
    }

    public function myBids()
    {
        $logUser = Auth::user()->id;
        $auctionProduct = AuctionBidProduct::with('unit', 'product')->where('user_id', $logUser)->orderBy('id', 'desc')->get();
            // dd($auctionProduct['product']);
        return view('frontend.my-bid',[
            'auctionProduct' => $auctionProduct,
        ]);

    }

    public function wonBidList()
    {
        $won_products = AuctionProduct::with(['catalogue','auction','thumbnail', 'bids' => function ($q) {
            $q->select('id', 'auction_product_id', 'price', 'auction_bid_products.quantity as bid_qty');
        }])
            ->withCount('bids')
            ->where('winner_id', auth()->user()->id)
            ->orderBy('id', 'DESC')
            ->take(12)
            ->get()->map(function ($product) {
                $product['lowest_bid'] = $product->bids->min('price');
                return $product;
            });

        return view('frontend.won-bid-list',[
            'won_products' => $won_products,
        ]);
    }

    public function catalogue()
    {
        return view('frontend.catalogue');
    }

    public function auctions(Request $request)
    {
        // dd($request);
        $products = AuctionProduct::with(['auction', 'catalogue'])
            ->whereHas('auction', function ($q) {
                $q->where('service_type','!=',Auction::QUOTATION_SERVICE);
            })
            ->where('winner_id', null) // Add this line to filter products with a null winner_id
            ->orderBy('id','desc')->paginate($request->perPage);

        $categories = Category::where('parent_id', 0)->get();

        return view('frontend.auctions', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function quotations(Request $request)
    {
        $products = AuctionProduct::with(['auction', 'catalogue'])
            ->whereHas('auction', function ($q) {
                $q->where('service_type',Auction::QUOTATION_SERVICE);
            })
            ->orderBy('id','desc')->paginate($request->perPage);

        $categories = Category::where('parent_id', 0)->get();

        return view('frontend.auctions', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function pricingPlan(Request $request)
    {
        $subscription_plan = Subscription::orderBy('id', 'asc')->get()->toArray();
        return view('frontend.pricing-plan', ['subscription_plan' => $subscription_plan]);
    }

    public function auctionsByCategory($category, Request $request)
    {
        $category = Category::where('slug', $category)->first();
        $categories = Category::where('parent_id', 0)->get();

        $catalogueIds = Catalogue::where('parent_category_id', $category->id)
            ->orWhere('category_id', $category->id)->get()->pluck('id')->toArray();

        $products = null;
        if (count($catalogueIds)) {
            $products = AuctionProduct::with(['auction', 'catalogue'])
                ->whereIn('catalogue_id', $catalogueIds)
                ->orderBy('id', 'desc')
                ->paginate($request->perPage);
        }

        return view('frontend.auctions', [
            'products' => $products,
            'categories' => $categories,
            'category' => $category,
            'featuredAuctions' => null, //TODO:: add featured auctions based on requirement
        ]);
    }

    public function wallet()
    {
        return view('frontend.wallet');
    }


    public function auction($slug)
    {
        $auction = Auction::with(['products.catalogue.images', 'unit'])->where('slug', $slug)->first();
        if (!$auction) {
            abort(404);
        }

        $brands = Brand::get();
        $units = Unit::get();

        return view('frontend.auction-details',[
            'auction' => $auction,
            'brands' => $brands,
            'units' => $units,
        ]);
    }

    public function auctionProduct($slug, $catalogueSlug, Request $request)
    {
        if (!$request->id) {
            abort(404);
        }

        if (!profileStatusCompleted()) {
            session()->flash('error', __('You must complete your profile before creating auctions'));
            return redirect()->route('frontend.profile');
        }

        $auctionProduct = AuctionProduct::whereHas('auction', function ($query) use ($slug){
            return $query->where('slug', $slug);
        })->whereHas('catalogue', function ($query) use ($catalogueSlug){
            return $query->where('slug', $catalogueSlug);
        })->with(['catalogue.category.parent', 'images', 'ownBids', 'bids.bidder', 'made_by'])
            ->findOrFail($request->id);

        $images = $auctionProduct->images->unique('src');

        $locale = app()->getLocale();

        $brand_column = 'title_' . $locale;
        if (!Schema::hasColumn('brands', $brand_column)) {
            $brand_column = 'title_en';
        }
        $brands = Brand::select('id', $brand_column, 'title_en')->get();      

        $unit_column = 'title_' . $locale;
        if (!Schema::hasColumn('units', $unit_column)) {
            $unit_column = 'title_en';
        }
        $units = Unit::select('id', $unit_column, 'title_en')->get();        

        $made_column = 'name_' . $locale;
        if (!Schema::hasColumn('made_ins', $made_column)) {
            $made_column = 'name_en';
        }
        $made_in = MadeIn::select('id', $made_column, 'name_en')->get();


        return view('frontend.auction-product-details', [
            'product' => $auctionProduct,
            'images' => $images,
            'brands' => $brands,
            'brand_column' => $brand_column,
            'units' => $units,
            'unit_column' => $unit_column,
            'made_in' => $made_in,
            'made_column' => $made_column,
        ]);
    }

    public function auctionProductDetails(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }

        $auctionProduct = AuctionProduct::with(['catalogue.category.parent', 'images', 'ownBids', 'bids.bidder', 'made_by'])
            ->findOrFail($request->id);
        // dd($auctionProduct);
        $images = $auctionProduct->images->unique('src');
        $brands = Brand::get();
        $units = Unit::get();
        $made_in = MadeIn::get();

        return view('frontend.auction-product-details', [
            'product' => $auctionProduct,
            'images' => $images,
            'brands' => $brands,
            'units' => $units,
            'made_in' => $made_in,
        ]);
    }


    public function saveRuntimeCatalog(Request $request)
    {

        $validatedData = $request->validate([
            'category__id' => 'required|integer',
            'sub__category__id' => 'required|integer',
            'title' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            $data = Catalogue::create([
                'parent_category_id' => $validatedData['category__id'],
                'category_id'        => $validatedData['sub__category__id'],
                'title'              => $validatedData['title'],
                'slug'               => Str::slug($validatedData['title']),
                'user_id'            => Auth::id(),
            ]);

            if ($request->hasFile('images')) {
                $imageService = new ImageService();
                $list = [];
                
                foreach ($request->file('images') as $image) {
                    $list[] = [
                        'catalogue_id' => $data->id,
                        'src' => $imageService->saveImage($image),
                    ];
                }

                CatalogueImage::insert($list);
            }

            return response()->json($data, 201);
        } catch (\Exception $e) {
            \Log::error('Error saving catalog: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Unable to save catalog', 'message' => $e->getMessage()], 500);
        }
    }


    public function GetRuntimeCatalogTitle($title): JsonResponse
    {
        $catalog_title = Catalogue::where('title', $title)->first();

        if (!$catalog_title) {
            return response()->json(['message' => 'Catalog title not found'], 404);
        }

        return response()->json($catalog_title);
    }

    public function auctionBidSuccess($slug, $catalogueSlug, Request $request)
    {
        $auction = Auction::where('slug', $slug)->first();

        return view('frontend.auction-bid-success', [
            'auction' => $auction,
            'slug' => $slug,
            'catalogueSlug' => $catalogueSlug,
            'id' => $request->id,
        ]);
    }

    public function aboutUs()
    {
        $locale = app()->getLocale();
        $page_multilang_data = 'page_details_' . $locale;
        
        if (!Schema::hasColumn('page_contents', $page_multilang_data)) {
            $page_multilang_data = 'page_details_en';
        }

        $page_data = PageContent::select('id', 'page_name_id', $page_multilang_data, 'page_details_en')
            ->where('page_name_id', 2)
            ->first();

        return view('frontend.about_us', [
            'page_data' => $page_data,
            'page_multilang_data' => $page_multilang_data
        ]);
    }

    public function contact()
    {
        $page_data = PageContent::where('page_name_id', 3)->first();
        return view('frontend.contact', ['page_data' => $page_data]);
    }    

    public function termCondition()
    {
        $locale = app()->getLocale();
        $page_multilang_data = 'page_details_' . $locale;
        
        if (!Schema::hasColumn('page_contents', $page_multilang_data)) {
            $page_multilang_data = 'page_details_en';
        }

        $page_data = PageContent::where('page_name_id', 1)->first();
        return view('frontend.term-condition', ['page_data' => $page_data, 'page_multilang_data' => $page_multilang_data]);
    }    

    public function privacyPolicy()
    {
        $locale = app()->getLocale();
        $page_multilang_data = 'page_details_' . $locale;
        
        if (!Schema::hasColumn('page_contents', $page_multilang_data)) {
            $page_multilang_data = 'page_details_en';
        }
        
        $page_data = PageContent::where('page_name_id', 4)->first();
        return view('frontend.privacy-policy', ['page_data' => $page_data, 'page_multilang_data' => $page_multilang_data]);
    }


    public function faq()
    {
        return view('frontend.faqs');
    }

    public function myAuctions($status = null)
    {
        $data = [
            'status' => $status ?? 'All',
            'auctions' => $this->getMyAuctions($status)
        ];
        switch ($status) {
            case 'active':
                return view('frontend.my-auctions-active', $data);
            case 'closed':
                return view('frontend.my-auctions-close', $data);
            case 'won':
                return view('frontend.my-auctions-won', $data);
            default:
                return view('frontend.my-auctions', $data);
        }
    }

    private function getMyAuctions($status)
    {
        if ($status == 'active') {
            $auctions = Auction::where('user_id', auth()->user()->id)
                ->where('end_time', '>', Carbon::now())
                ->orderBy('id', 'desc');
        } else if ($status == 'closed') {
            $auctions = Auction::where('user_id', auth()->user()->id)
                ->where('end_time', '<=', Carbon::now())->orderBy('id', 'desc');
        }else if ($status == 'won') {
            // $auctions = Auction::where('user_id', auth()->user()->id)->orderBy('id', 'desc');

              $auctions = Auction::where('user_id', auth()->user()->id)
                ->whereHas('products', function ($q) {
                    $q->whereNotNull('winner_id')->orderBy('id', 'desc');
                });
                
        } 
        // else if ($status == 'won') {
        //     $auctions = Auction::whereHas('products', function ($q) {
        //         $q->where('winner_id', auth()->user()->id)->orderBy('id', 'desc');
        //     });
        // } 
        else {
            $auctions = Auction::where('user_id', auth()->user()->id)->orderBy('id', 'desc');
        }

        return $auctions->paginate(20);
    }
}
