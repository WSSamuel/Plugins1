
<div id="wphelpful-<?php echo $user_id; ?>">
<?php if ( count( $total_posts ) <= 0 ) : ?>
  No posts enabled (yet)
<?php else : ?>
  <a href="users.php?page=wphelpful-users&amp;user_id=<?php echo $user_id; ?>"> <?php echo count( $user_posts ); ?> / <?php echo count( $total_posts ); ?> posts </a>
<?php endif; ?>  
</div>
