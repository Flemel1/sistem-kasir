@section('title', 'Daftar Biaya Operasional')

<div>
    <div class="card">
        <h5 class="card-header">Daftar Biaya Operasional</h5>
        <a class="ms-auto me-3" href="{{ route('operation-cost.create') }}" wire:navigate>
            <button type="button" class="btn btn-primary">Tambah</button>
        </a>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Kebutuhan</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($costs as $cost)
                        <tr wire:key="{{ uniqId('operation-cost_') }}">
                            <td>{{ $cost->cost_name }}</td>
                            <td>Rp. {{ number_format($cost->cost_nominal, thousands_separator: '.') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('operation-cost.view', ['cost' => $cost]) }}"
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
            {{ $costs->links() }}
        </div>
    </div>
</div>
