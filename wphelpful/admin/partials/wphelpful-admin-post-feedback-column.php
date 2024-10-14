
<div id="wphelpful-<?php echo $post_id; ?>">
<?php if ($post_rating == '--') : ?>
  No feedback (yet)
<?php else : ?>
  <a href="edit.php?page=wphelpful-posts&amp;post_id=<?php echo $post_id; ?>">
    <?php echo $post_rating; ?> (from <?php echo count($post_feedback); ?> user<?php if ( count($post_feedback) != 1 ) echo 's'; ?>)
  </a>
<?php endif; ?>
</div>
