import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import 'flowbite';
import './dark-mode';
import './sidebar';
import { Select, Ripple, initTE, Input } from "tw-elements";

initTE({ Select, Input, Ripple});

window.Alpine = Alpine;
Alpine.plugin(focus);

Alpine.start();
