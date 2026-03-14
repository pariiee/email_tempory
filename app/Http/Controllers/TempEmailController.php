<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempEmail;
use App\Models\ReceivedEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TempEmailController extends Controller
{
    /**
     * Direct access to email via URL
     */
    public function directEmailAccess($emailAddress)
    {
        // Decode URL encoded email address
        $emailAddress = urldecode($emailAddress);
        
        // Find the email in database
        $tempEmail = TempEmail::where('email_address', $emailAddress)
                              ->where('is_active', true)
                              ->first();
        
        if (!$tempEmail) {
            // If email doesn't exist, redirect to homepage with message
            return redirect('/')->with('error', 'Email address not found or expired.');
        }
        
        // Pass the email data to the view
        return view('temp-email.index', [
            'preloadEmail' => $tempEmail,
            'directAccess' => true
        ]);
    }

    /**
     * Display the main temp email page
     */
    public function index()
    {
        return view('temp-email.index');
    }

    /**
     * Generate a new email
     */
    public function generateEmail(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'expires_in' => 'nullable|in:1_month,6_months,1_year',
            'generation_type' => 'nullable|in:auto,custom',
            'custom_username' => 'nullable|string|min:3|max:20|regex:/^[a-zA-Z0-9._-]+$/'
        ]);

        $domain = config('app.temp_email_domain', 'revacantik.my.id');
        $generationType = $validated['generation_type'] ?? 'auto';
        
        // Generate email address based on type
        if ($generationType === 'custom') {
            if (empty($validated['custom_username'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Custom username is required when generation type is custom',
                    'errors' => ['custom_username' => ['Custom username is required']]
                ], 422);
            }
            
            $emailAddress = $validated['custom_username'] . '@' . $domain;
            
            // Check if email already exists
            $existingEmail = TempEmail::where('email_address', $emailAddress)
                                    ->where('is_active', true)
                                    ->first();
            
            if ($existingEmail) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email address is already taken. Please choose a different username.',
                    'errors' => ['custom_username' => ['This username is already taken']]
                ], 422);
            }
        } else {
            // Auto generation - use existing random method
            do {
                $emailAddress = TempEmail::generateRandomEmail($domain);
                $exists = TempEmail::where('email_address', $emailAddress)->exists();
            } while ($exists);
        }

        // Calculate expiration date
        $expiresIn = $validated['expires_in'] ?? '1_month';
        $expiresAt = match($expiresIn) {
            '1_month' => now()->addMonth(),
            '6_months' => now()->addMonths(6),
            '1_year' => now()->addYear(),
            default => now()->addMonth()
        };

        // Create email
        $tempEmail = TempEmail::create([
            'email_address' => $emailAddress,
            'domain' => $domain,
            'expires_at' => $expiresAt,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $tempEmail->id,
                'email_address' => $tempEmail->email_address,
                'domain' => $tempEmail->domain,
                'expires_at' => $tempEmail->expires_at->format('Y-m-d H:i:s'),
                'expires_in_days' => $tempEmail->expires_at->diffInDays(now()),
                'generation_type' => $generationType
            ]
        ]);
    }

    /**     * Check if custom username is available
     */
    public function checkAvailability(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:20|regex:/^[a-zA-Z0-9._-]+$/'
        ]);

        $domain = config('app.temp_email_domain', 'revacantik.my.id');
        $emailAddress = $validated['username'] . '@' . $domain;
        
        $exists = TempEmail::where('email_address', $emailAddress)
                          ->where('is_active', true)
                          ->exists();

        return response()->json([
            'success' => true,
            'available' => !$exists,
            'username' => $validated['username'],
            'email_address' => $emailAddress
        ]);
    }

    /**     * Get inbox for a specific email
     */
    public function getInbox($emailId)
    {
        $tempEmail = TempEmail::active()->findOrFail($emailId);
        
        $emails = $tempEmail->receivedEmails()
            ->orderBy('received_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => [
                'temp_email' => [
                    'id' => $tempEmail->id,
                    'email_address' => $tempEmail->email_address,
                    'expires_at' => $tempEmail->expires_at?->format('Y-m-d H:i:s'),
                    'is_active' => $tempEmail->isActive()
                ],
                'emails' => $emails->items(),
                'pagination' => [
                    'current_page' => $emails->currentPage(),
                    'last_page' => $emails->lastPage(),
                    'per_page' => $emails->perPage(),
                    'total' => $emails->total()
                ]
            ]
        ]);
    }

    /**
     * Get a specific email
     */
    public function getEmail($emailId, $messageId)
    {
        $tempEmail = TempEmail::active()->findOrFail($emailId);
        $receivedEmail = $tempEmail->receivedEmails()->findOrFail($messageId);
        
        // Mark as read
        if (!$receivedEmail->is_read) {
            $receivedEmail->markAsRead();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $receivedEmail->id,
                'sender_email' => $receivedEmail->sender_email,
                'sender_name' => $receivedEmail->sender_name,
                'subject' => $receivedEmail->subject,
                'body_text' => $receivedEmail->body_text,
                'body_html' => $receivedEmail->body_html,
                'received_at' => $receivedEmail->formatted_received_at,
                'is_read' => $receivedEmail->is_read
            ]
        ]);
    }

    /**
     * Delete an email (deactivate it)
     */
    public function deleteEmail($emailId)
    {
        $tempEmail = TempEmail::findOrFail($emailId);
        $tempEmail->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Email has been deactivated'
        ]);
    }

    /**
     * Extend expiration time of email
     */
    public function extendExpiration($emailId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'months' => 'required|integer|min:1|max:12'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid months value',
                'errors' => $validator->errors()
            ], 400);
        }

        $tempEmail = TempEmail::active()->findOrFail($emailId);
        $newExpiration = ($tempEmail->expires_at ?: now())->addMonths($request->months);
        
        $tempEmail->update(['expires_at' => $newExpiration]);

        return response()->json([
            'success' => true,
            'data' => [
                'expires_at' => $newExpiration->format('Y-m-d H:i:s'),
                'expires_in_days' => $newExpiration->diffInDays(now())
            ]
        ]);
    }

    /**
     * Check for new emails (polling endpoint)
     */
    public function checkNewEmails($emailId, Request $request)
    {
        $tempEmail = TempEmail::active()->findOrFail($emailId);
        
        $lastCheck = $request->get('last_check');
        $query = $tempEmail->receivedEmails()->orderBy('received_at', 'desc');
        
        if ($lastCheck) {
            $query->where('received_at', '>', Carbon::parse($lastCheck));
        }
        
        $newEmails = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => [
                'new_emails_count' => $newEmails->count(),
                'new_emails' => $newEmails,
                'last_check' => now()->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Get email statistics
     */
    public function getStats($emailId)
    {
        $tempEmail = TempEmail::active()->findOrFail($emailId);
        
        $stats = [
            'total_emails' => $tempEmail->receivedEmails()->count(),
            'unread_emails' => $tempEmail->receivedEmails()->unread()->count(),
            'read_emails' => $tempEmail->receivedEmails()->read()->count(),
            'latest_email_at' => $tempEmail->receivedEmails()
                ->latest('received_at')
                ->value('received_at')
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Show API documentation page
     */
    public function apiDocs()
    {
        return view('api-docs.index');
    }

    /**
     * Get global platform statistics (real-time)
     */
    public function globalStats()
    {
        $now = Carbon::now();

        $activeEmails = TempEmail::where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', $now);
            })->count();

        $expiringSoon = TempEmail::where('is_active', true)
            ->whereBetween('expires_at', [$now, $now->copy()->addHours(24)])
            ->count();

        $generatedToday = TempEmail::whereDate('created_at', $now->toDateString())->count();

        $totalGenerated = TempEmail::count();

        $totalEmailsReceived = ReceivedEmail::count();

        $emailsReceivedToday = ReceivedEmail::whereDate('received_at', $now->toDateString())->count();

        $unreadEmails = ReceivedEmail::where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'active_emails'         => $activeEmails,
                'expiring_soon'         => $expiringSoon,
                'generated_today'       => $generatedToday,
                'total_generated'       => $totalGenerated,
                'total_emails_received' => $totalEmailsReceived,
                'emails_received_today' => $emailsReceivedToday,
                'unread_emails'         => $unreadEmails,
                'timestamp'             => $now->toISOString(),
            ]
        ]);
    }
}