<?php

namespace App\Http\Controllers\Api\DriverRider;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Driver\BoxDriver;
use App\Models\Rider;
use App\Models\Rider\BoxRider;
use App\Models\SecondaryCategory;
use App\Models\Trip;
use App\Models\Vechile;
use App\Models\Vechile\BoxVechile;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverRiderController extends Controller
{
    use GeneralTrait;

    public function calculate_trip_cost(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'trip_type' => 'required|string|in:internal,city',
        ]);

        // if trip between cities
        if ($request->trip_type == "city") {
            $request->validate([
                'city_name' => 'required',
                'trip_away' => 'required|string|in:going_cost,going_back_cost',
            ]);

            $category = DB::select("select percentage_type, going_cost, going_back_cost, city_cancel_cost, city_regect_cost, city_percent  from  category, city  where category.id = city.category_id and category.id = ? and city.city= ? limit 1;", [$request->category_id, $request->city_name]);
            if (count($category) > 0) {

                $total = 0;
                if ($request->trip_away == 'going_back_cost') {
                    $total = $category[0]->going_back_cost;
                } else if ($request->trip_away == 'going_cost') {
                    $total = $category[0]->going_cost;
                }
                $company = 0;
                $driver = 0;
                if ($category[0]->percentage_type == "daily_percent" || $category[0]->percentage_type == "percent") {
                    $company = $total * ($category[0]->city_percent / 100);
                    $driver = $total - $company;
                }
                return $this->calculate_data($total, $driver, $company, $category[0]->city_cancel_cost, $category[0]->city_regect_cost, $category[0]->percentage_type);
            } else {
                return $this->returnError('category not exist', 'No category is detected');
            }
        } else {
            $request->validate([
                'distance' => 'required|numeric',
            ]);
            $category = DB::select("select basic_price, km_cost, reject_cost, cancel_cost, percentage_type, fixed_percentage, category_percent from  category where id = ? limit 1;", [$request->category_id]);
            if (count($category) > 0) {
                $total = $category[0]->basic_price + ($category[0]->km_cost * ($request->distance / 1000));
                $company = 0;
                $driver = 0;
                if ($category[0]->percentage_type == "daily_percent" || $category[0]->percentage_type == "percent") {
                    $company = $total * ($category[0]->category_percent / 100);
                    $driver = $total - $company;
                }
                return $this->calculate_data($total, $driver, $company, $category[0]->cancel_cost, $category[0]->reject_cost, $category[0]->percentage_type);
            } else {
                return $this->returnError('category not exist', 'No category is detected');
            }
        }
    }

    public function calculate_data($total = 0, $driver = 0, $company = 0, $cancel = 0, $reject = 0, $payment_percentage = '')
    {
        $object = (object) [
            'total' => $total,
            'driver' => $driver,
            'company' => $company,
            'cancel' => $cancel,
            'reject' => $reject,
            'payment_percentage' => $payment_percentage,
        ];
        return $this->returnData('trip_cost', $object, 'All data for this trip');

    }

    public function trip_payment(Request $request)
    {
        $request->validate([
            "payment_type" => "required|string|in:cash,internal",
            "total" => "required|numeric",
            "company" => "required|numeric",
            "driver_id" => "required",
            "trip_id" => "required",
            "bons" => "required|numeric",
        ]);
        $trip = Trip::find($request->trip_id);
        if ($trip !== null) {
            if ($trip->state == 'expired') {
                return $this->returnError('E004', 'the trip is complete');
            }
            $trip->state = 'expired';
            $trip->trip_end_time = Carbon::now();
            $driver = Driver::find($request->driver_id);
            $vechile = Vechile::find($driver->current_vechile);
            if ($driver !== null || $vechile !== null) {
                $secondary = SecondaryCategory::find($vechile->secondary_id);
                if ($secondary !== null) {
                    if ($secondary->percentage_type == 'fixed') {
                        $request->company = $secondary->category_percent;
                    } else if ($secondary->percentage_type == 'percent') {
                        $request->company = $request->total * ($secondary->category_percent / 100);
                    }
                }
            }
            if ($request->payment_type == 'cash') {
                $boxVechile = new BoxVechile;
                // $driver =  Driver::find($request->driver_id);
                // $vechile = Vechile::find($driver->current_vechile);

                $money = round($request->company, 2);
                $description = 'تم خصم مبلغ  ' . round($request->company, 2) . ' عائد للمركبة رقم ' . $vechile->id . ' على رحلة رقم ' . $request->trip_id . ' تكلفة الرحلة ' . round($request->total, 2);
                $descriptionRider = 'عملية الدفع نقدا بنجاح ';
                $rider = Rider::find($trip->rider_id);
                $bons = 0;
                if ($request->bons > 0) {
                    $bons = $request->bons;
                    $boxRider = new BoxRider;
                    // $rider = Rider::find($trip->rider_id);
                    $boxRider->rider_id = $rider->id;
                    $boxRider->bond_type = 'take';
                    $boxRider->payment_type = 'internal transfer';
                    $boxRider->bond_state = 'deposited';
                    $boxRider->money = $bons;
                    $boxRider->tax = 0;
                    $boxRider->total_money = $bons;
                    $descriptionRider .= 'تم أضافة رصيد  ' . $bons . ' عائد من السائق رصيد أضافى' . $driver->name . ' على رحلة رقم ' . $request->trip_id;
                    $boxRider->descrpition = $descriptionRider;
                    $boxRider->add_date = Carbon::now();
                    // return $bons;

                    $description .= " و خصم رصيد " . $bons . " فرق النقدى من العميل";

                    $rider->account += $bons;
                    $boxRider->save();
                    $rider->save();
                }
                $boxVechile->vechile_id = $vechile->id;
                $boxVechile->foreign_type = 'driver';
                $boxVechile->foreign_id = $driver->id;
                $boxVechile->bond_type = 'take';
                $boxVechile->payment_type = 'internal transfer';
                $boxVechile->bond_state = 'deposited';
                $boxVechile->descrpition = $description;
                $boxVechile->money = ($money * 0.8) + $bons;
                $boxVechile->tax = 0;
                $boxVechile->total_money = ($money * 0.8) + $bons;
                $boxVechile->add_date = Carbon::now();

                $boxVechileAds = new BoxVechile();
                $boxVechileAds->vechile_id = $vechile->id;
                $boxVechileAds->foreign_type = 'stakeholders';
                $boxVechileAds->foreign_id = 11;
                $boxVechileAds->bond_type = 'spend';
                $boxVechileAds->payment_type = 'internal transfer';
                $boxVechileAds->bond_state = 'deposited';
                $boxVechileAds->descrpition = 'عائد من رحلة إلى أدارة التسويق والدعاية من رحلة داخلية';
                $boxVechileAds->money = $money * 0.2;
                $boxVechileAds->tax = 0;
                $boxVechileAds->total_money = $money * 0.2;
                $boxVechileAds->add_date = Carbon::now();
                $boxVechileAds->save();

                $stakeholder = \App\Models\Nathiraat\Stakeholders::find(11);
                $stakeholder->account += $money * 0.2;
                $stakeholder->save();

                $driver->account -= $money + $bons;
                $vechile->account += ($money * 0.8);

                // $driver->available = 1;

                $trip->payment_type = 'cash';
                $trip->cost = round($request->total, 2);
                $trip->save();

                $boxVechile->save();
                $driver->save();
                $vechile->save();
                $this->push_notification($driver->remember_token, 'تم خصيم من الرصيد', 'تم خصم مبلغ  ' . $description . ' من رصيدك  ', 'payment');

                $rider->message = 'تم أنهاء الرحلة بنجاح و دفع تكلفة الرحلة كاش' . ' تكلفة الرحلة ' . round($request->total, 2);
                $this->push_notification($rider->remember_token, $descriptionRider, $rider, 'payment');

                return $this->returnSuccessMessage("Payment confirmed successfully");

            } else if ($request->payment_type == 'internal') {
                $rider = Rider::find($trip->rider_id);
                // $driver =  Driver::find($request->driver_id);
                // $vechile = null;
                // if($driver !== null){
                //     $vechile = Vechile::find($driver->current_vechile);
                // }

                if ($rider !== null && $vechile !== null) {
                    if ($rider->account >= $request->total) {
                        $boxRider = new boxRider;
                        $boxVechile = new BoxVechile;
                        $boxDriver = new BoxDriver;

                        $boxVechile->vechile_id = $vechile->id;
                        $boxVechile->foreign_type = 'driver';
                        $boxVechile->foreign_id = $driver->id;
                        $boxVechile->bond_type = 'take';
                        $boxVechile->payment_type = 'internal transfer';
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->descrpition = 'تم خصم مبلغ  ' . round($request->company, 2) . ' عائد للمركبة رقم ' . $vechile->id . ' على رحلة رقم ' . $request->trip_id . ' تكلفة الرحلة ' . round($request->total, 2);
                        $boxVechile->money = round($request->company, 2) * 0.8;
                        $boxVechile->tax = 0;
                        $boxVechile->total_money = round($request->company, 2) * 0.8;
                        $boxVechile->add_date = Carbon::now();

                        $boxVechileAds = new BoxVechile();
                        $boxVechileAds->vechile_id = $vechile->id;
                        $boxVechileAds->foreign_type = 'stakeholders';
                        $boxVechileAds->foreign_id = 11;
                        $boxVechileAds->bond_type = 'spend';
                        $boxVechileAds->payment_type = 'internal transfer';
                        $boxVechileAds->bond_state = 'deposited';
                        $boxVechileAds->descrpition = 'عائد من رحلة إلى أدارة التسويق والدعاية من رحلة داخلية';
                        $boxVechileAds->money = round($request->company, 2) * 0.2;
                        $boxVechileAds->tax = 0;
                        $boxVechileAds->total_money = round($request->company, 2) * 0.2;
                        $boxVechileAds->add_date = Carbon::now();
                        $boxVechileAds->save();
                        $stakeholder = \App\Models\Nathiraat\Stakeholders::find(11);
                        $stakeholder->account += round($request->company, 2) * 0.2;
                        $stakeholder->save();

                        $boxRider->rider_id = $rider->id;
                        $boxRider->bond_type = 'spend';
                        $boxRider->payment_type = 'internal transfer';
                        $boxRider->bond_state = 'deposited';
                        $boxRider->money = round($request->total, 2);
                        $boxRider->tax = 0;
                        $boxRider->total_money = round($request->total, 2);
                        $boxRider->descrpition = 'تم خصم مبلغ  ' . round($request->total, 2) . ' عائد للسائق' . $driver->name . ' على رحلة رقم ' . $request->trip_id;
                        $boxRider->add_date = Carbon::now();
                        //$BoxRider->add_by = Auth::guard('admin')->user()->id;

                        $boxDriver->driver_id = $driver->id;
                        $boxDriver->bond_type = "take";
                        $boxDriver->payment_type = 'internal transfer';
                        $boxDriver->bond_state = 'deposited';
                        $boxDriver->money = round($request->total, 2);
                        $boxDriver->tax = 0;
                        $boxDriver->total_money = round($request->total, 2);
                        $boxDriver->descrpition = 'تم أضافة مبلغ  ' . round($request->total, 2) . ' عائد من الراكب ' . $rider->name . ' على رحلة رقم ' . $request->trip_id;
                        $boxDriver->add_date = Carbon::now();

                        //$boxDriver->add_by = Auth::guard('admin')->user()->id;

                        $rider->account -= round($request->total, 2);
                        $driver->account += round($request->total, 2) - round($request->company, 2);
                        $vechile->account += round($request->company, 2) * 0.8;

                        $driver->available = 1;
                        $trip->payment_type = 'internal transfer';
                        $trip->cost = round($request->total, 2);
                        $trip->save();

                        $boxRider->save();
                        $boxDriver->save();
                        $boxVechile->save();
                        $rider->save();
                        $driver->save();
                        $vechile->save();
                        $description = 'تم خصم مبلغ  ' . round($request->total, 2) . ' عائد للسائق' . $driver->name;
                        $rider->message = $description;
                        $this->push_notification($rider->remember_token, 'تم الخصم من الرصيد', $rider, 'payment');
                        $this->push_notification($driver->remember_token, 'تم الخصم من الرصيد', 'تم أضافة مبلغ  ' . round(($request->total - $request->company), 2) . ' إلى رصيدك  ', 'payment');
                        return $this->returnSuccessMessage("Payment confirmed successfully");
                    } else {
                        return $this->returnError(1, 'There is not enough balance');
                    }
                } else {
                    return $this->returnError(2, 'some thing is wrongs ');
                }
            } else {
                return $this->returnError(3, 'some thing is wrongs ');
            }
        } else {
            return $this->returnError('E003', 'the trip not exist');
        }
    }

    public function specific_trip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required',
        ]);
        $trip = Trip::find($request->trip_id);

        if ($trip !== null) {
            // $trip->driver = Driver::select()find($trip->driver_id);
            // $trip->rider = Rider::find($trip->rider_id);
            return $this->returnSuccessMessage($trip);
        } else {
            return $this->returnError('E003', 'there is no trips');
        }
    }
}
