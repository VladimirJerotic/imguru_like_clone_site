<template>
    <div >
        <hr class="dropdown-divider">
        <a @click="MarkAsReadComment(notification)" href="#" class="dropdown-item is-active">
            {{notification.data.user}} has replied on your comment <br>   
            <small>Comment: <br>{{notification.data.comment.comment_text}}</small>
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
            MarkAsReadComment: function(notification){
                var data = {
                    id: notification.id
                }
                axios.post('/notifications/read',data)
                .then(response => {
                    window.location.href = "/post/" + notification.data.comment.post_id
                })
            },
        }
    }
</script>
