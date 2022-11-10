<template>
    <div class="navbar-item dropdown is-right" v-bind:class="{ 'is-active': showNotif }">
      <div class="dropdown-trigger">
        <button @click="clickBell()" class="button" aria-haspopup="true" aria-controls="dropdown-menu">
          <span v-if="notifications.length > 0">{{notifications.length}}</span><i :class="bellClass" aria-hidden="true"></i>
        </button>
      </div>
      <div class="dropdown-menu" id="dropdown-menu" role="menu">
        <div class="dropdown-content">
            <div v-for="notification in notifications">
                <notification-post-component v-if="notification.data.hasOwnProperty('post')" :notification="notification"></notification-post-component>
                <notification-comment-component v-if="notification.data.hasOwnProperty('comment')"  :notification="notification"></notification-comment-component>
                <notification-reply-comment-component v-if="notification.data.hasOwnProperty('reply_comment')"  :notification="notification" ></notification-reply-comment-component>
            </div>
            <p v-if="notifications.length == 0">There are no new notifications</p>
        </div>
      </div>
    </div>    
</template>

<style scoped>
    .button{
        border:none;
    }
</style>
<script>
import notificationPostComponent from './NotificationPostComponent.vue'
import notificationCommentComponent from './NotificationCommentComponent.vue'
import notificationReplyCommentComponent from './NotificationReplyCommentComponent.vue'
//fa fa-bell
    export default {
        components:{
            'notification-post-component': notificationPostComponent,
            'notification-comment-component': notificationCommentComponent,
            'notification-reply-comment-component' : notificationReplyCommentComponent
        },
        data(){
            return {
                notifications: '',
                showNotif: false,
                bellClass: 'fa fa-bell-o',
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
            clickBell : function(){
                this.showNotif = !this.showNotif
                if (this.showNotif == true) {
                    this.bellClass = "fa fa-bell"
                }
                else if(this.showNotif != true){
                    this.bellClass = "fa fa-bell-o"
                }
            }
        },
        mounted(){
            axios.post('/notifications/get')
                .then(response => {
                    this.notifications = response.data
                })
        }
    }
</script>
