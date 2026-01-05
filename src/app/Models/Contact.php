<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getGenderLabelAttribute()
    {
        return match ((int)$this->gender) {
            1 => '男性',
            2 => '女性',
            3 => 'その他',
            default => '',
        };
    }

    public function getNameAttribute()
    {
        return trim(($this->last_name ?? '') . ' ' . ($this->first_name ?? ''));
    }

    public function getTelPlainAttribute()
    {
        // ハイフンをすべて除去
        return preg_replace('/-/', '', $this->tel);
    }
}
