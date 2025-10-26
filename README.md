# Post Based Image Gallery
WordPress plugin to manage post based image galleries.

## Usage
1. Create a post.
   1.1. Add a featured image.
   1.2. Add a tag called "image-gallery-item".
2. Create a post.
   2.1. Add the shortcuts to call the image gallery items: [image_gallery_item post_id="256" class="col-xs-12 col-md-3"].
        2.1.1 post_id field: the post id with a tag equal to image-gallery-item.
        2.1.2 class field: Bootstrap columns.
        2.1.3 modal field: set it as true to include a modal with the featured image and content instead the link to the post.
   2.2. Add a tag called "image-gallery".
3. Include a image gallery a page.
   3.1. Add a shortcut to call the image gallery: [image_gallery post_id="512"].
        3.1.1 post_id field: the post id with a tag equal to image-gallery.

## Requirements

- Bootstrap v5.3.8