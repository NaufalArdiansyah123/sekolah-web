<?php
// app/Models/Permission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class PermissionS extends SpatiePermission
{
    protected $fillable = [
        'name',
        'guard_name',
        'group',
        'description',
    ];

    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }
}

