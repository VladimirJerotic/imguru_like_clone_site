<div class="card-content">
    <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="field">
          <label class="label">Text</label>
          <div class="control">
            <input class="input"  name="post_text" type="text" placeholder="Text input">
          </div>
        </div>
        <div class="field">
          <label class="label">Img</label>
          <div class="control">
            <div class="file">
              <label class="file-label">
                <input class="file-input" accept="image/*" type="file" name="post_img" onchange="readURL(this);">
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
            <img onerror="this.style.display='none'" id="yourImage" src="#" alt="your image"/>
          </div>
        </div>
        <div class="field">
            <input type="submit" class="button is-primary" value="Upload">
        </div>
    </form>
</div>