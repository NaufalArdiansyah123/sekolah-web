<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityViolation;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SecurityViolationController extends Controller
{
    /**
     * Display a listing of security violations
     */
    public function index(Request $request)
    {
        $query = SecurityViolation::with(['violatorStudent', 'qrOwnerStudent', 'reviewedBy'])
                                 ->orderBy('violation_time', 'desc');

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('violation_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('violation_date', '<=', $request->date_to);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by severity
        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        // Filter by violation type
        if ($request->filled('violation_type')) {
            $query->where('violation_type', $request->violation_type);
        }

        // Search by student name or NIS
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('violatorStudent', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            })->orWhereHas('qrOwnerStudent', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $violations = $query->paginate(20);

        // Get statistics
        $stats = [
            'total' => SecurityViolation::count(),
            'pending' => SecurityViolation::where('status', 'pending')->count(),
            'today' => SecurityViolation::whereDate('violation_date', today())->count(),
            'this_week' => SecurityViolation::whereBetween('violation_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'by_severity' => SecurityViolation::selectRaw('severity, count(*) as count')
                                           ->groupBy('severity')
                                           ->pluck('count', 'severity')
                                           ->toArray(),
            'by_type' => SecurityViolation::selectRaw('violation_type, count(*) as count')
                                        ->groupBy('violation_type')
                                        ->pluck('count', 'violation_type')
                                        ->toArray(),
        ];

        return view('admin.security-violations.index', compact('violations', 'stats'));
    }

    /**
     * Show the specified security violation
     */
    public function show($id)
    {
        $securityViolation = SecurityViolation::with(['violatorStudent', 'qrOwnerStudent', 'reviewedBy'])
                                            ->findOrFail($id);
        
        return view('admin.security-violations.show', compact('securityViolation'));
    }

    /**
     * Review a security violation
     */
    public function review(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $securityViolation = SecurityViolation::findOrFail($id);
        
        $securityViolation->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pelanggaran berhasil direview.');
    }

    /**
     * Resolve a security violation
     */
    public function resolve(Request $request, $id)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $securityViolation = SecurityViolation::findOrFail($id);
        
        $securityViolation->update([
            'status' => 'resolved',
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pelanggaran berhasil diselesaikan.');
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:review,resolve,dismiss,delete',
            'violation_ids' => 'required|array',
            'violation_ids.*' => 'exists:security_violations,id',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $violationIds = $request->violation_ids;
        $action = $request->action;
        $adminNotes = $request->admin_notes;

        switch ($action) {
            case 'review':
                SecurityViolation::whereIn('id', $violationIds)
                                ->update([
                                    'status' => 'reviewed',
                                    'admin_notes' => $adminNotes,
                                    'reviewed_by' => auth()->id(),
                                    'reviewed_at' => now(),
                                ]);
                $message = count($violationIds) . ' pelanggaran berhasil direview.';
                break;

            case 'resolve':
                SecurityViolation::whereIn('id', $violationIds)
                                ->update([
                                    'status' => 'resolved',
                                    'admin_notes' => $adminNotes,
                                    'reviewed_by' => auth()->id(),
                                    'reviewed_at' => now(),
                                ]);
                $message = count($violationIds) . ' pelanggaran berhasil diselesaikan.';
                break;

            case 'dismiss':
                SecurityViolation::whereIn('id', $violationIds)
                                ->update([
                                    'status' => 'dismissed',
                                    'admin_notes' => $adminNotes,
                                    'reviewed_by' => auth()->id(),
                                    'reviewed_at' => now(),
                                ]);
                $message = count($violationIds) . ' pelanggaran berhasil dibatalkan.';
                break;

            case 'delete':
                SecurityViolation::whereIn('id', $violationIds)->delete();
                $message = count($violationIds) . ' pelanggaran berhasil dihapus.';
                break;

            default:
                return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get violation statistics
     */
    public function statistics(Request $request)
    {
        $dateFrom = $request->get('date_from', now()->subDays(30)->toDateString());
        $dateTo = $request->get('date_to', now()->toDateString());

        $stats = [
            'total_violations' => SecurityViolation::whereBetween('violation_date', [$dateFrom, $dateTo])->count(),
            'by_status' => SecurityViolation::whereBetween('violation_date', [$dateFrom, $dateTo])
                                          ->selectRaw('status, count(*) as count')
                                          ->groupBy('status')
                                          ->pluck('count', 'status')
                                          ->toArray(),
            'by_severity' => SecurityViolation::whereBetween('violation_date', [$dateFrom, $dateTo])
                                            ->selectRaw('severity, count(*) as count')
                                            ->groupBy('severity')
                                            ->pluck('count', 'severity')
                                            ->toArray(),
            'by_type' => SecurityViolation::whereBetween('violation_date', [$dateFrom, $dateTo])
                                        ->selectRaw('violation_type, count(*) as count')
                                        ->groupBy('violation_type')
                                        ->pluck('count', 'violation_type')
                                        ->toArray(),
            'daily_trend' => SecurityViolation::whereBetween('violation_date', [$dateFrom, $dateTo])
                                            ->selectRaw('DATE(violation_date) as date, count(*) as count')
                                            ->groupBy('date')
                                            ->orderBy('date')
                                            ->get(),
            'top_violators' => SecurityViolation::whereBetween('violation_date', [$dateFrom, $dateTo])
                                              ->selectRaw('violator_student_id, count(*) as violation_count')
                                              ->with('violatorStudent')
                                              ->groupBy('violator_student_id')
                                              ->orderBy('violation_count', 'desc')
                                              ->limit(10)
                                              ->get(),
        ];

        if ($request->ajax()) {
            return response()->json($stats);
        }

        return view('admin.security-violations.statistics', compact('stats', 'dateFrom', 'dateTo'));
    }

    /**
     * Update the status of a security violation
     */
    public function updateStatus(Request $request, SecurityViolation $securityViolation)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $securityViolation->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status pelanggaran berhasil diperbarui.');
    }

    /**
     * Bulk update status for multiple violations
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'violation_ids' => 'required|array',
            'violation_ids.*' => 'exists:security_violations,id',
            'status' => 'required|in:pending,reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        SecurityViolation::whereIn('id', $request->violation_ids)
                        ->update([
                            'status' => $request->status,
                            'admin_notes' => $request->admin_notes,
                            'reviewed_by' => auth()->id(),
                            'reviewed_at' => now(),
                        ]);

        $count = count($request->violation_ids);
        return redirect()->back()->with('success', "Status {$count} pelanggaran berhasil diperbarui.");
    }

    /**
     * Get violation statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_violations' => SecurityViolation::count(),
            'pending_violations' => SecurityViolation::where('status', 'pending')->count(),
            'today_violations' => SecurityViolation::whereDate('violation_date', today())->count(),
            'week_violations' => SecurityViolation::whereBetween('violation_date', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'recent_violations' => SecurityViolation::with(['violatorStudent', 'qrOwnerStudent'])
                                                  ->orderBy('violation_time', 'desc')
                                                  ->limit(5)
                                                  ->get(),
            'top_violators' => SecurityViolation::selectRaw('violator_student_id, count(*) as violation_count')
                                              ->with('violatorStudent')
                                              ->groupBy('violator_student_id')
                                              ->orderBy('violation_count', 'desc')
                                              ->limit(5)
                                              ->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Export violations to CSV
     */
    public function export(Request $request)
    {
        $query = SecurityViolation::with(['violatorStudent', 'qrOwnerStudent', 'reviewedBy']);

        // Apply same filters as index
        if ($request->filled('date_from')) {
            $query->whereDate('violation_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('violation_date', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        $violations = $query->orderBy('violation_time', 'desc')->get();

        $filename = 'security_violations_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($violations) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Tanggal Pelanggaran',
                'Waktu Pelanggaran',
                'Pelanggar (Nama)',
                'Pelanggar (NIS)',
                'Pelanggar (Kelas)',
                'Pemilik QR (Nama)',
                'Pemilik QR (NIS)',
                'Pemilik QR (Kelas)',
                'Jenis Pelanggaran',
                'Tingkat Keparahan',
                'Status',
                'Lokasi',
                'IP Address',
                'Catatan Admin',
                'Direview Oleh',
                'Waktu Review'
            ]);

            // CSV data
            foreach ($violations as $violation) {
                fputcsv($file, [
                    $violation->id,
                    $violation->violation_date->format('Y-m-d'),
                    $violation->violation_time->format('H:i:s'),
                    $violation->violatorStudent->name ?? 'N/A',
                    $violation->violatorStudent->nis ?? 'N/A',
                    $violation->violatorStudent->class ?? 'N/A',
                    $violation->qrOwnerStudent->name ?? 'N/A',
                    $violation->qrOwnerStudent->nis ?? 'N/A',
                    $violation->qrOwnerStudent->class ?? 'N/A',
                    $violation->violation_type_text,
                    $violation->severity_text,
                    $violation->status_text,
                    $violation->location ?? 'N/A',
                    $violation->ip_address ?? 'N/A',
                    $violation->admin_notes ?? 'N/A',
                    $violation->reviewedBy->name ?? 'N/A',
                    $violation->reviewed_at ? $violation->reviewed_at->format('Y-m-d H:i:s') : 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}