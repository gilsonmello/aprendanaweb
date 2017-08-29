<?php

namespace App\Commands;

use App\Repositories\Backend\Coupon\EloquentCouponRepository;
use Illuminate\Console\Command;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class importPartnerCommand extends Command implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $fileKeyPath = 'C:\\_IPQ\\teste.csv';
        $partner = 1;
        $percentage = 30;
        $value = 0;
        $daysToUse = 365;
        $limit = 3;

        (new EloquentCouponRepository())->importFromPartner($fileKeyPath, $partner, $percentage, $value, $daysToUse, $limit);

        Mail::raw('Brasil Jurídico :: importação dos cupons do parceiro ' . $partner,
            function($message) use ($partner)
            {
                $message->from('atendimento@brasiljuridico.com.br', 'BrasilJurídico');
                $message->to('adhemarfontes@gmail.com');
                $message->subject('Brasil Jurídico :: importação dos cupons do parceiro ' . $partner);
            });
    }
}
