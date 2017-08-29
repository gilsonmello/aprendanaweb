<?php

namespace App\Services\Utils;

use App\Coupon;
use App\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class RecoverOrder {

    public function recoverYesterday10percent($days, $percent) {
        recover(1, 10);
    }

    /**
     * 
     * @param integer $days
     * @param double $percent
     */
    public function recover($days, $percent) {

        $orders = Order::where('date_registration', '>=', Carbon::today()->addDay(-1 * $days))
                ->where('recover_action', '=', 0) //Que ainda não foi processado
                ->where('status_id', '=', 1) //Status pendente
                ->whereNotNull('student_id') //Possui aluno cadastrado
                ->get();

        foreach ($orders as $order) {
            if ($order->student != null) {
                //Existe cupom usado para o aluno?
                $coupons = Coupon::where('email', 'like', $order->student->email)
                                ->where('recover_action', '=', 1) // Flag para cupom gerados por recuperação do carrinho de compras
                                ->where('due_date', '<', Carbon::today())
                                ->whereRaw('used < limit')->get();

                if (count($coupons) == 0) { // Caso não exista
                    $coupon = new Coupon;
                    $coupon->name = $order->student->email . ' - ' . format_datetimebr(Carbon::now());
                    $coupon->code = $this->gen_uuid();
                    $coupon->start_date = Carbon::now();
                    $coupon->due_date = Carbon::now()->addDays(30);
                    $coupon->limit = 1;
                    $coupon->used = 0;
                    $coupon->percentage = $percent;
                    $coupon->value = 0;
                    $coupon->user_id_created_by = null;
                    $coupon->description = 'Cupom de recuperação de compra ' . $order->student->name;
                    $coupon->name_student = $order->student->name;
                    $coupon->email = $order->student->email;
                    $coupon->recover_action = 1; //Informa que este cupom foi gerado por uma recuperação de carrinho de compra
                    $coupon->save();
                    
                    //Envia o cupon
                    $this->send($coupon->id);
                }
                //Pedido
                $order->recover_action = 1;
                $order->save();
            }
        }
    }

    /**
     * @param $id
     */
    public function send($id) {
        $coupon = Coupon::findOrThrowException($id, true);

        $email = $coupon->email;
        $name_student = $coupon->name_student;

        Mail::send('emails.coupon_request', ['email' => $coupon->email,
            'name' => $coupon->name_student,
            'coupon' => $coupon], function ($message) use ($email, $name_student) {
            $message->to($email, $name_student)->subject(app_name() . ': ' . trans("strings.coupons"));
        });
        return redirect()->back()->withFlashSuccess(trans('alerts.coupons.sent'));
    }

    static function gen_uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                // 32 bits for "time_low"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                // 16 bits for "time_mid"
                mt_rand(0, 0xffff),
                // 16 bits for "time_hi_and_version",
                // four most significant bits holds version number 4
                mt_rand(0, 0x0fff) | 0x4000,
                // 16 bits, 8 bits for "clk_seq_hi_res",
                // 8 bits for "clk_seq_low",
                // two most significant bits holds zero and one for variant DCE1.1
                mt_rand(0, 0x3fff) | 0x8000,
                // 48 bits for "node"
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

}
