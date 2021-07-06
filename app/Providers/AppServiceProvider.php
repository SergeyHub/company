<?php

namespace App\Providers;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Validator\Constraints\NotBlank;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind( \Symfony\Component\Validator\Validator\ValidatorInterface::class, function() {
            return \Symfony\Component\Validator\Validation::createValidatorBuilder()
                ->enableAnnotationMapping()
                ->getValidator();
        });
    }
}
