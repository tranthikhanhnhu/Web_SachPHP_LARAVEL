<?php

    namespace App\Filters\Users;

    class ByKeyword{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('keyword')
            && !empty(request()->query('keyword'))) {
                return $builder->where(function ($query) {
                    $query->orWhere('username', 'like', '%'.request()->query('keyword').'%')
                    ->orWhere('email', 'like', '%'.request()->query('keyword').'%')
                    ->orWhere('phone_number', 'like', '%'.request()->query('keyword').'%');
                });
            }
            return $builder;
        }
    }

?>