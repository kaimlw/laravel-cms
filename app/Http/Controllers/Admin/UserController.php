<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    /**
     * (GET)
     * Menampilkan halaman User
     */
    function index() : View {
        $data['users'] = User::select('id', 'username', 'display_name', 'email', 'roles')
                        ->where('web_id', Auth::user()->web_id)
                        ->get();

        return view('admin.users', $data);
    }

    /**
     * (POST)
     * Menyimpan User Baru
     */
    function store(Request $request) : RedirectResponse {
        $request->validateWithBag('tambah',[
            'username' => 'required|unique:users,username',
            'displayName' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ], User::VALIDATION_MESSAGE);

        $newUser = User::create([
            'web_id' => Auth::user()->web_id,
            'username' => $request->username,
            'display_name' => $request->displayName,
            'email' => $request->email,
            'password' =>   Hash::make($request->password),
            'roles' => $request->role
        ]);

        if ($newUser) {
            return redirect()->route('admin.user')->with('showAlert', ['type' => 'success', 'msg' => 'Pengguna baru berhasil dibuat!']);
        }else {
            return redirect()->route('admin.user')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat.']);
        }
    }
    
    function update(Request $request, $id) : RedirectResponse {
        // Validasi input user
        $request->validateWithBag('edit',[
            'displayNameEdit' => 'required',
            'emailEdit' => 'required|email',
        ], User::VALIDATION_MESSAGE);

        $user = User::find(decrypt(base64_decode($id)));
        $updateArray = [
            'email' => $request->emailEdit,
            'display_name' => $request->displayNameEdit,
            'roles' => $request->roleEdit
        ];

        // Jika user mengubah username, lakukan validasi input username dan masukkan ke array update
        if ($user->username != $request->usernameEdit) {
            $request->validateWithBag('edit',[
                'usernameEdit' => 'required|unique:users,username',
            ],User::VALIDATION_MESSAGE);
            $updateArray['username'] = $request->usernameEdit;
        }

        // Jika user mengubah password, lakukan validasi input password dan masukkan ke array update
        if ($request->passwordEdit) {
            $request->validateWithBag('edit',[
                'passwordEdit' => 'min:8|confirmed'
            ],User::VALIDATION_MESSAGE);
            $updateArray['password'] = Hash::make($request->passwordEdit);
        }
        
        // Redirect ke halaman user, tampilkan pesan sesuai keberhasilan update
        if ($user->update($updateArray)) {
            return redirect()->route('admin.user')->with('showAlert', ['type' => 'success', 'msg' => 'Pengguna berhasil diedit!']);   
        }
        return redirect()->route('admin.user')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba beberapa saat lagi']);   
    }

    /**
     * (DELETE)
     * Menghapus user berdasarkan id user
     */
    function destroy($id) : RedirectResponse {
        $user = User::findOrFail(decrypt(base64_decode($id)));

        // Jika berhasil dihapus, kembali ke halaman User dan munculkan pesan berhasil.
        if ($user->delete()) {
            return redirect()->route('admin.user')->with('showAlert', ['type' => 'success', 'msg' => 'Pengguna berhasil dihapus!']);
        }
        
        return redirect()->route('admin.user')->with('showAlert', ['type' => 'danger', 'msg' => 'Terjadi kesalahan! Coba lagi beberapa saat!']);
    }

    /**
     * (GET)
     * Mengembalikan data user berdasarkan id
     */
    function user_get($id) : JsonResponse {
        $user = User::findOrFail(decrypt(base64_decode($id)));
        
        return response()->json([
            'encrypted_id' => base64_encode(encrypt($user->id)),
            'username' => $user->username,
            'display_name' => $user->display_name,
            'roles' => $user->roles,
            'email' => $user->email
        ]);
    }
}
