@section('title', 'Detail Biaya Operasional')

<div class="card">
    <div class="card-header">
        <h3>Detail Biaya Operasional</h3>
        <div class="d-flex gap-4">
            <a href="{{ route('operation-cost.edit', ['cost' => $cost]) }}"
                class="btn btn-secondary">Edit</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <h4>Nama Kebutuhan</h4>
                <span>{{ $cost->cost_name }}</span>
            </div>
            <div class="col-4">
                <h4>Deskripsi Kebutuhan</h4>
                <span>{{ $cost->cost_description }}</span>
            </div>
            <div class="col-4">
                <h4>Biaya Operasional</h4>
                <span>Rp. {{ number_format($cost->cost_nominal, thousands_separator: '.') }}</span>
            </div>
        </div>
    </div>
</div>
