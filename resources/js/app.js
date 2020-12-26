/*
 * Import dependencies
 */

require('./bootstrap');
require('bootstrap-select');

import bsCustomFileInput from 'bs-custom-file-input';


/*
 * Notifications
 */

/**
 * Marks all notifications in dropdown as read
 *
 * @return void
 */
window.markAllRead = function()
{
    // mark read in the backend
    $.get('/notifications/mark-all-read');
    // Remove all elements in dropdown, except the first 4 (buttons and hidden no notification <li>)
    $('#notificationDropdownMenu').children().slice(4).remove();

    // reset count and hide it
    $('#notify-count').text('');
    $('#notify-count').attr('hidden', true);

    // hide the mark all read button
    $('#markAllRead').addClass('d-none');
    // show the no notifications dropdown item
    $('#noNotifications').removeClass('d-none');
};

/**
 * Removes a specified notification from the dropdown
 *
 * @param  {int}    id  ID of notification
 *
 * @return void
 */
window.removeNotification = function(id)
{
    // remove the notification wrapper <div>
    $(`#${id}`).remove();

    // decrement count
    var count = $('#notify-count').text();
    count--;
    $('#notify-count').text(count);

    // if count now 0, reset and hide it
    if ($('#notify-count').text() == 0) {
        $('#notify-count').text('');
        $('#notify-count').addClass('d-none');
    }

    if ($('#notificationDropdownMenu').children().length <= 3) {
        $('#noNotifications').removeClass('d-none');
        $('#markAllRead').addClass('d-none');
    }
    $.get(`/notifications/${id}`);
};

/**
 * Determines the appropriate page for the notification clicked, then redirects to it
 *
 * @param  {[type]} id           [description]
 * @param  {[type]} notification [description]
 * @return {[type]}              [description]
 */
window.viewNotification = function(id, notification)
{
    // call removeNotification() on the notification
    removeNotification(id);

    // redirect as appropriate
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

/**
 * Adds a notification to the dropdown with the given
 *
 * @param {int}     id              ID of the ???
 * @param {string}  notification    Text the notification should contain
 *
 * @return void
 */
window.addNotification = function(id, notification)
{
    if (!$('#noNotifications').hasClass('d-none')) {
        // hide the no notifications item
        $('#noNotifications').addClass('d-none');
        // show the mark all as read button
        $('#markAllRead').removeClass('d-none');
    }

    // create the wrapper for the divider and notification <li>
    $('<div/>', {'id': id}).append(
        // add a new dropdown divider div above the notification
        $('<div/>', {'class': 'dropdown-divider'})
    ).append(
        // add the notification dropdown <li>
        $('<li/>', {'class': 'dropdown-item', 'id': id,}).append(
            $('<button />', {
                'html': notification.text,
                'onclick': `viewNotification('${id}', ${JSON.stringify(notification)})`,
                'class': 'btn',
                'type': 'button'
            })
        // add the button to remove the notification to the <li>
        ).append(
            $('<button/>', {
                'type': 'button',
                'class': 'btn',
                'onclick': `removeNotification('${id}')`,
            }).append(
                // uses unicode char for close icon
                $('<span/>', {'aria-hidden': 'true'}).html('&#9587;')
            )
        )
    // add notification <li> to dropdown
    ).appendTo('#notificationDropdownMenu');

    // increment, update and ensure the notification count is shown
    var count = $('#notify-count').text();
    count++;
    $('#notify-count').text(count);
    $('#notify-count').addClass('d-none');
};

/**
 * Shows a toast for a new notification.
 *     Also calls addNotification() to add the notification to the dropdown list
 *
 * @param  {int}    id
 * @param  {string} notification    Object containing notification data
 *
 * @return void
 */
window.newNotification = function(id, notification)
{
    // create and append a toast to the container (see ../views/layouts/base.blade.php)
    $('#notification-div').append(
        $('<div/>', {'class': 'toast', 'data-autohide': 'true', 'data-delay': '5000', 'id': id}).append(
            $('<div/>', {'class': 'toast-header'}).append(
                $('<strong/>', {'class': 'mr-auto'}).text(notification.title)
            ).append(
                $('<small/>').text('Just now')
            ).append(
                // close button for toast (in case user is incredibly impatient lol)
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

    // call the toast up to the view
    $(`#${id}`).toast('show');
    // call addNotification() to add a dropdown item to the list
    addNotification(id, notification);
};


/*
 * Set up zulu time display
 */
var moment = require('moment');
/**
 * Sets the value attribute of an element with the id 'time' to the current zulu time
 *
 * @return void
 */
function updateTime()
{
    $('#time').html(moment.utc().format('HH:mm') + " Z");
    $('#time-local').html(moment().format('HH:mm') + " L");
};


$(document).ready(function()
{
    // start automatic update of time display
    updateTime();
    if ($('#time').length) {
        setInterval(updateTime, 60000);
    }

    $('#logoutFormSubmit').click(function() {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    });

    // initialise any file input placeholders via plugin
    bsCustomFileInput.init();

    // show notification count where > 0
    if ($('#notify-count').text() > 0) {
        $('#notify-count').removeClass('d-none');
    }
});
