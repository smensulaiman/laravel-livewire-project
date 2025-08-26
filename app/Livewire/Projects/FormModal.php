<?php

namespace App\Livewire\Projects;

use App\Enum\ProjectStatus;
use App\Enum\Toaster;
use App\Models\Project;
use App\Services\ProjectService;
use App\Utils\Constants;
use Flux\Flux;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class FormModal extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:100')]
    public ?string $title = null;

    #[Validate('required|string|max:255')]
    public ?string $description = null;

    #[Validate('required|string')]
    public string $status = ProjectStatus::PENDING->value;

    #[Validate('required|string')]
    public ?string $deadline = null;

    #[Validate('nullable|image|max:2048')]
    public ?TemporaryUploadedFile $logo = null;

    public ?int $projectId = null;
    public bool $isViewMode = false;
    public ?string $existingImage = null;

    public function closeModal(): void
    {
        Flux::modal('project-modal')->close();
    }

    public function insertOrUpdateProject(ProjectService $projectService): Project
    {
        $validatedData = $this->validate();

        if ($this->projectId) {
            $project = $projectService->updateProject($this->projectId, $validatedData);
        } else {
            $project = $projectService->storeProject($validatedData);
        }

        $this->reset();

        Flux::modal('project-modal')->close();

        $this->dispatch(Constants::TOASTER_EVENT_DISPATCH_KEY,
            status: Toaster::SUCCESS,
            title: 'Project Saved',
            message: 'The project was saved successfully.',
            options: [
                'showCloseBtn' => true,
            ],
        );

        return $project;
    }

    #[NoReturn]
    #[On('open-project-modal')]
    public function projectDetails($mode, $project): void
    {
        $this->isViewMode = $mode === 'view';

        if ($mode === 'create') {
            $this->isViewMode = false;
            $this->reset();
        } else {
            $this->projectId = $project['id'];
            $this->title = $project['title'];
            $this->description = $project['description'];
            $this->status = $project['status'];
            $this->deadline = $project['deadline'];
            $this->existingImage = $project['project_logo'];
        }
    }

    public function render()
    {
        return view('livewire.projects.form-modal');
    }
}
