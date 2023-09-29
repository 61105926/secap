<form action="{{ route('usuarios.destroy', $users->id) }} " method="POST" style="display: inline-block;"
    class="form-eliminar">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger bton">
        <i class='fas fa-user-times' style='color:#ffffff'></i>
    </button>
</form>
