<?php
use Develop\Business\Wishlist\Intentions\AddItemWishlist as AddItemWishlistIntention;
use Develop\Business\Wishlist\Wishlist;

/**
 * validate wish list data
 * @param array $data
 * @return bool
 */
function isValidWishList(array $data)
{
    if (!isset($data['product_id']) || !assert(is_numeric($data['product_id']))) {
        return false;
    }
    if (!isset($data['email']) || !assert(filter_var($data['email'], FILTER_VALIDATE_EMAIL) !== false)) {
        return false;
    }
    return true;
}

/**
 * Gets wish list data.
 * @param array $data
 * @return AddItemWishlistIntention
 */
function getWishList(array $data)
{
    return new AddItemWishlistIntention($data['email'], $data['product_id']);
}

/**
 * Finds all products from given email.
 * @param string $email
 * @return Wishlist[] Returns wish list products from given email.
 */
function findAllWishProducts($email)
{
    $db = dbConnect();
    $query = <<<SQL
SELECT
  wishlists.id,
  wishlists.email,
  products.id as product_id,
  products.name as product_name,
  (products.stock > 0) as product_available,
  wishlists.status
FROM
  wishlists
INNER JOIN 
  products ON products.id = product_id 
WHERE email = ?
SQL;

    $stm = $db->prepare($query);
    $stm->execute([$email]);
    return $stm->fetchAll(\PDO::FETCH_FUNC, [Factory::class, 'createFromQueryResult']);
}

/**
 * Adds a new item into wish list of customer.
 * @param Wishlist $wishlist
 * @return bool|int
 */
function addWishItem(Wishlist $wishlist)
{
    $db = dbConnect();
    $db->beginTransaction();
    try {
        $stm = $db->prepare('INSERT INTO wishlists (email, product_id, status) VALUES (?, ?, ?)');
        $stm->execute([$wishlist->getEmail(), $wishlist->getItemId(), (string) $wishlist->getStatus()]);
        $db->commit();
        return $db->lastInsertId();
    } catch (Exception $e) {
        $db->rollBack();
    }
    return false;
}

function removeWishItem($id)
{
    $db = dbConnect();
    $db->beginTransaction();
    try {
        $stm = $db->prepare('DELETE FROM wishlists WHERE id = ?');
        $stm->execute([$id]);
        $db->commit();
        return true;
    } catch (Exception $e) {
        $db->rollBack();
    }
    return false;
}

function findAllWishlistsToNotify()
{
    $query = <<<SQL
SELECT
  wishlists.id, wishlists.email, products.name as product_name
FROM
  wishlists
INNER JOIN
  products ON products.id = product_id
WHERE
  products.stock > 0
  AND wishlists.status = 'P'
SQL;
    $db = dbConnect();
    $stm = $db->prepare($query);
    $stm->execute();
    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * @param int $id
 * @return void
 */
function wishlistNotified($id)
{
    $db = dbConnect();
    $stm = $db->prepare('UPDATE wishlists SET status = \'S\' WHERE id = ?');
    $stm->execute([$id]);
}
