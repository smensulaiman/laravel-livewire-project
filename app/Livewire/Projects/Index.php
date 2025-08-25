<?php

namespace App\Livewire\Projects;

use App\Services\ProjectService;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected ProjectService $projectService;

    public function mount(ProjectService $ps): void
    {
        $this->projectService = $ps;
    }

    public function getAllProjects()
    {
        return $this->projectService->getAllProjects();
    }

    public function render()
    {
        $projects = $this->projectService->getAllProjects()->orderBy('id')->paginate(5);
        return view('livewire.projects.index', compact('projects'));
    }
}
