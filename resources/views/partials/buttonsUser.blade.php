<div class='d-flex gap-2'>
    <a href='user/{{ $user->nidn }}/edit' class='btn btn-primary px-2'><i class='fa-solid fa-user-pen fs-5'></i></a>
    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('users.destroy', $user->nidn) }}"
        method="POST">
        @csrf
        @method('DELETE')
        <button type='submit' class='btn btn-danger px-2'><i class='fa-solid fa-trash fs-5'></i></button>
    </form>
</div>
