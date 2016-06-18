<?php

/**
 * Creates a url to remove product from wish list
 * @param int $id
 * @return string
 */
function removeUrl($uri, $id, array $extraQuery = array())
{
    $query = http_build_query(array_merge(['remove' => $id], $extraQuery));
    return sprintf('<a href="%s/remove?%s">remove</a>', $uri, $query);
}
