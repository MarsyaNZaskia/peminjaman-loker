@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('aktivasi.store') }}">
    @csrf

    <input name="username" placeholder="Username baru">
    <input name="email" placeholder="Email">
    <input name="phone" placeholder="No HP">
    <input name="address" placeholder="Alamat">
    <input name="class" placeholder="Kelas">

    <input type="password" name="password" placeholder="Password">
    <input type="password" name="password_confirmation" placeholder="Konfirmasi">

    <button type="submit">Aktivasi Akun</button>
</form>