new Vue({
    el: "#navigation-bar",

    data : {
    },

    ready: function () {
        this.fetchNotifications();
        this.pusherSubscribe();
    },

    methods: {
        pusherSubscribe: function () {
            var pusher = new Pusher('5a510c8f7596d923dd50', {
                encrypted: true
            });
            var subscription = 'notification-' + $("#auth_id").val();
            var channel = pusher.subscribe(subscription);

            channel.bind('App\\Events\\BookHasCreated', this.sendNotification);
        },

        fetchNotifications: function () {
            this.$http.get('http://library.gr/notifications', function (notifications) {
                this.$set('notify', notifications);
            });
        },
        sendNotification: function (data) {
            if (this.notify){
                this.notify.push({text: data['text'], created_on: data['time'], url: data['url'], unread: data['unread'], barcode : data['barcode']})
            }else{
                this.$set('notify', [{text: data['text'], created_on: data['time'], url: data['url'], unread: data['unread'], barcode : data['barcode']}]);
            }
        },
        addUser: function (data) {
            this.users.push(data['users'][0]);
        },

        isUnread: function (unread, barcode){
            unread = !unread;
            this.$http.get('http://library.gr/notification/makeRead/'+barcode);
        }

    }
});
