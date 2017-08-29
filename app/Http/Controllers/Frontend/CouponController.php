<?php
/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:38
 */

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Coupon\CreateCouponRequest;
use App\Http\Requests\Backend\Coupon\UpdateCouponRequest;
use App\Repositories\Backend\Coupon\CouponContract;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Commands\importPartnerCommand;
use App\Services\Utils\RecoverOrder;
use FPDI;
use App\Coupon;
use Carbon\Carbon;


class CouponController extends Controller {
    
    /**
     * @param CouponContract $coupons
     */
    public function __construct(CouponContract $coupons) {
        $this->coupons = $coupons;

    }

    /**
     * @return mixed
     */

    public function request10percent(Request $request){
        return $this->requestDiscount($request, 10);
    }

    private function requestDiscount(Request $request, $percent) {
        if (($request['email'] == null) || ($request['email'] == '')){
            return redirect()->route('home')->withFlashDanger('Informe o seu e-mail!');
        }

        if (($request['name'] == null) || ($request['name'] == '')){
            return redirect()->route('home')->withFlashDanger('Informe o seu nome!');
        }

        $coupons = Coupon::where('email', 'like', $request['email'] )->get();
        if (count($coupons) != 0){
            return redirect()->route('home')->withFlashDanger('Já foi gerado um cupom para este e-mail!');
        }

//        $coupons = Coupon::where('ip_request', '=', $request->ip() )->orderBy('created_at', 'desc')->get();
//        if (count($coupons) != 0){
//            testa IP
//        }

        $coupon = new Coupon;
        $coupon->name  = $request['name'] . ' - ' . format_datetimebr(Carbon::now()) ;
        $coupon->code   =  RecoverOrder::gen_uuid();
        $coupon->start_date = Carbon::now();
        $coupon->due_date = Carbon::now()->addDays(30);
        $coupon->limit = 1;
        $coupon->used = 0;
        $coupon->percentage = $percent;
        $coupon->value = 0;
        $coupon->user_id_created_by = null;
        $coupon->description = 'Cupom automatizado para ' . $request['name'];
        $coupon->name_student = $request['name'];
        $coupon->ip_request = $request->ip();
        $coupon->email = $request['email'];
        $coupon->save();

        $this->send($coupon->id);

        return redirect()->route('home')->withFlashSuccess('O cupom foi enviado para o seu e-mail');
    }

    /**
     * @param $id
     */
    public function send($id){
        $coupon = $this->coupons->findOrThrowException($id,true);

        $email = $coupon->email;
        $name_student = $coupon->name_student;

            Mail::send('emails.coupon_request',
                    ['email' => $coupon->email,
                    'name' => $coupon->name_student,
                    'coupon' => $coupon],
                    function ($message) use ($email, $name_student) {
                $message->to($email, $name_student)->subject(app_name() . ': ' . trans("strings.coupons"));
            });
        return redirect()->back()->withFlashSuccess(trans('alerts.coupons.sent'));

    }


}