<?php

namespace NotificationChannels\WebPush;

use Illuminate\Support\Facades\Log;

class ReportHandler implements ReportHandlerInterface
{
    /**
     * Handle a message sent report.
     *
     * @param \Minishlink\WebPush\MessageSentReport $report
     * @param \NotificationChannels\WebPush\PushSubscription $subscription
     * @param \NotificationChannels\WebPush\WebPushMessage $message
     * @return void
     */
    public function handleReport($report, $subscription, $message)
    {
        if ($report->isSuccess()) {
            return;
        }

        if ($report->isSubscriptionExpired()) {
            $subscription->delete();
        }else {
            Log::warning("Notification failed to sent for subscription {$subscription->endpoint}: {$report->getReason()}");
        }
    }
}
