<?php

namespace App\Livewire\MasterData;

use App\Livewire\Forms\CreateShiftForm;
use App\Models\Shift;
use Exception;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class EditShift extends Component
{
    public Shift $shift;
    public CreateShiftForm $form;

    public function mount(Shift $shift)
    {
        $this->shift = $shift;
        $this->form->setShift($shift);
    }

    public function update()
    {
        try {
            $isUpdated = $this->form->update($this->shift);

            if ($isUpdated) {
                $this->dispatch('update-shift', [
                    'type' => 'success',
                    'message' => 'Shift Karyawan berhasil diubah'
                ]);
            } else {
                $this->dispatch('update-shift', [
                    'type' => 'error',
                    'message' => 'Shift Karyawan gagal diubah'
                ]);
            }
        } catch (ValidationException $ex) {
            throw $ex;
        } catch (Exception $ex) {

            $this->dispatch('update-shift', [
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.master-data.edit-shift');
    }
}
