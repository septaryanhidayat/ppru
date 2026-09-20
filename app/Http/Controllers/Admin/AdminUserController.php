<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Services\UnitAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan 8 akun admin unit terisi otomatis jika belum ada di database
        UnitAccountService::ensureUnitAccountsExist();

        $roleFilter = $request->input('role');
        $query = User::with('unit');

        if ($roleFilter === 'admin_unit') {
            $query->where('role', 'admin_unit');
        } elseif ($roleFilter === 'global') {
            $query->whereIn('role', ['super_admin', 'admin']);
        } elseif ($roleFilter && in_array($roleFilter, ['editor', 'author'])) {
            $query->where('role', $roleFilter);
        }

        $counts = [
            'all' => User::count(),
            'global' => User::whereIn('role', ['super_admin', 'admin'])->count(),
            'unit' => User::where('role', 'admin_unit')->count(),
        ];

        $users = $query->orderByRaw("CASE WHEN role = 'super_admin' THEN 1 WHEN role = 'admin' THEN 2 WHEN role = 'admin_unit' THEN 3 ELSE 4 END")
            ->orderBy('name', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'counts', 'roleFilter'));
    }

    public function create()
    {
        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.users.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'admin_unit', 'editor', 'author'])],
            'unit_pendidikan_id' => 'nullable|exists:unit_pendidikans,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'unit_pendidikan_id' => $validated['role'] === 'admin_unit' ? ($validated['unit_pendidikan_id'] ?? null) : null,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'user_create',
            'description' => "Membuat akun pengguna baru: {$user->name} ({$user->email}) dengan peran {$user->role_label}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.users.edit', compact('user', 'units'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', Rule::in(['super_admin', 'admin', 'admin_unit', 'editor', 'author'])],
            'unit_pendidikan_id' => 'nullable|exists:unit_pendidikans,id',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->unit_pendidikan_id = $validated['role'] === 'admin_unit' ? ($validated['unit_pendidikan_id'] ?? null) : null;

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'user_update',
            'description' => "Memperbarui profil pengguna: {$user->name} ({$user->email})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'user_delete',
            'description' => "Menghapus akun pengguna: {$userName} ({$userEmail})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
