<?php

namespace App\Support\Nova;

trait NovaHelp
{
    public static function getRequestParamsStatic($request): ?array
    {
        $url = $request->headers->get('referer');
        $str = parse_url($url, PHP_URL_QUERY);
        parse_str($str, $output);

        return $output;
    }

    public function getRequestParams($request): ?array
    {
        $url = $request->headers->get('referer');
        $str = parse_url($url, PHP_URL_QUERY);
        parse_str($str, $output);

        return $output;
    }

}
