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

let $ = require('jquery');

//select2
require('select2');

$('select').select2({
    tags: true,
});

let $contactButton = $('#contactBtn');

$('#contactBtn').on(
    'click', function(){
        $('#contactForm').slideDown();
        $contactButton.slideUp();
    }
)