<?php

namespace App\Sms;

use App\Jobs\Sms\SampleSmsProviderJob;

class SampleSmsProvider implements SmsInterface
{
    public function send(int $employeeId, string $phoneNumber, string $message)
    {
        SampleSmsProviderJob::dispatch([
            'employee_id'  => $employeeId,
            'phone_number' => $phoneNumber,
            'message'      => $message
        ]);
    }
}
