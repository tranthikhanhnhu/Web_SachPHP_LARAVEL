<?php

    namespace App\Filters\Products;

    class ByPrice{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('amount_start')
            && request()->has('amount_end')
            && !empty(request()->query('amount_start'))
            && !empty(request()->query('amount_end'))) {
                return $builder->whereHas('rentPrice', function ($query) {
                    $query->where('number_of_days', request()->number_rent_price_days ?? 7)
                          ->whereBetween('price', [request()->query('amount_start'), request()->query('amount_end')]);
                });
            }
            return $builder;
        }
    }

?>