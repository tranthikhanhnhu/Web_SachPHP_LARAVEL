<?php

    namespace App\Filters\Categories;

    class ByKeyword{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('keyword')
            && !empty(request()->query('keyword'))) {
                return $builder->where(function ($query) {
                    $query->where('name', 'like', '%'.request()->query('keyword').'%')
                    ->orWhere('slug', 'like', '%'.request()->query('keyword').'%');
                });
            }
            return $builder;
        }
    }

?>