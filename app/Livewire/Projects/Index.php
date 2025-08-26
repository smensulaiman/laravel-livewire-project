<?php

namespace App\Livewire\Projects;

use App\Enum\Toaster;
use App\Repositories\ProjectRepository;
use App\Services\ProjectService;
use App\Utils\Constants;
use Flux\Flux;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public ?int $projectId = null;

    public function getAllProjects(): LengthAwarePaginator
    {
        return (new ProjectService(new ProjectRepository()))->getAllProjects()->orderBy('id')->paginate(7);
    }

    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }

    #[On('delete-project')]
    public function deleteProject(ProjectService $projectService): void
    {
        $result = $projectService->deleteProject($this->projectId);

        Flux::modal('delete-project')->close();

        $this->reset();

        if ($result) {
            $this->dispatch(Constants::TOASTER_EVENT_DISPATCH_KEY,
                status: Toaster::SUCCESS,
                title: 'Project Deleted',
                message: 'The project was deleted successfully.',
                options: [
                    'showCloseBtn' => true,
                ],
            );
        } else {
            $this->dispatch(Constants::TOASTER_EVENT_DISPATCH_KEY,
                status: Toaster::FAILED,
                title: 'Failed to delete project',
                message: 'There was an error deleting the project.',
                options: [
                    'showCloseBtn' => true,
                ],
            );
        }
    }

    public function render()
    {
        $projects = $this->getAllProjects();
        return view('livewire.projects.index', compact('projects'));
    }
}
