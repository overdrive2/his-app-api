import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import 'flowbite';
import './dark-mode';
import './sidebar';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
