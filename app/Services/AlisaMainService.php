<?php


namespace App\Services;


use App\Repositories\Interfaces\{FavouritesRepositoryInterface, SeriesRepositoryInterface, UserRepositoryInterface};
use App\Services\Interfaces\AlisaMainServiceInterface;
use Yandex\Dialogs\Webhook\Request\Fabric;

class AlisaMainService implements AlisaMainServiceInterface
{
    /** @var UserRepositoryInterface $seriesRepository */
    private $userRepository;
    /** @var SeriesRepositoryInterface $seriesRepository */
    private $seriesRepository;
    /** @var FavouritesRepositoryInterface $favouritesRepository */
    private $favouritesRepository;

    private $dialogRequest;
    private $responseFactory;

    private $user;

    /**
     * AlisaMainService constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $data = json_decode(trim(file_get_contents('php://input')), true);
        $this->dialogRequest = Fabric::initFromArray($data);
        $this->responseFactory = new \Yandex\Dialogs\Webhook\Response\Fabric($this->dialogRequest);

        $this->seriesRepository = app()->make(SeriesRepositoryInterface::class);
        $this->favouritesRepository = app()->make(FavouritesRepositoryInterface::class);
        $this->userRepository = app()->make(UserRepositoryInterface::class);
    }

    public function processRequest(): \Yandex\Dialogs\Webhook\Response\Fabric
    {
        if(!$this->authorizeCheck()) {
            return $this->responseFactory;
        }
    }

    private function authorizeCheck(): bool
    {
        $yandexID = $this->dialogRequest->getSession()->getUserId();
        if (!$this->user = $this->userRepository->getUserByYandexID($yandexID))
        {
            $this->user = $this->userRepository->addUserByYandexID($yandexID);
            $this->responseFactory
                ->setText(view('dialogues.greet-no-user'))
                ->setTts(view('dialogues.greet-no-user'))
                ->buildResponse();
            return true;
        }
        return false;
    }
}