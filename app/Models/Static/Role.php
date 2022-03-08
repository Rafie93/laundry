<?php

namespace App\Models\Static;

use App\Models\ReferenceAbstract;

/**
 * Role Class
 */
class Role extends ReferenceAbstract
{
    const SUPERADMIN = 11;
    const STORE_ADMIN = 12;
    const STORE_CS = 13;
    const STORE_KASIR = 14;
    const CUSTOMER = 15;
    const KURIR = 16;
}