<?php

namespace App\Filters\Products;

use App\Models\BookLayout;

    class ByBookLayouts{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            
            if (request()->has('book_layouts')
            && !is_null(request()->query('book_layouts'))) {

                return $builder->whereIn('book_layout', request()->book_layouts);

            }

            return $builder;
        }
    }

?>