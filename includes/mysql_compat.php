<?php
/**
 * Compatibility layer for legacy mysql_* calls on PHP 7+ / PHP 8.
 *
 * The original script was written for ext/mysql. PHP removed that extension,
 * so these small wrappers keep the existing call sites working through mysqli.
 */

if (!function_exists('mysql_connect')) {
    if (!class_exists('mysqli')) {
        die('PHP mysqli extension is required to run this script on PHP 8.3.');
    }

    if (!defined('MYSQL_ASSOC')) {
        define('MYSQL_ASSOC', MYSQLI_ASSOC);
    }
    if (!defined('MYSQL_NUM')) {
        define('MYSQL_NUM', MYSQLI_NUM);
    }
    if (!defined('MYSQL_BOTH')) {
        define('MYSQL_BOTH', MYSQLI_BOTH);
    }

    mysqli_report(MYSQLI_REPORT_OFF);

    $__mysql_compat_link = null;
    $__mysql_compat_errno = 0;
    $__mysql_compat_error = '';

    function mysql_compat_set_error($errno = 0, $error = '')
    {
        $GLOBALS['__mysql_compat_errno'] = (int) $errno;
        $GLOBALS['__mysql_compat_error'] = (string) $error;
    }

    function mysql_compat_get_link($link_identifier = null)
    {
        if ($link_identifier instanceof mysqli) {
            return $link_identifier;
        }
        return isset($GLOBALS['__mysql_compat_link']) && $GLOBALS['__mysql_compat_link'] instanceof mysqli
            ? $GLOBALS['__mysql_compat_link']
            : null;
    }

    function mysql_compat_parse_host($server)
    {
        $host = $server ?: 'localhost';
        $port = ini_get('mysqli.default_port') ?: 3306;
        $socket = null;

        if (strpos($host, ':/') !== false) {
            list($host, $socket) = explode(':', $host, 2);
        } elseif (preg_match('/^([^:]+):([0-9]+)$/', $host, $matches)) {
            $host = $matches[1];
            $port = (int) $matches[2];
        }

        return array($host, $port, $socket);
    }

    function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0)
    {
        list($host, $port, $socket) = mysql_compat_parse_host($server);

        $mysqli = mysqli_init();
        if (!$mysqli) {
            mysql_compat_set_error(mysqli_connect_errno(), mysqli_connect_error());
            return false;
        }

        $ok = @$mysqli->real_connect($host, $username, $password, null, $port, $socket, $client_flags);
        if (!$ok) {
            mysql_compat_set_error(mysqli_connect_errno(), mysqli_connect_error());
            return false;
        }

        mysql_compat_set_error();
        $GLOBALS['__mysql_compat_link'] = $mysqli;
        return $mysqli;
    }

    function mysql_select_db($database_name, $link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        if (!$link) {
            mysql_compat_set_error(2006, 'MySQL server has gone away');
            return false;
        }

        $ok = @$link->select_db($database_name);
        mysql_compat_set_error($ok ? 0 : $link->errno, $ok ? '' : $link->error);
        return $ok;
    }

    function mysql_query($query, $link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        if (!$link) {
            mysql_compat_set_error(2006, 'MySQL server has gone away');
            return false;
        }

        $result = @$link->query($query);
        mysql_compat_set_error($result === false ? $link->errno : 0, $result === false ? $link->error : '');
        return $result;
    }

    function mysql_fetch_array($result, $result_type = MYSQL_BOTH)
    {
        return ($result instanceof mysqli_result) ? $result->fetch_array($result_type) : false;
    }

    function mysql_fetch_assoc($result)
    {
        return ($result instanceof mysqli_result) ? $result->fetch_assoc() : false;
    }

    function mysql_fetch_row($result)
    {
        return ($result instanceof mysqli_result) ? $result->fetch_row() : false;
    }

    function mysql_num_rows($result)
    {
        return ($result instanceof mysqli_result) ? $result->num_rows : 0;
    }

    function mysql_data_seek($result, $row_number)
    {
        return ($result instanceof mysqli_result) ? $result->data_seek($row_number) : false;
    }

    function mysql_real_escape_string($unescaped_string, $link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        return $link ? $link->real_escape_string($unescaped_string) : addslashes($unescaped_string);
    }

    function mysql_escape_string($unescaped_string)
    {
        return addslashes($unescaped_string);
    }

    function mysql_insert_id($link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        return $link ? $link->insert_id : 0;
    }

    function mysql_errno($link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        return $link ? $link->errno : $GLOBALS['__mysql_compat_errno'];
    }

    function mysql_error($link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        return $link ? $link->error : $GLOBALS['__mysql_compat_error'];
    }

    function mysql_get_server_info($link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        return $link ? $link->server_info : '';
    }

    function mysql_get_client_info()
    {
        return mysqli_get_client_info();
    }

    function mysql_close($link_identifier = null)
    {
        $link = mysql_compat_get_link($link_identifier);
        if (!$link) {
            return false;
        }
        $ok = $link->close();
        if ($link === $GLOBALS['__mysql_compat_link']) {
            $GLOBALS['__mysql_compat_link'] = null;
        }
        return $ok;
    }
}
?>
