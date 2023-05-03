<?php

declare(strict_types=1);

namespace SimpleUsers\Log;

/**
 * Logger
 */
class ErrorLog
{
  /**
   * Store error logs.
   *
   * @param string  $msg   Error message.
   * @param string  $type  Error type.
   * @param string  $file  File path.
   * @param int     $line  Line number.
   */
    public static function log(string $msg, string $type, string $file, int $line)
    {
        // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
        error_log(sprintf('%s (%s:%d): %s', $type, $file, $line, $msg));
    }
}
