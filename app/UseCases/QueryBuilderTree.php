<?php

namespace App\UseCases;

use App\Helper;
use stdClass;

class QueryBuilderTree
{
    public function buildTree($logic)
    {
        $output = [];
        $current_root = '';
        $rightNode = false;
        $leftNode = false;
        for ($i = 0; $i < count($logic); $i++) {
            if ($logic[$i]->sub_operation) {
                if ($rightNode && $leftNode) {
                    $logic[$i]->sub_operation == "and" ?
                        $output = ["\$and" => $output] :
                        $output = ["\$or" => $output];
                    $current_root = $logic[$i]->sub_operation;
                    $leftNode = false;
                } else if ($rightNode) {
                    $temp = [];
                    $column1 = [];
                    $column1[$logic[$i]->column] = [Helper::getOperation($logic[$i]->operation) => $logic[$i]->value];
                    array_push($temp, $column1);
                    $column2 = [];
                    $column2[$logic[$i + 1]->column] = [Helper::getOperation($logic[$i + 1]->operation) => $logic[$i + 1]->value];
                    array_push($temp, $column2);
                    $obj=new stdClass();
                    $logic[$i]->sub_operation == "and" ?
                        array_push($output['$' . $current_root],['\$and'=>$temp]) :
                        array_push($output['$' . $current_root],['\$or'=>$temp]);
                    $leftNode = true;
                    $rightNode = true;
                } else {
                    $column = [];
                    $column[$logic[$i]->column] = [Helper::getOperation($logic[$i]->operation) => $logic[$i]->value];
                    array_push($output, $column);
                    $rightNode = true;
                    $column2 = [];
                    $column2[$logic[$i + 1]->column] = [Helper::getOperation($logic[$i + 1]->operation) => $logic[$i + 1]->value];
                    array_push($output, $column2);
                    $leftNode = true;
                    $current_root = $logic[$i]->sub_operation;
                    $logic[$i]->sub_operation == "and" ?
                        $output = ["\$and" => $output] :
                        $output = ["\$or" => $output];
                }
            }
        }
        return $output;
    }
}
