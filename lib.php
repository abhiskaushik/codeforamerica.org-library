<?php

    class Context
    {
        // PDO handle to SQLite DB.
        var $dbh;
    
        function __construct($dbname)
        {
            $this->dbh = new PDO("sqlite:{$dbname}");
        }
        
        function path_info()
        {
            return urldecode(ltrim($_SERVER['PATH_INFO'], '/'));
        }
        
        function base()
        {
            return rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        }
    }
    
    function get_categories(&$ctx)
    {
        $categories = array();
        $query = 'SELECT DISTINCT category
                  FROM items WHERE category IS NOT NULL AND category != ""
                  ORDER BY category';
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $categories[] = $row['category'];
        }
        
        return $categories;
    }
    
    function get_tags(&$ctx)
    {
        $tags = array();
        $query = 'SELECT DISTINCT tag
                  FROM item_tags WHERE tag IS NOT NULL AND tag != ""
                  ORDER BY tag';
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $tags[] = $row['tag'];
        }
        
        return $tags;
    }
    
    function get_category_items(&$ctx, $category_name)
    {
        $items = array();
        $query = sprintf('SELECT * FROM items
                          WHERE category = %s
                          ORDER BY title',
                         $ctx->dbh->quote($category_name));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $items[] = $row;
        }
        
        return $items;
    }
    
    function get_tag_items(&$ctx, $tag_name)
    {
        $items = array();
        $query = sprintf('SELECT items.* FROM item_tags
                          LEFT JOIN items ON items.id = item_tags.item_id
                          WHERE item_tags.tag = %s
                          ORDER BY items.title',
                         $ctx->dbh->quote($tag_name));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            $items[] = $row;
        }
        
        return $items;
    }
    
    function get_item(&$ctx, $item_id)
    {
        $query = sprintf('SELECT * FROM items WHERE id = %s LIMIT 1',
                         $ctx->dbh->quote($item_id));
        
        foreach($ctx->dbh->query($query, PDO::FETCH_ASSOC) as $row)
        {
            return $row;
        }
        
        return null;
    }

?>
