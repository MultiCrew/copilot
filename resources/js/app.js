/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-select');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$(document).ready(function() {
    $.get('/notifications', function(data) {
        for (const notification of data) {
            const nData = notification.data;
            addNotification(notification.id, nData);
        }
    });
    window.Echo.private(`App.Models.Users.User.${Laravel.userId}`).notification((notification) => {
        newNotification(notification.id, notification);
    });

    if ($('#time').length) {
        setInterval(updateTime, 1000);
    }
});

var moment = require('moment');
updateTime = function() {
    $('#time').attr('value', moment.utc().format('HH:mm') + " Z");
};

window.markAllRead = function() {
    $.get('/notifications/mark-all-read');
    $('#notificationDropdownMenu').children().slice(2).remove();
    $('#notify-count').text('');
    $('#noNotifications').removeAttr('hidden');
    $('#markAllRead').attr('hidden', 'hidden');
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
    }
    if ($('#notificationDropdownMenu').children().length <= 2) {
        $('#noNotifications').removeAttr('hidden');
        $('#markAllRead').attr('hidden', 'hidden');
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
        $('<div/>', {'class': 'toast', 'data-autohide': 'false', 'id': id}).append(
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
    if ($('#notificationDropdownMenu').children().length <= 2 && $('#noNotifications').not("hidden")) {
        $('#noNotifications').attr('hidden', 'hidden');
        $('#markAllRead').removeAttr('hidden');
    }
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
            'class': 'btn btn-sm',
            'onclick': `removeNotification('${id}')`,
            }).append(
                $('<span/>', {'aria-hidden': 'true'}).html('&times;')
            )
    ).appendTo('#notificationDropdownMenu');
    var count = $('#notify-count').text();
    count++;
    $('#notify-count').text(count);
};
