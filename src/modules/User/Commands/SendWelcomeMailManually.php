<?php

namespace Modules\User\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Modules\User\Models\UserModel;

class SendWelcomeMailManually extends Command implements PromptsForMissingInput {
    protected $signature = 'user:welcome-mail {email : The email of the user}';

    protected $description = 'Send welcome mail manually';

    /**
     * @throws \Exception
     */
    public function handle(): void {
        $user = UserModel::where('email', $this->argument('email'))->firstOrFail();

        $user->notify(new \Modules\User\Notifications\WelcomeMailNotification());

        $this->info("Sending welcome mail to {$user->email}");
    }

    protected function promptForMissingArgumentsUsing(): array {
        return [
            'email' => 'Which user should receive the welcome mail?',
        ];
    }
}
