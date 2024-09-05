<?php

namespace App\Http\Controllers;

use App\Models\User; // Import the Petugas model
use Illuminate\Http\Request;

class CreatePetugas extends Controller
{
    public function index()
    {
        $petugas = User::where('role', 'petugas')->get(); // Retrieve all petugas records
        return view('admin.createpetugas', ['petugas' => $petugas]);
    }

    public function create()
    {
        return view('admin.petugas'); // View for creating a new petugas
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => 'petugas'
        ]);

        return redirect()->route('admin.petugas');
    }


    public function edit($id)
    {
        $petugas = User::findOrFail($id);
        \Log::info('Petugas instance:', ['petugas' => $petugas]);
        return view('admin.createpetugas', ['petugas' => $petugas]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id,
            'password' => 'nullable|min:6',
        ]);

        // Fetch the Petugas by ID
        $petugas = User::findOrFail($id);

        // Update the Petugas
        $petugas->update([
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $petugas->password,
        ]);

        return redirect()->route('updateuserpetugas');
    }




    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('admin.petugas');
    }
}
