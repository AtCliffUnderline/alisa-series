<?php


namespace App\Services;


use App\Repositories\Interfaces\{FavouritesRepositoryInterface,
    SeriesRepositoryInterface,
    UserRepositoryInterface,
    UserSeriesRepositoryInterface};
use App\Services\Interfaces\AlisaMainServiceInterface;
use Illuminate\Support\Facades\Cache;
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
     * @var SeriesMatchService
     */
    private $matchService;
    private $userSeriesRepository;

    /**
     * AlisaMainService constructor.
     * @param SeriesRepositoryInterface $seriesRepository
     * @param UserSeriesRepositoryInterface $userSeriesRepository
     * @param UserRepositoryInterface $userRepository
     * @param SeriesMatchService $matchService
     */
    public function __construct(SeriesRepositoryInterface $seriesRepository,
                                UserSeriesRepositoryInterface $userSeriesRepository,
                                UserRepositoryInterface $userRepository,
                                SeriesMatchService $matchService)
    {
        $this->seriesRepository = $seriesRepository;
        $this->userSeriesRepository = $userSeriesRepository;
        $this->userRepository = $userRepository;
        $this->matchService = $matchService;
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
        $this->authorize();

        if($this->dialog->getRequest()->getSession()->isNew()) {
            $stage = 1;
        } else {
            $stage = Cache::get('stage_' . $this->user->id);
        }

        switch ($stage) {
            case 1:
                $this->firstStage();
                break;
            case 2:
                $this->secondStage($this->dialog->getRequest()->getBody()->getCommand());
                break;
        }

        return $this->response->buildResponse();
    }

    /**
     * @return void
     */
    private function firstStage()
    {
        if (!$this->user) {
            $this->user = $this->userRepository->addUserByYandexID($this->dialog->getRequest()->getSession()->getUserId());
            $this->response
                ->setText(view('dialogues.greet-no-user'))
                ->setTts(view('dialogues.greet-no-user'));
        } else if ($this->userSeriesRepository->getUserFavouriteSeries($this->user->id)->count() == 0) {
            $this->response
                ->setText(view('dialogues.greet-no-user'))
                ->setTts(view('dialogues.greet-no-user'));
        } else {
            $this->response
                ->setText(view('dialogues.greet-user-exists'))
                ->setTts(view('dialogues.greet-user-exists'));
        }
        Cache::put('stage_' . $this->user->id, 2, 2600);
    }

    private function secondStage(string $command)
    {
        $command = mb_strtolower(trim($command));
        if(strpos($command,"подобрать") !== false ||
            strpos($command,"подбери") !== false) {
            //Подбор сериалов
        } else {
            $series = $this->matchService->predict($command);
            if(sizeof($series) == 0) {
                $this->response
                    ->setText(view('dialogues.no-series-found'))
                    ->setTts(view('dialogues.no-series-found'));
            } else {
                $names = [];
                foreach($series as $id => $name) {
                    $names[] = $name;
                    $this->userSeriesRepository->addUserFavouriteSeries($this->user->id, $id);
                }
                $this->response
                    ->setText(view('dialogues.series-found', [
                        'series' => implode(', ', $names)
                    ]))
                    ->setTts(view('dialogues.series-found', [
                        'series' => implode(', ', $names)
                    ]));
            }
        }
    }

    private function authorize()
    {
        $yandexID = $this->dialog->getRequest()->getSession()->getUserId();
        $this->user = $this->userRepository->getUserByYandexID($yandexID);
    }
}
