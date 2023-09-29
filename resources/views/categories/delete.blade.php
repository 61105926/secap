<form action="{{ route('categorias.destroy', $categories->id) }} " method="POST" style="display: inline-block;"
    class="form-eliminar-categories">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger bton">
        <i class='fas fa-pen-square' style='color:#ffffff'></i>
    </button>
</form>
