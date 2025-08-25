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
    <div class="overflow-x-auto border rounded-xl shadow-md">
        <table class="min-w-full table-auto text-sm text-left whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold border-b">
            <tr>
                <th class="p-2 px-4">#</th>
                <th class="p-2">Title</th>
                <th class="p-2">Description</th>
                <th class="p-2">Status</th>
                <th class="p-2">Deadline</th>
                <th class="px-13 py-2 text-center">Logo</th>
                <th class="p-2 px-4 text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($projects as $project)
                @if($project instanceof Project)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-2 px-4"> {{ $loop->iteration }} </td>
                        <td class="p-2"> {{ $project->title }} </td>
                        <td class="p-2"> {{ $project->description }} </td>

                        <td class="p-2 capitalize">
                            @php
                                $statusClassNames = match ($project->status){
                                    ProjectStatus::PENDING->value => 'bg-yellow-200 text-yellow-900 border border-yellow-300',      // Soft matte yellow
                                    ProjectStatus::IN_PROGRESS->value => 'bg-blue-200 text-blue-900 border border-blue-300',        // Cool matte blue
                                    ProjectStatus::CANCELLED->value => 'bg-red-200 text-red-900 border border-red-300',             // Muted matte red
                                    ProjectStatus::COMPLETED->value => 'bg-green-200 text-green-900 border border-green-300',       // Calm matte green
                                };
                            @endphp
                            <span @class([$statusClassNames, 'px-3 py-1 rounded shadow-sm'])>
                            {{ $project->status }}
                            </span>
                        </td>
                        <td class="p-2"> {{ $project->deadline }} </td>
                        <td class="p-2 text-center">
                            @if($project->project_logo)
                                <img class="h-12 w-auto m-auto rounded border" src="{{ asset('storage/' . $project->project_logo) }}" alt="Project Logo">
                            @endif
                        </td>
                        <td class="px-4 text-center">
                            <div class="flex justify-center items-center gap-2">
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

                                <flux:button
                                    icon="trash"
                                    class="cursor-pointer text-xs px-2 py-1 rounded-sm"
                                    variant="primary"
                                    color="rose"
                                    size="sm"
                                />
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
    </div>

    {{-- form modal --}}
    <livewire:projects.form-modal/>
</div>
