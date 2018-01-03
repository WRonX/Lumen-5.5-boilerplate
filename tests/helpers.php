<?php
if(!function_exists('testRoute'))
{
    /**
     * To be used in unit tests. Returns correct urls for named routes instead of 'http://:/' when having
     * multiple named virtual servers with different apps.
     *
     * @param string $name
     * @param array  $params
     * @return string
     */
    function testRoute(string $name, array $params = []) : string
    {
        $baseRoute = route($name, $params);
        $invalidPattern = 'http://:/';
        if(!str_contains($baseRoute, $invalidPattern))
            return $baseRoute;
        
        $appUrl = rtrim(env('APP_URL', 'http://localhost'), '/') . '/';
        if(strpos($appUrl, 'http://') !== 0 && strpos($appUrl, 'https://') !== 0)
            $appUrl = 'http://' . $appUrl;
        
        return str_replace($invalidPattern, $appUrl, $baseRoute);
    }
}