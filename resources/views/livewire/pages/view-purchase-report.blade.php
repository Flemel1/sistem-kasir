@section('title', 'Detail Pembelian Harian')

<div class="card">
    <div class="card-header">
        <h3>Detail Pembelian Harian</h3>
        <div class="d-flex gap-4">
            <a href="{{ route('purchase.edit', ['purchase' => $purchase]) }}"
                class="btn btn-secondary">Edit</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <h4>Nama Barang</h4>
                <span>{{ $purchase->purchase_item_name }}</span>
            </div>
            <div class="col-4">
                <h4>Jumlah Barang</h4>
                <span>{{ $purchase->purchase_amount }}</span>
            </div>
            <div class="col-4">
                <h4>Harga Barang</h4>
                <span>Rp. {{ number_format($purchase->purchase_money, thousands_separator: '.') }}</span>
            </div>
        </div>
    </div>
</div>
