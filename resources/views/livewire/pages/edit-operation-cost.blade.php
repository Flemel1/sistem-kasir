@section('title', 'Edit Biaya Operasional')

<div>
    <form wire:submit="update">
        <div class="card">
            <h5 class="card-header">Edit Biaya Operasional</h5>

            <div class="card-body">
                <div class="mb-3">
                    <label for="cost_name" class="form-label">Nama Kebutuhan</label>
                    <input wire:model="form.cost_name" type="text" id="cost_name" class="form-control"
                        placeholder="Masukan nama barang" required>
                    @error('form.cost_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="cost_description" class="form-label">Deskripsi Kebutuhan</label>
                    <input wire:model="form.cost_description" type="text" id="cost_description" class="form-control"
                        placeholder="Masukan jumlah barang" required>
                    @error('form.cost_description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="cost_nominal" class="form-label">Nominal Kebutuhan</label>
                    <input wire:model="form.cost_nominal" type="text" id="cost_nominal" class="form-control"
                        placeholder="Masukan harga barang" required>
                    @error('form.cost_nominal')
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
            $wire.on('edit-operation-cost', (detail) => {

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
