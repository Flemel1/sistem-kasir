@section('title', 'Produk Tambahan')

<div class="card">
    <div class="card-header">
        <h3>Detail Produk Tambahan</h3>
        <div class="d-flex gap-4">
            <a href="{{ route('master-data.group-product.edit', ['group' => $group]) }}" class="btn btn-secondary" wire:navigate>Edit</a>
            <button wire:click="delete" type="button" class="btn btn-danger">Hapus</button>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-3">
                <h4>Nama</h4>
                <span>{{ $group->group_name }}</span>
            </div>
            <div class="col-3">
                <h4>Pilihan Lebih Dari 1</h4>
                <span>{{ $group->is_multiple ? 'Ya' : 'Tidak' }}</span>
            </div>
            <div class="col-3">
                <h4>Optional</h4>
                <span>{{ $group->is_optional ? 'Ya' : 'Tidak' }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4>Item</h4>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Item</th>
                                <th>Harga Item</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($group->items as $item)
                                <tr>
                                    <td>{{ $item['item_name'] }}</td>
                                    <td>Rp. {{ number_format($item['item_price'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @livewire('components.notification-toast')

    @script
        <script>
            $wire.on('delete-group-product', (detail) => {
                const { type, message } = detail[0]
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
                    Livewire.navigate('/master-data/grup-produk')
                }
            })
        </script>
    @endscript
</div>
