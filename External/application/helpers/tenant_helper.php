<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('initializeTenantDbConfig')) {
    function initializeTenantDbConfig($tenantIdentifier)
    {
        // Get the CodeIgniter instance
        $CI = &get_instance();

        // Load the default database configuration
        $CI->load->database();

        // Load the additional database for the tenant
        $CI->tenantDb = $CI->load->database($tenantIdentifier, TRUE);
    }
}
