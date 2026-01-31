<?php

namespace App\Livewire\Forms;

use App\Models\Shift;
use Livewire\Form;

class CreateShiftForm extends Form
{
    public string $employee_name;

    public array $shifts;

    public function rules(): array
    {
        return [
            'employee_name' => 'required|string|min:1|max:150',
            'shifts' => 'required|array',
            'shifts.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'employee_name.required' => 'Nama pegawai wajib diisi',
            'employee_name.min' => 'Nama pegawai minimal 1 karakter',
            'employee_name.max' => 'Nama pegawai maksimal 150 karakter',
            'shifts.required' => 'Jadwal wajib diisi',
            'shifts.*.string' => 'Jadwal harus berupa string',
        ];
    }

    public function setShift(Shift $shift): void
    {
        $this->employee_name = $shift->employee_name;
        $this->shifts = $shift->shift;
    }

    public function store(): bool
    {
        $this->validate();

        $shift = Shift::create([
            'employee_name' => $this->employee_name,
            'shift' => $this->shifts
        ]);

        if ($shift) {

            return true;
        }

        return false;
    }

    public function update(Shift $shift): bool
    {
        $this->validate();

        $shift = $shift->update([
            'employee_name' => $this->employee_name,
            'shift' => $this->shifts
        ]);

        if ($shift) {
            return true;
        }

        return false;
    }
}
