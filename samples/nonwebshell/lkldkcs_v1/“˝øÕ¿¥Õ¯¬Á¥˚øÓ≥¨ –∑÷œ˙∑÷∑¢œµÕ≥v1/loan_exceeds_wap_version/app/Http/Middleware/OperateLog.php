<?php

namespace App\Http\Middleware;

use Closure;

class OperateLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data=[
            'user_id'=>auth()->user()?auth()->user()->id:0,
            'path'=>$request->path(),
            'method'=>$request->method(),
            'ip'=>$request->ip(),
            'input'=>json_encode($request->all(),JSON_UNESCAPED_UNICODE)
        ];
        \App\Models\OperateLog::create($data);
        return $next($request);
    }
}
