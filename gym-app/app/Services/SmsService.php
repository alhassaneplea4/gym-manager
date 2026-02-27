<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    public function send(string $to, string $message): array
    {
        $provider = config('services.sms.provider');

        return match ($provider) {
            'twilio' => $this->sendViaTwilio($to, $message),
            'africastalking' => $this->sendViaAfricasTalking($to, $message),
            default => throw new \RuntimeException('Fournisseur SMS non configuré.'),
        };
    }

    private function sendViaTwilio(string $to, string $message): array
    {
        $sid = (string) config('services.sms.twilio.sid');
        $token = (string) config('services.sms.twilio.token');
        $from = (string) config('services.sms.twilio.from');

        $response = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To' => $to,
                'Body' => $message,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Échec envoi Twilio: '.$response->body());
        }

        return [
            'provider' => 'twilio',
            'message_id' => $response->json('sid'),
            'raw' => $response->json(),
        ];
    }

    private function sendViaAfricasTalking(string $to, string $message): array
    {
        $username = (string) config('services.sms.africastalking.username');
        $apiKey = (string) config('services.sms.africastalking.api_key');
        $from = (string) config('services.sms.africastalking.from');

        $payload = [
            'username' => $username,
            'to' => $to,
            'message' => $message,
        ];

        if ($from !== '') {
            $payload['from'] = $from;
        }

        $response = Http::withHeaders([
            'apiKey' => $apiKey,
            'Accept' => 'application/json',
        ])->asForm()->post('https://api.africastalking.com/version1/messaging', $payload);

        if (! $response->successful()) {
            throw new \RuntimeException('Échec envoi Africa\'s Talking: '.$response->body());
        }

        return [
            'provider' => 'africastalking',
            'message_id' => data_get($response->json(), 'SMSMessageData.Recipients.0.messageId'),
            'raw' => $response->json(),
        ];
    }
}
