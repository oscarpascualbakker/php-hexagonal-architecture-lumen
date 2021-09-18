<?php
declare(strict_types=1);

namespace src\User\Infrastructure;

use src\Shared\Cache\Domain\Interfaces\CacheInterface;
use src\User\Domain\User;
use src\User\Application\ShowUserUseCase;


final class ShowUserController
{

    private ShowUserUseCase $showUserUserCase;
    private CacheInterface $cache;


    public function __construct(ShowUserUseCase $showUserUserCase, CacheInterface $cache)
    {
        $this->showUserUserCase = $showUserUserCase;
        $this->cache            = $cache;
    }


    public function __invoke(Int $id): ?User
    {
        $key = 'user_' . $id;
        if (!$user = $this->cache->get($key)) {
            $showUserUseCase = $this->showUserUserCase;
            $user            = $showUserUseCase($id);

            if ($user) {
                $this->cache->set($key, $user);
                echo "MISS! (Saving...) \n";
            }
        } else {
            echo "HIT! \n";
        }
        return $user;
   }

}
