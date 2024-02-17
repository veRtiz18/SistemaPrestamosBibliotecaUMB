<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger text-light">
                <h1 class="modal-title fs-5" id="eliminaModalLabel">Eliminar Libro</h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Desea eliminar este registro?

                <form action="eliminaLibro.php" method="POST">
                    <input type="text" name="id" id="id">
                    <div class="modal-footer">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end justify-content-end mb-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger text-light">Eliminar Libro</button>
                        </div>

                </form>
            </div>
        </div>

    </div>
</div>
</div>