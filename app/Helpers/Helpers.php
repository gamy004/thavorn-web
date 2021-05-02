<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

function convertToBytes($from)
{
    preg_match('/([A-Z])+/', $from, $matches, PREG_OFFSET_CAPTURE);

    $matches = $matches[0];

    $number=substr($from, 0, $matches[1]);

    switch (strtoupper($matches[0])) {
        case "KB":
            return $number*1024;
        case "MB":
            return $number*pow(1024, 2);
        case "GB":
            return $number*pow(1024, 3);
        case "TB":
            return $number*pow(1024, 4);
        case "PB":
            return $number*pow(1024, 5);
        case "K":
            return $number*1024;
        case "M":
            return $number*pow(1024, 2);
        case "G":
            return $number*pow(1024, 3);
        case "T":
            return $number*pow(1024, 4);
        case "P":
            return $number*pow(1024, 5);
        default:
            return $from;
    }
}

/**
 * convert file size format
 *
 * @param  int $size // in byte
 * @return string
 */
function sizeFormat($size)
{
    $ret = '';
    $unit = [
        'KB' => 1024,
        'MB' => 1048576, // 1024*1024
        'GB' => 1073741824, // 1024*1024*1024
    ];

    if ($size < $unit['MB']) {
        $ret = number_format(round((float) $size / $unit['KB'], 2), 2) . ' KB';
    } elseif ($size < $unit['GB']) {
        $ret = number_format(round((float) $size / $unit['MB'], 2), 2) . ' MB';
    } else {
        $ret = number_format(round((float) $size / $unit['GB'], 2), 2) . ' GB';
    }
    return $ret;
}

function globalVar()
{
    return app('GlobalVar');
}

function tableName($name)
{
    return Str::snake(Str::plural($name, 2));
}

function intermediateTableName($name)
{
    return Str::snake(Str::singular($name));
}

function columnName($name)
{
    return sanitize(Str::snake($name));
}

function foreignkey($name)
{
    return sprintf(
        '%s_id',
        intermediateTableName($name)
    );
}

function whereToInsertArr(array $values)
{
    return array_reduce(
        $values,
        function ($res, $value) {
            $key = $value[0];
            $value = $value[1];

            $res[$key] = $value;

            return $res;
        },
        []
    );
}

function insertToWhereArr(array $values)
{
    $res = [];

    foreach ($values as $key => $value) {
        $res[] = [$key, $value];
    }

    return $res;
}

/** Copied sanitize method from UploadHandler form using outside the class */
function sanitize($name, $delimeter = '-', $force_lowercase = true, $anal = false)
{
    $paths = pathinfo($name);
    $name = $paths['filename'];
    $dirname = '';
    $extension = '';

    if (isset($paths['dirname'])) {
        $name = $paths['dirname'].$name;
    }

    if (isset($paths['extension'])) {
        $extension = $paths['extension'];
    }

    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\'", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($name)));
    $clean = preg_replace('/\s+/', $delimeter, $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

    $name  =  ($force_lowercase) ?
    (function_exists('mb_strtolower')) ?
    mb_strtolower($clean, 'UTF-8') :
    strtolower($clean) :
    $clean;

    if (strlen($extension) > 0) {
        $extension  =  ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($extension, 'UTF-8') :
        strtolower($extension) :
        $extension;

        $name .= ".$extension";
    }

    return $name;
}

/**
 * Solve multi-dimentional array access with dot notation
 * @param  array  $a       accessed array
 * @param  string $path    the string path 'bar.baz.foo'
 * @param  string $default Default value when no result
 * @return mixed
 */
function arrsolve(array $arr, $path, $default = null)
{
    $current = $arr;
    $p = strtok($path, '.');

    while ($p !== false) {
        if (!isset($current[$p])) {
            return $default;
        }
        $current = $current[$p];
        $p = strtok('.');
    }

    return $current;
}

function generateUniqueHashName($original_name, $id)
{
    $tmp = explode('.', $original_name);

    $extension = end($tmp);

    return $id . '_' . hash('sha256', $id . microtime()) . '.' . $extension;
}

function file_path($paths)
{
    return "files/".implode("/", (array) $paths);
}

function toBool($var)
{
    return filter_var($var, FILTER_VALIDATE_BOOLEAN);
}

function model_table($model)
{
    return app($model)->getTable();
}

function generateUUID($length, $check_method)
{
    do {
        $uuid = strtolower(str_random($length));
    } while ($check_method($uuid));

    return $uuid;
}

function GetWords($text) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\'", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ">", "?");
    
    $clean = trim(str_replace($strip, " ", strip_tags($text)));
    $clean = preg_replace('/\s+/', " ", $clean);

    $clean  =  (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean);

  // Remove duplicate spaces
  $cleanWordsOnly = str_replace("  ", " ", $clean);

  return explode(" ", $cleanWordsOnly);
}

function toSubQuery($query, $sub_query_name)
{
    // dump("sub", $sub_query_name);
    return DB::raw('(' . getEloquentSqlWithBindings($query) . ') as '. $sub_query_name .'');
}

function toNewQuery($query, $query_name)
{
    // dump("new", $query_name);

    $bindings = method_exists($query, "getQuery")
            ? $query->getQuery()
            : $query;
    
    $sqlWithBindings = toSqlBindings($query);

    return DB::table(DB::raw("({$sqlWithBindings}) as $query_name"));
    // MergeBindings method has a problem when using with union(), it make the binding occurs in the wrong position!!!
        // So I have replaced the $query->toSql() with the already merged query.
        // ->mergeBindings(
        //     $bindings
        // );
}

function getEloquentSqlWithBindings($query)
{
    // dump($query->toSql(), $query->getBindings());
    return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
        return is_numeric($binding) ? $binding : "'{$binding}'";
    })->toArray());
}

function toSqlBindings($query)
{
    return getEloquentSqlWithBindings($query);
}

function error(array $args = [], $code = 400)
{
    return responseJson($code, array_merge($args));
}

function unauthorized(array $errors)
{
    return responseJson(403, $errors);
}

function unprocessable(array $errors)
{
    return responseJson(422, $errors);
}

function unacceptable(array $errors)
{
    return responseJson(406, $errors);
}

function badImplementation(array $errors)
{
    return responseJson(500, $errors);
}

function success(array $props)
{
    return responseJson(200, $props);
}

function responseJson($code = 200, $args)
{
    return response()->json($args, $code);
}