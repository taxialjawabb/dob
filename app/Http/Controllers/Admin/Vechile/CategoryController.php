<?php

namespace App\Http\Controllers\Admin\Vechile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //show add form category
    public function show_add()
    {
        return view('vechile.category.addCategory');
    }


    //add new category
    public function add_category(Request $request)
    {
        $request->validate([
            'category_name' => ['required','string'],
            'basic_price' => ['required','numeric'],
            'km_cost' => ['required', 'numeric'],
            'km_cost' => ['required', 'numeric'],
            'minute_cost' => ['required', 'numeric'],
            'cancel_cost' => ['required', 'numeric'],
            'minimum_order' => ['required', 'numeric'],
        ]);

        $cat= Category::select('category_name')->where('category_name', $request->category_name)->get();

        if(count($cat) === 0){
            $cat= new Category;
            $cat->category_name  = $request->category_name;
            $cat->basic_price  = $request->basic_price ;
            $cat->km_cost  = $request->km_cost ;
            $cat->minute_cost  = $request->minute_cost ;
            $cat->reject_cost  = $request->reject_cost ;
            $cat->cancel_cost  = $request->cancel_cost ;
            $cat->admin_id  = Auth::guard('admin')->user()->id ;
            $cat->show_in_app  = $request->show_in_app? 1:0;
            $cat->minimum_order  = $request->minimum_order;
            $cat->save();
            $request->session()->flash('status', 'تم إضافة التصنيف بنجاح');
            return redirect('vechile/show/cagegory');
        }else{
            $request->session()->flash('error', 'هـذا التصنيف موجود بالفعل');
            return back();
        }
    }

    //show all categories
    public function show_category(Request $request)
    {
        $cats = DB::select(' select
        category.id,
        category_name,
        basic_price,
        km_cost,
        reject_cost,
        cancel_cost,
        admins.name as admin_name,
        ROUND(( rate / rate_counter) , 1) as rate
        from category, admins where category.admin_id= admins.id;');
        return view('vechile.category.showCategory', compact('cats'));
    }

    // detials category by id
    public function detials_show($id)
    {
        $cat = Category::find($id);
        if($cat !== null){
            $secondary = $cat->secondary;
            return view('vechile.category.detials', compact('cat', 'secondary'));
        }
        else{
            return redirect('vechile/show/cagegory');
        }
    }

    //show update form for update category
    public function update_show($id)
    {
        $cat = Category::find($id);
        $vechile = DB::select("select id from vechile where category_id = ? ;", [$id]);
        if($cat !== null){
            $hasVechile = count($vechile) == 0;
            return view('vechile.category.update', compact('cat', 'hasVechile'));
        }
        else{
            return redirect('vechile/show/cagegory');
        }
    }
    //update category by id
    public function update_category(Request $request)
    {
        $request->validate([
            'id' => ['required','integer'],
            'category_name' => ['required','string'],
            'basic_price' => ['required','numeric'],
            'km_cost' => ['required', 'numeric'],
            'minute_cost' => ['required', 'numeric'],
            'reject_cost' => ['required', 'numeric'],
            'cancel_cost' => ['required', 'numeric'],
            'minimum_order' => ['required', 'numeric'],
        ]);

        $cat= Category::find($request->id);
        if($cat !== null){
            $cat->category_name  = $request->category_name;
            $cat->basic_price  = $request->basic_price ;
            $cat->km_cost  = $request->km_cost ;
            $cat->minute_cost  = $request->minute_cost ;
            $cat->reject_cost  = $request->reject_cost ;
            $cat->cancel_cost  = $request->cancel_cost ;
            $cat->show_in_app  = $request->show_in_app? 1:0;
            $cat->admin_id  = Auth::guard('admin')->user()->id;
            $cat->minimum_order  = $request->minimum_order;
            $cat->save();

            $request->session()->flash('status', 'تم تعديل التصنيف بنجاح');
            return back();
        }else{
            $request->session()->flash('error', 'هـذا التصنيف غير موجود لتعديله');
            return back();
        }
    }
}
