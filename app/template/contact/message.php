<div class="wrapper">
    <h2>Messages</h2>
    <h3>Recived</h3>
    <table>
        <thead>
        <tr>
            <th>Subject</th>
            <th>Sender</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['recived_messages'] as $key => $result): ?>
            <tr>
                <td><a class="<?php echo $result['status'] ? 'message_link-bold' : 'message_link' ?>" href="<?=BASE_URL . '/message/read/' .$result['id'] ?>"><?php echo $result['subject'] ?></a></td>
                <td><?php echo $result['sender_email'] ?></td>
                <td><?php echo $result['create_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h3>Send</h3>
    <table>
        <thead>
        <tr>
            <th>Subject</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['sended_messages'] as $key => $result): ?>
            <tr>
                <td><?php echo $result['subject'] ?></td>
                <td><?php echo $result['create_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

