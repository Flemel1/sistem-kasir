@section('title', 'Daftar Open Bill')

<div>

    <div class="card">
        <h5 class="card-header">Daftar Open Bill</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($orders as $order)
                        <tr wire:key="{{ uniqId('order_') }}">
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('order.create', ['open_bill_id' => $order]) }}"
                                            class="dropdown-item"><i class="bx bx-note me-1"></i>
                                            Tambah Pesanan</a>
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
