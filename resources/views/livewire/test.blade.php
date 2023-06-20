<div>
    <div class="content-center">
        @foreach ($options as $key => $item)
        <div class="border-b w-full max-w-sm text-left">
            <input type="checkbox" value="{{ $key }}" wire:model="selected"> {{ $item }}
        </div>
        @endforeach
        <div class="text-left mt-4">
            <span role="button" class="border p-2 bg-gray-100" wire:click="save">Save</span>
        </div>
    </div>
</div>
