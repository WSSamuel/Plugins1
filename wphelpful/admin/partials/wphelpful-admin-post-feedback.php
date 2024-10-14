
<div class="wrap">

  <h1>
    Post Feedback - <?php echo $post->post_title; ?>
  </h1>

  <table class="wp-list-table widefat fixed striped posts">
    <thead>
      <tr>
        <th scope="col" class='manage-column column-datetime'>Date</th>
        <th scope="col" class='manage-column column-email'>User</th>
        <th scope="col" class='manage-column column-rating'>Rating</th>
        <th scope="col" class='manage-column column-feedback'>Feedback</th>
        <th scope="col" class='manage-column column-delete'></th>
      </tr>
    </thead>
    <tbody data-wp-lists='list:posts'>
      <?php foreach ($post_feedback as $post_time => $feedback) : ?>
      <tr>
        <td class='name column-datetime' data-colname="Date">
          <abbr title="<?php echo $feedback['local_time']; ?>"><?php echo $feedback['gmt_time']; ?> GMT</abbr>
        </td>
        <td class='name column-email' data-colname="User Email">
          <?php echo $feedback['user']; ?>
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
