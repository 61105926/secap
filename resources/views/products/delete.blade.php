<form action="{{ route('productos.destroy', $products->id) }} " method="POST" style="display: inline-block;"
    class="form-eliminar-productos">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger bton">
        <i class='fas fa-eraser' style='color:#ffffff'></i>
    </button>
</form>
