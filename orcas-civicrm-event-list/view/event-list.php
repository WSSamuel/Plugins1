<div class="civicrm-event-list">
    <?php $last = null ?>
    <?php foreach ($this->events['values'] as $event): ?>
        <?php $date = explode(' ',$event['event_start_date']); ?>
        <?php $enddate = explode(' ', $event['event_end_date']); ?>
        <?php $starttime = $this->getTime($date[1]); ?>
        <?php $endtime = $this->getTime($enddate[1]); ?>
        <?php if($event['is_active']): ?>
            <?php if($last == null || $last != $date[0]): ?>
                <div class="civicrm-event-spacer">
                    <h2><?php echo date_i18n(get_option( 'date_format' ),strtotime($event['event_start_date'])); $last = $date[0]; ?></h2>
                </div>
            <?php endif; ?>
            <div class="civicrm-event">
                <div class="civicrm-event-time">
                    <?php if($date[0] == $enddate[0]): ?>
                        <div class="civicrm-event-time-singleline">
                            <div class="civicrm-event-time-singledate">
                                <i class="far fa-calendar"></i><?php echo date_i18n(get_option( 'date_format' ),strtotime($event['event_start_date'])); ?>
                            </div>
                            <?php if($starttime != null): ?>
                                <div class="civicrm-event-time-singletime">
                                    <i class="far fa-clock"></i>
                                    <i>
                                        <?php echo date_i18n(get_option( 'time_format' ),strtotime($event['event_start_date'])); ?>
                                        <?php if($endtime != null): ?>
                                            <?php echo ' - ' . date_i18n(get_option( 'time_format' ),strtotime($event['event_end_date']));; ?>
                                        <?php endif; ?>
                                    </i>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="civicrm-event-time-double">
                            <div class="civicrm-event-list-start">
                                <i class="far fa-calendar"></i><?php echo date_i18n(get_option( 'date_format' ),strtotime($event['event_start_date'])); ?>
                                <?php if($starttime != null): ?>
                                    <i class="far fa-clock"></i>
                                    <i>
                                        <?php echo date_i18n(get_option( 'time_format' ),strtotime($event['event_start_date'])); ?>
                                    </i>
                                <?php endif; ?>
                            </div>
                            <div class="civicrm-event-list-start">
                                <i class="fas fa-calendar"></i><?php echo date_i18n(get_option( 'date_format' ),strtotime($event['event_end_date'])); ?>
                                <?php if($endtime != null): ?>
                                    <i class="far fa-clock"></i>
                                    <i>
                                        <?php echo date_i18n(get_option( 'time_format' ),strtotime($event['event_end_date'])); ?>
                                    </i>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="civicrm-attend-box">
                    <div class="civicrm-event-title">
                        <h2><?php echo $event['title'] ?></h2>
                    </div>
                    <?php if($event['is_online_registration'] && $this->checkDate($event)): ?>
                        <div class="civicrm-event-attend">
                            <a href="civicrm/?page=CiviCRM&q=civicrm/event/register&id=1&reset=<?php echo $event['ID']; ?>"><?php echo $event['registration_link_text']; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<!--
<pre>
    <?php //var_dump($this->events['values'][1]); ?>
</pre>
-->