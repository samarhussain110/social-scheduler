# نوٹیفیکیشنز اور ایکٹیویٹی لاگنگ سسٹم
# Notifications and Activity Logging System

## دستاویز / Documentation

### ⚠️ اہم / Important
یہ فیچر کام کرنے کے لیے آپ کو **دو فائلوں میں چھوٹی سی تبدیلی کرنی ہوگی**:
1. `app/Models/User.php` - ریلشنز شامل کرنے کے لیے
2. `routes/web.php` - روٹس شامل کرنے کے لیے

---

## ضروری تبدیلیاں / Required Changes

### 1. app/Models/User.php میں تبدیلی

**شامل کریں / Add these methods:**

```php
public function notifications(): HasMany
{
    return $this->hasMany(Notification::class);
}

public function activityLogs(): HasMany
{
    return $this->hasMany(ActivityLog::class);
}
```

### 2. routes/web.php میں تبدیلی

**یہ انپورٹس شامل کریں / Add these imports:**
```php
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\NotificationController;
```

**یہ روٹس شامل کریں (Posts کے گروپ کے بعد) / Add these routes (after Posts group):**
```php
/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
*/

Route::prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/{notification}/mark-unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark-unread');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});


/*
|--------------------------------------------------------------------------
| Activity Logs
|--------------------------------------------------------------------------
*/

Route::prefix('activity-logs')->group(function () {
    Route::get('/', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
    Route::delete('/{activityLog}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');
});
```

---

---

## جو کچھ شامل ہے / What's Included

### 1. ڈیٹا بیس ٹیبلز (Database Tables)

#### notifications table
- `id` - یونیک ID
- `user_id` - صارف کا ID (فارن کی)
- `type` - نوٹیفیکیشن کی قسم (info, success, warning, error)
- `title` - نوٹیفیکیشن کا عنوان
- `message` - نوٹیفیکیشن کا پیغام
- `data` - اضافی ڈیٹا (JSON)
- `link` - متعلقہ لنک (اختیاری)
- `read_at` - پڑھنے کا وقت
- `created_at`, `updated_at` - ٹائم اسٹیمپس

#### activity_logs table
- `id` - یونیک ID
- `user_id` - صارف کا ID (فارن کی)
- `action` - کارروائی کی قسم (post_created, post_published, etc.)
- `entity_type` - انٹٹی کی قسم (ScheduledPost, SocialAccount, etc.)
- `entity_id` - انٹٹی کا ID
- `description` - وضاحت
- `old_values` - پرانے ویلیوز (JSON) - آڈٹ کے لیے
- `new_values` - نئے ویلیوز (JSON) - آڈٹ کے لیے
- `ip_address` - IP ایڈریس
- `user_agent` - یوزر ایجنٹ
- `created_at`, `updated_at` - ٹائم اسٹیمپس

---

### 2. ماڈلز (Models)

#### Notification Model
```php
// کیا ہے / What it does
- نوٹیفیکیشنز کا نمائندگی کرتا ہے
- صارف کے ساتھ ریلشین شپ ہے
- ریڈ/انریڈ اسکوپس ہیں
- helper methods: markAsRead(), markAsUnread(), isRead()
```

#### ActivityLog Model
```php
// کیا ہے / What it does
- ایکٹیویٹی لاگز کا نمائندگی کرتا ہے
- صارف کے ساتھ ریلشین شپ ہے
- فلٹر اسکوپس: forAction(), forEntity(), recent()
```

---

### 3. کنٹرولرز (Controllers)

#### NotificationController
- `index()` - تمام نوٹیفیکیشنز دکھائیں
- `show()` - نوٹیفیکیشن کی تفصیلات دکھائیں
- `markAsRead()` - نوٹیفیکیشن کو ریڈ مارک کریں
- `markAsUnread()` - نوٹیفیکیشن کو انریڈ مارک کریں
- `markAllAsRead()` - تمام نوٹیفیکیشنز کو ریڈ مارک کریں
- `destroy()` - نوٹیفیکیشن ڈیلیٹ کریں

#### ActivityLogController
- `index()` - تمام ایکٹیویٹی لاگز دکھائیں (فلٹر کے ساتھ)
- `show()` - ایکٹیویٹی لاگ کی تفصیلات دکھائیں
- `destroy()` - ایکٹیویٹی لاگ ڈیلیٹ کریں

---

### 4. ویوز (Views)

#### نوٹیفیکیشنز ویوز
- `resources/views/notifications/index.blade.php` - نوٹیفیکیشنز کی لسٹ
- `resources/views/notifications/show.blade.php` - نوٹیفیکیشن کی تفصیلات

#### ایکٹیویٹی لاگز ویوز
- `resources/views/activity-logs/index.blade.php` - ایکٹیویٹی لاگز کی لسٹ (فلٹرز کے ساتھ)
- `resources/views/activity-logs/show.blade.php` - ایکٹیویٹی لاگ کی تفصیلات

---

### 5. روٹس (Routes)

#### نوٹیفیکیشن روٹس
- `GET /notifications` - نوٹیفیکیشنز کی لسٹ
- `GET /notifications/{notification}` - نوٹیفیکیشن کی تفصیلات
- `POST /notifications/{notification}/mark-read` - ریڈ مارک کریں
- `POST /notifications/{notification}/mark-unread` - انریڈ مارک کریں
- `POST /notifications/mark-all-read` - سب کو ریڈ مارک کریں
- `DELETE /notifications/{notification}` - ڈیلیٹ کریں

#### ایکٹیویٹی لاگ روٹس
- `GET /activity-logs` - ایکٹیویٹی لاگز کی لسٹ
- `GET /activity-logs/{activityLog}` - ایکٹیویٹی لاگ کی تفصیلات
- `DELETE /activity-logs/{activityLog}` - ڈیلیٹ کریں

---

## کیسے استعمال کریں / How to Use

### مرحلہ 1: ڈیٹا بیس مائگریشن رن کریں

```bash
php artisan migrate
```

### مرحلہ 2: نوٹیفیکیشن بنائیں

```php
use App\Models\Notification;
use App\Models\User;

$user = User::find(1);

// نوٹیفیکیشن بنائیں
$notification = Notification::create([
    'user_id' => $user->id,
    'type' => 'success',
    'title' => 'Post Published Successfully',
    'message' => 'Your post has been published on Facebook.',
    'data' => [
        'post_id' => 123,
        'platform' => 'facebook'
    ],
    'link' => route('posts.show', 123)
]);
```

### مرحلہ 3: ایکٹیویٹی لاگ بنائیں

```php
use App\Models\ActivityLog;
use App\Models\User;

$user = User::find(1);

// ایکٹیویٹی لاگ بنائیں
ActivityLog::create([
    'user_id' => $user->id,
    'action' => 'post_created',
    'entity_type' => 'ScheduledPost',
    'entity_id' => 123,
    'description' => 'User created a new scheduled post',
    'old_values' => null,
    'new_values' => [
        'content' => 'New post content',
        'platform' => 'facebook'
    ],
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent()
]);
```

### مرحلہ 4: ویوز تک رسائی

#### نوٹیفیکیشنز
- `http://your-app.com/notifications` - نوٹیفیکیشنز کی لسٹ
- `http://your-app.com/notifications/{id}` - نوٹیفیکیشن کی تفصیلات

#### ایکٹیویٹی لاگز
- `http://your-app.com/activity-logs` - ایکٹیویٹی لاگز کی لسٹ
- `http://your-app.com/activity-logs/{id}` - ایکٹیویٹی لاگ کی تفصیلات

---

## فیچرز / Features

### نوٹیفیکیشن فیچرز
- ✅ نوٹیفیکیشن ٹائپز (info, success, warning, error)
- ✅ ریڈ/انریڈ اسٹیٹس
- ✅ نوٹیفیکیشن کو ریڈ/انریڈ مارک کریں
- ✅ تمام نوٹیفیکیشنز کو ایک ساتھ ریڈ مارک کریں
- ✅ نوٹیفیکیشن ڈیلیٹ کریں
- ✅ متعلقہ لنک (اختیاری)
- ✅ اضافی ڈیٹا (JSON)
- ✅ پجینیشن
- ✅ فلٹرنگ (ریڈ/انریڈ)

### ایکٹیویٹی لاگ فیچرز
- ✅ کارروائی کی قسم (action)
- ✅ انٹٹی ٹریکنگ (entity_type, entity_id)
- ✅ آڈٹ ٹریل (old_values, new_values)
- ✅ IP ایڈریس ٹریکنگ
- ✅ یوزر ایجنٹ ٹریکنگ
- ✅ فلٹرنگ (بائی ایکشن، بائی ڈیٹ رینج)
- ✅ پجینیشن
- ✅ ڈیلیٹ فنکشنلٹی

---

## جدید فائلیں / New Files

### ڈیٹا بیس مائگریشنز
- `database/migrations/2026_09_17_152919_create_notifications_table.php`
- `database/migrations/2026_09_17_153131_create_activity_logs_table.php`

### ماڈلز
- `app/Models/Notification.php`
- `app/Models/ActivityLog.php`

### کنٹرولرز
- `app/Http/Controllers/NotificationController.php`
- `app/Http/Controllers/ActivityLogController.php`

### ویوز
- `resources/views/notifications/index.blade.php`
- `resources/views/notifications/show.blade.php`
- `resources/views/activity-logs/index.blade.php`
- `resources/views/activity-logs/show.blade.php`

### تبدیل شدہ فائلیں (Modified Files) - آپ کو خود تبدیلی کرنی ہوگی
- `app/Models/User.php` - notifications() اور activityLogs() ریلشنز شامل (تفصیل اوپر دی گئی ہے)
- `routes/web.php` - نوٹیفیکیشنز اور ایکٹیویٹی لاگز روٹس شامل (تفصیل اوپر دی گئی ہے)

---

## استعمال کے مثال / Usage Examples

### مثال 1: پوسٹ پبلش ہونے پر نوٹیفیکیشن

```php
// PostController.php میں
public function publish(Post $post)
{
    // پوسٹ پبلش کریں
    $post->publish();
    
    // نوٹیفیکیشن بنائیں
    Notification::create([
        'user_id' => auth()->id(),
        'type' => 'success',
        'title' => 'Post Published Successfully',
        'message' => "Your post has been published on {$post->platform}.",
        'data' => [
            'post_id' => $post->id,
            'platform' => $post->platform
        ],
        'link' => route('posts.show', $post)
    ]);
    
    return redirect()->back()->with('success', 'Post published successfully');
}
```

### مثال 2: پوسٹ بنانے پر ایکٹیویٹی لاگ

```php
// PostController.php میں
public function store(Request $request)
{
    $post = Post::create($request->all());
    
    // ایکٹیویٹی لاگ بنائیں
    ActivityLog::create([
        'user_id' => auth()->id(),
        'action' => 'post_created',
        'entity_type' => 'ScheduledPost',
        'entity_id' => $post->id,
        'description' => 'User created a new scheduled post',
        'new_values' => [
            'content' => $post->content,
            'platform' => $post->platform,
            'scheduled_at' => $post->scheduled_at
        ],
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent()
    ]);
    
    return redirect()->route('posts.show', $post);
}
```

### مثال 3: اکاؤنٹ کنیکٹ ہونے پر نوٹیفیکیشن

```php
// SocialAccountController.php میں
public function store(Request $request)
{
    $account = SocialAccount::create($request->all());
    
    // نوٹیفیکیشن بنائیں
    Notification::create([
        'user_id' => auth()->id(),
        'type' => 'success',
        'title' => 'Account Connected Successfully',
        'message' => "Your {$account->platform} account has been connected.",
        'data' => [
            'account_id' => $account->id,
            'platform' => $account->platform
        ],
        'link' => route('accounts.index')
    ]);
    
    return redirect()->route('accounts.index');
}
```

---

## ڈیش بورڈ میں انضمام / Dashboard Integration

اگر آپ ڈیش بورڈ میں نوٹیفیکیشنز اور ایکٹیویٹی لاگز دکھانا چاہتے ہیں، تو آپ نیویگیشن میں لنکس شامل کر سکتے ہیں:

```blade
<!-- resources/views/layouts/navigation.blade.php میں -->

<!-- نوٹیفیکیشنز لنک -->
<a href="{{ route('notifications.index') }}" class="...">
    Notifications
    @if (auth()->user()->notifications()->unread()->count() > 0)
        <span class="badge">{{ auth()->user()->notifications()->unread()->count() }}</span>
    @endif
</a>

<!-- ایکٹیویٹی لاگز لنک -->
<a href="{{ route('activity-logs.index') }}" class="...">
    Activity Logs
</a>
```

---

## ٹراؤبل شوٹنگ / Troubleshooting

### مسئلہ: نوٹیفیکیشنز نہیں دکھ رہے
**حل:** یہ چیک کریں کہ مائگریشن رن ہوئی ہے:
```bash
php artisan migrate:status
```

### مسئلہ: ریلشنز کام نہیں کر رہے
**حل:** یہ چیک کریں کہ User model میں ریلشنز شامل ہیں:
```php
public function notifications(): HasMany
{
    return $this->hasMany(Notification::class);
}

public function activityLogs(): HasMany
{
    return $this->hasMany(ActivityLog::class);
}
```

### مسئلہ: ویوز نہیں مل رہے
**حل:** یہ چیک کریں کہ ویوز فولڈر درست ہے:
- `resources/views/notifications/`
- `resources/views/activity-logs/`

---

## نٹس / Notes

- یہ سسٹم Laravel کے موجودہ آرکیٹیکچر کے ساتھ مکمل طور پر مطابقت رکھتا ہے
- UI/Tailwind CSS موجودہ اسٹائل کے ساتھ مطابقت رکھتا ہے
- **ضروری:** آپ کو دو فائلوں میں تبدیلی کرنی ہوگی (User.php اور web.php) - ان تبدیلیوں کی تفصیل اوپر دی گئی ہے
- اس سسٹم کو آسانی سے موجودہ فیچرز کے ساتھ انٹیگریٹ کیا جا سکتا ہے

---

## اگلے اقدامات / Next Steps

1. مائگریشن رن کریں: `php artisan migrate`
2. ڈیش بورڈ میں نیویگیشن لنکس شامل کریں
3. اپنے کنٹرولرز میں نوٹیفیکیشنز اور ایکٹیویٹی لاگز شامل کریں
4. ویوز کو اپنی ضروریات کے مطابق کسٹمائز کریں

---

**ضروری تبدیلیاں: آپ کو User.php اور web.php میں تبدیلی کرنی ہوگی (تفصیل اوپر دی گئی ہے).**
**Required changes: You need to make changes in User.php and web.php (details provided above).**