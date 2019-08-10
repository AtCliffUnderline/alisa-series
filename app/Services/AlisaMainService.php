<?php


namespace App\Services;


use App\Repositories\Interfaces\{FavouritesRepositoryInterface, SeriesRepositoryInterface, UserRepositoryInterface};
use App\Services\Interfaces\AlisaMainServiceInterface;
use YaDialogues\Dialogue;
use YaDialogues\Response;

class AlisaMainService implements AlisaMainServiceInterface
{
    /** @var UserRepositoryInterface $seriesRepository */
    private $userRepository;
    /** @var SeriesRepositoryInterface $seriesRepository */
    private $seriesRepository;
    /** @var FavouritesRepositoryInterface $favouritesRepository */
    private $favouritesRepository;

    /**
     * @var Dialogue
     */
    private $dialog;

    /**
     * @var Response
     */
    private $response;

    private $user;

    /**
     * AlisaMainService constructor.
     * @param array $requestArr
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->seriesRepository = app()->make(SeriesRepositoryInterface::class);
        $this->favouritesRepository = app()->make(FavouritesRepositoryInterface::class);
        $this->userRepository = app()->make(UserRepositoryInterface::class);
    }

    /**
     * @param array $requestArr
     * @return array
     * @throws \TextNotProvidedException
     */
    public function processRequest(array $requestArr): array
    {
        $this->dialog = new Dialogue();
        $this->dialog->createDialogue($requestArr);

        $this->response = $this->dialog->createResponse();

        if(!$this->authorizeCheck()) {
            return $this->response->buildResponse();
        }
    }

    /**
     * @return bool
     */
    private function authorizeCheck(): bool
    {
        $yandexID = $this->dialog->getRequest()->getSession()->getUserId();
        if (!$this->user = $this->userRepository->getUserByYandexID($yandexID))
        {
            $this->user = $this->userRepository->addUserByYandexID($yandexID);
            $this->response
                ->setText(view('dialogues.greet-no-user'))
                ->setTts(view('dialogues.greet-no-user'));
            return false;
        }
        return true;
    }
}
