class Notification
{
    notify(message, type) {
        new Noty({
            layout: 'topRight',
            type: type,
            progressBar: true,
            text: message,
            timeout: 2000
        }).show();
    }
}

export default Notification = new Notification;