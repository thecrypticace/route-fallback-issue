<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, Closure $next)
    {
        $this->dump("Entering EncryptCookies");
        
        $response = parent::handle($request, $next);
        
        $this->dump("Response cookies");
        $this->dumpCookies($response->headers->getCookies());
        
        $this->dump("Leaving EncryptCookies");

        return $response;
    }

    private function dumpCookies($cookies)
    {
        foreach ($cookies as $cookie) {
            $this->dump([
                "name" => $cookie->getName(),
                "value" => $cookie->getValue(),
            ]);
        }
    }

    private function dump($data)
    {
        static $cloner;
        static $dumper;

        $cloner = $cloner ?? new VarCloner;
        $dumper = $dumper ?? tap(new HtmlDumper, function ($dumper) {
            $dumper->setDisplayOptions([
                "maxStringLength" => 10000,
            ]);
        });

        $dumper->dump($cloner->cloneVar($data));
    }
}
