<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RootController extends Controller {
    public function index() {
        $path = URL('/uploads/product') . '/';
        $product_images = ProductImage::select(
            'product_categories.name AS category_name',
            'products.id AS product_id',
            'products.title',
            DB::Raw("CASE WHEN " . 'image' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'image' . ") ELSE CONCAT(" . "'" . $path . "'" . ", 'noImage.jpg')
        END as image")
        )
            ->leftjoin('products', 'product_images.product_id', 'products.id')
            ->leftjoin('product_categories', 'products.product_category_id', 'product_categories.id')
            ->take(6)->inRandomOrder()->get();

        $count = Counter::where('status', 'active')->get();
        return view('front.index')->with(['product_images' => $product_images, 'count' => $count]);
    }

    public function about() {
        $path = URL('/uploads/team') . '/';
        $team = Team::select(
            'name',
            'facebook_url',
            'twitter_url',
            'linked_in_url',
            'instagram_url',
            DB::Raw("CASE WHEN " . 'image' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'image' . ") ELSE CONCAT(" . "'" . $path . "'" . ", 'defaultAvatar.png')
        END as image")
        )->get();
        return view('front.about')->with(['teams' => $team]);
    }

    public function product() {
        $path = URL('/uploads/product') . '/';
        $categries = ProductCategory::where(['status' => 'active'])->get(['name']);
        $product_images = ProductImage::select(
            'product_categories.name AS category_name',
            'products.id AS product_id',
            'products.title',
            DB::Raw("CASE WHEN " . 'image' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'image' . ") ELSE CONCAT(" . "'" . $path . "'" . ", 'noImage.jpg')
        END as image")
        )
            ->leftjoin('products', 'product_images.product_id', 'products.id')
            ->leftjoin('product_categories', 'products.product_category_id', 'product_categories.id')
            ->where(['product_images.status' => 'active'])
            ->get();
        return view('front.product')->with(['categories' => $categries, 'product_images' => $product_images]);
    }

    public function product_detail(Request $request, $id) {
        if ($id) {
            $path = URL('/uploads/product') . '/';
            $id = base64_decode($request->id);
            $products = Product::select('products.id', 'products.title', 'products.product_description', 'product_categories.name AS category_name')
                ->leftjoin('product_categories', 'product_categories.id', 'products.product_category_id')
                ->where('products.id', $id)
                ->first();
            if (!$products) {
                return redirect()->back()->with(['error', 'Somthing went wrong!']);
            }
            $product_images = ProductImage::select(DB::Raw("CASE WHEN " . 'image' . " != '' THEN CONCAT(" . "'" . $path . "'" . ", " . 'image' . ") ELSE CONCAT(" . "'" . $path . "'" . ", 'noImage.jpg')
            END as image"))->where('product_id', $id)->get();
            return view('front.product_details')->with(['products' => $products, 'product_images' => $product_images]);
        } else {
            return redirect()->back()->with(['error', 'Somthing went wrong!']);
        }
    }

    public function client() {
        return view('front.client');
    }

    public function contact() {
        return view('front.contact');
    }
}
