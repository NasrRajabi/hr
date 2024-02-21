<?php
// Initialize an empty array to hold the nodes of the organizational chart
$org_chart = array();

// Iterate over the rows of data and add each node to the organizational chart array
foreach ($org_chart_data as $row) {
    $id = $row['id'];
    $parent_id = $row['parent_id'];
    $node_level = $row['node_level'];
    $node_order = $row['node_order'];
    $dept_type = $row['dept_type'];
    $status = $row['status'];

    $node = array(
        'id' => $id,
        'parent_id' => $parent_id,
        'node_level' => $node_level,
        'node_order' => $node_order,
        'dept_type' => $dept_type,
        'status' => $status,
        'children' => array()
    );

    // Add the node to the organizational chart array
    if ($node_level == 1) {
        $org_chart[$id] = $node;
    } else {
        $parent_node = &$org_chart[$parent_id];
        $parent_node['children'][$id] = $node;
    }
}

// Define a recursive function to output the HTML for the organizational chart
function output_org_chart($node) {
    echo '<li>' . $node['id'];
    if (!empty($node['children'])) {
        echo '<ul>';
        foreach ($node['children'] as $child_node) {
            output_org_chart($child_node);
        }
        echo '</ul>';
    }
    echo '</li>';
}

// Call the recursive function to output the HTML for the organizational chart
echo '<ul>';
foreach ($org_chart as $root_node) {
    output_org_chart($root_node);
}
echo '</ul>';
?>