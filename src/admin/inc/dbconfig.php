<?php

/**
 * DEPRECATED: This file used deprecated mysql_ functions and has been disabled.
 * Use Peking\Admin\Database class instead for all database operations.
 */

error_log('SECURITY WARNING: Deprecated dbconfig.php accessed. This file uses insecure mysql_ functions.');

throw new Exception(
    'This legacy database configuration has been disabled for security reasons. ' .
    'Use the modern Peking\Admin\Database class instead.'
);
