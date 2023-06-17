<div
    x-data="{
        rooms: [],
        value: null,
        open: false,
        setBed: (room_id) =>  {
            $wire.setBeds(room_id)
        }
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
            <div class="p-2 bg-blue-600 text-white rounded-md shadow-sm min-w-max max-w-sm" role="button" x-on:click="setBed(room.id)" x-text="room.room_name"></div>
        </template>
    </div>
</div>
