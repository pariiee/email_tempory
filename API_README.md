# REVA Mail API Documentation

Complete API reference for REVA Mail - Email Service with Custom Email Generation & Advanced Features

## 🚀 Quick Start

### Base URL
```
Production: https://revacantik.my.id/api/v1
Development: http://127.0.0.1:8000/api/v1
```

### Authentication
Include CSRF token in your requests:
```javascript
headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': 'your-csrf-token',
    'Accept': 'application/json'
}
```

## ✨ New Features
- 🎯 **Custom Email Generation** - Choose your own username
- ⏰ **Flexible Expiration** - 1 month, 6 months, or 1 year
- 🔍 **Real-time Availability Checking** - Check username availability
- 🔗 **Direct URL Access** - Share emails via direct URLs
- 📱 **Mobile-friendly Sharing** - Native share API support
- 📊 **Live Statistics** - Real-time platform stats with auto-refresh

## 📧 Email Management

### Generate Temporary Email
**POST** `/temp-emails/generate`

Creates a new temporary email with auto-generation or custom username options.

#### Auto-Generation (Random Username)
```javascript
// Request - Auto Generation
fetch('/api/v1/temp-emails/generate', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token
    },
    body: JSON.stringify({
        generation_type: 'auto',
        expires_in: '1_month'
    })
})

// Response
{
    "success": true,
    "data": {
        "id": 1,
        "email_address": "abc123@revacantik.my.id",
        "domain": "revacantik.my.id",
        "expires_at": "2026-04-14T08:30:45Z",
        "expires_in_days": 31,
        "created_at": "2026-03-14T08:30:45Z",
        "is_active": true,
        "generation_type": "auto"
    }
}
```

#### Custom Username Generation
```javascript
// Request - Custom Username
fetch('/api/v1/temp-emails/generate', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token
    },
    body: JSON.stringify({
        generation_type: 'custom',
        custom_username: 'myemail123',
        expires_in: '6_months'
    })
})

// Response - Success
{
    "success": true,
    "data": {
        "id": 2,
        "email_address": "myemail123@revacantik.my.id",
        "domain": "revacantik.my.id", 
        "expires_at": "2026-09-14T08:30:45Z",
        "expires_in_days": 183,
        "created_at": "2026-03-14T08:30:45Z",
        "is_active": true,
        "generation_type": "custom"
    }
}

// Response - Error (Username Taken)
{
    "success": false,
    "message": "Username already taken. Please choose a different username.",
    "errors": {
        "custom_username": ["This username is already taken"]
    }
}
```

#### Request Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `generation_type` | string | No | `auto` (default) or `custom` |
| `custom_username` | string | Conditional | Required if `generation_type` is `custom`. 3-20 chars, letters, numbers, dots, hyphens, underscores only |
| `expires_in` | string | No | `1_month` (default), `6_months`, or `1_year` |

### Check Username Availability
**POST** `/temp-emails/check-availability`

Check if a custom username is available before generating an email. Perfect for real-time validation.

```javascript
// Request
fetch('/api/v1/temp-emails/check-availability', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrf_token
    },
    body: JSON.stringify({
        username: 'myemail123'
    })
})

// Response - Available
{
    "success": true,
    "available": true,
    "username": "myemail123",
    "email_address": "myemail123@revacantik.my.id"
}

// Response - Taken
{
    "success": true,
    "available": false,
    "username": "myemail123", 
    "email_address": "myemail123@revacantik.my.id"
}
```

### Direct URL Access
Access any active email directly via URL:
```
https://revacantik.my.id/username@revacantik.my.id
```
This automatically loads the email and inbox without needing the API.
```

### Delete Email
**DELETE** `/temp-emails/{id}`

Permanently deletes temporary email and all messages.

### Extend Expiration
**PUT** `/temp-emails/{id}/extend`

Extends email lifetime (1_month, 6_months, 1_year).

```json
{
    "extension_period": "1_month"
}
```

## � Platform Statistics

### Get Live Statistics
**GET** `/stats`

Retrieves real-time platform statistics including active emails, daily counts, and totals. Perfect for dashboard displays with automatic refresh.

```javascript
// Request
fetch('/api/v1/stats', {
    method: 'GET',
    headers: {
        'Accept': 'application/json'
    }
})

// Response
{
    "success": true,
    "data": {
        "stats": [
            {
                "label": "Lagi Aktif",
                "emoji": "🔥",
                "value": 29,  
                "description": "Email yang sedang aktif dan belum expired"
            },
            {
                "label": "Dibuat Hari Ini",
                "emoji": "✨",
                "value": 7,
                "description": "Email baru yang dibuat hari ini"
            },
            {
                "label": "Masuk Hari Ini", 
                "emoji": "📬",
                "value": 2,
                "description": "Email yang diterima hari ini"
            },
            {
                "label": "Total Sepanjang Masa",
                "emoji": "🏆", 
                "value": 29,
                "description": "Total email yang pernah dibuat"
            }
        ],
        "updated_at": {
            "time": "14.07.43",
            "formatted": "Diperbarui jam 14.07.43",
            "full_datetime": "2026-03-16 14:07:43",
            "iso": "2026-03-16T14:07:43.000Z"
        },
        "server_info": {
            "timezone": "UTC",
            "date": "16 Mar 2026",
            "day_name": "Sunday"
        }
    }
}
```

**Features:**
- ⚡ Real-time data updates
- 🕐 Timestamp with precise update time 
- 🌍 Timezone and date information
- 📱 Mobile-friendly emoji indicators
- 🔄 Perfect for auto-refresh dashboards

## �📬 Inbox Operations

### Get Inbox
**GET** `/temp-emails/{id}/inbox`

Retrieves all received emails.

### Get Specific Email
**GET** `/temp-emails/{id}/email/{messageId}`

Gets email details and marks as read.

### Check New Emails
**GET** `/temp-emails/{id}/check-new`

Checks for unread emails (perfect for polling).

### Get Statistics
**GET** `/temp-emails/{id}/stats`

Returns email stats and remaining time.

## 🧪 Testing & Simulation

### Simulate Email
**POST** `/simulate/email`

Perfect for testing and development.

```json
{
    "temp_email_id": 1,
    "from_email": "test@example.com",
    "sender_name": "Test Sender",
    "subject": "Test Email",
    "body": "Test message content",
    "verification_code": "123456",
    "link": "https://example.com/verify"
}
```

## 🔧 Server Integration

### Receive Email
**POST** `/receive/email`

For email server integration.

```json
{
    "to_email": "abc123@revacantik.my.id",
    "from_email": "sender@example.com",
    "sender_name": "Sender Name",
    "subject": "Subject",
    "body": "Email content"
}
```

### Bulk Email Processing
**POST** `/receive/bulk-emails`

Process multiple emails in one request.

```json
{
    "emails": [
        {
            "to_email": "abc123@revacantik.my.id",
            "from_email": "sender1@example.com",
            "subject": "Email 1",
            "body": "Content 1"
        }
    ]
}
```

## ⚡ Rate Limits

- **60** requests per minute per IP
- **10** email generations per hour
- **20** simulations per hour

Rate limit headers:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 45
X-RateLimit-Reset: 1640995200
```

## 🚨 Error Handling

All errors return consistent format:

```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        "field_name": ["Validation error"]
    }
}
```

### HTTP Status Codes
- `200` - Success
- `400` - Bad Request/Validation Error
- `404` - Not Found
- `419` - CSRF Token Mismatch
- `429` - Rate Limit Exceeded
- `500` - Server Error

## 💻 Code Examples

### JavaScript (ES6)
```javascript
class REVAMailAPI {
    constructor(baseUrl, csrfToken) {
        this.baseUrl = baseUrl;
        this.csrfToken = csrfToken;
    }

    async generateEmail() {
        const response = await fetch(`${this.baseUrl}/temp-emails/generate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken
            }
        });
        return response.json();
    }

    async getInbox(emailId) {
        const response = await fetch(`${this.baseUrl}/temp-emails/${emailId}/inbox`);
        return response.json();
    }

    async simulateEmail(emailData) {
        const response = await fetch(`${this.baseUrl}/simulate/email`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken
            },
            body: JSON.stringify(emailData)
        });
        return response.json();
    }
}

// Usage
const api = new REVAMailAPI('/api/v1', csrf_token);
const email = await api.generateEmail();
console.log('Generated:', email.data.email_address);
```

### PHP
```php
<?php
class REVAMailAPI {
    private $baseUrl;
    private $csrfToken;

    public function __construct($baseUrl, $csrfToken) {
        $this->baseUrl = $baseUrl;
        $this->csrfToken = $csrfToken;
    }

    public function generateEmail() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . '/temp-emails/generate');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-CSRF-TOKEN: ' . $this->csrfToken
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }

    public function getInbox($emailId) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl . "/temp-emails/{$emailId}/inbox");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response, true);
    }
}

// Usage
$api = new REVAMailAPI('/api/v1', $csrfToken);
$email = $api->generateEmail();
echo 'Generated: ' . $email['data']['email_address'];
?>
```

### Python
```python
import requests
import json

class REVAMailAPI:
    def __init__(self, base_url, csrf_token):
        self.base_url = base_url
        self.csrf_token = csrf_token
        self.headers = {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf_token
        }

    def generate_email(self):
        response = requests.post(
            f'{self.base_url}/temp-emails/generate',
            headers=self.headers
        )
        return response.json()

    def get_inbox(self, email_id):
        response = requests.get(f'{self.base_url}/temp-emails/{email_id}/inbox')
        return response.json()

    def simulate_email(self, email_data):
        response = requests.post(
            f'{self.base_url}/simulate/email',
            json=email_data,
            headers=self.headers
        )
        return response.json()

# Usage
api = REVAMailAPI('/api/v1', csrf_token)
email = api.generate_email()
print(f"Generated: {email['data']['email_address']}")

# Simulate incoming email
email_data = {
    'temp_email_id': email['data']['id'],
    'from_email': 'test@example.com',
    'sender_name': 'Test Sender',
    'subject': 'Test Email',
    'body': 'This is a test message'
}

result = api.simulate_email(email_data)
print(f"Simulated: {result['success']}")
```

## 🔗 Integration Examples

### Mobile App Integration
```javascript
// React Native / Expo
import AsyncStorage from '@react-native-async-storage/async-storage';

class REVAMailService {
    async generateTempEmail() {
        try {
            const response = await fetch('/api/v1/temp-emails/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            
            const data = await response.json();
            
            // Store email info locally
            await AsyncStorage.setItem('tempEmail', JSON.stringify(data.data));
            
            return data.data;
        } catch (error) {
            console.error('Failed to generate email:', error);
            return null;
        }
    }

    async checkInbox(emailId) {
        const response = await fetch(`/api/v1/temp-emails/${emailId}/check-new`);
        return response.json();
    }
}
```

### Web Form Integration
```html
<!-- Registration form with temp email -->
<form id="registrationForm">
    <div class="form-group">
        <label>Email Address:</label>
        <div class="input-group">
            <input type="email" id="emailInput" readonly>
            <button type="button" onclick="generateTempEmail()">
                Generate Temp Email
            </button>
        </div>
    </div>
    
    <div id="inboxSection" style="display:none;">
        <h4>Check for verification emails:</h4>
        <button type="button" onclick="checkInbox()">
            Check Inbox
        </button>
        <div id="emailList"></div>
    </div>
</form>

<script>
let currentTempEmail = null;

async function generateTempEmail() {
    const response = await fetch('/api/v1/temp-emails/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
    
    const result = await response.json();
    
    if (result.success) {
        currentTempEmail = result.data;
        document.getElementById('emailInput').value = result.data.email_address;
        document.getElementById('inboxSection').style.display = 'block';
        
        // Start polling for new emails
        startEmailPolling();
    }
}

async function checkInbox() {
    if (!currentTempEmail) return;
    
    const response = await fetch(`/api/v1/temp-emails/${currentTempEmail.id}/inbox`);
    const result = await response.json();
    
    const emailList = document.getElementById('emailList');
    emailList.innerHTML = '';
    
    result.data.forEach(email => {
        const emailDiv = document.createElement('div');
        emailDiv.innerHTML = `
            <div class="email-item">
                <strong>${email.subject}</strong>
                <p>From: ${email.from_email}</p>
                <p>Code: ${email.verification_code || 'N/A'}</p>
            </div>
        `;
        emailList.appendChild(emailDiv);
    });
}

function startEmailPolling() {
    setInterval(checkInbox, 5000); // Check every 5 seconds
}
</script>
```

### Testing Automation
```python
# Selenium + Python example
from selenium import webdriver
from revamailapi import REVAMailAPI
import time

def test_email_verification():
    # Setup
    driver = webdriver.Chrome()
    api = REVAMailAPI('/api/v1', csrf_token)
    
    # Generate temporary email
    temp_email = api.generate_email()
    email_address = temp_email['data']['email_address']
    email_id = temp_email['data']['id']
    
    # Use in form
    driver.get('https://example.com/register')
    driver.find_element_by_name('email').send_keys(email_address)
    driver.find_element_by_name('submit').click()
    
    # Wait for verification email
    time.sleep(10)
    
    # Check inbox
    inbox = api.get_inbox(email_id)
    verification_emails = [
        email for email in inbox['data'] 
        if 'verify' in email['subject'].lower()
    ]
    
    if verification_emails:
        verification_code = verification_emails[0]['verification_code']
        verification_link = verification_emails[0]['link']
        
        # Use verification code or link
        if verification_link:
            driver.get(verification_link)
        elif verification_code:
            driver.find_element_by_name('code').send_keys(verification_code)
            driver.find_element_by_name('verify').click()
    
    driver.quit()
```

## 🎯 Use Cases

1. **User Registration Testing** - Automated testing of email verification flows
2. **Privacy Protection** - Temporary emails for downloads, trials, newsletters
3. **Development & QA** - Testing email functionality without spam
4. **API Integration** - Building apps that need disposable email addresses
5. **Bot Protection** - Preventing permanent email harvesting
6. **Multi-account Testing** - Testing with multiple unique email addresses

## 🏗️ Advanced Features

### Real-time Email Polling
```javascript
class EmailPoller {
    constructor(apiUrl, emailId, csrfToken) {
        this.apiUrl = apiUrl;
        this.emailId = emailId;
        this.csrfToken = csrfToken;
        this.polling = false;
        this.interval = null;
    }

    start(callback, intervalMs = 5000) {
        if (this.polling) return;
        
        this.polling = true;
        this.interval = setInterval(async () => {
            try {
                const response = await fetch(
                    `${this.apiUrl}/temp-emails/${this.emailId}/check-new`
                );
                const result = await response.json();
                
                if (result.success && result.data.has_new) {
                    callback(result.data);
                }
            } catch (error) {
                console.error('Polling error:', error);
            }
        }, intervalMs);
    }

    stop() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
            this.polling = false;
        }
    }
}

// Usage
const poller = new EmailPoller('/api/v1', emailId, csrfToken);
poller.start((newEmails) => {
    console.log('New emails received:', newEmails.new_emails_count);
    // Update UI with new emails
});
```

### Webhook Integration (Future Feature)
```javascript
// Future webhook endpoint configuration
const webhookConfig = {
    url: 'https://your-app.com/webhook/temp-email',
    events: ['email_received', 'email_expired'],
    signature_secret: 'your-webhook-secret'
};

// Webhook payload example
{
    "event": "email_received",
    "temp_email_id": 1,
    "email_data": {
        "id": 5,
        "subject": "New Email",
        "from_email": "sender@example.com",
        "received_at": "2026-03-14T10:30:00Z"
    },
    "timestamp": "2026-03-14T10:30:00Z",
    "signature": "sha256=..."
}
```

## 📊 Monitoring & Analytics

### Usage Statistics
```javascript
// Get usage statistics (admin endpoint)
fetch('/api/v1/admin/stats', {
    headers: {
        'Authorization': 'Bearer admin-token',
        'Content-Type': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    console.log('Total emails generated:', data.total_emails);
    console.log('Active emails:', data.active_emails);
    console.log('Emails received:', data.total_received);
});
```

## 🔐 Security Considerations

1. **CSRF Protection** - Always include CSRF tokens
2. **Rate Limiting** - Respect API rate limits
3. **Input Validation** - Validate all input data
4. **Email Sanitization** - Email content is automatically sanitized
5. **Expiration** - Emails automatically expire and are deleted
6. **No PII Storage** - No personal information is stored

## 🚀 Performance Tips

1. **Use Check-New Endpoint** - For polling, use `/check-new` instead of full inbox
2. **Batch Operations** - Use bulk endpoints when available
3. **Caching** - Cache email data on client side
4. **Reasonable Polling** - Don't poll faster than 3-5 seconds
5. **Clean Up** - Delete emails when no longer needed

## 📋 Best Practices

1. **Error Handling** - Always handle API errors gracefully
2. **User Experience** - Show loading states and progress indicators
3. **Accessibility** - Make email interfaces accessible
4. **Mobile Friendly** - Design responsive email viewers
5. **Testing** - Use simulation endpoints for testing
6. **Documentation** - Document your integration for team members

## 🆘 Troubleshooting

### Common Issues

**CSRF Token Mismatch (419)**
```javascript
// Ensure CSRF token is current
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
```

**Rate Limit Exceeded (429)**
```javascript
// Implement exponential backoff
async function apiCallWithRetry(url, options, maxRetries = 3) {
    for (let i = 0; i < maxRetries; i++) {
        const response = await fetch(url, options);
        
        if (response.status !== 429) {
            return response;
        }
        
        // Wait before retry (exponential backoff)
        await new Promise(resolve => setTimeout(resolve, Math.pow(2, i) * 1000));
    }
    throw new Error('Max retries exceeded');
}
```

**Email Not Found (404)**
```javascript
// Check if email is still active
const statsResponse = await fetch(`/api/v1/temp-emails/${emailId}/stats`);
const stats = await statsResponse.json();

if (!stats.success) {
    console.log('Email expired or deleted');
    // Generate new email
}
```

## 📞 Support

- **Web Interface**: [https://revacantik.my.id](https://revacantik.my.id)
- **API Documentation**: [https://revacantik.my.id/api-docs](https://revacantik.my.id/api-docs)
- **GitHub Issues**: Report bugs and feature requests
- **Email**: For integration support and questions

---

**Happy Coding!** 🎉

Built with ❤️ using Laravel 11 & TailwindCSS