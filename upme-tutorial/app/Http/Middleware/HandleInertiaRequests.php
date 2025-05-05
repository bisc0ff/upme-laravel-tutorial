<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */

     //share common data between all pages
     // some use cases: have authenticated user data
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            //

            //when we have authentication, we can use this
            //this is a sample of lazy loading as it will only be called when the user is authenticated or 
            // it will only run when it's needed or when it's time to serialize the data and send it to the frontend

            'auth.user' => fn () => $request->user()    //if user exists
            ? $request->user()->only('id', 'name')      // then get id and name
            : 'Mike',                                   // else return Mike
        ];
    }
}
