<?php

namespace App\Http\Controllers\Admin\Bills;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver\BoxDriver;
use App\Models\Groups\GroupTax;
use App\Models\Vechile\BoxVechile;

class TaxController extends Controller
{
    public function show($year = null)
    {
        if($year == null){
            $year = request()->year;
        }
        if($year == null){
            return back();
        }

        $groupTax = GroupTax::whereNull('group_id')->where('tax_year', $year)->pluck('tax_year', 'periodic');


        $sql = "select sum(tax) as tax from(
                select ((total_money - money)) as tax from box_driver where bond_type = 'take' and bond_state = 'deposited' and payment_type != 'internal transfer'
                and ( date(deposit_date) >= ?  and date(deposit_date) <= ?)
                union all
                select ((total_money - money)) as tax from box_vechile where bond_type = 'take' and bond_state = 'deposited' and payment_type != 'internal transfer'
                and ( date(deposit_date) >= ?  and date(deposit_date) <= ?)
                union all
                select ((total_money - money)) as tax from box_user where bond_type = 'take' and bond_state = 'deposited' and payment_type != 'internal transfer'
                and ( date(deposit_date) >= ?  and date(deposit_date) <= ?)
                union all
                select ((total_money - money)) as tax from box_rider where bond_type = 'take' and bond_state = 'deposited' and payment_type != 'internal transfer'
                and ( date(deposit_date) >= ?  and date(deposit_date) <= ?)
                union all
                select ((total_money - money)) as tax from box_nathriaat where bond_type = 'take' and bond_state = 'deposited' and payment_type != 'internal transfer'
                and ( date(deposit_date) >= ?  and date(deposit_date) <= ?)) t;";
        $firstPeriodic = \DB::select($sql, [
            $year.'-1-1', $year.'-3-31',
            $year.'-1-1', $year.'-3-31',
            $year.'-1-1', $year.'-3-31',
            $year.'-1-1', $year.'-3-31',
            $year.'-1-1', $year.'-3-31',
        ]);
        $firstPeriodic = $firstPeriodic[0]->tax;

        $secondPeriodic = \DB::select($sql, [
             $year.'-4-1', $year.'-6-30',
             $year.'-4-1', $year.'-6-30',
             $year.'-4-1', $year.'-6-30',
             $year.'-4-1', $year.'-6-30',
             $year.'-4-1', $year.'-6-30',
        ]);
        $secondPeriodic = $secondPeriodic[0]->tax;


        $thirdPeriodic = \DB::select($sql, [
            $year.'-7-1', $year.'-9-30',
            $year.'-7-1', $year.'-9-30',
            $year.'-7-1', $year.'-9-30',
            $year.'-7-1', $year.'-9-30',
            $year.'-7-1', $year.'-9-30',
       ]);
       $thirdPeriodic = $thirdPeriodic[0]->tax;

        $fourthPeriodic = \DB::select($sql, [
            $year.'-10-1', $year.'-12-31',
            $year.'-10-1', $year.'-12-31',
            $year.'-10-1', $year.'-12-31',
            $year.'-10-1', $year.'-12-31',
            $year.'-10-1', $year.'-12-31',
       ]);
       $fourthPeriodic = $fourthPeriodic[0]->tax;




        return view('bills.tax', compact('groupTax', 'firstPeriodic', 'secondPeriodic', 'thirdPeriodic', 'fourthPeriodic','year'));
    }

    public function spend_tax(Request $request)
    {
        $request->validate([
            'year' =>  'required|numeric|min:2020|max:2050',
            'start_date' =>  'required|string|date',
            'end_date' =>        'required|string|date',
            'tax' =>        'required|numeric',
            'periodic' =>        'required|string|in:first,second,third,fourth'
        ]);
         $groupTax = GroupTax::whereNull('group_id')
                            ->whereDate('start_date', $request->start_date)
                            ->whereDate('end_date', $request->end_date)
                            ->whereYear('tax_year', $request->year)->first();
        if($groupTax !== null){
            $request->session()->flash('error', 'تم صرف ضريبة القيمة المضافة لهذه الفترة من قبل');
            return back();
        }
        $groupTax=  GroupTax::create([
            'tax_year' => $request->year,
            'start_date' =>  $request->start_date,
            'end_date' => $request->end_date,
            'add_date' => \Carbon\Carbon::now(),
            'added_by' => auth()->id(),
            'tax' => $request->tax,
            'periodic' => $request->periodic,
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
        $boxNathriaat = new \App\Models\Nathiraat\BoxNathriaat;
        $boxNathriaat->stakeholders_id = 8;
        $boxNathriaat->foreign_type = 'tax';
        $boxNathriaat->foreign_id = $groupTax->id;
        $boxNathriaat->bond_type = 'spend';
        $boxNathriaat->payment_type = 'internal transfer';
        $boxNathriaat->money = $request->tax;
        $boxNathriaat->tax = 0;
        $boxNathriaat->total_money = $request->tax;
        $boxNathriaat->descrpition = $description;
        $boxNathriaat->add_date = \Carbon\Carbon::now();
        $boxNathriaat->add_by = \Auth::guard('admin')->user()->id;
        $boxNathriaat->save();


        $request->session()->flash('status', 'تم صرف قيمة الضريبه المضافة لهذه الفترة بنجاح ');

        return back();


    }
}
