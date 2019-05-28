<?php

function declension ($number, $array) {
    $case = [2, 0, 1, 1, 1, 2];
    return $number.' '.$array[ ($number % 100 > 4 && $number % 100 < 20) ? 2 : $case[min($number % 10, 5)] ];
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

function menuList($current_page)
{
    $menu_items = dbaseConnect()->query('SELECT name, path from menu_items;');
    foreach ($menu_items as $item) {
        include ('menu_item.php');
    }
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

function getCategories()
{
    return dbaseConnect()->query('SELECT id, name FROM categories');
}

function constructQueryForProducts($query_array)
{
    $query = " FROM products as p WHERE p.is_active = 'yes'";
    if (empty($query_array)) {
        return $query;
    }
    if (isset($query_array['cat']) && $query_array['cat'] != 'all') {
        $query = " FROM products as p JOIN category_product as cp ON p.id = cp.product_id WHERE p.is_active = 'yes' AND cp.category_id = :cat_id";
    }
    if (isset($query_array['new']) && $query_array['new'] = 'on') {
        $query .= " AND p.new = 'yes'";
    }
    if (isset($query_array['sale']) && $query_array['sale'] = 'on') {
        $query .= " AND p.sale = 'yes'";
    }
    if (isset($query_array['min_price'])) {
        $query .= " AND p.price >= :min_price";
    }
    if (isset($query_array['max_price'])) {
        $query .= " AND p.price <= :max_price";
    }
    return $query;
}

function execArray($query_array)
{
    if (isset($query_array['cat']) && $query_array['cat'] != 'all') {
        $array['cat_id'] = $query_array['cat'];
    }
    if (isset($query_array['min_price'])) {
        $array['min_price'] = $query_array['min_price'];
    }
    if (isset($query_array['max_price'])) {
        $array['max_price'] = $query_array['max_price'];
    }
    if (isset($array)) {
        return $array;
    } else {
        return null;
    }
}

function getCountProducts($query_array)
{
    $query = "SELECT COUNT(p.id) as count" . constructQueryForProducts($query_array);
    $stmt = dbaseConnect()->prepare($query);
    $stmt->execute(execArray($query_array));
    return $stmt->fetch()['count'];
}

function getProducts($query_array)
{
    if (isset($query_array['sort'])) {
        $sort_array = explode('_', $query_array['sort']);
        if (in_array($sort_array[0], ['price', 'name'])) {
            $sort = 'p.' . $sort_array[0];
        }
        if (in_array($sort_array[1], ['ASC', 'DESC'])) {
            $order = $sort_array[1];
        } else {
            $sort = 'p.date_create';
            $order = 'ASC';
        }
    } else {
        $sort = 'p.date_create';
        $order = 'ASC';
    }
    $query = "SELECT p.id, p.name, p.price, p.img_path, p.new" . constructQueryForProducts($query_array) . " ORDER BY " . $sort . ' ' . $order . " LIMIT " . ITEMS_ON_PAGE . " OFFSET :offset";
    $stmt = dbaseConnect()->prepare($query);
    $array = execArray($query_array);
    if (isset($query_array['page']) && $query_array['page'] > 0) {
        $array['offset'] = ($query_array['page'] - 1) * ITEMS_ON_PAGE;
    } else {
        $array['offset'] = 0 * ITEMS_ON_PAGE;
    }
    $stmt->execute($array);
    return $stmt;
}

function getMinMaxPrice($query_array)
{
    if (isset($query_array['min_price'])) {
        unset ($query_array['min_price']);
    }
    if (isset($query_array['max_price'])) {
        unset ($query_array['max_price']);
    }
    $min_price = "SELECT MIN(p.price) as min_price" . constructQueryForProducts($query_array);
    $max_price = "SELECT MAX(p.price) as max_price" . constructQueryForProducts($query_array);
    $stmt = dbaseConnect()->prepare($min_price);
    $stmt->execute(execArray($query_array));
    $price['min_price'] = $stmt->fetch()['min_price'];
    $stmt = dbaseConnect()->prepare($max_price);
    $stmt->execute(execArray($query_array));
    $price['max_price'] = $stmt->fetch()['max_price'];
    return $price;
}

function getUserCategory($user_id, $group_name = GROUP_NAME)
{
    $stmt = dbaseConnect()->prepare('
    SELECT group_id FROM group_user AS gu JOIN groups AS g ON gu.group_id = g.id
    WHERE gu.user_id = :user_id AND g.name = :group_name LIMIT 1;');
    $stmt->execute(['user_id' => $user_id, 'group_name' => $group_name]);
    $result = $stmt->fetch();
    if ($result['group_id'] != null) {
        return true;
    } else {
        return false;
    }
}

function getCategoryByProductId($product_id)
{
    $stmt = dbaseConnect()->prepare('SELECT c.name as name FROM categories as c JOIN category_product AS cp ON c.id = cp.category_id WHERE cp.product_id = :product_id');
    $stmt->execute(['product_id' => $product_id]);
    return $stmt;
}

function getOrders($query)
{
    if (isset($query['page']) && $query['page'] > 0) {
        $offset = ($query['page'] - 1) * ITEMS_ON_PAGE;
    } else {
        $offset = 0 * ITEMS_ON_PAGE;
    }
    $stmt = dbaseConnect()->prepare('
    SELECT o.id, o.address, o.delivery_type, o.payment_type, o.comment, o.status, c.name, c.surname, c.patronymic, c.phone, p.price 
    FROM orders as o JOIN clients as c ON o.client_id = c.id JOIN products as p ON o.product_id = p.id ORDER BY o.date_create ASC LIMIT ' . ITEMS_ON_PAGE . ' OFFSET :offset;');
    $stmt->execute(['offset' => $offset]);
    return $stmt;
}

function getProductById($id)
{
    $stmt = dbaseConnect()->prepare('SELECT id, name, price, img_path FROM products WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch();
}

function getCountOrders()
{
    $stmt = dbaseConnect()->query('SELECT COUNT(id) as c_id FROM ORDERS');
    return $stmt->fetch()['c_id'];

}

function checkPhoneNumber($phoneNumber)
{
    $phoneNumber = preg_replace('/\s|\+|-|\(|\)/','', $phoneNumber);
    if(is_numeric($phoneNumber))
    {
        if(mb_strlen($phoneNumber) < 5 || mb_strlen($phoneNumber) > 13)
        {
            return false;
        }
        else
        {
            return $phoneNumber;
        }
    }
    else
    {
        return false;
    }
}

function checkIdProduct($id)
{
    $stmt = dbaseConnect()->prepare("SELECT id FROM products WHERE id = ? AND is_active = 'yes'");
    $stmt->execute([$id]);
    if ($stmt->fetch()) {
        return true;
    } else {
        return false;
    }
}

function newOrder(array $order)
{
    if ($client = isOldClient($order['phone'], $order['email'])) {
        foreach ($client as $client_data) {
            $client_id = $client_data['id'];
        }
    } else {
        $client_id = newClient($order['phone'],
            $order['email'],
            $order['name'],
            $order['surname'],
            $order['thirdname'] ? $order['thirdname'] : '');
    }
    if ($client_id) {
        $stmt = dbaseConnect()->prepare('INSERT INTO orders (
        client_id, product_id, address, delivery_type, payment_type, comment)
        VALUES (:client_id, :product_id, :address, :delivery_type, :payment_type, :comment)');
        $result = $stmt->execute([
            'client_id' => $client_id,
            'product_id' => $order['product_id'],
            'address' => (!empty($order['address'])) ? implode(',', $order['address']) : '',
            'delivery_type' => $order['delivery_type'],
            'payment_type' => $order['payment_type'],
            'comment' => (!empty($order['comment'])) ? $order['comment'] : ''
        ]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    else {
        return false;
    }
}

function isOldClient($phone, $email)
{
    $stmt = dbaseConnect()->prepare('SELECT id FROM clients WHERE phone = :phone AND email = :email');
    $stmt->execute(['phone' => $phone, 'email' => $email]);
    return $stmt->fetchAll();
}

function newClient($phone, $email, $name, $surname, $thirdname = '')
{
    $stmt = dbaseConnect()->prepare('INSERT INTO clients (phone, email, name, surname, thirdname)
    VALUES (:phone, :email, :name, :surname, :thirdname)');
    $stmt->execute([
        'phone' => $phone,
        'email' => $email,
        'name' => $name,
        'surname' => $surname,
        'thirdname' => $thirdname
    ]);
    return dbaseConnect()->lastInsertId();
}