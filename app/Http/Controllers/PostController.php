<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Brand;
use App\Models\PostContent;
use App\Models\PostMedia;
use App\Models\Campaign;
use App\Models\UserProfile;
use App\Models\BrandSocialMediaAccount;



class PostController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Fetch posts for logged-in user or tenant
        $posts = Post::with(['postType', 'profile'])
            ->where('tenant_id', $user->id)
            ->orWhere('user_id', $user->id)
            ->latest()
            ->paginate(10);

        // Fetch channels (brand social accounts)
        $channels = BrandSocialMediaAccount::where('user_id', $user->id)
            ->orWhere('tenant_id', $user->id)
            ->get();

        // Fetch brands for the same tenant/user
        $brands = Brand::where('user_id', $user->id)
            ->orWhere('tenant_id', $user->id)
            ->get();

        return view('posts.index', compact('posts', 'channels', 'brands'));
    }



    // Step 1: show create form
    public function createStep1()
    {
        $user = auth()->user();

        // Get campaigns
        $campaigns = \App\Models\Campaign::where('user_id', $user->id)->get();

        // Get post types
        $postTypes = \App\Models\PostType::all();

        // Get connected social media accounts (channels)
        $profiles = \App\Models\BrandSocialMediaAccount::where('user_id', $user->id)->get();

        return view('posts.create-step1', compact('campaigns', 'postTypes', 'profiles'));
    }



    // Step 1: store
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'campaign_id' => 'required|integer',
            'profile_id' => 'required|integer',
            'content' => 'nullable|string',
            'content_type' => 'required|in:text,media',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240'
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'tenant_id' => auth()->user()->id,
            'title' => $validated['title'],
            'campaign_id' => $validated['campaign_id'],
            'profile_id' => $validated['profile_id'],
            'content_type' => $request->content_type, // 

            'status' => 'draft',
        ]);

        // Save text if available
        if ($request->filled('content')) {
            PostContent::create([
                'post_id' => $post->id,
                'platform' => 'general',
                'content' => $request->content,
            ]);
        }

        // Save media files
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('uploads/posts', 'public');
                PostMedia::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('posts.create.step2', $post->id);
    }




    // Step 2: Show step 2 form
    public function createStep2($id)
    {
        $post = Post::findOrFail($id);
        $postTypes = \App\Models\PostType::all(); // fetch from DB
        return view('posts.create-step2', compact('post', 'postTypes'));
    }


    // Step 2: Store Post Contents, Media, etc.
    public function storeStep2(Request $request, $id)
    {
        $validated = $request->validate([
            'post_type_id' => 'required|exists:post_types,id', // added here
            'status' => 'required|in:draft,scheduled,published',
            'schedule_date' => 'nullable|date',
            'schedule_time' => 'nullable',
            'approver_id' => 'nullable|integer|exists:users,id',
        ]);

        $post = Post::findOrFail($id);

        //  Update post_type_id and other info
        $post->update([
            'post_type_id' => $validated['post_type_id'],
            'status' => $validated['status'],
            'schedule_date' => $validated['schedule_date'] ?? null,
            'schedule_time' => $validated['schedule_time'] ?? null,
            'approver_id' => $validated['approver_id'] ?? null,
        ]);

        // Save platform-specific contents
        $contents = [
            'twitter'   => $request->input('twitter_content'),
            'instagram' => $request->input('instagram_content'),
            'facebook'  => $request->input('facebook_content'),
            'linkedin'  => $request->input('linkedin_content'),
            'reel'      => $request->input('reel_caption'),
            'story'     => $request->input('story_description'),
            'shorts'    => $request->input('shorts_title'),
        ];

        foreach ($contents as $platform => $content) {
            if (!empty($content)) {
                PostContent::create([
                    'post_id' => $post->id,
                    'platform' => $platform,
                    'content' => $content,
                ]);
            }
        }

        // Handle file uploads
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('uploads/posts', 'public');
                PostMedia::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }
}
