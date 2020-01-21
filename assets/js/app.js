import Places from 'places.js'
import Map from './modules/map'
import 'slick-carousel'
import 'slick-carousel/slick/slick.css'
import 'slick-carousel/slick/slick-theme.css'

Map.init()

let inputAddress = document.querySelector('#restaurant_address');
if (inputAddress !== null) {
    let place = Places({
        container: inputAddress
    });
    place.on('change', e => {
        document.querySelector('#restaurant_city').value = e.suggestion.city;
        document.querySelector('#restaurant_postal_code').value = e.suggestion.postcode;
        document.querySelector('#restaurant_lat').value = e.suggestion.latlng.lat;
        document.querySelector('#restaurant_lng').value = e.suggestion.latlng.lng
    })
}

let searchAddress = document.querySelector('#search_address');
if (searchAddress !== null) {
    let place = Places({
        container: searchAddress
    });
    place.on('change', e => {
        document.querySelector('#lat').value = e.suggestion.latlng.lat;
        document.querySelector('#lng').value = e.suggestion.latlng.lng
    })
}

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

/// app.js

const $ = require('jquery');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
require('@fortawesome/fontawesome-free/js/all');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

let $contactButton = $('#contactButton');
$contactButton.click(e => {
    e.preventDefault();
    $('#contactForm').slideDown();
    $contactButton.slideUp();
});

$('[data-slider]').slick({
    dots: true,
    arrows: true
});

//suppression des elements
document.querySelectorAll('[data-delete]').forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        fetch(a.getAttribute('href'), {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'

            },
            body: JSON.stringify({'_token': a.dataset.token})
        }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    a.parentNode.parentNode.removeChild(a.parentNode)
                } else {
                    alert(data.error)
                }
            })
            .catch(e => alert(e))
    })
});

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
