<?php

namespace App\Console\Commands;

use App\Models\NotificationLog;
use App\Models\Subscription;
use App\Services\SmsService;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class SendSubscriptionExpiryReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-subscription-expiry-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des SMS automatiques 5 jours avant expiration des abonnements actifs';

    /**
     * Execute the console command.
     */
    public function handle(SmsService $smsService): int
    {
        $targetDate = Carbon::today()->addDays(5);

        $subscriptions = Subscription::with('member')
            ->where('status', 'active')
            ->whereDate('end_date', $targetDate)
            ->get();

        if ($subscriptions->isEmpty()) {
            $this->info('Aucun abonnement expirant dans 5 jours.');

            return self::SUCCESS;
        }

        foreach ($subscriptions as $subscription) {
            $member = $subscription->member;
            $message = sprintf(
                'Bonjour %s, votre abonnement gym expire le %s. Merci de le renouveler à temps.',
                $member->first_name,
                $subscription->end_date->format('d/m/Y')
            );

            try {
                $result = $smsService->send($member->phone, $message);

                NotificationLog::create([
                    'member_id' => $member->id,
                    'channel' => 'sms',
                    'type' => 'subscription_expiry_reminder',
                    'message' => $message,
                    'status' => 'sent',
                    'provider_message_id' => $result['message_id'] ?? null,
                    'sent_at' => now(),
                    'metadata' => [
                        'provider' => $result['provider'] ?? null,
                        'subscription_id' => $subscription->id,
                    ],
                ]);

                $this->info("SMS envoyé à {$member->phone}");
            } catch (\Throwable $exception) {
                NotificationLog::create([
                    'member_id' => $member->id,
                    'channel' => 'sms',
                    'type' => 'subscription_expiry_reminder',
                    'message' => $message,
                    'status' => 'failed',
                    'metadata' => [
                        'error' => $exception->getMessage(),
                        'subscription_id' => $subscription->id,
                    ],
                ]);

                $this->error("Échec SMS {$member->phone}: {$exception->getMessage()}");
            }
        }

        return self::SUCCESS;
    }
}
