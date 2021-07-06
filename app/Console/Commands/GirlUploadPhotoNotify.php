<?php

namespace App\Console\Commands;

use App\Entity\Girl\Girl;
use App\Entity\User\User;
use App\Mail\Girls\UploadPhotos;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class GirlUploadPhotoNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:girl-photos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        // ищем девушек, у которых нет фотографий, но заполнен профиль
        Girl::with('user')
            ->whereHas('user', function ($query) {
                $query->where('receive_notifications', 1);
            })
            ->whereDoesntHave('avatarOriginal')
            ->where('phone', '!=', null)
            ->chunkById(100, function ($girls) {
                foreach ($girls as $girl) {
                    Mail::to($girl->user)
                        ->later(1, (new UploadPhotos)->onQueue('mail'));
                }
            });
    }
}
