<?php

namespace App\Http\Controllers;

use App\Models\GeneralBox;
use App\Models\Groups\Group;
use App\Traits\GeneralTrait;
use File;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use GeneralTrait;

    public function hasPermissionData($groupid)
    {
        $group = \App\Models\Groups\GroupUser::where('user_id', \Auth::guard('admin')->user()->id)->where('group_id', $groupid)->where('state', 'active')->get();
        $groupData = Group::find($groupid);

        if (\Auth::user()->isAbleTo('manage_group')) {
            return true;
        } else if (count($group) > 0) {

            if ($groupData->state == 'active') {

                if ($groupData->expired_date_transportation_license_number == null) {
                    session()->flash('error', 'تأكد من  رفع ترخيص هيئة النقل');
                    return false;
                } else if ($groupData->expired_date_commercial_register == null) {
                    session()->flash('error', 'تأكد من  رفع ترخيص السجل التجاري');
                    return false;
                } else if ($groupData->expired_date_municipal_license_number == null) {
                    session()->flash('error', '  تأكد من  رفع ترخيص رخصة البلدية');
                    return false;
                } else if (date($groupData->expired_date_transportation_license_number) < \Carbon\Carbon::now()) {
                    session()->flash('error', ' رخصة هيئة النقل منتهية');
                    return false;
                } else if (date($groupData->expired_date_commercial_register) < \Carbon\Carbon::now()) {
                    session()->flash('error', 'السجل التجاري منتهية');
                    return false;
                } else if (date($groupData->expired_date_municipal_license_number) < \Carbon\Carbon::now()) {
                    session()->flash('error', ' رخصة البلدية منتهية');
                    return false;
                } else {
                    return true;
                }

            } else {

                session()->flash('error', 'المجموعة غير فعالة حاليا');
                return false;

            }

        } else {
            session()->flash('error', 'ليس لديك صلاحيه الدخول ');
            return false;
        }

    }

    public function push_notification($token, $title, $body, $subtitle = "")
    {

        try {
            //$token_1 = 'e6WBgNuvz0WdoCSZxLpOKM:APA91bFYgWK6jtSrMlG0axpGzWdBz7emIRrc16MCO3Z8jW3gD2NSkGdfaF-y_3pt_k7oh8ZbFUGb0roDp4ycFidta4iGtDEfMAZPfbJTVdyqXhTXYLOnH3LUoCnCAvyvPo6qM-NtLF63';
            $url = 'https://fcm.googleapis.com/fcm/send';
            $serverKey = 'AAAA8fKSKWs:APA91bH0rFQJIGqH___-ccXM8MRgTjhZMVH3TtaU19R4QPxXO6uaMkSDeT_lTwsUo6I0BOJPbKomOgL8cy6zh5t6xRnRlehlVvCFdKcMDaA6lhhw_NcwD8IWuCDAkgXhou1gfFOAyTSn';

            $data = [
                "registration_ids" => [
                    $token,
                ],
                'notification' => [
                    "title" => $title,
                    "sound" => "sound.caf",
                ],
                "data" => [
                    "type" => $body,
                    "subtitle" => $subtitle,
                ],
                "aps" => [
                    "alert" => $title,
                    "sound" => "soundnote.aiff",
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "alert" => $title,
                            "sound" => "sound.caf",
                        ],
                    ],
                ],

            ];
            $encodedData = json_encode($data);

            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            // Execute post
            $result = curl_exec($ch);
            if ($result === false) {
                // die('Curl failed: ' . curl_error($ch));
                return false;
            }
            // Close connection
            curl_close($ch);
            // FCM response
            return $result;
            return true;

        } catch (\Exception$ex) {
            return false;
            // return $this->returnError($ex->getCode(), $ex->getMessage());

        }

    }

    public function generalBox($take = 0, $spend = 0, $updated_at)
    {
        $generalBox = GeneralBox::find(1);
        $total_money = $take - $spend;
        $generalBox->account += $total_money;
        $generalBox->take += $take;
        $generalBox->spend += $spend;
        $generalBox->updated_at = $updated_at;
        $generalBox->save();
    }

    public function show_pdf()
    {
        $path = 'public/' . request()->url;
        if (File::exists($path)) {
            return response()->file($path);
        } else {
            return back();
        }
    }

    public function vechileState($state)
    {
        switch ($state) {
            case 'active':
                return 'مستلمة';
                break;
            case 'waiting':
                return 'منتظرة';
                break;
            case 'blocked':
                return 'مستبعدة';
                break;
            default:
                return '';
        }
    }
    public function driverState($state)
    {
        switch ($state) {
            case 'active':
                return 'مستلم';
                break;
            case 'waiting':
                return 'منتظر';
                break;
            case 'blocked':
                return 'مستبعد';
                break;
            case 'pending':
                return 'مسجل حديثا';
                break;
            default:
                return '';
        }
    }
}
