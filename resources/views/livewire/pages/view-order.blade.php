@section('title', 'View Order')

<div class="card">
    <div class="card-header">
        <h3>Detail Order</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-3">
                <h4>Nama Customer</h4>
                <span>{{ $order->customer_name }}</span>
            </div>
            <div class="col-3">
                <h4>Total Bayar</h4>
                <span>Rp. {{ number_format($order->total_payment, thousands_separator: '.') }}</span>
            </div>
            <div class="col-3">
                <h4>Cash</h4>
                <span>Rp. {{ number_format($order->cash_money, thousands_separator: '.') }}</span>
            </div>
            <div class="col-3">
                <h4>Kembalian</h4>
                <span>Rp. {{ number_format($order->change_money, thousands_separator: '.') }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <h4>Pesanan</h4>
                @foreach ($order->order_details as $detail)
                    <div class="row">
                        <span>{{ $detail->product->product_name }} {{ $detail->amount }} Pcs</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
