<?php

namespace App\Http\Controllers\GuruPiket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class QrScannerSessionController extends Controller
{
    /**
     * Get current scan session data
     * Menggunakan Cache (persisten) daripada Session
     */
    public function getSessionData(Request $request)
    {
        $userId = auth()->id();
        $today = now()->toDateString();
        $cacheKey = "qr_scanner_{$userId}_{$today}";

        \Log::info('🔍 Getting session data', [
            'userId' => $userId,
            'today' => $today,
            'cacheKey' => $cacheKey
        ]);

        // Ambil dari cache, jika tidak ada return default
        $sessionData = Cache::get($cacheKey, [
            'qrCodes' => [],
            'stats' => [
                'success' => 0,
                'manual' => 0,
                'error' => 0
            ],
            'lastResult' => ''
        ]);

        \Log::info('📦 Session data retrieved', [
            'data' => $sessionData
        ]);

        return response()->json($sessionData);
    }

    /**
     * Update scan session data
     * Simpan ke Cache dengan TTL 24 jam
     */
    public function updateSessionData(Request $request)
    {
        $userId = auth()->id();
        $today = now()->toDateString();
        $cacheKey = "qr_scanner_{$userId}_{$today}";

        \Log::info('💾 Updating session data', [
            'userId' => $userId,
            'today' => $today,
            'cacheKey' => $cacheKey,
            'requestData' => $request->all()
        ]);

        $data = $request->validate([
            'qrCodes' => 'array',
            'stats' => 'array',
            'lastResult' => 'string'
        ]);

        \Log::info('✅ Validated data', [
            'data' => $data
        ]);

        // Simpan ke cache dengan TTL 24 jam (86400 detik)
        Cache::put($cacheKey, $data, 86400);

        \Log::info('✅ Data saved to cache', [
            'cacheKey' => $cacheKey
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Clear scan session data
     */
    public function clearSessionData(Request $request)
    {
        $userId = auth()->id();
        $today = now()->toDateString();
        $cacheKey = "qr_scanner_{$userId}_{$today}";

        Cache::forget($cacheKey);

        return response()->json(['success' => true]);
    }
}
