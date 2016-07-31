<?php
namespace Wambo\PerformanceTester;

/**
 * Class PerformanceMiddleware
 *
 * @package Wambo\PerformanceTester
 */
class PerformanceMiddleware
{

    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $start = microtime(true);

        $response = $next($request, $response);

        $end = microtime(true);
        $timeInMs = ($end - $start) * 1000;

        $usedMemory = memory_get_peak_usage(true);
        $usedMemoryMB = $usedMemory / 1024 / 1024;

        $color = 'lightgreen';
        if($timeInMs > 100){
            $color = 'yellow';
        }
        if($timeInMs > 200){
            $color = 'red';
        }

        $css = 'background:'.$color;

        $msg = '<div class="performance_footer" style="'.$css.'">' .
                sprintf('Request duration: %sms', number_format($timeInMs, 2)) .
                ' || ' .
                sprintf('Memory usage (peak): %s', number_format($usedMemoryMB, 2)) .
                '<div>';


        $response->getBody()->write($msg);

        $response = $response->withHeader('X-PHP-Duration', $timeInMs);
        $response = $response->withHeader('X-PHP-Memory-Peak', $usedMemoryMB);

        return $response;
    }

}