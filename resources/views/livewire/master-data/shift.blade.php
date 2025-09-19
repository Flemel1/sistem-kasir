<div>
    @section('title', 'Daftar Shift Karyawan')
    <div class="card">
        <h5 class="card-header">Daftar Shift Karyawan</h5>
        <a class="ms-auto me-3" href="{{ route('master-data.shift.create') }}" wire:navigate>
            <button type="button" class="btn btn-primary">Tambah Shift</button>
        </a>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Karyawan</th>
                        <th>Shift</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($shifts as $shift)
                        <tr>
                            <td>{{ $shift->employee_name }}</td>
                            <td>
                                <ol>
                                    @foreach ($shift->shift as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ol>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('master-data.shift.edit', ['shift' => $shift]) }}"
                                            class="dropdown-item" wire:navigate><i class="bx bx-note me-1"></i>
                                            Edit</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

        <div class="p-2">
            {{ $shifts->links() }}
        </div>
    </div>
</div>
