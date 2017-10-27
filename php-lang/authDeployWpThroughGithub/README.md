### How it works:

Read this: https://www.sitepoint.com/git-and-wordpress-how-to-auto-update-posts-with-pull-requests/

### Idea:

1) User (push) github
2) github (call:post) http://yoursite.com/githook/index.php
3) you can get list file change and is branch master or not
4) in the path (authors/specific-author/specific-post/meta.json keep information about the current post
5) we have { content post, post id } => (use wp post update <post id> <file_tmp>
6) DONE