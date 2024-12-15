<?php

namespace Modules\User\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\UserModel;
use Modules\User\Notifications\WelcomeMailNotification;

class WelcomeMailJobs implements ShouldQueue {
    use Queueable, SerializesModels;

    public function __construct(
        public readonly UserModel $user
    ) {
    }

    public function handle(): void {
        $this->user->notify(new WelcomeMailNotification());
    }
}
