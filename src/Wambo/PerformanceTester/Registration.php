<?php
namespace Wambo\PerformanceTester;

use Wambo\Core\App;
use Wambo\Core\Module\ModuleBootstrapInterface;

/**
 * Class Registration
 * @package Wambo\PerformanceTester
 */
class Registration implements ModuleBootstrapInterface
{

    /**
     * Registration constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $app->add(new PerformanceMiddleware());
    }
}