<?php

namespace App\Models\Os;

use App\Models\Model;

class OsModel
{

  public static function  all(): array
  {
    $sql = 'SELECT *  FROM os';
    $results = Model::query_get($sql);

    return $results;
  }

  public static function store(int $parent_id, int $node_level, int  $dept_type, string $name): array
  {

    $sql = "  INSERT INTO os( parent_id, node_level, dept_type, name ) 
                    VALUES
                        (?, ?, ?, ?)";
    $results = Model::query_set($sql, [$parent_id, $node_level,  $dept_type, $name]);

    return $results;
  }



  public static function getOSRole(int $os_id): array
  {
    $sql = 'SELECT * FROM roles
            where os_id = ? and status = 1';
    $results = Model::query_get($sql, [$os_id]);

    return $results;
  }

  public static function getAllPositionsUnderBox(int $os_id): array
  {
    $sql = 'with recursive
        descendants as
          ( select parent_id, id as descendant, name
            from os
          union all
            select d.parent_id, s.id, s.name
            from descendants as d
              join os s
                on d.descendant = s.parent_id
          ) 
        select *
        from descendants 
        where parent_id = ?;';

    $results = Model::query_get($sql, [$os_id]);

    return $results;
  }

  // get os top-down path 
  public static function getOsPath($os_id): array
  {
    $sql = "WITH RECURSIVE nodes_cte(id, name, parent_id, depth, path) AS (
        SELECT tn.id, tn.name, tn.parent_id, 1::INT AS depth, tn.id::TEXT AS path 
        FROM os AS tn 
        WHERE tn.parent_id = 0
       UNION ALL 
        SELECT c.id, c.name, c.parent_id, p.depth + 1 AS depth, 
               (p.path || ',' || c.id::TEXT) 
        FROM nodes_cte AS p, os AS c 
        WHERE c.parent_id = p.id
       )
       SELECT * FROM nodes_cte AS n WHERE n.id = ?;";
    $results = Model::query_get($sql, [$os_id]);

    if ($results['status'] == true && $results['rowCount'] > 0 && !empty($results['result'][0]->path)) {
      $id_list = explode(',', $results['result'][0]->path);
      $prams = array_fill(0, sizeof($id_list), '?');
      $sql = "SELECT * from os  where id in (" . implode(', ', $prams) . ") ORDER BY parent_id";
      $results = Model::query_get($sql, $id_list);
      return $results;
    }

    return $results;
  }
}
