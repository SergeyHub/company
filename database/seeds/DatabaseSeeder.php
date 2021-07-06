<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OrientationSeed::class,
            BodyHairSeed::class,
            BodySeed::class,
            EthnicitySeed::class,
            VipTariffSeed::class,
            EyesSeed::class,
            HairsSeed::class,
            NationalitiesSeed::class,
            LanguagesSeed::class,
            GeographiesSeed::class,
            ContactMethodsSeed::class,
            CurrenciesSeed::class,
            PurposeSeed::class,
            PublicationTariffSeed::class,
            ContentSeed::class,
            ReadyForSeed::class,
            WhatLikeSeed::class,
            WhatLikeSeed::class,
        ]);
    }

}
