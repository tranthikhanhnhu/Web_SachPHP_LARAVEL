<?php

    namespace App\Filters\Products;

    class ByCategory{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('category')
            && !empty(request()->query('category'))) {
                return $builder
                ->whereHas('categories', function ($query) {
                    $query->where('slug', request()->query('category'));
                });
            }
            return $builder;
        }
    }

?>