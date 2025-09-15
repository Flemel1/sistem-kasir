<div wire:ignore.self class="modal fade" id="modal-create-order" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form wire:submit="save">
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="customer_name" class="form-label">Nama Pelanggan</label>
                            <input wire:model="form.customer_name" type="text" id="customer_name" class="form-control"
                                placeholder="Nama Pelanggan" required>
                            @error('form.customer_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="cash_money" class="form-label">Cash</label>
                            <input wire:model="form.cash_money" type="number" id="cash_money" class="form-control"
                                placeholder="Jumlah" required>
                            @error('form.cash_money')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="status_order" class="form-label">Status Order</label>
                            <select id="status_order" wire:model="form.status_order"  class="form-control">
                                <option value="closed" selected>Close</option>
                                <option value="opened">Open</option>
                            </select>
                            @error('form.status_order')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="close" type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
