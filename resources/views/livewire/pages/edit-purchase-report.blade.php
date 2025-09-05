@section('title', 'Edit Pembelian')

<div>
    <form wire:submit="update">
        <div class="card">
            <h5 class="card-header">Edit Pembelian Harian</h5>

            <div class="card-body">
                <div class="mb-3">
                    <label for="purchase_item_name" class="form-label">Nama Barang</label>
                    <input wire:model="form.purchase_item_name" type="text" id="purchase_item_name" class="form-control"
                        placeholder="Masukan nama barang" value="{{ $purchase->purchase_item_name }}" required>
                    @error('form.purchase_item_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="purchase_amount" class="form-label">Jumlah Barang</label>
                    <input wire:model="form.purchase_amount" type="text" id="purchase_amount" class="form-control"
                        placeholder="Masukan jumlah barang" value="{{ $purchase->purchase_amount }}" required>
                    @error('form.purchase_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="purchase_money" class="form-label">Harga Barang</label>
                    <input wire:model="form.purchase_money" type="text" id="purchase_money" class="form-control"
                        placeholder="Masukan harga barang" value="{{ $purchase->purchase_money }}" required>
                    @error('form.purchase_money')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>

    @livewire('components.notification-toast')

    @script
        <script>
            $wire.on('edit-purchase', (detail) => {

                const {
                    type,
                    message
                } = detail[0]
                const toastEl = $('#notification-toast')
                const toastBody = $('#notification-toast .toast-body')

                if (type === 'error') {
                    toastEl.addClass('bg-danger')
                } else {
                    toastEl.removeClass('bg-danger')
                    toastEl.addClass('bg-success')
                }

                const toast = new bootstrap.Toast(toastEl)
                toastBody.text(message)
                toast.show()
            })
        </script>
    @endscript
</div>
