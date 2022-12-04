<?php

namespace App\Common\Jobs;

use App\Common\Models\Catalog\Document\ReservationCancel\DocumentReservationCancel;
use App\Common\Models\Errors\_Errors;
use Exception;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ReservationCheckJob extends BaseJob implements ShouldBeUnique
{
    public $deleteWhenMissingModels = true;
    public $tries = 3;

    public function handle()
    {
        try {
            DocumentReservationCancel::reservationCheck();
        } catch (Exception $exception) {
            $this->setErrors(_Errors::exception($exception, $this));
        }
        parent::handle();
    }
}