@section('title', 'Setting')

<div>
    <div class="card">
        <h5 class="card-header">Ganti Password</h5>
        <div class="card-body">
            <form wire:submit="update_password">
                <div class="mb-3">
                    <label for="current_password" class="form-label">Password Lama</label>
                    <input wire:model="current_password" type="password" id="current_password" class="form-control"
                        placeholder="Masukan password lama" required>
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input wire:model="password" type="password" id="password" class="form-control"
                        placeholder="Masukan password baru" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                    <input wire:model="password_confirmation" type="password" id="password_confirmation"
                        class="form-control" placeholder="Masukan konfirmasi password baru" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    @livewire('components.notification-toast')

    @script
        <script>
            $wire.on('password-updated', (detail) => {
                const {
                    type,
                    message
                } = detail[0]
                const toastEl = $('#notification-toast')
                const toastBody = $('#notification-toast .toast-body')

                if (type === 'error') {
                    toastEl.removeClass('bg-success')
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
