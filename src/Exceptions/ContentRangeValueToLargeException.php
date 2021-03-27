<?php

namespace Theanh\FileManager\Exceptions;

use Exception;

/**
 * Class Theanh\FileManager\Exceptions\ContentRangeValueToLargeException
 *
 * @package    theanh/laravel-filemanager
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/theanhk/tadcms
 * @license    MIT
 */
class ContentRangeValueToLargeException extends \Exception
{
    public function __construct(
        $message = 'The content range value is to large',
        $code = 500,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
