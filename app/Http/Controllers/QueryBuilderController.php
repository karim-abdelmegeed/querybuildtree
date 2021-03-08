<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\UseCases\QueryBuilderTree;

class QueryBuilderController extends Controller
{
    private $tree;

    public function __construct(QueryBuilderTree $tree)
    {
        $this->tree = $tree;
    }

    public function index()
    {
        $logic = json_decode(file_get_contents(public_path('storage/input.txt')));
        $output = $this->tree->buildTree($logic);
        Storage::disk('public')->put('output.txt', json_encode($output));
    }
}
