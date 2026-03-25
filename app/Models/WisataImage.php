<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WisataImage extends Model
{
    use HasFactory;

    protected $table = 'wisata_images';

    protected $fillable = ['wisata_id', 'image_path', 'sort_order'];

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}
