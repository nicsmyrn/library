<!DOCTYPE html>
<html>
    <head>
        <title>Laravel 5.1</title>
    </head>
    <body>
        <h2>Welcome</h2>

        <div id="users">
             <ul id="users">
                 <li v-repeat="user: users"> @{{ user.name }} </li>
             </ul>

             <pre>
                @{{ $data | json }}
             </pre>
        </div>


        <script src="https://js.pusher.com/2.2/pusher.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/vue/0.12.12/vue.min.js"></script>
        <script>
            new Vue({
                el: "#users",

                data : {
                    users : [

                    ]
                },

                ready : function(){
                    var pusher = new Pusher('5a510c8f7596d923dd50', {
                      encrypted: true
                    });
                    pusher.subscribe('test')
                        .bind('App\\Events\\UserHasRegistered', this.addUser);
                },

                methods : {
                    addUser : function(user){
                        this.users.push(user);
                    }
                }
            })
        </script>
    </body>
</html>
