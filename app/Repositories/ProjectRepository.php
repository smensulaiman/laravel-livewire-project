<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;

class ProjectRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    /**
     * @param array $projectData
     * @return Project
     */
    public function storeProject(array $projectData): Project
    {
        return Project::create($projectData);
    }

    /**
     * @return Builder
     */
    public function getProjectQuery(): Builder
    {
        return Project::query();
    }

    public function updateProject(Project $existingProject, array $projectRequest): Project
    {
       $existingProject->update($projectRequest);
       return Project::query()->findOrFail($existingProject->id);
    }

    public function deleteProject(int $projectId): bool
    {
        $project = Project::query()->findOrFail($projectId);
        return $project->delete();
    }
}
