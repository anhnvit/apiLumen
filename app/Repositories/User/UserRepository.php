<?php

namespace App\Repositories\User;


use App\Models\User;
use App\Repositories\AbstractBaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends AbstractBaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAll() {
       return $this->findAll();
    }
}