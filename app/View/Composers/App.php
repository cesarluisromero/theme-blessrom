<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use Illuminate\View\View;
use Roots\Acorn\View\Composer as AcornComposer;
class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Retrieve the site name.
     */
    public function siteName(): string
    {
        return get_bloginfo('name', 'display');
    }

    public function with()
    {
        return [
            'cartCount' => function_exists('WC') ? WC()->cart->get_cart_contents_count() : 0,
        ];
    }
}