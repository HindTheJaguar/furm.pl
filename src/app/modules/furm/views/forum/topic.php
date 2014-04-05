<?php
/**
 *
 * @author hind <hind@hind.pl>
 * @license BSD
 * @version $Id$
 */
echo '<h1>' . $this->topic->name . '</h1>';


if ($moderator = yiff\stdlib\Service::get('user')->isAdmin()) {
    echo '<button onclick="if(confirm(\'Usunąć temat?\')) {document.location=\'' . port('/adm/forum/deleteTopic/'.$this->topic->id) . '\'}">Usuń Temat</button>';
}
?>

<?php foreach ($this->posts as $post) : ?>

    <a name="<?php echo $post->id; ?>"></a>
    <div class="forum-topic">

        <div class="forum-topic-top">
            <div class="forum-topic-nick"><?php echo $post->name; ?></div>
            <div class="forum-avatar"><div class="user-avatar"><img src="<?= $this->gravatar($post->mail);?>"></div></div>


            <div class="forum-topic-date"><?php echo $post->created; ?></div>
            <div class="forum-topic-ip"><?php echo $post->ip; ?></div>




        </div>
        <a name="postid-<?php echo $post->id; ?>"></a>
        <div class="forum-main">

            <div class="forum-topic-title">
                <div class="forum-topic-id">
<?php if ($moderator): ?>
                        <a href="<?=port('/adm/forum/deletePost/'.$post->id);?>">Usuń</a> |
<?php endif; ?>
                <a href="<?php echo port('topic'); ?>#<?php echo $post->id; ?>">#<?php echo $post->id; ?></a>
            </div>
&nbsp;</div>
            <?php
                echo $this->escape($post->content);
            ?>
            </div>
            <div class="forum-topic-foot"></div>
        </div>

<?php endforeach; ?>
<?php if(uid()):?>
                <div class="forum-link">

                    [<a href='/nojs' onclick="document.location='<?php echo port('/forum/newtopic'); ?>'; return false;">Nowy Temat</a>]

                </div>

                <div class="forum-reply">
                    <form action="<?php echo port('/forum/post/:topic_id:', array('topic_id' => $this->topic->id)); ?>" id="form-post-url" method=post>
        <textarea name=text style="width:100%;height:150px;"></textarea><br>
        <input type="submit" value="Zapisz">
    </form>
</div>
    <?php endif;?>
