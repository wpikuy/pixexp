<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class pixauth {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (Session::get('login', 'false') === 'true'){
			return $next($request);
		}
		else{
			return redirect('entrance');
		}
	}

}
