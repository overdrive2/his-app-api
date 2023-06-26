<div
    x-data="{
        rooms: [],
        wardId: null,
        value: @entangle($attributes->wire('model')),
        open: false
    }"

    @set-rooms.window="(e) => {
        rooms = e.detail.rooms
        open = true
    }"
    style="display: none;"
    x-show="open"
>
    <div class="flex flex-nowrap gap-2 py-2">
        <template x-for="room in rooms">
            <div
                @click="value = room.id"
                class="p-2 bg-sky-300 dark:text-white rounded-md shadow-sm min-w-max max-w-sm"
                role="button"
                x-text="room.room_name"
            ></div>
        </template>
    </div>
</div>
