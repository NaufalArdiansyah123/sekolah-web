<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // Handle PostTooLargeException specifically
        if ($e instanceof PostTooLargeException) {
            return $this->handlePostTooLargeException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle PostTooLargeException with user-friendly message
     */
    protected function handlePostTooLargeException(Request $request, PostTooLargeException $e)
    {
        $maxPostSize = ini_get('post_max_size');
        $maxUploadSize = ini_get('upload_max_filesize');
        
        // Convert to MB for display
        $maxPostSizeMB = $this->convertToMB($maxPostSize);
        $maxUploadSizeMB = $this->convertToMB($maxUploadSize);
        
        $message = "File yang diupload terlalu besar. ";
        $message .= "Maksimal ukuran POST: {$maxPostSizeMB}MB, ";
        $message .= "Maksimal ukuran file: {$maxUploadSizeMB}MB. ";
        $message .= "Silakan gunakan file yang lebih kecil atau hubungi administrator.";

        // Log the error for debugging
        \Log::error('PostTooLargeException occurred', [
            'user_id' => auth()->id(),
            'url' => $request->url(),
            'method' => $request->method(),
            'max_post_size' => $maxPostSize,
            'max_upload_size' => $maxUploadSize,
            'user_agent' => $request->userAgent(),
        ]);

        // Return appropriate response based on request type
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'File terlalu besar',
                'message' => $message,
                'max_post_size' => $maxPostSize,
                'max_upload_size' => $maxUploadSize,
                'max_post_size_mb' => $maxPostSizeMB,
                'max_upload_size_mb' => $maxUploadSizeMB,
            ], 413);
        }

        // For web requests, redirect back with error
        return back()
            ->withInput()
            ->with('error', $message)
            ->with('upload_error_details', [
                'max_post_size' => $maxPostSize,
                'max_upload_size' => $maxUploadSize,
                'max_post_size_mb' => $maxPostSizeMB,
                'max_upload_size_mb' => $maxUploadSizeMB,
            ]);
    }

    /**
     * Convert PHP size notation to MB
     */
    protected function convertToMB($size)
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int) $size;

        switch ($last) {
            case 'g':
                $size *= 1024;
            case 'm':
                return $size;
            case 'k':
                return round($size / 1024, 2);
            default:
                return round($size / 1048576, 2);
        }
    }
}