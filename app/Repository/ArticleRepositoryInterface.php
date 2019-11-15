<?php
namespace App\Repository;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface
{
    public function search(string $query = ''): Collection;
}
