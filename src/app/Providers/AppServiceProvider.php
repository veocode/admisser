<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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

    public function multipleArgs($expression)
    {
        return collect(explode(',', $expression))->map(function ($item) {
            return trim($item, " '");
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('sorthead', function ($expression) {

            $expression = $this->multipleArgs($expression);

            $column = $expression->get(0);
            $title = $expression->get(1);

            return implode('', [
                '<?php $column = "'.$column.'"; ?>',
                '<?php $title = "'.$title.'"; ?>',
                '<?php $sort = $_GET["sort"] ?? "id"; ?>',
                '<?php $order = $_GET["order"] ?? "desc"; ?>',
                '<?php if ($sort !== $column){ echo \'<a href="?sort=\'.$column.\'&order=asc&page=1"><span>\'.$title.\'</span></a>\'; } ?>',
                '<?php if ($sort == $column) { ?>',
                '<?php if ($order == "asc"){ echo \'<a href="?sort=\'.$column.\'&order=desc&page=1"><span>\'.$title.\'</span><i class="fa fa-angle-up"></i></a>\'; } ?>',
                '<?php if ($order == "desc"){ echo \'<a href="?sort=\'.$column.\'&order=asc&page=1"><span>\'.$title.\'</span><i class="fa fa-angle-down"></i></a>\'; } ?>',
                '<?php } ?>',
            ]);

        });
    }
}
