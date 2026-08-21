<h1>Edit Pengguna</h1>

<form action="{{ route('admin.pengguna.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $user->name }}">
    <br><br>

    <input type="email" name="email" value="{{ $user->email }}">
    <br><br>

    <select name="role">
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
            Admin
        </option>

        <option value="kepala_sekolah" {{ $user->role == 'kepala_sekolah' ? 'selected' : '' }}>
            Kepala Sekolah
        </option>
    </select>

    <br><br>

    <button type="submit">Update</button>
</form>
