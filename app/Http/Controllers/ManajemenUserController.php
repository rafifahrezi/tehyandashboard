<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Tambahkan ini
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ManajemenUserController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        // Statistik pengguna
        $stats = [
            'total_user' => $users->count(),
            'administrator' => $users->filter(function ($user) {
                return $user->hasRole('admin');
            })->count(),
            'active_users' => $users->where('status', 'aktif')->count(),
            'inactive_users' => $users->where('status', 'nonaktif')->count(),
        ];

        // Tambahkan fungsi formatWhatsAppNumber
        $formatWhatsAppNumber = fn($phoneNumber) => '+' . ltrim(
            preg_replace('/[^0-9]/', '', $phoneNumber),
            '0'
        );


        // Data untuk view - JANGAN gunakan compact dengan nested array
        return view('admin.manajemen-user.index', [
            'pageTitle' => 'Manajemen User',
            'pageDescription' => 'Kelola pengguna dan hak akses',
            'stats' => $stats,
            'users' => $users,
            'roles' => ['administrator'],
            'departments' => ['Pegawai'],
            'formatWhatsAppNumber' => $formatWhatsAppNumber,
        ]);
    }

    // Helper method untuk format last login
    private function formatLastLogin($lastLogin)
    {
        if (!$lastLogin) {
            return 'Belum pernah login';
        }

        $diff = now()->diffInMinutes($lastLogin);

        if ($diff < 60) {
            return $diff . ' menit yang lalu';
        } elseif ($diff < 1440) {
            return floor($diff / 60) . ' jam yang lalu';
        } else {
            return floor($diff / 1440) . ' hari yang lalu';
        }
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.manajemen-user.create', [
            'pageTitle'       => 'Buat Pengguna Baru',
            'pageDescription' => 'Tambahkan pengguna baru ke sistem',
            'roles'           => Role::all(['id', 'name'])->pluck('name', 'id'), // id => name untuk select
            'departments'     => ['Pegawai'], // Sesuaikan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Authorize: hanya yang boleh create user
        $this->authorize('create', User::class);

        try {
            DB::transaction(function () use ($request) {
                // 1. Buat user
                $user = User::create([
                    'name'       => $request->name,
                    'email'      => $request->email,
                    'password'   => Hash::make($request->password),
                    'telp'       => $request->telp,
                    'jabatan'    => $request->jabatan,
                    'department' => $request->department,
                ]);

                // 2. Assign role dengan validasi role exists (aman dari injection)
                $role = Role::findByName($request->role); // Akan throw ModelNotFoundException jika tidak ada
                $user->assignRole($role);

                // Optional: Log aktivitas
                Log::info('User created and role assigned', [
                    'user_id'     => $user->id,
                    'user_name'   => $user->name,
                    'assigned_role' => $role->name,
                    'created_by'  => auth()->id(),
                ]);
            });

            return redirect()
                ->route('admin.manajemen-user.index')
                ->with('success', 'Pengguna berhasil ditambahkan dan role telah diberikan.');
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            // Role tidak ditemukan (misal di-tweak dari inspector)
            Log::warning('Attempt to assign non-existent role', [
                'role' => $request->role,
                'by'   => auth()->id(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Role yang dipilih tidak valid.');
        } catch (\Throwable $e) {
            Log::error('Failed to create user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data'  => $request->except('password'),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan pengguna. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) // Route Model Binding
    {
        return view('view', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        DB::transaction(fn() => $user->delete());

        return redirect()
            ->route('manajemen.user-admin')
            ->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }
}
