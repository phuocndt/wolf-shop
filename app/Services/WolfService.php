<?php

declare(strict_types=1);

namespace App\Services;

/* The `final` keyword in PHP is used to prevent a class from being extended or subclassed. In this case,
the `WolfService` class is marked as `final`, which means that it cannot be extended by any other class.
This ensures that the functionality provided by the `WolfService` class cannot be altered or overridden by
any subclasses. */

class WolfService
{
    /**
     * The function `updateQuality` iterates through items, updating their sellIn values and quality
     * based on item names.
     */
    public function updateQuality($item)
    {
        switch ($item->name) {
            case 'Apple AirPods':
                $item = self::handleAppleAirpods($item);
                break;
            case 'Apple iPad Air':
                $item = self::handleAppleiPadAir($item);
                break;
            case 'Samsung Galaxy S23':
                // Never degrades or needs to be sold
                break;
            case 'Xiaomi Redmi Note 13':
                $item = self::handleXiaomiRedmiNote13($item);
                break;
            default:
                $item = self::handleDefault($item);
                break;
        }
        $item->quality = max($item->quality, 0);
        return $item;
    }

    /**
     * The function `handleAppleAirpods` increases the quality of an item if it's below 50 and sets the quality to 0
     * if the sellIn value is less than 0.
     *
     * @param $item
     *
     * @return the updated `` object after applying the quality and sellIn checks for Apple Airpods.
     */
    private static function handleAppleAirpods($item)
    {
        if ($item->quality < 50) {
            $item->quality++;
        }
        if ($item->sellIn < 0) {
            $item->quality = 0;
        }
        return $item;
    }

    /**
     * The function `handleAppleiPadAir` increases the quality of an item based on certain conditions and sets the
     * quality to 0 if the sellIn value is less than 0.
     *
     * @param $item
     *
     * @return The function `handleAppleiPadAir` is returning the `` object after applying the quality and sellIn
     * logic for an Apple iPad Air product.
     */
    private static function handleAppleiPadAir($item)
    {
        if ($item->quality < 50) {
            $item->quality++;
            if ($item->sellIn < 11) {
                $item->quality++;
            }
            if ($item->sellIn < 6) {
                $item->quality++;
            }
        }
        if ($item->sellIn < 0) {
            $item->quality = 0;
        }

        return $item;
    }

    /**
     * The function `handleXiaomiRedmiNote13` decreases the quality of an item by 2 if its quality is greater than 0,
     * and sets the quality to 0 if the sellIn value is less than 0.
     *
     * @param $item
     *
     * @return The function `handleXiaomiRedmiNote13` is returning the updated `` object after applying the quality
     * degradation logic based on the conditions specified in the function.
     */
    private static function handleXiaomiRedmiNote13($item)
    {
        if ($item->quality > 0) {
            $item->quality -= 2;
        }
        if ($item->sellIn < 0) {
            $item->quality = 0;
        }

        return $item;
    }

    /**
     * The handleDefault function decreases the quality of an item by 1 if its quality is greater than 0, and sets the
     * quality to 0 if the sellIn value is less than 0.
     *
     * @param $item
     *
     * @return The function `handleDefault` is returning the updated `` object after adjusting its quality based on
     * the conditions specified in the function.
     */
    private static function handleDefault($item)
    {
        if ($item->quality > 0) {
            $item->quality--;
        }
        if ($item->sellIn < 0) {
            $item->quality -= $item->quality;
        }

        return $item;
    }
}
