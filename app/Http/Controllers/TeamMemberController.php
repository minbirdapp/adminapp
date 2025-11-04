<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\UserRole;
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
    public function index()
    {
        $tenantId = Auth::user()->tenant_id;

        $teamMembers = TeamMember::with(['user', 'user.role'])
            ->where('tenant_id', $tenantId)
            ->get();

        $roles = UserRole::all();

        return view('app-settings-teams', compact('teamMembers', 'roles'));
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
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    //  Create temporary password
    $tempPassword = Str::random(10);

    // Create user
    $user = User::create([
        'name' => trim($request->first_name . ' ' . $request->last_name),
        'email' => $request->email,
        'password' => bcrypt($tempPassword),
        'user_role_id' => $request->role_id,
    ]);

    //  Create team member
    TeamMember::create([
        'tenant_id' => Auth::user()->tenant_id,
        'user_id' => $user->id,
        'status' => $request->status,
    ]);

    // Generate invite link (you can direct them to setup password)
    $inviteLink = url('/setup-account?email=' . urlencode($user->email));

    //  Send invitation email
    Mail::to($user->email)->send(new TeamMemberInviteMail($user, $inviteLink));

    return redirect()->back()->with('success', 'Team member invited successfully and email sent!');
}
    public function view($id)
    {
        $member = TeamMember::with(['user.role'])->findOrFail($id);

        return response()->json([
            'name' => $member->user->name,
            'email' => $member->user->email,
            'status' => $member->status ? 'Active' : 'Inactive',
            'role' => $member->user->role->name ?? 'N/A',
            'created_at' => $member->created_at->format('M d, Y h:i A'),
        ]);
    }

    public function edit($id)
    {
        $member = TeamMember::with(['user', 'user.role'])->findOrFail($id);
        $roles = UserRole::all();
        return view('team-members.edit', compact('member', 'roles'));
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

        $member->update(['status' => $request->status]);

        return redirect()->route('team-members.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy($id)
    {
        $member = TeamMember::findOrFail($id);
        $user = $member->user;

        $member->delete();
        $user->delete(); // optional if you want to remove user too

        return back()->with('success', 'Team member deleted successfully.');
    }
}
