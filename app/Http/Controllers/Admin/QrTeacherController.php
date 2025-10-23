<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Teacher;
use App\Services\QrCodeService;

class QrTeacherController extends Controller
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function index(Request $request)
    {
        $query = Teacher::with('qrTeacherAttendance');
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $teachers = $query->orderBy('name')->paginate(12)->withQueryString();

        return view('admin.qr-teacher.index', compact('teachers'));
    }

    public function generate(Request $request, Teacher $teacher)
    {
        try {
            $payload = json_encode([
                'type' => 'teacher',
                'id' => $teacher->id,
                'name' => $teacher->name,

            ]);

            // Generate QR image via Endroid service (PNG/SVG based on environment)
            $imageData = $this->qrCodeService->generateCustomQrCode(json_decode($payload, true));
            $ext = function_exists('imagepng') ? 'png' : 'svg';
            $path = "qr/teachers/{$teacher->id}.{$ext}";
            Storage::disk('public')->put($path, $imageData);

            // Generate unique QR code
            $qrCode = \App\Models\QrTeacherAttendance::generateQrCode($teacher->id);

            // Create or update QrTeacherAttendance record
            \App\Models\QrTeacherAttendance::updateOrCreate(
                ['teacher_id' => $teacher->id],
                [
                    'qr_code' => $qrCode,
                    'qr_image_path' => $path,
                    'is_active' => true,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'QR guru berhasil dibuat',
                'url' => Storage::url($path),
                'path' => $path,
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed generating teacher QR', ['teacher_id' => $teacher->id, 'error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Gagal membuat QR: ' . $e->getMessage()], 500);
        }
    }

    public function regenerate(Request $request, Teacher $teacher)
    {
        return $this->generate($request, $teacher);
    }

    public function generateBulk(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada guru yang dipilih'], 422);
        }

        $results = [];
        foreach (Teacher::whereIn('id', $ids)->get() as $teacher) {
            try {
                $payload = json_encode([
                    'type' => 'teacher',
                    'id' => $teacher->id,
                    'name' => $teacher->name,

                ]);
                $imageData = $this->qrCodeService->generateCustomQrCode(json_decode($payload, true));
                $ext = function_exists('imagepng') ? 'png' : 'svg';
                $path = "qr/teachers/{$teacher->id}.{$ext}";
                Storage::disk('public')->put($path, $imageData);

                // Generate unique QR code
                $qrCode = \App\Models\QrTeacherAttendance::generateQrCode($teacher->id);

                // Create or update QrTeacherAttendance record
                \App\Models\QrTeacherAttendance::updateOrCreate(
                    ['teacher_id' => $teacher->id],
                    [
                        'qr_code' => $qrCode,
                        'qr_image_path' => $path,
                        'is_active' => true,
                    ]
                );

                $results[] = [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'url' => Storage::url($path),
                ];
            } catch (\Throwable $e) {
                Log::error('Failed generating teacher QR (bulk)', ['teacher_id' => $teacher->id, 'error' => $e->getMessage()]);
            }
        }

        return response()->json(['success' => true, 'message' => 'QR bulk selesai', 'results' => $results]);
    }

    public function view(Teacher $teacher)
    {
        $path = "qr/teachers/{$teacher->id}.png";
        $exists = Storage::disk('public')->exists($path);
        $url = $exists ? Storage::url($path) : null;
        return view('admin.qr-teacher.view', compact('teacher', 'url'));
    }

    public function download(Teacher $teacher)
    {
        $base = "qr/teachers/{$teacher->id}";
        $pathPng = $base . '.png';
        $pathSvg = $base . '.svg';
        $disk = Storage::disk('public');
        if (!$disk->exists($pathPng) && !$disk->exists($pathSvg)) {
            // Auto-generate if missing
            $this->generate(request(), $teacher);
        }
        $finalPath = $disk->exists($pathPng) ? $pathPng : $pathSvg;
        $downloadName = 'qr-guru-' . $teacher->id . (str_ends_with($finalPath, '.svg') ? '.svg' : '.png');
        return $disk->download($finalPath, $downloadName);
    }
}
