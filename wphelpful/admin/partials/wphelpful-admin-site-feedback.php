
<div class="wrap">

  <h1>
    Feedback
  </h1>

  <table class="wp-list-table widefat fixed striped users">
    <thead>
      <tr>
        <th scope="col" class='manage-column column-datetime'>Date</th>
        <th scope="col" class='manage-column column-email'>User</th>
        <th scope="col" class='manage-column column-title'>Post</th>
        <th scope="col" class='manage-column column-rating'>Rating</th>
        <th scope="col" class='manage-column column-feedback'>Feedback</th>
        <th scope="col" class='manage-column column-delete'></th>
      </tr>
    </thead>
    <tbody data-wp-lists='list:posts'>
      <?php foreach ($all_feedback as $post_time => $feedback) : ?>
      <tr>
        <td class='name column-title' data-colname="Date">
          <abbr title="<?php echo $feedback['local_time']; ?>"><?php echo $feedback['gmt_time']; ?> GMT</abbr>
        </td>
        <td class='name column-email' data-colname="User Email">
          <?php echo $feedback['user']; ?>
        </td>
        <td class='name column-title' data-colname="Title">
          <a href="<?php echo get_edit_post_link($feedback['post_id']); ?>"><?php echo get_the_title($feedback['post_id']); ?></a>
        </td>
        <td class='name column-rating' data-colname="Rating">
          <?php echo $feedback['rating']; ?> 
        </td>
        <td class='name column-feedback' data-colname="Feedback">
          <?php echo stripslashes($feedback['feedback']); ?>
        </td>
        <td><a href="javascript:;" data-feedback-id="<?php echo $feedback['id']; ?>" class="wph_delete_button">Delete</a></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>
