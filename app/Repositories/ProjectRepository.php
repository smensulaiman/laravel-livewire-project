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
}
