/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import { Tooltip, Toast, Popover } from 'bootstrap';

var $ = require('jquery');

// utilisation du plugin 'select2' sur tous les select
require('select2')
$('select').select2()

// animation de formulaire de contact sur la vue d'un bien détaillé (show.html.twig)
let $contactButton = $('#contactButton');
$contactButton.click(e => {
    e.preventDefault();
    $('#contactForm').slideDown();
    $contactButton.slideUp();
})

let $cancelButton = $('#cancelButton');
$cancelButton.click(e => {
    e.preventDefault();
    $('#contactForm').slideUp();
    $contactButton.slideDown();
})