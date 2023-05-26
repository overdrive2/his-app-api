import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import './theme';
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'

import {
    Datepicker,
    Input,
    Select,
    Ripple,
    initTE,
    Collapse,
    Dropdown,
    Sidenav,
    Button,
    Modal,
    Timepicker
} from "tw-elements";

initTE({ Datepicker, Select, Input, Ripple, Collapse, Dropdown, Sidenav, Button, Modal, Timepicker});

window.Modal = Modal;
window.Input = Input;
window.Datepicker = Datepicker;
window.Timepicker = Timepicker;
window.Swal = Swal;

const sidenav = document.getElementById("sidenav-main");
const sidenavInstance = Sidenav.getInstance(sidenav);

let innerWidth = null;

const setMode = (e) => {
  // Check necessary for Android devices
  if (window.innerWidth === innerWidth) {
    return;
  }

  innerWidth = window.innerWidth;

  if (window.innerWidth < sidenavInstance.getBreakpoint("sm")) {
    sidenavInstance.changeMode("over");
    sidenavInstance.hide();
  } else {
    sidenavInstance.changeMode("side");
    sidenavInstance.show();
  }
};

if (window.innerWidth < sidenavInstance.getBreakpoint("sm")) {
  setMode();
}

// Event listeners
window.addEventListener("resize", setMode);

window.addEventListener('toastify', event => {
    Swal.fire(
        'Good job!',
        'You clicked the button!',
        'success'
    )
})

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
