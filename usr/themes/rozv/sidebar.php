<div id="sidebar">
    <div class="side_box side_1">
        <h3>友链</h3>
        <p><a href="https://www.tomori.top" target="_blank">傲娇且孤独の老人</a></p>
        <p><a href="http://www.jarvis.top" target="_blank">超神Jarvis</a></p>
        <p><a href="http://www.nowamagic.net" target="_blank">简明现代魔法</a></p>
    </div>
    <div class="side_box side_2">
        <h3>关于我</h3>
        <?php if ($this->options->aboutText): ?>
            <p><img class="footer_avatar" src="<?php echo Typecho_Common::gravatarUrl('xierungui@hotmail.com', 45, 'X', 'mm', false); ?>" /><?php $this->options->aboutText() ?></p>
        <?php else : ?>
            <p>这是一段自我介绍，请在博客后台的设置外观页面下进行修改。</p>
        <?php endif; ?>
    </div>
</div>
