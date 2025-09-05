@section('title', 'Daftar Pesanan')

<div>

    <div class="card">
        <h5 class="card-header">Daftar Pesanan</h5>
        <a class="ms-auto me-3" href="{{ route('order.create') }}">
            <button type="button" class="btn btn-primary">Buat Pesanan</button>
        </a>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($orders as $order)
                        <tr wire:key="{{ uniqId('order_') }}">
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>Rp. {{ number_format($order->total_payment, thousands_separator: '.') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('order.view', ['order' => $order]) }}"
                                            class="dropdown-item"><i class="bx bx-note me-1"></i>
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
            {{ $orders->links() }}
        </div>
    </div>


</div>
