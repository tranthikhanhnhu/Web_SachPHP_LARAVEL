<?php

    namespace App\Filters\Products;

use App\Models\Publisher;

    class ByPublishers{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            
            if (request()->has('publishers')
            && !empty(request()->query('publishers'))
            && count(request()->query('publishers')) > 0
            && !is_null(request()->query('publishers')[0])) {
                $publisherIds = Publisher::whereIn('slug', request()->query('publishers'))
                ->pluck('id');
                
                return $builder->whereIn('publisher_id', $publisherIds);
            }
            
            return $builder;
        }
    }

?>