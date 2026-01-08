<?php

// app/Hooks/DatabasePreSystemHook.php
namespace App\Hooks;

use Config\Database;

class DatabasePreSystemHook
{
    public function handle()
    {
        // Check if the tenant identifier is available in the URL
            $uri = $_SERVER['REQUEST_URI'];
	        $segments = explode('/', $uri);
          $tenant = $segments[1];
	      // You can modify this based on how you fetch the tenant identifier from the URL

        // Fetch the default database group configuration
        $defaultDBConfig = config('Database')->default;

        // Fetch the details of the specific tenant from another default database
        $tenantDatabaseConfig = $this->getTenantDatabaseDetails($tenant);

        // If the tenant-specific database details are found, merge them with the default database configuration
        if (!empty($tenantDatabaseConfig)) {
            $newDBConfig = array_merge($defaultDBConfig, $tenantDatabaseConfig);

            // Create a new database group for the tenant and set its configuration
            $tenantDBGroup = 'tenant_db'; // Replace 'tenant_db' with the desired name for the new database group
            config('Database')->addDatabase($tenantDBGroup, $newDBConfig);
        }
    }

    private function getTenantDatabaseDetails($tenant)
    {
        // Connect to another default database to fetch tenant-specific details
        $db = Database::connect(); // Connect without a group name to use the default configuration
        $query = $db->table('tenant_table')->where('tenant_identifier', $tenant)->get();

        // Assuming there is only one row for each tenant in the 'tenant_table'
        $tenantData = $query->getRow();

        if ($tenantData) {
            return [
                'hostname' => $tenantData->db_hostname,
                'username' => $tenantData->db_username,
                'password' => $tenantData->db_password,
                'database' => $tenantData->db_name,
            ];
        }

        return [];
    }
}


?>