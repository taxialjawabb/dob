<?php

namespace App\Http\Controllers\Admin\Groups\SharedGroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groups\Group;
use App\Models\Groups\GroupTax;
use App\Models\Groups\GroupsInternalBox;
class TaxController extends Controller
{
    public function show_tax(Group $group , $year = null)
    {
        if($year == null){
            $year = request()->year;
        }
        if($year == null){
            return back();
        }

        $groupTax = GroupTax::where('group_id', $group->id)->where('tax_year', $year)->pluck('tax_year', 'periodic');
        // return isset($groupTax['first']);

        $firstPeriodic = GroupsInternalBox::select(\DB::raw("(total_money - money) as tax"))->where('group_id', $group->id)
                        ->whereDate('add_date' , '>=' , $year.'-1-1' )->whereDate('add_date' , '<=' , $year.'-3-31' )->sum('tax');
        $secondPeriodic = GroupsInternalBox::select(\DB::raw("(total_money - money) as tax"))->where('group_id', $group->id)
                        ->whereDate('add_date' , '>=' , $year.'-4-1' )->whereDate('add_date' , '<=' , $year.'-6-30' )->sum('tax');
        $thirdPeriodic = GroupsInternalBox::select(\DB::raw("(total_money - money) as tax"))->where('group_id', $group->id)
                        ->whereDate('add_date' , '>=' , $year.'-7-1' )->whereDate('add_date' , '<=' , $year.'-9-30' )->sum('tax');
        $fourthPeriodic = GroupsInternalBox::select(\DB::raw("(total_money - money) as tax"))->where('group_id', $group->id)
                        ->whereDate('add_date' , '>=' , $year.'-10-1' )->whereDate('add_date' , '<=' , $year.'-12-31' )->sum('tax');

        return view('groups.shared.generalBox.tax', compact('group','groupTax', 'firstPeriodic', 'secondPeriodic', 'thirdPeriodic', 'fourthPeriodic','year'));
    }

    public function spend_tax(Group $group,Request $request)
    {
        // return $request->all();
        $request->validate([
            'year' =>  'required|numeric|min:2020|max:2050',
            'start_date' =>  'required|string|date',
            'end_date' =>        'required|string|date',
            'tax' =>        'required|numeric',
            'periodic' =>        'required|string|in:first,second,third,fourth'
        ]);
         $groupTax = GroupTax::where('group_id', $group->id)->whereDate('start_date', $request->start_date)
                            ->whereDate('end_date', $request->end_date)->whereYear('tax_year', $request->year)->first();
        if($groupTax !== null){
            $request->session()->flash('error', 'تم صرف ضريبة القيمة المضافة لهذه الفترة من قبل');
            return back();
        }
        GroupTax::create([
            'tax_year' => $request->year,
            'start_date' =>  $request->start_date,
            'end_date' => $request->end_date,
            'add_date' => \Carbon\Carbon::now(),
            'added_by' => auth()->id(),
            'tax' => $request->tax,
            'periodic' => $request->periodic,
            'group_id' => $group->id,
        ]);
        $description = "صرف قيمة الضريبة المضافة للمجموعة فى الفترة ";
        switch ($request->periodic) {
            case 'first':
                $description .= "الأولى تبدأ من : ". $request->start_date ." و تنتهى فى: ". $request->end_date;
                break;
            case 'second':
                $description .= "الثانية تبدأ من : ". $request->start_date ." و تنتهى فى: ". $request->end_date;
                break;
            case 'third':
                $description .= "الثالثة تبدأ من : ". $request->start_date ." و تنتهى فى: ". $request->end_date;
                break;
            case 'fourth':
                $description .= "الرابعة تبدأ من : ". $request->start_date ." و تنتهى فى: ". $request->end_date;
                break;
            default:
                break;
        }
        $box = new \App\Models\Groups\GroupsInternalBox;
        $box->group_id = $group->id;
        $box->foreign_type = 'group';
        $box->foreign_id = $group->id;
        $box->bond_type = 'spend';
        $box->payment_type = 'internal transfer';
        $box->money = $request->tax;
        $box->tax = 0;
        $box->total_money = $request->tax;;

        $box->descrpition = $description ;
        $box->add_date = \Carbon\Carbon::now();
        $box->add_by = \Auth::guard('admin')->user()->id;
        $box->save();

        $request->session()->flash('status', 'تم صرف قيمة الضريبه المضافة لهذه الفترة بنجاح وخصمها من الصندوق العام');
        return redirect()->route('shared.groups.show.tax', [ 'group' => $group, 'year' => $request->year]);


    }
}
