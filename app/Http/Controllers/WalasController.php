<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\Walas;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class WalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleName = 'wali_kelas'; // Ganti dengan nama peran yang Anda inginkan

        $role = Role::where('name', $roleName)->first();

        $walas = Walas::whereHas('user', function ($query) use ($role) {
            $query->role($role);
        })->get();

        return view('data-wali-kelas', compact('walas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('create-wali-kelas', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nipd' => 'required',
            'kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'kelas_id' => 'required',
            'telepon' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $user->assignRole('wali_kelas');

        $siswa = Walas::create([
            'nama' => $request->input('nama'),
            'nipd' => $request->input('nipd'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'kelamin' => $request->input('kelamin'),
            'kelas_id' => $request->input('kelas_id'),
            'telepon' => $request->input('telepon'),
            'user_id' => $user->id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Siswa berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
