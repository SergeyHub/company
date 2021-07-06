<?php

namespace App\Console\Commands;

use App\Entity\User\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SetOfflines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offlines:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /** @var array */
    protected $countries;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::query()->where('online', 1)
            ->chunkById(100, function (Collection $users) {
                $last_seen_date = now()->subMinute();
                $users->each(function (User $user) use ($last_seen_date) {
                    $last_seen_time = Cache::get('last_seen_' . $user->id);
                    if (!$last_seen_time) {
                        $user->setOffline($last_seen_date);
                    }
                });
            });
    }
}
