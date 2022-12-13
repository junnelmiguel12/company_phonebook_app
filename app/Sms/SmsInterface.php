<?php

namespace App\Sms;
use App\Sms\Jobs\SampleSmsProviderJob;
use App\Sms\Jobs\LogSmsJob;

interface SmsInterface
{
    public function send(int $employeeId, string $phoneNumber, string $message);
}
