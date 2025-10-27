# Post Based Image Gallery
WordPress plugin to manage post based image galleries.

## Usage
- Create a post.
   - Add a featured image.
   - Add a tag called "image-gallery-item".
- Create a post.
   - Add the shortcuts to call the image gallery items: [image_gallery_item post_id="256" class="col-xs-12 col-md-3"].
        - post_id field: the post id with a tag equal to image-gallery-item.
        - class field: Bootstrap columns.
        - modal field: set it as true to include a modal with the featured image and content instead the link to the post.
   - Add a tag called "image-gallery".
- Include a image gallery a page.
   - Add a shortcut to call the image gallery: [image_gallery post_id="512"].
        - post_id field: the post id with a tag equal to image-gallery.

## Requirements

- Bootstrap v5.3.8