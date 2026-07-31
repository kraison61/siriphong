<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $productCategories = Category::query()
            ->where('type', 'product')
            ->orderBy('sort_order')
            ->get();

        $serviceCategories = Category::query()
            ->where('type', 'service')
            ->orderBy('sort_order')
            ->get();

        $products = Product::query()
            ->with('category')
            ->where('type', 'product')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $services = Product::query()
            ->with('category')
            ->where('type', 'service')
            ->where('is_active', true)
            ->orderByDesc('is_featured')
            ->orderBy('id')
            ->get();

        $title = 'สินค้าและบริการ | ศิริพงษ์ เซอร์วิส';
        $description = 'จำหน่ายเครื่องดูดฝุ่นอุตสาหกรรม อะไหล่แท้ และบริการซ่อมครบวงจร ทุกยี่ห้อ รับประกันงาน';

        return view('frontend.products.index', compact(
            'productCategories',
            'serviceCategories',
            'products',
            'services',
            'title',
            'description',
        ));
    }
}
