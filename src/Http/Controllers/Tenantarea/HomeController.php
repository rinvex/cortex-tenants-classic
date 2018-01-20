<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Tenantarea;

use Cortex\Foundation\Http\Controllers\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Show index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('cortex/tenants::tenantarea.pages.home');
    }
}
