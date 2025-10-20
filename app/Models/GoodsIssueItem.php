<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsIssueItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'goods_issue_id',
        'material_id',
        'qty',
        'remarks',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
    ];

    public function issue(): BelongsTo
    {
        return $this->belongsTo(GoodsIssue::class, 'goods_issue_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
