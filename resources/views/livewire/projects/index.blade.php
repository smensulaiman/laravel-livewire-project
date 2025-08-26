@php use App\Enum\ProjectStatus;use App\Models\Project; @endphp
<div class="p-4">
    <x-heading-block title="Projects" subtitle="Create and manage your projects."/>

    {{-- button section --}}
    <div class="text-end mb-4">
        <flux:modal.trigger name="project-modal">
            <flux:button wire:click="dispatch('open-project-modal', { mode: 'create', project: [] })" icon="plus-circle" class="cursor-pointer">Add Project</flux:button>
        </flux:modal.trigger>
    </div>

    {{-- table for porject listing --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
        <table class="table-fixed min-w-full text-sm text-left whitespace-nowrap">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">#</th>
                <th scope="col" class="px-6 py-3">
                    <span>Logo</span>
                </th>
                <th scope="col" class="px-6 py-3">Title</th>
                <th scope="col" class="px-6 py-3">Description</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Deadline</th>
                <th scope="col" class="px-6 py-3 w-25 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($projects as $project)
                @if($project instanceof Project)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-semibold"> {{ $loop->iteration }} </td>
                        <td class="px-6 py-4">
                            @if($project->project_logo)
                                <img class="w-16 max-w-full max-h-full rounded-2xl" src="{{ asset('storage/' . $project->project_logo) }}" alt="Project Logo">
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white"> {{ $project->title }} </td>
                        <td class="px-6 py-4"> {{ $project->description }} </td>
                        <td class="px-6 py-4 capitalize">
                            @php
                                $statusClassNames = match ($project->status){
                                    ProjectStatus::PENDING->value => 'bg-yellow-200 text-yellow-900 border border-yellow-300',
                                    ProjectStatus::IN_PROGRESS->value => 'bg-blue-200 text-blue-900 border border-blue-300',
                                    ProjectStatus::CANCELLED->value => 'bg-red-200 text-red-900 border border-red-300',
                                    ProjectStatus::COMPLETED->value => 'bg-green-200 text-green-900 border border-green-300',
                                };
                            @endphp
                            <span @class([$statusClassNames, 'px-3 py-1 rounded shadow-sm'])>
                            {{ $project->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4"> {{ $project->deadline }} </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end items-center gap-2">
                                <flux:modal.trigger name="project-modal">
                                    <flux:button
                                        wire:click="dispatch('open-project-modal', { mode: 'view', project: {{ $project }} })"
                                        icon="eye"
                                        class="cursor-pointer text-xs px-2 py-1 rounded-sm"
                                        variant="primary"
                                        color="slate"
                                        size="sm"
                                    />
                                    <flux:button
                                        wire:click="dispatch('open-project-modal', { mode: 'edit', project: {{ $project }} })"
                                        icon="pencil"
                                        class="cursor-pointer text-xs px-2 py-1 rounded-sm"
                                        variant="primary"
                                        color="indigo"
                                        size="sm"
                                    />
                                </flux:modal.trigger>
                                <flux:modal.trigger name="delete-project">
                                    <flux:button
                                        icon="trash"
                                        class="cursor-pointer text-xs px-2 py-1 rounded-sm"
                                        variant="primary"
                                        color="rose"
                                        size="sm"
                                    />
                                </flux:modal.trigger>
                            </div>
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="7" class="p-6 text-center">
                        <flux:text class="flex items-center justify-center text-red-500">
                            <flux:icon.exclamation-circle class="mr-2"/>
                            No projects found!
                        </flux:text>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $projects->links() }}
    </div>

    {{-- form modal --}}
    <livewire:projects.form-modal/>

    {{-- delete project modal --}}
    <livewire:projects.confirmation-modal/>
</div>
