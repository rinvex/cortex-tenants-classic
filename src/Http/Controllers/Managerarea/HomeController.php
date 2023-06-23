<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Managerarea;

use Cortex\Foundation\Http\Controllers\AuthorizedController;

class HomeController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'access-managerarea';

    /**
     * Show managerarea index.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('cortex/tenants::managerarea.pages.index');
    }
}
