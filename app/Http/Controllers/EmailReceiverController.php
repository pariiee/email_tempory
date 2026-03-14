<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TempEmail;
use App\Models\ReceivedEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EmailReceiverController extends Controller
{
    /**
     * Receive an incoming email (webhook endpoint)
     * This would typically be called by your email server or service
     */
    public function receiveEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_email' => 'required|email',
            'from_email' => 'required|email',
            'from_name' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:500',
            'body_text' => 'nullable|string',
            'body_html' => 'nullable|string',
            'message_id' => 'nullable|string|max:255',
            'raw_email' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email data',
                'errors' => $validator->errors()
            ], 400);
        }

        // Find the email
        $tempEmail = TempEmail::active()
            ->where('email_address', $request->to_email)
            ->first();

        if (!$tempEmail) {
            Log::info('Received email for non-existent or inactive email: ' . $request->to_email);
            return response()->json([
                'success' => false,
                'message' => 'Temporary email not found or expired'
            ], 404);
        }

        // Check if this email already exists (prevent duplicates)
        if ($request->message_id) {
            $existingEmail = ReceivedEmail::where('message_id', $request->message_id)->first();
            if ($existingEmail) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email already processed',
                    'data' => ['id' => $existingEmail->id]
                ]);
            }
        }

        // Create the received email record
        $receivedEmail = ReceivedEmail::create([
            'temp_email_id' => $tempEmail->id,
            'sender_email' => $request->from_email,
            'sender_name' => $request->from_name,
            'subject' => $request->subject ?: '(No Subject)',
            'body_text' => $request->body_text,
            'body_html' => $request->body_html,
            'received_at' => now(),
            'is_read' => false,
            'message_id' => $request->message_id,
            'raw_email' => $request->raw_email
        ]);

        Log::info('Email received successfully for: ' . $request->to_email, [
            'email_id' => $receivedEmail->id,
            'sender' => $request->from_email,
            'subject' => $request->subject
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email received successfully',
            'data' => [
                'id' => $receivedEmail->id,
                'temp_email_id' => $tempEmail->id,
                'received_at' => $receivedEmail->received_at->format('Y-m-d H:i:s')
            ]
        ], 201);
    }

    /**
     * Simulate receiving an email (for testing purposes)
     */
    public function simulateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'temp_email_id' => 'required|exists:temp_emails,id',
            'sender_email' => 'nullable|email',
            'sender_name' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:500',
            'message_type' => 'nullable|in:welcome,verification,promotional,newsletter,support'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid simulation data',
                'errors' => $validator->errors()
            ], 400);
        }

        $tempEmail = TempEmail::active()->findOrFail($request->temp_email_id);

        // Generate sample email content based on message type
        $messageType = $request->message_type ?: 'welcome';
        $sampleData = $this->generateSampleEmailData($messageType);

        $receivedEmail = ReceivedEmail::create([
            'temp_email_id' => $tempEmail->id,
            'sender_email' => $request->sender_email ?: $sampleData['sender_email'],
            'sender_name' => $request->sender_name ?: $sampleData['sender_name'],
            'subject' => $request->subject ?: $sampleData['subject'],
            'body_text' => $sampleData['body_text'],
            'body_html' => $sampleData['body_html'],
            'received_at' => now(),
            'is_read' => false,
            'message_id' => 'sim_' . uniqid() . '@simulator.local'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Test email simulated successfully',
            'data' => [
                'id' => $receivedEmail->id,
                'sender_email' => $receivedEmail->sender_email,
                'subject' => $receivedEmail->subject,
                'received_at' => $receivedEmail->received_at->format('Y-m-d H:i:s')
            ]
        ], 201);
    }

    /**
     * Generate sample email data for testing
     */
    private function generateSampleEmailData($type)
    {
        $samples = [
            'welcome' => [
                'sender_email' => 'noreply@example.com',
                'sender_name' => 'Welcome Team',
                'subject' => 'Welcome to our service!',
                'body_text' => "Hello!\n\nWelcome to our amazing service. We're excited to have you on board.\n\nBest regards,\nThe Team",
                'body_html' => '<h2>Welcome!</h2><p>Hello there!</p><p>Welcome to our amazing service. We\'re excited to have you on board.</p><p>Best regards,<br>The Team</p>'
            ],
            'verification' => [
                'sender_email' => 'verify@example.com',
                'sender_name' => 'Verification Service',
                'subject' => 'Please verify your email address',
                'body_text' => "Please click the link below to verify your email address:\n\nhttps://example.com/verify?token=abc123\n\nThis link will expire in 24 hours.",
                'body_html' => '<h2>Email Verification</h2><p>Please click the link below to verify your email address:</p><p><a href="https://example.com/verify?token=abc123">Verify Email</a></p><p><small>This link will expire in 24 hours.</small></p>'
            ],
            'promotional' => [
                'sender_email' => 'offers@shop.com',
                'sender_name' => 'Online Shop',
                'subject' => 'Special offer just for you! 50% OFF',
                'body_text' => "Don't miss out on this amazing deal!\n\n50% OFF on selected items. Use code: SAVE50\n\nShop now: https://shop.com/sale",
                'body_html' => '<h1>🎉 Special Offer!</h1><p>Don\'t miss out on this amazing deal!</p><h2>50% OFF</h2><p>on selected items. Use code: <strong>SAVE50</strong></p><p><a href="https://shop.com/sale">Shop Now</a></p>'
            ],
            'newsletter' => [
                'sender_email' => 'news@techblog.com',
                'sender_name' => 'Tech Blog Weekly',
                'subject' => 'This Week in Tech - Latest Updates',
                'body_text' => "This Week in Tech\n\n1. New AI breakthrough announced\n2. Latest smartphone reviews\n3. Privacy updates you need to know\n\nRead more: https://techblog.com/weekly",
                'body_html' => '<h2>This Week in Tech</h2><ul><li>New AI breakthrough announced</li><li>Latest smartphone reviews</li><li>Privacy updates you need to know</li></ul><p><a href="https://techblog.com/weekly">Read more</a></p>'
            ],
            'support' => [
                'sender_email' => 'support@helpdesk.com',
                'sender_name' => 'Customer Support',
                'subject' => 'Your support ticket #12345 has been resolved',
                'body_text' => "Hello,\n\nYour support ticket #12345 has been resolved.\n\nIssue: Account login problem\nResolution: Password reset completed\n\nIf you have any other questions, feel free to contact us.\n\nBest regards,\nSupport Team",
                'body_html' => '<h2>Support Ticket Update</h2><p>Hello,</p><p>Your support ticket <strong>#12345</strong> has been resolved.</p><p><strong>Issue:</strong> Account login problem<br><strong>Resolution:</strong> Password reset completed</p><p>If you have any other questions, feel free to contact us.</p><p>Best regards,<br>Support Team</p>'
            ]
        ];

        return $samples[$type] ?? $samples['welcome'];
    }

    /**
     * Bulk receive multiple emails (for batch processing)
     */
    public function bulkReceiveEmails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emails' => 'required|array|max:100',
            'emails.*.to_email' => 'required|email',
            'emails.*.from_email' => 'required|email',
            'emails.*.from_name' => 'nullable|string|max:255',
            'emails.*.subject' => 'nullable|string|max:500',
            'emails.*.body_text' => 'nullable|string',
            'emails.*.body_html' => 'nullable|string',
            'emails.*.message_id' => 'nullable|string|max:255',
            'emails.*.raw_email' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid bulk email data',
                'errors' => $validator->errors()
            ], 400);
        }

        $results = [];
        $processed = 0;
        $failed = 0;

        foreach ($request->emails as $emailData) {
            try {
                $tempEmail = TempEmail::active()
                    ->where('email_address', $emailData['to_email'])
                    ->first();

                if (!$tempEmail) {
                    $results[] = [
                        'success' => false,
                        'email' => $emailData['to_email'],
                        'message' => 'Email not found or expired'
                    ];
                    $failed++;
                    continue;
                }

                // Check for duplicates
                if (isset($emailData['message_id'])) {
                    $existingEmail = ReceivedEmail::where('message_id', $emailData['message_id'])->first();
                    if ($existingEmail) {
                        $results[] = [
                            'success' => true,
                            'email' => $emailData['to_email'],
                            'message' => 'Email already processed',
                            'id' => $existingEmail->id
                        ];
                        $processed++;
                        continue;
                    }
                }

                $receivedEmail = ReceivedEmail::create([
                    'temp_email_id' => $tempEmail->id,
                    'sender_email' => $emailData['from_email'],
                    'sender_name' => $emailData['from_name'] ?? null,
                    'subject' => $emailData['subject'] ?? '(No Subject)',
                    'body_text' => $emailData['body_text'] ?? null,
                    'body_html' => $emailData['body_html'] ?? null,
                    'received_at' => now(),
                    'is_read' => false,
                    'message_id' => $emailData['message_id'] ?? null,
                    'raw_email' => $emailData['raw_email'] ?? null
                ]);

                $results[] = [
                    'success' => true,
                    'email' => $emailData['to_email'],
                    'message' => 'Email received successfully',
                    'id' => $receivedEmail->id
                ];
                $processed++;

            } catch (\Exception $e) {
                $results[] = [
                    'success' => false,
                    'email' => $emailData['to_email'] ?? 'unknown',
                    'message' => 'Processing failed: ' . $e->getMessage()
                ];
                $failed++;
                Log::error('Bulk email processing failed', ['error' => $e->getMessage(), 'email_data' => $emailData]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Bulk processing completed. Processed: {$processed}, Failed: {$failed}",
            'summary' => [
                'total' => count($request->emails),
                'processed' => $processed,
                'failed' => $failed
            ],
            'results' => $results
        ]);
    }
}