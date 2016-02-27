<?php

return array(

    /*
     |--------------------------------------------------------------------------
     | LaraMultiDbTenant Settings
     |--------------------------------------------------------------------------
     |
     | LaraMultiDbTenant is set to false by default.
     | You can override the value by setting enabled to true or false instead of null.
     |
     */

    'enabled' => false,

    /*
     |--------------------------------------------------------------------------
     | LaraMultiDbTenant Tenant Model
     |--------------------------------------------------------------------------
     |
     | LaraMultiDbTenant Tenant Model is the Model you will be using for the different organizations.
     | Change this to point to your Tenant/Organization model.
     |
     */
    'TenantModel' => 'app/Tenant'

);