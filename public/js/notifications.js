$(document).ready(function() {
    OneSignal.isPushNotificationsEnabled(function(isEnabled) {
        if (isEnabled) {
            OneSignal.getUserId( function(userId) {
                $('body').data('notification-id', userId);
            });
        }
        else {
            $('.notification-toggle').prop('disabled', true);
        }
    });
});

function bindNotificationToggles() {
    var subscribedEvents = getEventSubscriptions();
    subscribedEvents.forEach(function(event) {
        console.log($('.notification-toggle[data-event-id='+event+']'));
        $('.notification-toggle[data-event-id='+event+']').closest('label').button('toggle');
        $('.notification-toggle[data-event-id='+event+']').prop('checked', true);
    });
    $('.notification-toggle').change(refreshSubscriptionState);
}

function refreshSubscriptionState() {
    var isPushSupported = OneSignal.isPushNotificationsSupported();
    if(isPushSupported === false) {
        alert('Notifications are supported on most platforms except those without support for Service Workers. You seem to be using one of the unsupported platforms (probably iOS).');
        return;
    }
    var subscribedEvents = [];
    $('.notification-toggle').each(function(item) {
        if($(this).prop("checked")) {
            subscribedEvents.push($(this).data('event-id'));
        }
    });
    setEventSubscriptions(subscribedEvents);
    syncWithBackend();
}

function setEventSubscriptions(subscribedEvents) {
    localStorage.setItem('eventSubscriptions', JSON.stringify(subscribedEvents));
}

function getEventSubscriptions() {
    if(localStorage.getItem('eventSubscriptions') === null) {
        return [];
    }
    return JSON.parse(localStorage.getItem('eventSubscriptions'));
}

function syncWithBackend() {
    var subscribedEvents = getEventSubscriptions();
    $.ajax({
        url: "/notifications/subscribe",
        type: "post",
        data: {
            playerId: $('body').data('notification-id'),
            events: subscribedEvents
        },
    });
}

