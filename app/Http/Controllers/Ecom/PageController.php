<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductOffer;
use App\Models\Advertisement;
use App\Models\OrderItem;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
// use App\Models\BlogComment;
// use App\Models\Customer;
use App\Models\Post;

use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index()
    {
        $user = auth()->guard('customer')->user();
        // Log::info($user);
        // $products = Product::where('is_active', 1)->with('productVariants')->latest()->get();
        $best_sellers = Product::where('is_active', 1)->where('is_bestseller', 1)->with('productVariants')->get();
        // $advertisements = Advertisement::where('status', 1)->take(2)->get();
        $advertisements = Advertisement::where('media', 'desktop')->get();
        $mobile_ads = Advertisement::where('media', 'mobile')->get();
        $offers = ProductOffer::where('is_active', 1)->get();

        // get latest first 1 offer
        $offer = ProductOffer::where('is_active', 1)->latest()->first();

        // get latest 8 products
        $products = Product::where('is_active', 1)->with('productVariants')->latest()->take(8)->get();

        $feacherdProducts = Product::where('is_active', 1)->where('is_featured', 1)->with('productVariants')->get();

        // return view('ecom.index', compact('products', 'offers', 'best_sellers', 'advertisements'));
        return view('ecom.web.index', compact('products', 'offer', 'offers', 'best_sellers', 'advertisements', 'feacherdProducts', 'mobile_ads'));
    }

    public function products(Request $request)
    {
        // Log::info($request->all());
        $user = auth()->guard('customer')->user();
        $categories = Category::where('is_active', 1)->get();
        $productsQuery = Product::where('is_active', 1)->with('productVariants');
        $category = null;
        $title = 'Products';

        // $products = $productsQuery->get();

        // // get latest new 10 products
        // $newProducts = Product::where('is_active', 1)->with('productVariants')->latest()->take(10)->get();

        if ($request->has('category_id')) {
            $category_id = Category::where('uuid', $request->category_id)->value('id');
            $productsQuery->where('category_id', $category_id);
            $category = Category::where('uuid', $request->category_id)->first();
        } elseif ($request->has('search')) {
            $searchTerm = $request->search;
            $productsQuery->where('name', 'like', '%' . $searchTerm . '%');
        } elseif ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;
            $productsQuery->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif ($request->has('min_price')) {
            $minPrice = $request->min_price;
            $productsQuery->where('price', '>=', $minPrice);
        } elseif ($request->has('max_price')) {
            $maxPrice = $request->max_price;
            $productsQuery->where('price', '<=', $maxPrice);
        } elseif ($request->has('is_bestseller')) {
            $productsQuery->where('is_bestseller', 1);
        } elseif ($request->has('is_featured')) {
            $productsQuery->where('is_featured', 1);
        } elseif ($request->has('new_to_old')) {
            $productsQuery->latest('created_at');
        } elseif ($request->has('old_to_new')) {
            $productsQuery->oldest('created_at');
        } elseif ($request->has('low_to_high')) {
            $productsQuery->orderBy('price', 'asc');
        } elseif ($request->has('high_to_low')) {
            $productsQuery->orderBy('price', 'desc');
        } elseif ($request->has('a_to_z')) {
            $productsQuery->orderBy('name', 'asc');
        } elseif ($request->has('z_to_a')) {
            $productsQuery->orderBy('name', 'desc');
        } else {
            $productsQuery->latest('created_at');
        }

        $products = $productsQuery->paginate(12);
        $products->appends($request->except('page'));

        return view('ecom.web.products', compact('products', 'categories', 'category', 'title'));
    }

    public function productDetails($slug)
    {
        $customer = auth()->guard('customer')->user();

        // check slug type is integer or string
        if (is_numeric($slug)) {
            $slug = ProductVariant::where('id', $slug)->value('uuid');
        }

        $product = Product::whereHas('productVariants', function ($query) use ($slug) {
            $query->where('uuid', $slug);
        })->with('productVariants', 'category', 'productVariants.reviews')->first();

        // Get reviews for the first product variant
        $reviews = $product->productVariants->first()->reviews;

        // Calculate average rating
        $avgRating = $reviews->avg('rating');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('productVariants', 'category')
            ->get();

        foreach ($relatedProducts as $relatedProduct) {
            foreach ($relatedProduct->productVariants as $variant) {
                $averageRating = $variant->avg_rating();
                $variant->averageRating = $averageRating;
            }
        }

        $title = $product->name;

        // if customer has logged in then find if the product is ordered by this user or not
        if (!is_null($customer)) {
            $product_variant = ProductVariant::where('uuid', $slug)->first();

            $order = OrderItem::where('customer_id', $customer->id)
                ->where('product_variant_id', $product_variant->id)
                ->first();

            if (!is_null($order)) {
                $product->is_ordered = true;
            } else {
                $product->is_ordered = false;
            }
        }

        return view('ecom.web.product-detail', compact('product', 'relatedProducts', 'slug', 'title', 'reviews', 'avgRating'));
    }

    public function privacy()
    {
        $title = 'Privacy Policy';
        return view('ecom.web.privacy-policy', compact('title'));
    }

    public function terms()
    {
        $title = 'Terms & Conditions';
        return view('ecom.web.term-condition', compact('title'));
    }

    public function shipingpolicy()
    {
        $title = 'Shipping Policy';
        return view('ecom.web.shipping-policy', compact('title'));
    }

    public function returnpolicy()
    {
        $title = 'Return Policy';
        return view('ecom.web.return-policy', compact('title'));
    }

    public function aboutUs()
    {
        $title = 'About Us';
        return view('ecom.web.aboutus', compact('title'));
    }

    public function contactUs()
    {
        $title = 'Contact Us';
        return view('ecom.web.contact', compact('title'));
    }

    public function blog(Request  $request)
    {
        try {
            $title = 'Blog';
            $user = auth()->guard('customer')->user();
            $categories = BlogCategory::all();
            $tags = BlogTag::all();
            $blog = Blog::with('createdby', 'category');
            $recent_blogs = Blog::latest()->take(4)->get();

            if ($request->has('category_id')) {
                $blog->where('category_id', $request->category_id);
            } elseif ($request->has('search')) {
                $searchTerm = $request->search;
                $blog->where('title', 'like', '%' . $searchTerm . '%');
            } elseif ($request->has('tag')) {
                // $blogTags = $blog->tag;
                $searchTag = $request->tag;
                $blog->where('tag', 'like', '%' . $searchTag . '%');
            } elseif ($request->has('is_bestseller')) {
                $blog->where('is_bestseller', 1);
            } elseif ($request->has('is_featured')) {
                $blog->where('is_featured', 1);
            } elseif ($request->has('new_to_old')) {
                $blog->latest('created_at');
            } elseif ($request->has('old_to_new')) {
                $blog->oldest('created_at');
            } elseif ($request->has('low_to_high')) {
                $blog->orderBy('price', 'asc');
            } elseif ($request->has('high_to_low')) {
                $blog->orderBy('price', 'desc');
            } else {
                $blog->latest('created_at');
            }

            $blogs = $blog->paginate(12);
            $blogs->appends($request->except('page'));

            return view('ecom.web.blog', compact('title', 'blogs', 'categories', 'tags', 'recent_blogs'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }

    public function blogDetail($id)
    {
        $blog = Blog::with('createdby', 'category', 'comments')->where('id', $id)->first();
        $latest_blogs = Blog::where('id', '!=', $id)->latest()->take(8)->get();
        $title = $blog->title;
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        $posts = Blog::all();
        $recent_blogs = Blog::latest()->take(4)->get();
        return view('ecom.web.blog-detail', compact('title', 'blog', 'categories', 'tags', 'recent_blogs', 'posts', 'latest_blogs'));
    }

    public function post(Request  $request)
    {
        try {
            $title = 'Post';
            $user = auth()->guard('customer')->user();
            $posts = Post::with('customer', 'comments')->where('status', 'approved')->get();
            return view('ecom.web.posts', compact('title', 'posts'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return abort(500); // Internal Server Error
        }
    }
}
