<template>
    <div >
        <hr class="dropdown-divider">
        <a @click="MarkAsReadPost(notification)" href="#" class="dropdown-item is-active">
            {{notification.data.user}} has commented on your post <br>   
            <small>Post Title: <br>{{notification.data.post.post_text}}</small>
            <!-- hasOwnProperty -->
        </a>
    </div>
</template>

<script>
//fa fa-bell
    export default {
        props:['notification'],
        data(){
            return {

            }
        },
        methods:{
            MarkAsReadPost: function(notification){
                var data = {
                    id: notification.id
                }
                axios.post('/notifications/read',data)
                .then(response => {
                    window.location.href = "/post/" + notification.data.post.id
                })
            },
        }
    }
</script>
