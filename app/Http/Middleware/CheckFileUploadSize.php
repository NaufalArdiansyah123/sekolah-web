<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Symfony\Component\HttpFoundation\Response;

class CheckFileUploadSize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if this is a file upload request
        if ($request->hasFile('video_file') || $request->hasFile('thumbnail')) {
            $this->checkUploadLimits($request);
        }

        return $next($request);
    }

    /**
     * Check upload limits and provide helpful error messages
     */
    protected function checkUploadLimits(Request $request)
    {
        $maxPostSize = $this->convertToBytes(ini_get('post_max_size'));
        $maxUploadSize = $this->convertToBytes(ini_get('upload_max_filesize'));
        
        // Get content length from headers
        $contentLength = $request->header('Content-Length');
        
        if ($contentLength && $contentLength > $maxPostSize) {
            $maxPostSizeMB = round($maxPostSize / 1048576, 1);
            $contentLengthMB = round($contentLength / 1048576, 1);
            
            \Log::warning('Upload size exceeds post_max_size', [
                'content_length' => $contentLength,
                'content_length_mb' => $contentLengthMB,
                'max_post_size' => $maxPostSize,
                'max_post_size_mb' => $maxPostSizeMB,
                'user_id' => auth()->id(),
                'url' => $request->url(),
            ]);
            
            throw new PostTooLargeException(
                "File terlalu besar ({$contentLengthMB}MB). Maksimal {$maxPostSizeMB}MB."
            );
        }

        // Check individual file sizes
        foreach ($request->allFiles() as $key => $files) {
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $file) {
                if ($file && $file->getSize() > $maxUploadSize) {
                    $fileSizeMB = round($file->getSize() / 1048576, 1);
                    $maxUploadSizeMB = round($maxUploadSize / 1048576, 1);
                    
                    \Log::warning('Individual file size exceeds upload_max_filesize', [
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'file_size_mb' => $fileSizeMB,
                        'max_upload_size' => $maxUploadSize,
                        'max_upload_size_mb' => $maxUploadSizeMB,
                        'user_id' => auth()->id(),
                    ]);
                    
                    throw new \Exception(
                        "File '{$file->getClientOriginalName()}' terlalu besar ({$fileSizeMB}MB). Maksimal {$maxUploadSizeMB}MB per file."
                    );
                }
            }
        }
    }

    /**
     * Convert PHP size notation to bytes
     */
    protected function convertToBytes($size)
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int) $size;

        switch ($last) {
            case 'g':
                $size *= 1024;
            case 'm':
                $size *= 1024;
            case 'k':
                $size *= 1024;
        }

        return $size;
    }
}