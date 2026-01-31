<?php

namespace App\Livewire\Forms;

use App\Models\OperationCost;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateOperationCostForm extends Form
{
    public ?string $cost_name;

    public ?string $cost_description;

    public ?string $cost_nominal;

    public function rules(): array
    {
        return [
            'cost_name' => 'required|string|max:150',
            'cost_description' => 'required|string',
            'cost_nominal' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'cost_name.required' => 'Nama wajib diisi',
            'cost_name.max' => 'Nama maksimal 150 karakter',
            'cost_description.required' => 'Deskripsi wajib diisi',
            'cost_nominal.required' => 'Nominal wajib diisi',
            'cost_nominal.numeric' => 'Nominal harus berupa angka',
        ];
    }


    public function setOperationCost(OperationCost $cost)
    {
        $this->cost_name = $cost->cost_name;
        $this->cost_description = $cost->cost_description;
        $this->cost_nominal = $cost->cost_nominal;
    }

    public function save()
    {
        $this->validate();

        $operationCost = OperationCost::create($this->all());

        if ($operationCost) {
            return true;
        }

        return false;
    }

    public function update(OperationCost $cost)
    {
        $this->validate();

        $cost->update($this->all());
    }
}
