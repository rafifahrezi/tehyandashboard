<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Validation\Rule;

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
        $this->authorize('create', User::class);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name'       => $request->name,
                    'email'      => $request->email,
                    'password'   => Hash::make($request->password),
                    'telp'       => $request->telp,
                    'jabatan'    => $request->jabatan,
                    'department' => $request->department,
                ]);

                $role = Role::findByName($request->role);
                $user->assignRole($role);

                Log::info('User created successfully', [
                    'user_id'       => $user->id,
                    'user_name'     => $user->name,
                    'role'          => $role->name,
                    'created_by'    => auth()->id(),
                ]);
            });

            return redirect()
                ->route('manajemen.user.index')
                ->with('notification', [
                    'type'     => 'success',
                    'title'    => 'Berhasil!',
                    'message'  => "Pengguna '{$request->name}' berhasil ditambahkan.",
                    'duration' => 8000
                ], 500);
        } catch (\Spatie\Permission\Exceptions\RoleDoesNotExist $e) {
            return back()
                ->withInput()
                ->with('notification', [
                    'type'     => 'error',
                    'title'    => 'Role Tidak Valid',
                    'message'  => 'Role yang dipilih tidak tersedia.',
                    'duration' => 6000
                ]);
        } catch (\Throwable $e) {
            Log::error('Gagal membuat user', [
                'error' => $e->getMessage(),
                'data'  => $request->except(['password', 'password_confirmation'])
            ]);

            return back()
                ->withInput()
                ->with('notification', [
                    'type'     => 'error',
                    'title'    => 'Gagal!',
                    'message'  => 'Terjadi kesalahan saat menambahkan pengguna.',
                    'duration' => 8000
                ]);
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
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.manajemen-user.edit', [
            'pageTitle'       => 'Edit User',
            'pageDescription' => 'Update informasi pengguna',
            'user'            => $user->load('roles'), // Eager load roles
            'roles'           => Role::all(['id', 'name']),
            'departments'     => ['Pegawai'], // Sesuaikan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $this->validate($request, [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'telp'              => ['nullable', 'string', 'max:20'],
            'jabatan'           => ['nullable', 'string', 'max:100'],
            'role'              => ['required', 'string', Rule::exists('roles', 'name')],
            'password'          => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active'         => ['nullable', 'boolean'],
        ]);
        try {
            DB::beginTransaction();
            $userData = [
                'name'      => $validated['name'],
                'email'     => $validated['email'],
                'telp'      => $validated['telp'] ?? null,
                'jabatan'   => $validated['jabatan'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ];

            // 3. Handle password hanya jika diisi
            if (! empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $user->update($userData);

            // Sync role menggunakan Spatie
            $role = Role::findByName($validated['role']);
            $user->syncRoles($role);

            DB::commit();
            return to_route('manajemen.user.index')
                ->with('notification', [
                    'type'    => 'success',
                    'title'   => 'Berhasil!',
                    'message' => "Data pengguna {$user->name} berhasil diperbarui.",
                    'duration' => 5000,
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui user', [
                'user_id' => $user->id,
                'actor'   => auth()->id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('notification', [
                    'type'    => 'error',
                    'title'   => 'Gagal Memperbarui',
                    'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    'duration' => 6000,
                ]);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $this->authorize('delete', $user);

            if ($user->is(auth()->user())) {
                return response()->json([
                    'notification' => [
                        'type' => 'error',
                        'title' => 'Aksi Ditolak',
                        'message' => 'Anda tidak dapat menghapus akun Anda sendiri.',
                        'duration' => 5000
                    ]
                ], 422);
            }
            $userName = $user->name;

            // 4. Hapus relasi pivot (roles & permissions) — hanya jika pakai Spatie
            $user->roles()->detach();
            $user->permissions()->detach();

            $deleted = $user->delete();

            if (! $deleted) {
                throw new \Exception('Gagal menghapus user dari database.');
            }

            return response()->json([
                'notification' => [
                    'type' => 'success',
                    'title' => 'Berhasil!',
                    'message' => "User \"{$userName}\" berhasil dihapus.",
                    'duration' => 4000
                ]
            ]);
        } catch (AuthorizationException $e) {
            Log::warning('User tidak diizinkan menghapus user lain', [
                'actor' => auth()->id(),
                'target' => $user->id ?? null,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'notification' => [
                    'type' => 'error',
                    'title' => 'Tidak Diizinkan',
                    'message' => 'Anda tidak memiliki izin untuk menghapus user ini.',
                    'duration' => 5000
                ]
            ], 403);
        } catch (\Throwable $e) {
            // Log error lengkap (termasuk SQL constraint, dll)
            Log::error('Gagal menghapus user', [
                'user_id' => $user->id ?? null,
                'actor_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'notification' => [
                    'type' => 'error',
                    'title' => 'Gagal Menghapus',
                    'message' => 'Terjadi kesalahan sistem. User mungkin memiliki data terkait yang tidak bisa dihapus.',
                    'duration' => 6000
                ]
            ], 500);
        }
    }
}
