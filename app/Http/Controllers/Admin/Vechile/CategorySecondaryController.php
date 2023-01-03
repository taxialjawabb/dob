<?php

namespace App\Http\Controllers\Admin\Vechile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SecondaryCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CategorySecondaryController extends Controller
{
    //show add form category
    public function show_add($id)
    {
        $cat = Category::find($id);
        if($cat !== null){
            return view('vechile.category.secondary.addSecondaryCategory', compact('cat'));
        }
        else{
            return back();
        }
    }


    //add new category
    public function add_category(Request $request)
    {
        $request->validate([            
            'name' => ['required', 'string'],
            'percentage_type' => ['required', 'string'],
            'category_id' => ['required', 'numeric'],
            'category_percent' => ['required', 'numeric'],
        ]);
        
        
        $cat = SecondaryCategory::where('category_id', $request->category_id)->where('name', $request->name)->get();
        if(count($cat) === 0){
            $secondaryCat = new SecondaryCategory;
            $secondaryCat ->name  = $request->name ;
            $secondaryCat ->percentage_type  = $request->percentage_type ;
            $secondaryCat ->category_percent  = $request->category_percent ;
            $secondaryCat ->admin_id  = Auth::guard('admin')->user()->id ;
            $secondaryCat ->category_id  = $request->category_id;
            $secondaryCat ->add_date  = Carbon::now();
            $secondaryCat ->save();
            $request->session()->flash('status', 'تم إضافة التصنيف الفرعي بنجاح');
            return redirect('vechile/detials/cagegory/'.$request->category_id);
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
        admins.name as admin_name
        from category, admins where category.admin_id= admins.id;');
        return view('vechile.category.showCategory', compact('cats'));
    }
    
    // detials category by id
    public function detials_show($id)
    {     
        $cat = Category::find($id);
        if($cat !== null){
            return view('vechile.category.detials', compact('cat'));
        }
        else{
            return redirect('vechile/show/cagegory');
        }
    }

    //show update form for update category
    public function update_show($id)
    {     
        $cat = SecondaryCategory::find($id);
        if($cat !== null){
            return view('vechile.category.secondary.update', compact('cat'));
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
            'name' => ['required','string'],
            'percentage_type' => ['required', 'string'],
            'category_percent' => ['required', 'numeric'],
        ]);

        $cat= SecondaryCategory::find($request->id);
        if($cat !== null){
            $cat->name  = $request->name;
            $cat->percentage_type  = $request->percentage_type ;
            $cat->category_percent  = $request->category_percent ;
            $cat->save();
            $request->session()->flash('status', 'تم تعديل التصنيف بنجاح');
            return redirect('vechile/detials/cagegory/'.$cat->category_id);
            return back();    
        }else{
            $request->session()->flash('error', 'هـذا التصنيف غير موجود لتعديله');
            return back();    
        }
    }
}
