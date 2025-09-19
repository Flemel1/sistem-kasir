@section('title', 'Edit Shift')

<div>
    <div class="card">
        <h5 class="card-header">Edit Shift</h5>

        <form wire:submit="update">
            <div class="card-body">
                <div class="mb-3">
                    <label for="employee_name" class="form-label">Nama Karyawan</label>
                    <input wire:model="form.employee_name" type="text" id="employee_name" class="form-control"
                        placeholder="Masukan nama karyawan" value="{{ $form->employee_name }}" required>
                    @error('form.employee_name')
                        <span class="text-danger">{{ $message }} </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <p class="form-label">Jadwal Shift</p>
                    <label for="senin">
                        <input type="checkbox" wire:model="form.shifts" id="senin" value="senin"> Senin
                    </label><br>

                    <label for="selasa">
                        <input type="checkbox" wire:model="form.shifts" id="selasa" value="selasa"> Selasa
                    </label><br>

                    <label for="rabu">
                        <input type="checkbox" wire:model="form.shifts" id="rabu" value="rabu"> rabu
                    </label><br>

                    <label for="kamis">
                        <input type="checkbox" wire:model="form.shifts" id="kamis" value="kamis"> Kamis
                    </label><br>

                    <label for="jumat">
                        <input type="checkbox" wire:model="form.shifts" id="jumat" value="jumat"> Jum'at
                    </label><br>

                    <label for="sabtu">
                        <input type="checkbox" wire:model="form.shifts" id="sabtu" value="sabtu"> Sabtu
                    </label><br>

                    <label for="minggu">
                        <input type="checkbox" wire:model="form.shifts" id="minggu" value="minggu"> Minggu
                    </label><br>
                    @error('form.shifts')
                        <span class="text-danger">{{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>


    @livewire('components.notification-toast')

    @script
        <script>
            $wire.on('update-shift', (detail) => {
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

                if (type !== 'error') {
                    window.location.href = '/master-data/shift'
                }
            })
        </script>
    @endscript
</div>
