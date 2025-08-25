@php use App\Enum\ProjectStatus; @endphp
<flux:modal name="project-modal" variant="flyout">
    <div class="space-y-6">
        <div>
            <flux:heading class="font-bold" size="lg">{{ $isViewMode ? 'Project Details' : ($projectId ? 'Update' : 'Create') . ' Project' }}</flux:heading>
            <flux:text class="mt-2">Add a new project using the form below.</flux:text>
        </div>

        <form wire:submit="saveProject" class="space-y-6">
            <div class="form-group">
                <flux:input wire:model="title" :disabled="$isViewMode" label="Project Name" placeholder="Enter project name"/>
            </div>

            <div class="form-group">
                <flux:textarea wire:model="description" :disabled="$isViewMode" label="Description" placeholder="Type short description..."
                               rows="3"/>
            </div>

            <div class="form-group">
                <flux:input wire:model="deadline" :disabled="$isViewMode" label="Deadline" type="date"/>
            </div>

            <div class="form-group">
                <flux:select wire:model="status" :disabled="$isViewMode" label="Status" placeholder="Select status...">
                    @foreach(ProjectStatus::cases() as $projectStatus)
                        <flux:select.option value="{{ $projectStatus->value }}">{{ $projectStatus->value }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="form-group">
                @if($isViewMode)
                    <img class="w-100 border rounded-xl" src="{{ $existingImage }}" alt="Project Logo">
                @else
                    @if($logo && !$errors->has('logo'))
                        <img class="w-100 border rounded-xl" src="{{ $logo->temporaryUrl() }}" alt="Project Logo">
                    @elseif($projectId && $existingImage)
                        <img class="w-100 border rounded-xl" src="{{ $existingImage }}" alt="Project Logo">
                    @endif
                    <flux:input wire:model="logo" :hidden="$isViewMode" class="cursor-pointer" type="file"
                                label="Project Logo" accept="image/*"
                                placeholder="Please add project logo"/>
                @endif
            </div>

            <div class="flex gap-2">
                <flux:spacer/>

                <flux:modal.close>
                    <flux:button :hidden="$isViewMode" class="cursor-pointer" variant="danger" wire:click="closeModal">Cancel</flux:button>
                </flux:modal.close>

                <flux:button :hidden="$isViewMode" class="cursor-pointer" type="submit" variant="primary"><?= $projectId ? 'Update' : 'Save'?> Project</flux:button>
            </div>
        </form>
    </div>
</flux:modal>
