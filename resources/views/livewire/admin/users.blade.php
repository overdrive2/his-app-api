<div
    x-data = "{
        edit: (id) => {
            console.log(id)
            Livewire.emit('get:wards', id)
        }
    }">
    @livewire('admin.user-list')

    @livewire('admin.user-wards')
</div>
