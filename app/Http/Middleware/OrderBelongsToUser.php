<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class OrderBelongsToUser
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
        $order = Order::find($request->route('id'));

        if(is_null($order))
        {
            abort(404);
        }

        if($order->user_id !== $request->user()->id ){
            abort(403);
        }
        
        return $next($request);
    }
}
