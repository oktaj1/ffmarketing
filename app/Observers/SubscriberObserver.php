<?php

namespace App\Observers;

use App\Models\Subscriber;
use Illuminate\Support\Facades\Cache;

class SubscriberObserver
{
    private function clearChannelCache($channelId)
    {
        if ($channelId) {
            Cache::forget("channel.{$channelId}.subscriber_count");
        }
    }

    public function created(Subscriber $subscriber)
    {
        $this->clearChannelCache($subscriber->channel_id);
    }

    public function updated(Subscriber $subscriber)
    {
        // Clear cache for both old and new channel if channel_id changed
        if ($subscriber->isDirty('channel_id')) {
            $this->clearChannelCache($subscriber->getOriginal('channel_id'));
        }
        $this->clearChannelCache($subscriber->channel_id);
    }

    public function deleted(Subscriber $subscriber)
    {
        $this->clearChannelCache($subscriber->channel_id);
    }
}