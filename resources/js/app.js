/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-select');

import bsCustomFileInput from 'bs-custom-file-input';

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });

/*
 * Notifications
 */
window.markAllRead = function() {
    $.get('/notifications/mark-all-read');
    $('#notificationDropdownMenu').children().slice(2).remove();
    $('#notify-count').text('');
    $('#noNotifications').removeClass('d-none');
    $('#markAllRead').addClass('d-none');
};

window.removeNotification = function(id) {
    if ($(`#${id}`).index() === 1) {
        $(`#${id}`).next().remove();
    } else {
        $(`#${id}`).prev().remove();
    }

    $(`#${id}`).remove();

    var count = $('#notify-count').text();
    count--;
    $('#notify-count').text(count);

    if ($('#notify-count').text() == 0) {
        $('#notify-count').text('');
        $('#notify-count').attr('hidden', true);
    }

    if ($('#notificationDropdownMenu').children().length <= 3) {
        $('#noNotifications').removeClass('d-none');
        $('#markAllRead').addClass('d-none');
    }
    $.get(`/notifications/${id}`);
};

window.viewNotification = function(id, notification) {
    removeNotification(id);
    switch (notification.title) {
        case 'Request Accepted':
            window.location.href = `/flights/${notification.flight.id}`;
            break;
        case 'Flight Plan Accepted':
            window.location.href = `/dispatch/${notification.plan_id}`;
            break;
        case 'Flight Plan Rejected':
            window.location.href = `/flights/${notification.flight_id}`;
            break;
        default:
            break;
    }
};

window.newNotification = function(id, notification) {
    $('#notification-div').append(
        $('<div/>', {'class': 'toast', 'data-autohide': 'true', 'data-delay': '5000', 'id': id}).append(
            $('<div/>', {'class': 'toast-header'}).append(
                $('<strong/>', {'class': 'mr-auto'}).text(notification.title)
            ).append(
                $('<small/>').text('Just now')
            ).append(
                $('<button/>', {
                    'type': 'button',
                    'class': 'ml-2 mb-1 close',
                    'data-dismiss': 'toast',
                    'aria-label': 'Close'
                    }).append(
                        $('<span/>', {'aria-hidden': 'true'}).html('&times;')
                    )
            )
        ).append(
            $('<div/>', {'class': 'toast-body'}).text(notification.text)
        )
    );
    $(`#${id}`).toast('show');
    addNotification(id, notification);
};

window.addNotification = function(id, notification) {
    $('#noNotifications').addClass('d-none');
    $('#markAllRead').removeClass('d-none');

    if ($('#notificationDropdownMenu').children().length >= 2 ) {
        $('<div/>', {'class': 'dropdown-divider'}).appendTo('#notificationDropdownMenu');
    }
    $('<li/>', {'class': 'dropdown-item', 'id': id,}).append(
        $('<button />', {
            'html': notification.text,
            'onclick': `viewNotification('${id}', ${JSON.stringify(notification)})`,
            'class': 'btn',
            'type': 'button'
        })
    ).append(
        $('<button/>', {
            'type': 'button',
            'class': 'btn',
            'onclick': `removeNotification('${id}')`,
            }).append(
                $('<span/>', {'aria-hidden': 'true'}).html('&#9587;')
            )
    ).appendTo('#notificationDropdownMenu');
    var count = $('#notify-count').text();
    count++;
    $('#notify-count').text(count);
    $('#notify-count').attr('hidden', false);
};

/*
 * Set up zulu time display
 */
var moment = require('moment');
/**
 * Sets the value attribute of an element with the id 'time' to the current
 * zulu time
 *
 * @return void
 */
function updateTime() {
    $('#time').attr('value', moment.utc().format('HH:mm') + " Z");
};

$(document).ready(function() {
    updateTime();
    if ($('#time').length) {
        setInterval(updateTime, 60000);
    }

    bsCustomFileInput.init();

    if ($('#notify-count').text() < 1) {
        $('#notify-count').attr('hidden', true);
    }
});
