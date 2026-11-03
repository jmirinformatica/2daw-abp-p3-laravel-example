import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/** 
 * TW Elements
 * @see https://tw-elements.com/docs/standard/integrations/laravel-integration/
 */ 
import { Dropdown, Ripple, initTWE } from "tw-elements";

initTWE({ Dropdown, Ripple });

/**
 * Flowbite
 * @see https://flowbite.com/docs/getting-started/laravel/
 */
import 'flowbite';