<template>
    <footer class="card-footer">
        <a href="#" v-on:click.prevent="likeMethod" class="card-footer-item "><span>{{countLikes}}</span><i v-bind:class="{'fa fa-thumbs-o-up' : !like , ' fa fa-thumbs-up': like}"></i></a>
        <a href="#" v-on:click.prevent="dislikeMethod" class="card-footer-item "><span>{{countDislikes}}</span><i v-bind:class="{'fa fa-thumbs-o-down' : !dislike , 'fa fa-thumbs-down': dislike}"></i></a>
    </footer> 
</template>

<script>
    export default {
        //Props mora jebano biti like-count da bi Mogao da pristupis njemu kao likeCount
        props:['like-count','dislike-count','post-id', 'user-liked','user-disliked'],
        data(){
            return {
                like: this.userLiked,
                dislike : this.userDisliked,
                countLikes: this.likeCount,
                countDislikes : this.dislikeCount,
                id_post: this.postId
            }
        },
        methods:{
            likeMethod: function(e){
                //Kada post nije ni lajkovan ni dislajkovan
                if (this.like == false && this.dislike == false) {
                    this.like = true
                    this.countLikes++
                    axios.post('/likePost',{
                        post_id: this.id_post,
                        like: this.like
                    })
                }
                //Kada post dislajkovan pa onda likovan
                else if (this.like == false && this.dislike == true) {
                    this.like = true
                    this.dislike = false
                    this.countLikes++
                    this.countDislikes--
                    axios.post('/likePost',{
                        post_id: this.id_post,
                        like: this.like
                    })
                }
                //Kada je post bio lajkovan i oces da unistis like
                else if(this.like == true && this.dislike == false){
                    this.like = false
                    this.countLikes--
                    axios.post('/likePost/d',{
                        post_id: this.id_post,
                    })
                }
                
            },
            dislikeMethod: function(e){
                //Kada post nije ni lajkovan ni dislajkovan
                if (this.dislike == false && this.like == false) {
                    this.dislike = true
                    this.countDislikes++
                    axios.post('/likePost',{
                        post_id: this.id_post,
                        like: !this.dislike
                    })
                }
                //Kada post lajkovan pa onda dislajkovan
                else if (this.dislike == false && this.like == true) {
                    this.dislike = true
                    this.like = false
                    this.countDislikes++
                    this.countLikes--
                    axios.post('/likePost',{
                        post_id: this.id_post,
                        like: !this.dislike
                    })
                }
                //Kada je post bio dislikovan i oces da unistis dislike
                else if(this.dislike == true && this.like == false){
                    this.dislike = false
                    this.countDislikes--
                    axios.post('/likePost/d',{
                        post_id: this.id_post,
                    })
                }
            }
        },
    }
</script>

