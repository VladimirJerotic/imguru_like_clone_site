<template>
    <div>
        <small><a href="#" v-on:click.prevent="likeMethod"><span>{{countLikes}}</span><i v-bind:class="{'fa fa-thumbs-o-up' : !like , ' fa fa-thumbs-up': like}"></i></a> · <a href="#" v-on:click.prevent="dislikeMethod"><span>{{countDislikes}}</span><i v-bind:class="{'fa fa-thumbs-o-down' : !dislike , 'fa fa-thumbs-down': dislike}"></i></a> · <a  href="#" v-on:click.prevent="showM" v-bind:value="showV">{{showV}}</a> · Created at: {{createdAt}}</small>
        <form v-if="show" v-bind:action="url" enctype='multipart/form-data' method="POST">
            <input type="hidden" name="_token" v-bind:value="csrf">
            <input type="hidden" name="post_id" v-bind:value="id_post">
            <input type="hidden" name="comment_id" v-bind:value="id_comment">
            <input name="reply_comment_text" class="input is-rounded" type="text" placeholder="Reply...">
            <div class="control" style="margin-top: 5px;">
                <div class="file">
                  <label class="file-label">
                    <input class="file-input" accept="image/*" type="file" name="reply_comment_img">
                    <span class="file-cta">
                      <span class="file-icon">
                        <i class="fa fa-upload" aria-hidden="true"></i>
                      </span>
                      <span class="file-label">
                        Choose  image…
                      </span>
                    </span>
                  </label>
                </div>
            </div>
            <input style="margin-top: 5px;" class="button is-primary  is-rounded " type="submit" value="Reply">
        </form>
    </div>
</template>

<script>
    export default {
        //Props mora jebano biti like-count da bi Mogao da pristupis njemu kao likeCount
        props:['token','comment-created-at','comment-id','like-comment-count','dislike-comment-count','post-id', 'user-comment-liked','user-comment-disliked'],
        data(){
            return {
                like: this.userCommentLiked,
                dislike : this.userCommentDisliked,
                countLikes: this.likeCommentCount,
                countDislikes : this.dislikeCommentCount,
                createdAt: this.commentCreatedAt,
                id_comment: this.commentId,
                id_post: this.postId,
                show : false,
                showV: 'Reply',
                // Url je smao tu zbog forme
                url: 'http://memes.test/replyComment',
                csrf: this.token,
            }
        },
        methods:{
            showM: function(e){
                if (this.showV == 'Reply') {
                    this.show = true
                    this.showV = 'Hide'
                }else{
                    this.show = false
                    this.showV = 'Reply'
                }
            },
            likeMethod: function(e){
                //Kada post nije ni lajkovan ni dislajkovan
                if (this.like == false && this.dislike == false) {
                    this.like = true
                    this.countLikes++
                    this.likeView = 'Unlike'
                    axios.post('/commentLike', {
                         post_id: this.id_post,
                         comment_id: this.id_comment,
                         like: this.like
                      })
                }
                //Kada post dislajkovan pa onda likovan
                else if (this.like == false && this.dislike == true) {
                    this.like = true
                    this.dislike = false
                    this.countLikes++
                    this.countDislikes--
                    this.likeView = 'Unlike'
                    this.dislikeView = 'Dislike'
                    axios.post('/commentLike',{
                        post_id: this.id_post,
                        comment_id: this.id_comment,
                        like: this.like
                    })
                }
                //Kada je post bio lajkovan i oces da unistis like
                else if(this.like == true && this.dislike == false){
                    this.like = false
                    this.countLikes--
                    this.likeView = 'Like'
                    axios.post('/commentLike/d',{
                        post_id: this.id_post,
                        comment_id: this.id_comment
                    })
                }
                
            },
            dislikeMethod: function(e){
                //Kada post nije ni lajkovan ni dislajkovan
                if (this.dislike == false && this.like == false) {
                    this.dislike = true
                    this.countDislikes++
                    this.dislikeView = 'Undislike'
                    axios.post('/commentLike',{
                        post_id: this.id_post,
                        comment_id: this.id_comment,
                        like: !this.dislike
                    })

                }
                //Kada post lajkovan pa onda dislajkovan
                else if (this.dislike == false && this.like == true) {
                    this.dislike = true
                    this.like = false
                    this.countDislikes++
                    this.countLikes--
                    this.dislikeView = 'Undislike'
                    this.likeView = 'Like'
                    axios.post('/commentLike',{
                        post_id: this.id_post,
                        comment_id: this.id_comment,
                        like: !this.dislike
                    })
                }
                //Kada je post bio dislikovan i oces da unistis dislike
                else if(this.dislike == true && this.like == false){
                    this.dislike = false
                    this.countDislikes--
                    this.dislikeView = 'Dislike'
                    axios.post('/commentLike/d',{
                        post_id: this.id_post,
                        comment_id: this.id_comment
                    })
                }
            }
        },
    }
</script>

