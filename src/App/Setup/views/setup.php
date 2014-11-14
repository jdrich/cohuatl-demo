<h2>Application Setup</h2>
<form action="<?php echo (new \App\Routes())->map('@setup_save'); ?>" method="post">
    <?php $default = $config['default']; ?>
    <?php unset($config['default']); ?>
    <h4>Configuration</h4>
    <ul>
        <?php foreach($config as $item => $value): ?>
            <li>
                <label><?php echo pretty($item); ?></label>
                <input type="text" name="config/<?php echo $item; ?>" value="<?php echo $value; ?>" />
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if($default): ?>
        <h4>Initial User Setup</h4>
        <p>An initial user has not been set up yet. Please enter credentials for the first user.</p>
        <ul>
                <li>
                    <label>Username</label>
                    <input type="text" name="username" value="" />
                </li>
                <li>
                    <label>Password</label>
                    <input type="password" name="password" value="" />
                </li>
                <li>
                    <label>Confirm Password</label>
                    <input type="password" name="confirm" value="" />
                </li>
        </ul>
    <?php endif; ?>
    <input type="hidden" name="config/default" value="0" />
    <input type="submit" name="submit" value="Submit &gt;" />
</form>
<?php

function pretty($input) {
    $pretty = [
        'blog_title' => 'Blog Title',
        'on_index' => 'Number of posts on the index page'
    ];

    return isset($pretty[$input]) ? $pretty[$input] : $input;
}

?>
