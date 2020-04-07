<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('flattenTree', function ($childrenField = 'children', $levelAttribute = 'level')
        {
            $toProcess = $this->items;
            $processed = [];
            while($item = array_shift($toProcess))
            {
                $item->$levelAttribute ++;
                $processed[] = $item;
                if (count($item->$childrenField) > 0) {
                    $children = array_reverse($item->$childrenField->items);
                    foreach ($children as $child) {
                        $child->$levelAttribute = $item->$levelAttribute;
                        array_unshift($toProcess,$child);
                    }
                }
            }
            return Collection::make($processed);
        });
    }
}
