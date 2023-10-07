<?php

    namespace App\Filters\Users;

    class ByLevel{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('level')
            && !is_null(request()->query('level'))) {
                return $builder
                ->where('level', request()->query('level'));
            }
            return $builder;
        }
    }

?>