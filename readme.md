# Problem with respondWithRoute

0. Clone this repo
1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`
4. Setup in valet, homestead, etc…
5. Visit in browser

You'll get a page w/ two links.
- Normal Page: This page shows the typical middleare run stack w/ cookie values.
- Broken Page: This page shows the doubled middleare run stack w/ cookie values when using `::respondWithRoute`

Take special note of the Laravel Passport cookie `laravel_token` and note how it gets double-encrypted on the broken page because middleware is run more than once.

In the middleware stack trace I've highlighted:
- `Router::runRoute`
- `Routeer::respondWithRoute`
- Cookie encryption middleware
- Exception handling rendering
