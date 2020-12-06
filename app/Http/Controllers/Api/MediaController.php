<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    private $dir = 'dashboard.media.';

    public function storeFile(Request $request)
    {
        // validate for available mime:types
        if($request->file instanceof UploadedFile) {
            $media = Media::create(storeFile($request->file));
            $file = Storage::disk('public')->url($media->path);
            return ApiResponse::success(['file' => $file]);
        }
        
        return ApiResponse::error($request->all(), 'Invalid file');
    }

    public function storeMultipleFiles(Request $request)
    {
        if($request->file instanceof UploadedFile) {
            $media = Media::create(storeFile($request->file));
            $file = Storage::disk('public')->url($media->path);
            return ApiResponse::success(['file' => $file]);
        }
        
        return ApiResponse::error($request->all(), 'Invalid file');
    }
}
