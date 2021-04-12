<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimeBasedRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if not reservation, access forbidden
        if ( \App\Models\Event::orderBy('id', 'DESC')->first()->reservation_end->isPast() ) {
            return redirect('event-over');
        }
        return $next($request);
    }
}
