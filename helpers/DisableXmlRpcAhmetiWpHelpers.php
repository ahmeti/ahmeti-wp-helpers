<?php

class DisableXmlRpcAhmetiWpHelpers
{
    public function __construct()
    {
        add_filter('xmlrpc_enabled', '__return_false');
    }
}