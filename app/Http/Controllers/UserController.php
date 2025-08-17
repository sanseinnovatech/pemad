<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest\Store;
use App\Http\Requests\UserRequest\Update;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $query = User::whereNot('role', 'superadmin')->get();
            return DataTables::of($query)->make();
        }

        return view('pages.user.index');
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Store $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ];

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatar', 'public');
        }

        User::create($data);

        return redirect('user')->with('toast', 'showToast("Data berhasil disimpan")');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = User::findOrFail($id);

        return view('pages.user.edit',[
            'item'  =>  $item
        ]);
    }

    public function update(Update $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'username' => $request->username,
        ];

        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            $path = "avatar/";
            $oldfile = $path.basename($user->avatar);
            Storage::disk('public')->delete($oldfile);
            $data['avatar'] = Storage::disk('public')->put($path, $request->file('avatar'));
        }

        if($request->password){
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('user')->with('toast', 'showToast("Data berhasil diupdate")');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('toast', 'showToast("Data berhasil dihapus")');
    }
}
