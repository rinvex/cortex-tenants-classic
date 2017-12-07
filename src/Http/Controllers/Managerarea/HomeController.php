<?php

declare(strict_types=1);

namespace Cortex\Tenants\Http\Controllers\Managerarea;

use Cortex\Foundation\Http\Controllers\AuthorizedController;

class HomeController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'managerarea';

    /**
     * {@inheritdoc}
     */
    protected $resourceAbilityMap = ['index' => 'access'];

    /**
     * Show the managerarea home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cortex/tenants::managerarea.pages.home');
    }
}
