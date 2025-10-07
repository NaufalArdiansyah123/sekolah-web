<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastMessage;
use App\Models\Extracurricular;
use App\Models\ExtracurricularRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class BroadcastController extends Controller
{
    /**
     * Send broadcast message
     */
    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'extracurricular_id' => 'required|exists:extracurriculars,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
            'send_email' => 'boolean',
            'post_public' => 'boolean',
            'send_sms' => 'boolean',
            'schedule_type' => 'required|in:now,later',
            'schedule_date' => 'required_if:schedule_type,later|date|after:today',
            'schedule_time' => 'required_if:schedule_type,later|date_format:H:i',
        ]);

        try {
            DB::beginTransaction();

            $extracurricular = Extracurricular::findOrFail($request->extracurricular_id);
            
            // Get active members count
            $membersCount = ExtracurricularRegistration::where('extracurricular_id', $extracurricular->id)
                ->where('status', 'approved')
                ->count();

            // Prepare scheduled datetime
            $scheduledAt = null;
            if ($request->schedule_type === 'later') {
                $scheduledAt = Carbon::createFromFormat('Y-m-d H:i', 
                    $request->schedule_date . ' ' . $request->schedule_time);
            }

            // Create broadcast message record
            $broadcast = BroadcastMessage::create([
                'extracurricular_id' => $extracurricular->id,
                'user_id' => Auth::id(),
                'subject' => $request->subject,
                'content' => $request->content,
                'send_email' => $request->boolean('send_email'),
                'post_public' => $request->boolean('post_public'),
                'send_sms' => $request->boolean('send_sms'),
                'schedule_type' => $request->schedule_type,
                'scheduled_at' => $scheduledAt,
                'status' => $request->schedule_type === 'now' ? 'sent' : 'pending',
                'recipients_count' => $membersCount,
                'sent_at' => $request->schedule_type === 'now' ? now() : null,
            ]);

            // If sending now, process immediately
            if ($request->schedule_type === 'now') {
                $this->processBroadcast($broadcast);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->schedule_type === 'now' 
                    ? 'Broadcast sent successfully!' 
                    : 'Broadcast scheduled successfully!',
                'broadcast_id' => $broadcast->id,
                'refresh' => $request->boolean('post_public'), // Refresh if posted publicly
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Broadcast failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to send broadcast: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get members count for an extracurricular
     */
    public function getMembersCount($extracurricularId)
    {
        $count = ExtracurricularRegistration::where('extracurricular_id', $extracurricularId)
            ->where('status', 'approved')
            ->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Process broadcast delivery
     */
    private function processBroadcast(BroadcastMessage $broadcast)
    {
        $deliveryLog = [];
        $emailsSent = 0;
        $smsSent = 0;

        try {
            // Get active members
            $members = ExtracurricularRegistration::where('extracurricular_id', $broadcast->extracurricular_id)
                ->where('status', 'approved')
                ->get();

            // Send emails if enabled
            if ($broadcast->send_email && $members->count() > 0) {
                foreach ($members as $member) {
                    try {
                        // Here you would send actual emails
                        // For now, we'll just simulate
                        $this->sendBroadcastEmail($member, $broadcast);
                        $emailsSent++;
                        
                        $deliveryLog[] = [
                            'type' => 'email',
                            'recipient' => $member->email,
                            'status' => 'sent',
                            'sent_at' => now()->toISOString(),
                        ];
                    } catch (\Exception $e) {
                        $deliveryLog[] = [
                            'type' => 'email',
                            'recipient' => $member->email,
                            'status' => 'failed',
                            'error' => $e->getMessage(),
                            'sent_at' => now()->toISOString(),
                        ];
                    }
                }
            }

            // Send SMS if enabled (placeholder)
            if ($broadcast->send_sms && $members->count() > 0) {
                foreach ($members as $member) {
                    if ($member->phone) {
                        try {
                            // Here you would send actual SMS
                            // For now, we'll just simulate
                            $smsSent++;
                            
                            $deliveryLog[] = [
                                'type' => 'sms',
                                'recipient' => $member->phone,
                                'status' => 'sent',
                                'sent_at' => now()->toISOString(),
                            ];
                        } catch (\Exception $e) {
                            $deliveryLog[] = [
                                'type' => 'sms',
                                'recipient' => $member->phone,
                                'status' => 'failed',
                                'error' => $e->getMessage(),
                                'sent_at' => now()->toISOString(),
                            ];
                        }
                    }
                }
            }

            // Update broadcast record
            $broadcast->update([
                'emails_sent' => $emailsSent,
                'sms_sent' => $smsSent,
                'delivery_log' => $deliveryLog,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {
            $broadcast->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'delivery_log' => $deliveryLog,
            ]);
            
            throw $e;
        }
    }

    /**
     * Send broadcast email (placeholder)
     */
    private function sendBroadcastEmail($member, BroadcastMessage $broadcast)
    {
        // This is a placeholder for actual email sending
        // You would implement actual email sending here using Laravel's Mail facade
        
        /*
        Mail::send('emails.broadcast', [
            'member' => $member,
            'broadcast' => $broadcast,
            'extracurricular' => $broadcast->extracurricular,
        ], function ($message) use ($member, $broadcast) {
            $message->to($member->email, $member->student_name)
                   ->subject($broadcast->subject);
        });
        */
        
        // For now, just log it
        Log::info("Broadcast email sent to {$member->email}: {$broadcast->subject}");
    }

    /**
     * Get public broadcasts for display on public pages
     */
    public function getPublicBroadcasts($limit = 10)
    {
        return BroadcastMessage::with(['extracurricular', 'user'])
            ->public()
            ->recent()
            ->orderBy('sent_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Process scheduled broadcasts (for cron job)
     */
    public function processScheduledBroadcasts()
    {
        $scheduledBroadcasts = BroadcastMessage::scheduled()->get();

        foreach ($scheduledBroadcasts as $broadcast) {
            try {
                $this->processBroadcast($broadcast);
                Log::info("Scheduled broadcast {$broadcast->id} processed successfully");
            } catch (\Exception $e) {
                Log::error("Failed to process scheduled broadcast {$broadcast->id}: " . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'processed' => $scheduledBroadcasts->count(),
        ]);
    }
}