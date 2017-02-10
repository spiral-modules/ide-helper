<?php
/**
 * Spiral Framework, IDE Helper
 *
 * @author    Dmitry Mironov <dmitry.mironov@spiralscout.com>
 * @licence   MIT
 */

namespace TestApplication\Requests;


use Spiral\Http\Request\RequestFilter;

/**
 * Class NestedRequest
 *
 * @package TestApplication\Requests
 */
class NestedRequest extends RequestFilter
{
    const SCHEMA = [
        'simple'  => SimpleRequest::class,
        'simples' => [SimpleRequest::class],
    ];
}