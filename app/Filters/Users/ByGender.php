<?php

    namespace App\Filters\Users;

    class ByGender{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('gender')
            && !is_null(request()->query('gender'))) {
                return $builder
                ->where('gender', request()->query('gender'));
            }
            return $builder;
        }
    }

?>