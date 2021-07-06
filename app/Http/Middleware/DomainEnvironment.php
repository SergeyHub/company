<?php

namespace App\Http\Middleware;

use App\Services\Domain\DomainService;
use Closure;

class DomainEnvironment
{

    protected $domainService;

    public function __construct(DomainService $domainService)
    {
        $this->domainService = $domainService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // проверяем поддомен (поддомен - slug страны)
        $host = $request->getHost();

        // если хост - nginx, то запрос идет с контейнера nuxt
        // берем переданный хост из хедера
        if($host === 'nginx')
            $host = $request->header('SecretHost');

        // ищем поддомен
        preg_match('/([\w-]+)\.([\w-]+)\.([\w]+)/', $host, $matches);

        if(count($matches)) {
            $this->domainService->setEnvForCountry($matches[1]);
        } else {
//            $this->domainService->setEnvForCountry('russia');
        }
        return $next($request);
    }
}
