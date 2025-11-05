<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\UserRole;
use App\Models\UserProfile;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeamMemberInviteMail;


class TeamMemberController extends Controller
{
    /**
     * Display a listing of the team members.
     */
    public function index($id = null)
    {
        $tenantId = Auth::id(); // current logged in user's id (acts as tenant_id)
        $selectedMember = TeamMember::with(['user','user.profile', 'user.role'])->find($id);
        $teamMembers = TeamMember::with(['invitedUser.role'])
            ->where('tenant_id', $tenantId)
            ->get();
        $roles = UserRole::all();
        return view('app-settings-teams', compact('teamMembers', 'roles','selectedMember'));
    }



    /**
     * Store a newly created team member.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'role_id'    => 'required|exists:user_roles,id',
            'status'     => 'required|in:0,1',
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email is required.',
            'email.unique'        => 'This email is already registered.',
            'role_id.required'    => 'Please select a role.',
            'status.required'     => 'Status is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inviter = Auth::user(); // The logged-in user who sends the invite

        // Step 1️⃣: Generate a random password
        $plainPassword = Str::random(10);

        // Step 2️⃣: Create the new user
        $user = User::create([
            'name' => trim($request->first_name . ' ' . $request->last_name),
            'email' => $request->email,
            'password' => bcrypt($plainPassword), // store hashed password
            'user_role_id' => $request->role_id,
        ]);

        // Step 3️⃣: Create Team Member record
        TeamMember::create([
            'tenant_id' => $inviter->id,
            'user_id' => $inviter->id,       // inviter ID
            'team_member_id' => $user->id,   // invited user ID
            'status' => $request->status,
        ]);

        // Step 4️⃣: Create User Profile
        \App\Models\UserProfile::create([
            'user_id' => $user->id,
            'tenant_id' => $inviter->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role' => $request->role_id,
        ]);

        // Step 5️⃣: Send Email with random password
        $inviteLink = url('/setup-account?email=' . urlencode($user->email));
        Mail::to($user->email)->send(new \App\Mail\TeamMemberInviteMail($user, $inviteLink, $plainPassword));

        return redirect()->back()->with('success', 'Team member invited successfully! Invitation email sent with login password.');
    }


    public function view($id)
    {
        $member = TeamMember::with(['invitedUser.role'])->findOrFail($id);

        return response()->json([
            'name'       => $member->invitedUser->name ?? 'N/A',
            'email'      => $member->invitedUser->email ?? 'N/A',
            'status'     => $member->status ? 'Active' : 'Inactive',
            'role'       => $member->invitedUser->role->name ?? 'N/A',
            'created_at' => $member->created_at->format('M d, Y h:i A'),
        ]);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:users,email,' . $id,
            'role_id'    => 'required|exists:user_roles,id',
            'status'     => 'required|boolean',
        ]);

        $member = TeamMember::findOrFail($id);
        $user = $member->user;

        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'user_role_id' => $request->role_id,
        ]);
        UserProfile::where('user_id',$user->id )->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role' => $request->role_id
        ]);
        $member->update(['status' => $request->status]);

        return redirect()->route('team-members.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $member->delete();
        return back()->with('success', 'Team member deleted successfully.');
    }
}
