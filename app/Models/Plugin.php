<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Types\Plugin as PluginType;

class Plugin extends Model
{
    protected $casts = [
        'config' => 'array',
        'type' => PluginType::class,
    ];

    protected $fillable = [
        'name',
        'description',
        'is_auto_activated',
        'is_enabled',
        'external_system_name',
        'supports_authorization_profiles',
        'type',
        'config',
    ];
}
