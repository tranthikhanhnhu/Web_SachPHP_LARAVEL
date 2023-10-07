<?php

    namespace App\Filters\Orders;

    use App\Models\ProductInOrder;

    class ByActive{
        public function handle($request, \Closure $next) {
            $builder = $next($request);
            if (request()->has('active_order')
            && (int)request()->query('active_order') === 1) {
                $active_statuses = [
                    ProductInOrder::STATUS_WAIT_FOR_PICK_UP, 
                    ProductInOrder::STATUS_PICKED_UP,
                    ProductInOrder::STATUS_SOME_RETURNED_BAD,
                    ProductInOrder::STATUS_SOME_RETURNED_GOOD,
                ];
                return $builder
                ->whereHas('productsInOrder', function ($query) use ($active_statuses) {
                    $query->whereIn('status', $active_statuses);
                });
            }
            return $builder;
        }
    }

?>