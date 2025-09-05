<div class="modal fade" id="modal-create-additional-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form wire:submit="save">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="additional_product_name" class="form-label">Nama Produk Tambahan</label>
                            <input wire:model="form.additional_product_name" type="text" id="additional_product_name" class="form-control"
                                placeholder="Nama Pelanggan" required>
                            @error('form.additional_product_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="additional_product_price" class="form-label">Harga</label>
                            <input wire:model="form.additional_product_price" type="number" id="additional_product_price" class="form-control"
                                placeholder="Jumlah" required>
                            @error('form.additional_product_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
