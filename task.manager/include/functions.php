<?php

function arraySort(&$array, $sort = SORT_ASC, $key = 'sort')
{
    usort($array, function ($a, $b) use ($key, $sort)
    {
        return $sort == SORT_DESC ? ($b[$key] <=> $a[$key]) : ($a[$key] <=> $b[$key]);
    });
}

function getCurrentPage($get_page, $array_menu)
{
    if (!empty($get_page)) {
        foreach ($array_menu as $value) {
            if (stristr($value['path'], $get_page)) {
                return $value['title'];
            }
        }
    }
}

function menuList($arr, $current_page)
{
    foreach ($arr as $item) {
        include ('menu_items.php');
    }
}

function trimTo($str, int $count)
{
    return mb_strimwidth($str, 0, $count, "...");
}

function dbaseConnect()
{
    static $connect;
    if ($connect === null) {
        try {
            $connect = new PDO(DSN, USER, PASS, OPT);
        } catch (PDOException $e) {
            die ('Подключение не удалось' . $e->getMessage());
        }
    }
    return $connect;
}

function checkUser($login, $password) {
    $stmt = dbaseConnect()->prepare('SELECT id, password FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $login]);
    $result = $stmt->fetch();
    if ($result['id'] && $result['password'] === md5($password)) {
        return $result['id'];
    } else {
        return false;
    }
}

function getUserCat($user_id)
{
    $stmt = dbaseConnect()->prepare('
    SELECT group_id FROM group_user AS gu JOIN groups AS g ON gu.group_id = g.id
    WHERE gu.user_id = :user_id AND g.name LIKE (:group_name) LIMIT 1;');
    $stmt->execute(['user_id' => $user_id, 'group_name' => GROUP_NAME]);
    $result = $stmt->fetch();
    return $result['group_id'];
}

function getCategories()
{
    return dbaseConnect()->query('SELECT `id`, `name`, `color` FROM categories;');
}

function showMessages($user_id)
{
    $stmt = dbaseConnect()->prepare("SELECT m.id as msg_id, m.caption as message_caption, c.name as category
    FROM messages AS m INNER JOIN categories AS c ON m.category_id = c.id
    WHERE was_read = 'no' AND m.user_receive_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    return $stmt;
}

function setWasReadYes($msg_id)
{
    $stmt = dbaseConnect()->prepare("UPDATE messages SET was_read = 'yes' WHERE id = :msg_id;");
    $stmt->execute(['msg_id' => $msg_id]);
}

function showCurrentMessage($msg_id, $user_id)
{
    $check_msg = dbaseConnect()->prepare('SELECT was_read FROM messages WHERE id = :msg_id LIMIT 1');
    $check_msg->execute(['msg_id' => $msg_id]);
    $check_msg = $check_msg->fetch();
    if ($check_msg['was_read'] == 'no') {
        $stmt = dbaseConnect()->prepare("SELECT m.id as msg_id, m.caption, m.content, m.createdate, u.name, u.surname, u.patronymic, u.email
        FROM messages as m JOIN users as u ON m.user_create_id WHERE m.id = :msg_id AND m.user_receive_id = :user_id AND was_read = 'no' LIMIT 1");
        $stmt->execute(['msg_id' => $msg_id, 'user_id' => $user_id]);
        setWasReadYes($msg_id);
        return $stmt->fetch();
    } else {
        return false;
    }
}

function checkEmail($email)
{
    $email_id = dbaseConnect()->prepare('SELECT id FROM users WHERE email = ? LIMIT 1;');
    $email_id->execute([$email]);
    return $email_id->fetch();
}

function sendMessage($caption, $content, $user_create_id, $user_receive_id, $category_id)
{
    $stmt = dbaseConnect()->prepare('INSERT INTO `messages` 
    (`caption`, `content`, `createdate`, `user_create_id`, `user_receive_id`, `category_id`) 
    VALUES (:caption, :content, NOW(), :user_create_id, :user_receive_id, :category_id);');
    return $stmt->execute([
        'caption' => $caption,
        'content' => $content,
        'user_create_id' => $user_create_id,
        'user_receive_id' => $user_receive_id,
        'category_id' => $category_id
    ]);
}

function showCategories()
{
    return dbaseConnect()->query('SELECT `id`, `name`, `color` FROM categories;');
}