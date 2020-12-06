<?php

namespace App\Models;

use App\Enums\MediaTypes;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $guarded = [];
    public $timestamps = false;
    
    const EXTENSIONS = [
        MediaTypes::IMAGE => ['jpg', 'jpeg', 'jfif', 'png', 'svg'],
        MediaTypes::GIF   => ['gif'],
        MediaTypes::VIDEO => ['mp4', 'avi'],
        MediaTypes::DOC   => ['doc', 'docx', 'pdf'],
    ];
}
