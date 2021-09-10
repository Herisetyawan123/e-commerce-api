<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if($id)
        {
            $category_by_id = ProductCategory::with('products')->find($id);
            if($category_by_id){
                return ResponseFormatter::success(
                    $category_by_id,
                    'Data product berhasil di ambil'
                );
            }else{
                return ResponseFormatter::error(
                    null,
                    'Data product tidak ada',
                    404
                );
            }
        }

        $category = ProductCategory::query();
        if($name)
        {
            $category->where('name', 'like', "%".$name."%");
        }

        if($show_product){
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data Kategori Berhasil di ambil'
        );
    }
}
