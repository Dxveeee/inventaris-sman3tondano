<h1>Tambah Pengguna</h1>

<form action="{{ route('admin.pengguna.store') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Nama">
    <br><br>

    <input type="email" name="email" placeholder="Email">
    <br><br>

    <select name="role">
        <option value="admin">Admin</option>
        <option value="kepala_sekolah">Kepala Sekolah</option>
        <option value="guru">Guru</option>
        <option value="siswa">Siswa</option>
    </select>

    <br><br>

    <input type="password" name="password" placeholder="Password">

    <br><br>

    <button type="submit">Simpan</button>
</form>
