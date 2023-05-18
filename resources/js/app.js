import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import './theme';

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
window.Datepicker = Datepicker;
window.Timepicker = Timepicker;

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

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
