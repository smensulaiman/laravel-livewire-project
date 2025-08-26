<?php

namespace App\Livewire\Projects;

use Flux\Flux;
use Livewire\Component;

class ConfirmationModal extends Component
{
    public function hideConfirmationDialog(): void
    {
        Flux::modal('delete-project')->close();
    }

    public function render()
    {
        return view('livewire.projects.confirmation-modal');
    }
}
