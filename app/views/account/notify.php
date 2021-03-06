<?php use Model\Notify; ?>
<span class="stamp fontello">Notify</span>

<article class="typo wrapper-padding wrapper-page">

    <?php $hasNotification = is_array($notifies) && count($notifies); ?>

    <div class="typo-p tab tab-notify">
        <h2>Notifications: </h2>
        <a class="tag tag-<?php echo $is_read ? 'info' : 'tips active'; ?>" href="<?php echo url('/my/notice'); ?>">unread</a>
        <a class="tag tag-<?php echo $is_read ? 'tips active' : 'info'; ?>" href="<?php echo url('/my/notice?read'); ?>">read</a>
    </div>

    <?php if($hasNotification && !$is_read): ?>
        <form action="" method="POST" class="markall">
            <input type="submit" value="Mark all read" class="btn" />
        </form>
    <?php elseif(!$hasNotification): ?>
        <p>No notifications!</p>
    <?php endif; ?>

    <div id="comments">
        
        <?php foreach ($notifies as $notify): ?>
            <?php
            $sender = $notify->sender()->find_one();
            $article = $notify->object()->find_one();
            ?>
            <div class="comment notify <?php echo $notify->status ? '' : 'on' ?>" data-id="<?php echo $notify->id; ?>">
                <div class="typo-small">
                    <a href="<?php echo url('/p/' . $article->id); ?>"><?php echo $article->title; ?></a>:
                    <a href="<?php echo url('/u/' . $sender->id); ?>"><?php echo $sender->name; ?></a>
                    <small class="identical-day"><?php switch ($notify->type) {
                        case Notify::REPLY:
                            echo 'reply to you';
                            break;
                        case Notify::MENTION:
                            echo 'mention you';
                            break;
                    }?>
                    @ <?php echo $notify->created_at; ?>
                    </small>
                </div>
                <div class="typo-small"><?php echo Helper\Html::fromMarkdown($notify->message); ?></div>
            </div>
        <?php endforeach;?>
    </div>
</article>

<?php echo $page ?>