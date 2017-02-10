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
 * Class SimpleRequest
 *
 * @package TestApplication\Requests
 */
class SimpleRequest extends RequestFilter
{
    const SCHEMA = [
        'comment' => 'data:comment',
        'files'   => 'file:files',
    ];
}