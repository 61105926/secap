<form action="{{ route('clientes.destroy', $clients->id) }} " method="POST" style="display: inline-block;"
    class="form-eliminar-clients">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger bton">
        <i class='fas fa-user-times' style='color:#ffffff'></i>
    </button>
</form>
