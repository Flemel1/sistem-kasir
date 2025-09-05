<?php

namespace App\Livewire\Forms;

use App\Models\OperationCost;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateOperationCostForm extends Form
{
    #[Validate(rule: 'required|string|max:150')]
    public ?string $cost_name;
    #[Validate(rule: 'required|string')]
    public ?string $cost_description;
    #[Validate(rule: 'required|numeric')]
    public ?string $cost_nominal;

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
