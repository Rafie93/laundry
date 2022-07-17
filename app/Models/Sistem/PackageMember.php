<?php

namespace App\Models\Sistem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageMember extends Model
{
    use HasFactory;
    protected $table = "package_member";
    protected $fillable = [
        "package",
        "price",
        "duration",
        "duration_day",
        "maks_transaksi",
        "cashier",
        "branch",
        "footer",
        "qris",
        "report_to_wa",
        "auto_send_nota",
        "status"
    ];
}
