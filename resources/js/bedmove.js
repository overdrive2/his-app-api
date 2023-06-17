export const bedMoveProps = {
    errors: [],
    beds: [],
    rooms: [],
}

export const nurseListProps = {
    rooms:[],
    beds:[],
    errors:[],
    page: 1,
    loading: false,
    ipd: {
        hn: '',
        an: ''
    },
    setPage:(page, idx) => {
        page = idx
        window.Livewire.emit('set:page', idx)
    },
    setLoading: () => {
        loading = false;
    }
}

export const newCaseModal = {
    show:(ipd, rooms, beds, e) => {
        ipd = e.detail.ipd;
        rooms = e.detail.rooms;
        beds = e.detail.beds;
        setTimeout(async ()=> {
            let event = new Event('swal:close')
            await dispatchEvent(event)
            ncModal.show();
        }, 800)
    },
    hide:() => {
        window.Livewire.emit('refresh:newcase');
        ncModal.hide();
    }
}

export default { nurseListProps, bedMoveProps, newCaseModal };
