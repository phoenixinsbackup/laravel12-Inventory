<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    public function AllBrand()
    {
        $brand=Brand::latest()->get();
        return view('admin.backend.brand.all_brand',compact('brand'));

    }

    public function AddBrand()
    {
         return view('admin.backend.brand.add_brand');
    }
}
