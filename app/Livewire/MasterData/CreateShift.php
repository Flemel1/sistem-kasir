<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateShiftForm;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CreateShift extends Component
{
    public CreateShiftForm $form;

    public function save(): void
    {
        try {
            $isCreated = $this->form->store();

            if ($isCreated) {
                $this->dispatch('create-shift', [
                    'type' => 'success',
                    'message' => 'Shift Karyawan berhasil dibuat'
                ]);
            } else {
                $this->dispatch('create-shift', [
                    'type' => 'error',
                    'message' => 'Shift Karyawan gagal dibuat'
                ]);
            }
        } catch (ValidationException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            $this->dispatch('create-shift', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.create-shift');
    }
}
