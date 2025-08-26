<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Str;

class ProjectService
{
    /**
     * Create a new class instance.
     */
    public function __construct(public ProjectRepository $projectRepository)
    {
    }

    public function storeProject(array $projectRequest): Project
    {
        if(!empty($projectRequest['logo'])){
            /**
             * @var TemporaryUploadedFile $projectLogo
             */
            $projectLogo = $projectRequest['logo'];

            # Upload project logo
            $projectLogoPath = $projectLogo->store('projects', 'public');
            $projectRequest['project_logo'] = $projectLogoPath;
        }

        $projectRequest['slug'] = Str::slug($projectRequest['title']);

        return $this->projectRepository->storeProject($projectRequest);
    }

    public function updateProject(int $projectId, array $projectRequest): ?Project
    {
        $existingProject = $this->getAllProjects()->orderByDesc('id')->find($projectId)->first();

        if(!$existingProject){
            return null;
        }

        if(!empty($projectRequest['logo'])){
            /**
             * @var TemporaryUploadedFile $projectLogo
             */
            $projectLogo = $projectRequest['logo'];

            # Upload project logo
            $projectLogoPath = $projectLogo->store('projects', 'public');
            $projectRequest['project_logo'] = $projectLogoPath;

            if($existingProject->project_logo && Storage::exists($existingProject->project_logo)){
                Storage::delete($existingProject->project_logo);
            }
        }

        $projectRequest['slug'] = Str::slug($projectRequest['title']);

        return $this->projectRepository->updateProject($existingProject, $projectRequest);
    }

    public function getAllProjects(): Builder
    {
        return $this->projectRepository->getProjectQuery();
    }

    public function deleteProject(int $projectId): bool
    {
        return $this->projectRepository->deleteProject($projectId);
    }
}
