<h2>Profile</h2>

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <label>Username</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}">

    <button type="submit">Update</button>
</form>