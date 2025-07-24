<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest; // Pastikan request ini ada dan sudah dikonfigurasi
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password; // Untuk validasi password
use Illuminate\Validation\ValidationException; // Untuk menangani error validasi
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (name, email, photo).
     */
    public function updateProfileInformation(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        // Jika ada upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada dan bukan default-avatar.png
            // Asumsi 'photos' adalah folder di public disk
            if ($user->photo && Storage::disk('public')->exists($user->photo) && !str_contains($user->photo, 'default-avatar.png')) {
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto baru
            // Pastikan folder 'photos' ada di storage/app/public
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        // Reset verifikasi email jika email berubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Menggunakan 'success' untuk pesan flash yang umum
        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update the user's password.
     * Mengasumsikan rute ini adalah 'password.update'
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // Validasi input password
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'], // Memeriksa password saat ini
            'password' => ['required', Password::defaults(), 'confirmed'], // Password baru dan konfirmasi
        ]);

        // Update password pengguna
        $request->user()->update([
            'password' => bcrypt($validated['password']), // Hash password baru
        ]);

        // Menggunakan 'password_success' untuk pesan flash yang spesifik untuk password
        return Redirect::route('profile.edit')->with('password_success', 'Kata sandi berhasil diubah.');
    }


    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Hapus file jika ada dan ada di storage, dan pastikan bukan default-avatar.png
        if ($user->photo && Storage::disk('public')->exists($user->photo) && !str_contains($user->photo, 'default-avatar.png')) {
            Storage::disk('public')->delete($user->photo);
            $user->photo = null; // Set photo field di database menjadi null
            $user->save(); // Simpan perubahan ke database
            // Menggunakan 'success' untuk pesan flash
            return Redirect::route('profile.edit')->with('success', 'Foto profil berhasil dihapus.');
        }

        // Jika tidak ada foto atau foto default, berikan pesan error
        return Redirect::route('profile.edit')->with('error', 'Tidak ada foto profil yang bisa dihapus.');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Hapus foto profil pengguna jika ada sebelum menghapus akun
        if ($user->photo && Storage::disk('public')->exists($user->photo) && !str_contains($user->photo, 'default-avatar.png')) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
