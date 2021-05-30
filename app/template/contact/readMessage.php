<div class="wrapper">
    <h1>Message</h1>
    <?php foreach ($data['messages'] as $key => $message): ?>
        <h4>Subject:<b> <?php echo $message->getSubject(); ?></b></h4>
        <p>Message: <?php echo $message->getMessage(); ?></p>
        <?php if(count ($data['messages'])- 1 === $key ): ?>
           <a href="<?php echo BASE_URL . '/message/createMessage/'. $message->getsenderId().'?replayID=' . $message->getId() ?>">Replay</a>
        <?php endif; ?>
    <?php endforeach;?>

</div>