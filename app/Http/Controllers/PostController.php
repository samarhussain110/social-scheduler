<?php

namespace App\Http\Controllers;

use App\Models\PostMedia;
use App\Models\ScheduledPost;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of scheduled posts.
     */
    public function index()
    {
        $posts = ScheduledPost::where('user_id', auth()->id())
            ->with(['socialAccount', 'media'])
            ->orderBy('scheduled_at', 'desc')
            ->paginate(15);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $socialAccounts = SocialAccount::where('user_id', auth()->id())
            ->where('status', 'connected')
            ->get()
            ->groupBy('platform');

        return view('posts.create', compact('socialAccounts'));
    }

    /**
     * Store a newly created scheduled post.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform' => 'required|in:facebook,instagram,linkedin',
            'social_account_id' => 'required|exists:social_accounts,id',
            'content' => 'required|string|max:5000',
            'scheduled_date' => 'required|date',
            'timezone' => 'required|timezone',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
            'media_captions' => 'nullable|array',
            'media_captions.*' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify social account belongs to user
        $socialAccount = SocialAccount::where('id', $request->social_account_id)
            ->where('user_id', auth()->id())
            ->where('platform', $request->platform)
            ->first();

        if (!$socialAccount) {
            return back()
                ->with('error', 'Invalid social account selected.')
                ->withInput();
        }

        // Parse scheduled datetime with timezone
        try {
            $scheduledAt = \Carbon\Carbon::parse($request->scheduled_date, $request->timezone);
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Invalid date/time format.')
                ->withInput();
        }

        if ($scheduledAt->lessThanOrEqualTo(now())) {
            return back()
                ->withErrors(['scheduled_date' => 'The scheduled date must be in the future.'])
                ->withInput();
        }

        $scheduledAt->setTimezone('UTC');

        // Create scheduled post
        $post = ScheduledPost::create([
            'user_id' => auth()->id(),
            'platform' => $request->platform,
            'social_account_id' => $request->social_account_id,
            'content' => $request->content,
            'status' => 'scheduled',
            'scheduled_at' => $scheduledAt,
            'timezone' => $request->timezone,
        ]);

        // Handle media uploads
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $mediaType = in_array($file->getClientMimeType(), ['video/mp4', 'video/quicktime', 'video/x-msvideo']) 
                    ? 'video' 
                    : 'image';

                $path = $file->store('post-media', 'public');

                PostMedia::create([
                    'scheduled_post_id' => $post->id,
                    'media_type' => $mediaType,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'caption' => $request->media_captions[$index] ?? null,
                    'order' => $index,
                ]);
            }
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post scheduled successfully!');
    }

    /**
     * Display the specified post.
     */
    public function show(ScheduledPost $post)
    {
        $this->authorizePost($post);

        $post->load(['socialAccount', 'media']);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(ScheduledPost $post)
    {
        $this->authorizePost($post);

        if (in_array($post->status, ['published', 'publishing', 'cancelled'])) {
            return back()
                ->with('error', 'Cannot edit a post that is already published or cancelled.');
        }

        $socialAccounts = SocialAccount::where('user_id', auth()->id())
            ->where('status', 'connected')
            ->get()
            ->groupBy('platform');

        $post->load('media');

        return view('posts.edit', compact('post', 'socialAccounts'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, ScheduledPost $post)
    {
        $this->authorizePost($post);

        if (in_array($post->status, ['published', 'publishing', 'cancelled'])) {
            return back()
                ->with('error', 'Cannot edit a post that is already published or cancelled.');
        }

        $validator = Validator::make($request->all(), [
            'platform' => 'required|in:facebook,instagram,linkedin',
            'social_account_id' => 'required|exists:social_accounts,id',
            'content' => 'required|string|max:5000',
            'scheduled_date' => 'required|date|after:now',
            'timezone' => 'required|timezone',
            'new_media.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
            'new_media_captions' => 'nullable|array',
            'new_media_captions.*' => 'nullable|string|max:500',
            'remove_media' => 'nullable|array',
            'remove_media.*' => 'exists:post_media,id',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verify social account belongs to user
        $socialAccount = SocialAccount::where('id', $request->social_account_id)
            ->where('user_id', auth()->id())
            ->where('platform', $request->platform)
            ->first();

        if (!$socialAccount) {
            return back()
                ->with('error', 'Invalid social account selected.')
                ->withInput();
        }

        // Parse scheduled datetime with timezone
        try {
            $scheduledAt = \Carbon\Carbon::parse($request->scheduled_date, $request->timezone)
                ->setTimezone('UTC');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Invalid date/time format.')
                ->withInput();
        }

        // Update post
        $post->update([
            'platform' => $request->platform,
            'social_account_id' => $request->social_account_id,
            'content' => $request->content,
            'scheduled_at' => $scheduledAt,
            'timezone' => $request->timezone,
        ]);

        // Remove selected media
        if ($request->has('remove_media')) {
            foreach ($request->remove_media as $mediaId) {
                $media = PostMedia::where('id', $mediaId)
                    ->where('scheduled_post_id', $post->id)
                    ->first();

                if ($media) {
                    Storage::disk('public')->delete($media->file_path);
                    $media->delete();
                }
            }
        }

        // Add new media
        if ($request->hasFile('new_media')) {
            $currentMaxOrder = $post->media()->max('order') ?? 0;

            foreach ($request->file('new_media') as $index => $file) {
                $mediaType = in_array($file->getClientMimeType(), ['video/mp4', 'video/quicktime', 'video/x-msvideo']) 
                    ? 'video' 
                    : 'image';

                $path = $file->store('post-media', 'public');

                PostMedia::create([
                    'scheduled_post_id' => $post->id,
                    'media_type' => $mediaType,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                    'caption' => $request->new_media_captions[$index] ?? null,
                    'order' => $currentMaxOrder + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(ScheduledPost $post)
    {
        $this->authorizePost($post);

        if (in_array($post->status, ['published', 'publishing'])) {
            return back()
                ->with('error', 'Cannot delete a post that is currently being published.');
        }

        // Delete media files
        foreach ($post->media as $media) {
            Storage::disk('public')->delete($media->file_path);
        }

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Cancel a scheduled post.
     */
    public function cancel(ScheduledPost $post)
    {
        $this->authorizePost($post);

        if (in_array($post->status, ['published', 'cancelled'])) {
            return back()
                ->with('error', 'Cannot cancel a post that is already published or cancelled.');
        }

        $post->cancel();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post cancelled successfully!');
    }

    /**
     * Authorize that the user owns the post.
     */
    protected function authorizePost(ScheduledPost $post): void
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
