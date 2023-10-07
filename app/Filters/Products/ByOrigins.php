<?php

namespace App\Filters\Products;

use App\Models\Origin;

    class ByOrigins{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('origins')
            && !empty(request()->query('origins'))
            && count(request()->query('origins')) > 0
            && !is_null(request()->query('origins')[0])) {
            $originIds = Origin::whereIn('slug', request()->query('origins'))
            ->pluck('id');

            return $builder->whereIn('origin_id', $originIds);
                return $builder
                ->whereIn('origin_id', request()->query('origins'));
            }
            return $builder;
        }
    }

?>