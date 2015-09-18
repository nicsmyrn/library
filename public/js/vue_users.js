//(function(){
//    var pusher = new Pusher('5a510c8f7596d923dd50', {
//        encrypted: true
//    });
//    var channel = pusher.subscribe('test');
//    channel.bind('App\\Events\\UserHasRegistered', function(data) {
//        console.log(data);
//    });
//})();

new Vue({
    el: "#users",

    data : {
        sortKey : 'last_name',
        reverse : false,
        search : '',
        fa_icon : '<i class="fa fa-sort-amount-asc"></i>',
        columns : [
            {header : 'last_name', value: 'Επίθετο'},
            {header : 'first_name', value: 'Όνομα'},
            {header : 'username', value: 'Αναγνωριστικό'},
        ],
    },

    ready: function () {
        this.fetchUsers();

        this.pusherSubscribe();
    },

    methods: {
        isActive : function(){
            //sortKey == 'last_name'

        },
        sortBy : function(sortKey){
            this.reverse = (this.sortKey == sortKey) ? !this.reverse : false;
            this.columns.value = this.columns.value + this.fa_icon;
            this.sortKey = sortKey;
        },

        fetchUsers: function () {
            this.$http.get('/users', function (users) {
                this.$set('users', users);
                //this.users.push(this.single);
            });
        },

        pusherSubscribe: function () {
            var pusher = new Pusher('5a510c8f7596d923dd50', {
                encrypted: true
            });
            var channel = pusher.subscribe('test');

            channel.bind('App\\Events\\UserHasRegistered', this.addUser);
        },

        addUser: function (data) {
            this.users.push(data['users'][0]);
        }
    }
});
