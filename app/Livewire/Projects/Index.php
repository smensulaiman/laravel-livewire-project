<?php

namespace App\Livewire\Projects;

use App\Repositories\ProjectRepository;
use App\Services\ProjectService;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function getAllProjects(): LengthAwarePaginator
    {
        return (new ProjectService(new ProjectRepository()))->getAllProjects()->orderBy('id')->paginate(5);
    }

    public function render()
    {
        $projects = $this->getAllProjects();
        return view('livewire.projects.index', compact('projects'));
    }
}
