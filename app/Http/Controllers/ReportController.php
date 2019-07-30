<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Type;
use App\Models\Report;
use App\Http\Requests\ReportCreateRequest;

class ReportController extends Controller
{
	public function showAll()
    {
        return Report::with('user', 'article', 'type')->get();
    }

    public function create(ReportCreateRequest $request)
    {
        $user = User::create($request->all());
        $article = Article::create($request->all());
        $type = Type::create($request->all());

        $report = new Report($request->all());
        $report->user()->associate($user);
        $report->article()->associate($article);
        $report->type()->associate($type);
        $report->save();

        return response('', 201);
    }
}
