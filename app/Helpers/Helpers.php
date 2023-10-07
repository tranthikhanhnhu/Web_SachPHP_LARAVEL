<?php

use App\Models\Product;
use App\Models\ProductInOrder;
use Carbon\Carbon;

function calculatePrice(Product $product, $number_of_days=7, $quantity=1) {
	$price = 0;
    $days = [90, 30, 7, 1];
	
    foreach ($days as $day) {
        $quotient = intdiv($number_of_days, $day);
        $number_of_days %= $day;
        $price += $quotient * $product->rentPrice
            ->where('number_of_days', $day)
            ->first()
            ->price;
    }
						  
	return $price * $quantity;
}

function calculateTodayAvailability(Product $product) {
    $quantity = $product->quantity;
    $active_statuses = [
        ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
        ProductInOrder::STATUS_PICKED_UP,
        ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ProductInOrder::STATUS_SOME_RETURNED_GOOD,
    ];
    $active_items = 
    ProductInOrder::where('product_id', $product->id)
    ->whereIn('status', $active_statuses)
    ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
    ->get();
    foreach ($active_items as $item) {
        if ($item->status === ProductInOrder::STATUS_WAIT_FOR_PICK_UP
        && Carbon::today()->gte($item->expected_pick_up_date)) {

            $quantity -= $item->product_quantity;

        } else if($item->status === ProductInOrder::STATUS_PICKED_UP) {

            $quantity -= $item->product_quantity;

        } else if($item->status === ProductInOrder::STATUS_SOME_RETURNED_BAD
        || $item->status === ProductInOrder::STATUS_SOME_RETURNED_GOOD) {

            $quantity -= $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);

        }
    }
    return $quantity;
}

function calculateAvailability(Product $product, $date = null) {

    $available_quantity = calculateTodayAvailability($product);

    if (!is_null($date)) {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $this_date = Carbon::today();
        $count = 0;
        $active_statuses = [
            ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
            ProductInOrder::STATUS_PICKED_UP,
            ProductInOrder::STATUS_SOME_RETURNED_BAD,
            ProductInOrder::STATUS_SOME_RETURNED_GOOD,
        ];
        $for_next_date = 0;

        $items = 
        ProductInOrder::whereIn('status', $active_statuses)
        ->where('product_id', $product->id)
        ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
        ->get();
        $for_next_date = 0;
        foreach ($items as $item) {
            if ($item->expected_return_date === $this_date->format('Y-m-d')) {
                $for_next_date += $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);
            }
        }


        $this_date->addDay();

        while ($this_date->lt($date)
        && $count < 365) {
            
            $available_quantity += $for_next_date;

            $items = 
            ProductInOrder::whereIn('status', $active_statuses)
            ->where('product_id', $product->id)
            ->get();
            $for_next_date = 0;
            $wait_rent_quantity = 0;
            foreach ($items as $item) {
                if ($item->expected_return_date === $this_date->format('Y-m-d')) {
                    $for_next_date += $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);
                } else if($item->expected_pick_up_date === $this_date->format('Y-m-d')) {
                    $wait_rent_quantity += $item->product_quantity;
                }
            }
            $available_quantity -= $wait_rent_quantity;
            $this_date->addDay();
            
            $count++;
        }
    }
    
    return $available_quantity;

}

function checkWillPickUp(Product $product, $pick_up_date, $rent_time, $quantity) {

    $willPickUp = false;

    $nextPickUp = ProductInOrder::where('product_id', $product->id)
    ->where('status', ProductInOrder::STATUS_WAIT_FOR_PICK_UP)
    ->pluck('expected_pick_up_date')->max();
    if ($nextPickUp) {
        $toNextPickUp = Carbon::createFromFormat('Y-m-d', $nextPickUp)->diffInDays($pick_up_date);
    } else {
        $toNextPickUp = 0;
    }


    $pick_up_date = Carbon::createFromFormat('Y-m-d', $pick_up_date);

    for ($i = 0; ($i <= $rent_time && $i <= $toNextPickUp); $i++) {
        if (calculateAvailability($product, $pick_up_date->format('Y-m-d')) < $quantity) {
            $willPickUp = true;
            break;
        }
        $pick_up_date->addDay();
    }
    return $willPickUp;
}

function findNotAvailableDays(Product $product, $quantity, $rent_time) {

    $date = Carbon::today();
    $notAvailableDays = [];

    $active_statuses = [
        ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
        ProductInOrder::STATUS_PICKED_UP,
        ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ProductInOrder::STATUS_SOME_RETURNED_GOOD,
    ];

    $latest_return_date = 
    ProductInOrder::whereIn('status', $active_statuses)
    ->where('product_id', $product->id)
    ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
    ->max('expected_return_date');

    $limit = Carbon::today()->diffInDays($latest_return_date);
    $limit = $limit > 365 ? 364 : $limit;

    for ($i = 0; $i <= $limit; $i++) {
        if (checkWillPickUp($product, $date->format('Y-m-d'), $rent_time, $quantity)) {
            $notAvailableDays[] = $date->format('Y-m-d');
        }
        $date->addDay();
    }

    return $notAvailableDays;
}









function calculateTodayAvailabilityExtend(Product $product, ProductInOrder $productInOrder) {

    $quantity = $product->quantity;
    
    if (Carbon::today()->gt($productInOrder->expected_return_date)) {
        $quantity += $productInOrder->product_quantity - $productInOrder->returned_good_quantity;
    }
    
    $active_statuses = [
        ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
        ProductInOrder::STATUS_PICKED_UP,
        ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ProductInOrder::STATUS_SOME_RETURNED_GOOD,
    ];
    $active_items = 
    ProductInOrder::where('product_id', $product->id)
    ->whereIn('status', $active_statuses)
    ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
    ->get();
    foreach ($active_items as $item) {
        $check[] =  $item->id !== $productInOrder->id;
        if ($item->status === ProductInOrder::STATUS_WAIT_FOR_PICK_UP
        && Carbon::today()->gte($item->expected_pick_up_date)) {

            $quantity -= $item->product_quantity;

        } else if($item->status === ProductInOrder::STATUS_PICKED_UP
        && $item->id !== $productInOrder->id) {

            $quantity -= $item->product_quantity;

        } else if(($item->status === ProductInOrder::STATUS_SOME_RETURNED_BAD
        || $item->status === ProductInOrder::STATUS_SOME_RETURNED_GOOD)
        && $item->id !== $productInOrder->id) {

            $quantity -= $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);

        }
    }
    return $quantity;
}

function calculateAvailabilityExtend(Product $product, $date = null, ProductInOrder $productInOrder) {

    $available_quantity = calculateTodayAvailabilityExtend($product, $productInOrder);

    if (!is_null($date)) {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $this_date = Carbon::today();
        $count = 0;
        $active_statuses = [
            ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
            ProductInOrder::STATUS_PICKED_UP,
            ProductInOrder::STATUS_SOME_RETURNED_BAD,
            ProductInOrder::STATUS_SOME_RETURNED_GOOD,
        ];
        $for_next_date = 0;

        $items = 
        ProductInOrder::whereIn('status', $active_statuses)
        ->where('product_id', $product->id)
        ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
        ->get();
        $for_next_date = 0;
        foreach ($items as $item) {
            if ($item->expected_return_date === $this_date->format('Y-m-d')
            && $item->id !== $productInOrder->id) {
                $for_next_date += $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);
            }
        }


        $this_date->addDay();

        while ($this_date->lt($date)
        && $count < 365) {
            
            $available_quantity += $for_next_date;

            $items = 
            ProductInOrder::whereIn('status', $active_statuses)
            ->where('product_id', $product->id)
            ->get();
            $for_next_date = 0;
            $wait_rent_quantity = 0;
            foreach ($items as $item) {
                if ($item->expected_return_date === $this_date->format('Y-m-d')
                && $item->id !== $productInOrder->id) {
                    $for_next_date += $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);
                } else if($item->expected_pick_up_date === $this_date->format('Y-m-d')
                && $item->id !== $productInOrder->id) {
                    $wait_rent_quantity += $item->product_quantity;
                }
            }
            $available_quantity -= $wait_rent_quantity;
            $this_date->addDay();
            
            $count++;
        }
    }
    
    return $available_quantity;

}

function checkWillPickUpExtend(Product $product, $pick_up_date, $rent_time, $quantity, ProductInOrder $productInOrder) {

    $willPickUp = false;

    $nextPickUp = ProductInOrder::where('product_id', $product->id)
    ->where('status', ProductInOrder::STATUS_WAIT_FOR_PICK_UP)
    ->pluck('expected_pick_up_date')->max();
    if ($nextPickUp) {
        $toNextPickUp = Carbon::createFromFormat('Y-m-d', $nextPickUp)->diffInDays($pick_up_date);
    } else {
        $toNextPickUp = 0;
    }

    $pick_up_date = Carbon::createFromFormat('Y-m-d', $pick_up_date);

    for ($i = 0; ($i <= $rent_time && $i <= $toNextPickUp); $i++) {
        if (calculateAvailabilityExtend($product, $pick_up_date->format('Y-m-d'), $productInOrder) < $quantity) {
            $willPickUp = true;
            break;
        }
        $pick_up_date->addDay();
    }

    return $willPickUp;
}
function getMaxExtendTime(Product $product, ProductInOrder $productInOrder) {
    
    $max_rent_time = 0;

    $quantity = $productInOrder->product_quantity - ($productInOrder->returned_good_quantity + $productInOrder->returned_bad_quantity);

    $old_return_date = $productInOrder->expected_return_date;

    $rent_times = [1, 3, 7, 30, 90];

    
    foreach($rent_times as $rent_time) {
        checkWillPickUpExtend($product, $old_return_date, $rent_time, $quantity, $productInOrder);
        if (checkWillPickUpExtend($product, $old_return_date, $rent_time, $quantity, $productInOrder)) {
            break;
        }
        $max_rent_time = $rent_time;
    }

    return $max_rent_time;
}









function calculateTodayAvailabilityReschedule(Product $product, $nextRentsIds) {
    $quantity = $product->quantity;
    $active_statuses = [
        ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
        ProductInOrder::STATUS_PICKED_UP,
        ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ProductInOrder::STATUS_SOME_RETURNED_GOOD,
    ];
    $active_items = 
    ProductInOrder::where('product_id', $product->id)
    ->whereIn('status', $active_statuses)
    ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
    ->whereNotIn('id', $nextRentsIds)
    ->get();
    foreach ($active_items as $item) {
        if ($item->status === ProductInOrder::STATUS_WAIT_FOR_PICK_UP
        && Carbon::today()->gte($item->expected_pick_up_date)) {

            $quantity -= $item->product_quantity;

        } else if($item->status === ProductInOrder::STATUS_PICKED_UP) {

            $quantity -= $item->product_quantity;

        } else if($item->status === ProductInOrder::STATUS_SOME_RETURNED_BAD
        || $item->status === ProductInOrder::STATUS_SOME_RETURNED_GOOD) {

            $quantity -= $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);

        }
    }
    return $quantity;
}

function calculateAvailabilityReschedule(Product $product, $date = null, $nextRentsIds) {

    $available_quantity = calculateTodayAvailabilityReschedule($product, $nextRentsIds);

    if (!is_null($date)) {
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $this_date = Carbon::today();
        $count = 0;
        $active_statuses = [
            ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
            ProductInOrder::STATUS_PICKED_UP,
            ProductInOrder::STATUS_SOME_RETURNED_BAD,
            ProductInOrder::STATUS_SOME_RETURNED_GOOD,
        ];
        $for_next_date = 0;

        $items = 
        ProductInOrder::whereIn('status', $active_statuses)
        ->where('product_id', $product->id)
        ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
        ->whereNotIn('id', $nextRentsIds)
        ->get();
        $for_next_date = 0;
        foreach ($items as $item) {
            if ($item->expected_return_date === $this_date->format('Y-m-d')) {
                $for_next_date += $item->product_quantity - ($item->returned_good_quantity + $item->returned_bad_quantity);
            }
        }


        $this_date->addDay();

        while ($this_date->lt($date)
        && $count < 365) {
            
            $available_quantity += $for_next_date;

            $items = 
            ProductInOrder::whereIn('status', $active_statuses)
            ->where('product_id', $product->id)
            ->get();
            $for_next_date = 0;
            $wait_rent_quantity = 0;
            foreach ($items as $item) {
                if ($item->expected_return_date === $this_date->format('Y-m-d')) {
                    $for_next_date += $item->product_quantity - $item->returned_good_quantity;
                } else if($item->expected_pick_up_date === $this_date->format('Y-m-d')) {
                    $wait_rent_quantity += $item->product_quantity;
                }
            }
            $available_quantity -= $wait_rent_quantity;
            $this_date->addDay();
            
            $count++;
        }
    }
    
    return $available_quantity;

}

function checkWillPickUpReschedule(Product $product, $pick_up_date, $rent_time, $quantity, $nextRentsIds) {

    $willPickUp = false;

    $nextPickUp = ProductInOrder::where('product_id', $product->id)
    ->where('status', ProductInOrder::STATUS_WAIT_FOR_PICK_UP)
    ->pluck('expected_pick_up_date')->max();
    if ($nextPickUp) {
        $toNextPickUp = Carbon::createFromFormat('Y-m-d', $nextPickUp)->diffInDays($pick_up_date);
    } else {
        $toNextPickUp = 0;
    }

    $pick_up_date = Carbon::createFromFormat('Y-m-d', $pick_up_date);

    for ($i = 0; ($i <= $rent_time && $i <= $toNextPickUp); $i++) {
        if (calculateAvailabilityReschedule($product, $pick_up_date->format('Y-m-d'), $nextRentsIds) < $quantity) {
            $willPickUp = true;
            break;
        }
        $pick_up_date->addDay();
    }

    return $willPickUp;
}

function findNearestAvailableDayReschedule(Product $product, $quantity, $rent_time, $nextRentsIds) {

    $date = Carbon::today()->subDay();

    $active_statuses = [
        ProductInOrder::STATUS_WAIT_FOR_PICK_UP,
        ProductInOrder::STATUS_PICKED_UP,
        ProductInOrder::STATUS_SOME_RETURNED_BAD,
        ProductInOrder::STATUS_SOME_RETURNED_GOOD,
    ];

    $latest_return_date = 
    ProductInOrder::whereIn('status', $active_statuses)
    ->where('product_id', $product->id)
    ->where('expected_return_date', '>=' , Carbon::today()->format('Y-m-d'))
    ->whereNotIn('id', $nextRentsIds)
    ->max('expected_return_date');

    $limit = Carbon::today()->diffInDays($latest_return_date);
    $limit = $limit > 365 ? 365 : $limit;

    for ($i = 0; $i <= $limit + 1; $i++) {
        $date->addDay();
        if (!checkWillPickUpReschedule($product, $date->format('Y-m-d'), $rent_time, $quantity, $nextRentsIds)) {
            break;
        }
    }

    return $date->format('Y-m-d');
}



?>