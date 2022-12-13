<?php

namespace App\Sms;

use App\Jobs\Sms\LogSmsJob;

class LogSms implements SmsInterface
{
    public function send(int $employeeId, string $phoneNumber, string $message)
    {
        LogSmsJob::dispatch([
            'employee_id'  => $employeeId,
            'phone_number' => $phoneNumber,
            'message'      => $message
        ]);
    }
}
