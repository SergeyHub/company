<?php

namespace App\Services\Bills;

use App\Entity\Wallet\Wallet;

class WalletService
{

    public function getActiveWallet(): Wallet
    {
        $wallet = Wallet::inRandomOrder()->active()->firstOrFail();
        return $wallet;
    }

}
