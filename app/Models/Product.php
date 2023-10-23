<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';
    protected $casts = [
        'data' => 'array',
        'status' => Status::class
    ];
    protected $fillable = ['article', 'name', 'status', 'data'];

    const AVAILABLE = 'available';
    const UNAVAILABLE = 'unavailable';

    protected function status(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return Status::fromString($value)->value;
            }
        );
    }

    protected function data(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if (is_null($value) || empty($value)) {
                    return null;
                }
                $newArray = [];
                $count = count($value);

                for ($i = 0; $i < $count; $i += 2) {
                    $key = $value[$i];
                    $item = $value[$i + 1];

                    $newArray[$key] = $item;
                }

                return json_encode($newArray);
            }
        );
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::AVAILABLE);
    }

}
