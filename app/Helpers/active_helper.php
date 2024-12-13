<?php
if (!function_exists('set_active')) {
    function set_active($uri)
    {
        return url_is($uri) ? 'active' : '';
    }
}
