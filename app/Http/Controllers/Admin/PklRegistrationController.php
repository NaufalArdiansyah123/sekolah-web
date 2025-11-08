<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PklRegistration;
use App\Services\PklQrCodeService;
use Illuminate\Http\Request;

class PklRegistrationController extends Controller
{
    protected $pklQrCodeService;

    public function __construct(PklQrCodeService $pklQrCodeService)
    {
        $this->pklQrCodeService = $pklQrCodeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PklRegistration::with(['student', 'tempatPkl']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('tempatPkl', function ($tempatQuery) use ($search) {
                        $tempatQuery->where('nama_tempat', 'like', "%{$search}%");
                    });
            });
        }

        $pklRegistrations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.pkl-registrations.index', compact('pklRegistrations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PklRegistration $pklRegistration)
    {
        $pklRegistration->load(['student', 'tempatPkl']);
        return view('admin.pkl-registrations.show', compact('pklRegistration'));
    }

    /**
     * Approve the PKL registration.
     */
    public function approve(PklRegistration $pklRegistration)
    {
        try {
            $pklRegistration->approve();

            // Generate QR code for approved registration
            $this->pklQrCodeService->generateQrCodeForRegistration($pklRegistration);

            return redirect()->back()->with('success', 'Pendaftaran PKL berhasil disetujui dan QR code telah dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyetujui pendaftaran PKL: ' . $e->getMessage());
        }
    }

    /**
     * Reject the PKL registration.
     */
    public function reject(Request $request, PklRegistration $pklRegistration)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $pklRegistration->reject($request->notes);

            return redirect()->back()->with('success', 'Pendaftaran PKL berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menolak pendaftaran PKL: ' . $e->getMessage());
        }
    }

    /**
     * Generate QR code for PKL registration
     */
    public function generateQr(PklRegistration $pklRegistration)
    {
        try {
            $this->pklQrCodeService->generateQrCodeForRegistration($pklRegistration);

            return redirect()->back()->with('success', 'QR code berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat QR code: ' . $e->getMessage());
        }
    }

    /**
     * Regenerate QR code for PKL registration
     */
    public function regenerateQr(PklRegistration $pklRegistration)
    {
        try {
            $this->pklQrCodeService->regenerateQrCodeForRegistration($pklRegistration);

            return redirect()->back()->with('success', 'QR code berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui QR code: ' . $e->getMessage());
        }
    }

    /**
     * View QR code for PKL registration
     */
    public function viewQr(PklRegistration $pklRegistration)
    {
        if (!$pklRegistration->qr_image_path) {
            return redirect()->back()->with('error', 'QR code belum dibuat untuk pendaftaran ini.');
        }

        return view('admin.pkl-registrations.view-qr', compact('pklRegistration'));
    }

    /**
     * Download QR code for PKL registration
     */
    public function downloadQr(PklRegistration $pklRegistration)
    {
        if (!$pklRegistration->qr_image_path) {
            return redirect()->back()->with('error', 'QR code belum dibuat untuk pendaftaran ini.');
        }

        $filePath = storage_path('app/public/' . $pklRegistration->qr_image_path);

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File QR code tidak ditemukan.');
        }

        return response()->download($filePath, 'pkl-qr-' . $pklRegistration->id . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }

    /**
     * Display a listing of approved PKL registrations with QR codes.
     */
    public function indexQr(Request $request)
    {
        $query = PklRegistration::with(['student', 'tempatPkl'])
            ->where('status', 'approved')
            ->whereNotNull('qr_code');

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($studentQuery) use ($search) {
                    $studentQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhereHas('tempatPkl', function ($tempatQuery) use ($search) {
                        $tempatQuery->where('nama_tempat', 'like', "%{$search}%");
                    });
            });
        }

        $pklQrCodes = $query->orderBy('updated_at', 'desc')->paginate(12);

        return view('admin.pkl-qr-codes.index', compact('pklQrCodes'));
    }

    /**
     * View/Download document (surat pengantar) for PKL registration
     */
    public function viewDocument(PklRegistration $pklRegistration)
    {
        if (!$pklRegistration->surat_pengantar) {
            abort(404, 'Document not found');
        }

        $suratPath = $pklRegistration->surat_pengantar;

        // Add public/ prefix if not already there
        if (!str_starts_with($suratPath, 'public/')) {
            if (str_starts_with($suratPath, 'surat-pengantar/')) {
                $suratPath = 'public/' . $suratPath;
            } else {
                $suratPath = 'public/surat-pengantar/' . basename($suratPath);
            }
        }

        // Check if file exists in storage
        if (!\Illuminate\Support\Facades\Storage::exists($suratPath)) {
            abort(404, 'File not found');
        }

        // Get full file path
        $fullPath = storage_path('app/' . $suratPath);

        // Return file for inline viewing
        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="surat-pengantar.pdf"'
        ]);
    }
}
