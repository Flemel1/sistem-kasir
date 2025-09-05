@section('title', 'Daftar Pembelian')

<div class="card">
    <h5 class="card-header">Daftar Pembelian</h5>
    <a class="ms-auto me-3" href="{{ route('purchase.create') }}" wire:navigate>
        <button type="button" class="btn btn-primary">Tambah</button>
    </a>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($purchases as $purchase)
                    <tr wire:key="{{ uniqId('purchase_item_') }}">
                        <td>{{ $purchase->purchase_item_name }}</td>
                        <td>{{ $purchase->purchase_amount }}</td>
                        <td>Rp. {{ number_format($purchase->purchase_money, thousands_separator: '.') }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('purchase.view', ['purchase' => $purchase]) }}"
                                        class="dropdown-item" wire:navigate><i class="bx bx-note me-1"></i>
                                        Detail</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-2">
        {{ $purchases->links() }}
    </div>
</div>
