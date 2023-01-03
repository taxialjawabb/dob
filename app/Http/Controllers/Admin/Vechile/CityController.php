<?php

namespace App\Http\Controllers\Admin\Vechile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    //show all cities belong to specifec category
    public function show_city($id)
    {
        $cat = Category::find($id);
        if($cat !== null){
            $city = DB::select(' select
            city.id,
            city,
            going_cost,
            going_back_cost,
            city_cancel_cost,
            city_regect_cost,
            city.percentage_type,
            city_percent,
            admins.name as admin_name
            from city, category, admins  where city.admin_id = admins.id and city.category_id = category.id and category.id = ?;', [$id]);
            return view('vechile.city.showCity', compact('cat', 'city'));
        }
        else{
            return redirect('vechile/show/cagegory');
        }
    }

    //show add city form to category
    public function show_add($id)
    {
        $cat = Category::find($id);
        if($cat !== null){

            return view('vechile.city.addCity', compact('cat'));
        }   
        else{
            return redirect('vechile/show/cagegory');
        }     
    }

    // add city to specifec category
    public function add_city(Request $request)
    {

        $request->validate([            
            'city' => ['required','string'],
            'going_cost' => ['required','integer'],
            'going_back_cost' => ['required','integer'],
            'city_cancel_cost' => ['required','integer'],
            'city_regect_cost' => ['required','integer'],
            'percentage_type' => ['required', 'string'],
            'city_percent' => ['required','integer'],
            'category_id' => ['required','integer'],
        ]);
        
        $cat= Category::find($request->category_id);
        
        if($cat !== null){
            $city = City::where('category_id','=', $request->category_id)->where('city','=',$request->city)->get();
            // return count($city);
            if(count($city) == 0){
            $city= new City;
            $city->city  = $request->city;
            $city->going_cost  = $request->going_cost ;
            $city->going_back_cost  = $request->going_back_cost ;
            $city->city_cancel_cost  = $request->city_cancel_cost ;
            $city->city_regect_cost  = $request->city_regect_cost ;
            $city->percentage_type  = $request->percentage_type ;
            $city->city_percent  = $request->city_percent ;
            $city->category_id  = $request->category_id ;
            $city->add_date  = Carbon::now() ;
            $city->admin_id  = Auth::guard('admin')->user()->id;
            $city->save();

            $request->session()->flash('status', 'تم إضافة المدينة للتصنيف بنجاح');
            return redirect('vechile/show/city/'.$request->category_id);
        }
        else{
            $request->session()->flash('error', 'هـذه المدينة مودجوده فى التصنيف بالفعل');
            return back();    
        }
    }else{
            $request->session()->flash('error', 'هـذا التصنيف غير موجود');
            return back();    
        }
    }

    //show city form to update
    public function show_update($catid, $citid)
    {
        $cat = Category::find($catid);
        $city = City::find($citid);
        if($cat !== null && $city !== null){
            return view('vechile.city.updateCity', compact('cat', 'city'));
        }   
        else{
            return redirect('vechile/show/cagegory');
        }     
    }

    // update city in specifec category
    public function update_city(Request $request)
    {
        $request->validate([            
            'city_id' => ['required','integer'],
            // 'city' => ['required','string'],
            'going_cost' => ['required','integer'],
            'going_back_cost' => ['required','integer'],
            'city_cancel_cost' => ['required','integer'],
            'city_regect_cost' => ['required','integer'],
            'percentage_type' => ['required', 'string'],
            'city_percent' => ['required','integer'],
            'category_id' => ['required','integer'],
        ]);

        $cat= Category::find($request->category_id);
        $city = $cat->cities->find($request->city_id);
        
        if($cat !== null &&  $city !== null){
            $city->going_cost  = $request->going_cost ;
            $city->going_back_cost  = $request->going_back_cost ;
            $city->city_cancel_cost  = $request->city_cancel_cost ;
            $city->city_regect_cost  = $request->city_regect_cost ;
            $city->percentage_type  = $request->percentage_type ;
            $city->city_percent  = $request->city_percent ;
            $city->category_id  = $request->category_id ;
            $city->add_date  = Carbon::now() ;
            $city->admin_id  = Auth::guard('admin')->user()->id ;
            $city->save();

            $request->session()->flash('status', 'تم تعديل بيانات المدينة للتصنيف بنجاح');
            return back();    
    }else{
            $request->session()->flash('error', 'هـذا التصنيف غير موجود');
            return back();    
        }
    }

}
