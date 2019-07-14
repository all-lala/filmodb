<?php
namespace Alala\TmdbBundle\Command;

use Alala\TmdbBundle\Enum\TmdbChoices;
use Alala\TmdbBundle\Service\TmdbQuery;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Alala\TmdbBundle\Service\LocalMovieInterface;

class TmbdMovieCommand extends Command
{    
    use LockableTrait;
    
    private $configs;
    private $tmdbQuery;
    private $localMovie;
    private $request;
    
    public function __construct($configs = null, TmdbQuery $tmdbQuery, LocalMovieInterface $localMovie = null){
        $this->configs = $configs;
        $this->tmdbQuery = $tmdbQuery;
        $this->localMovie = $localMovie;
        
        parent::__construct();
    }
    
    protected function configure(){
        $this->setName('tmbd:movie')
            ->setDescription('Query TMDB by discover');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output){
        
        if(!$this->lock()){
            throw new \RuntimeException('The command is already running in another process.');
        }
        
        $this->request = [
            'url' => [],
            'parameters' => []
        ];
        
        $output->writeln([
            '=================================',
            '========== TMDB MOVIES ==========',
            '=================================',
            '']);
        
        $choiceType = [];
        foreach(TmdbChoices::QUERY_MOVIES as $key => $choice){
            $choiceType[] = $key;
        }
        
        $helper = $this->getHelper('question');
        
        $question = new ChoiceQuestion('Type of search : ',
            $choiceType,
            0);
        $chosenQuery = $helper->ask($input, $output, $question);
        
        $this->request['url']['link'] = TmdbChoices::QUERY_MOVIES[$chosenQuery]['link'];
        
        $this->showQuestions(TmdbChoices::QUERY_MOVIES[$chosenQuery], $input, $output);
        
        $movies = $this->tmdbQuery->request($this->request);
        
        if(!empty($movies)){
            $this->showMoviesTable($movies, $output);
            if(isset($this->localMovie)){
                $question = new ConfirmationQuestion('Do you want to save this movies? [True|False] <False>', false, '/^(true|t|false|f)/i');
                if($helper->ask($input, $output, $question)){
                    $this->localMovie->saveMovies($movies);
                }
            }
        }else{
            $output->writeln('No movie!');
        }
        
    }
    
    /**
     * Affiche les questions
     * @param array $questionsList exemple :
        'parameters' => [
            'language' => [
                'title' => 'Chose your language',
                'type' => 'string',
                'required' => false,
                'default' => ['language']
            ],
            'region' => [
                'title' => 'Chose region',
                'type' => 'integer',
                'required' => false,
                'default' => 123476
            ],
            'sort_by' => [
                'title' => 'Chose the sort by result',
                'type' => 'array',
                'list' => ['byname', 'bypref'],
                'required' => false,
                'default' => ['discover','sortby']
            ]
        ],
        'url' => [
            [
                'title' => 'Movie Id',
                'type' => 'string',
                'default' => null,
                'required' => true
            ]
        ]
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function showQuestions($questionsList, InputInterface $input, OutputInterface $output){
        $helper = $this->getHelper('question');
        
        foreach($this->request as $key => &$req){
            if(isset($questionsList[$key])){
                foreach($questionsList[$key] as $type => $query){
                    do{
                        $default = $this->getDefaultValue($query['default']);
                        
                        switch($query['type']){
                            case "boolean":
                                $question = new ConfirmationQuestion($query['title']. ' [True|False] <' . $default . '>', $default, '/^(true|t|false|f)/i');
                                break;
                            case "string":
                                $question = new Question($query['title']. ' [string] <' . $default . '>', $default);
                                break;
                            case "integer":
                                $question = new Question($query['title']. ' [number] <' . $default . '>', $default);
                                $question->setValidator(function($data){
                                    if(is_numeric($data) || empty($data)){
                                        return $data;
                                    }
                                    throw new \RuntimeException(
                                        'Numeric data only!'
                                        );
                                });
                                    break;
                            case "array":
                                $question = new ChoiceQuestion($query['title']. '<' . $default . '>',
                                $query['list'],
                                array_search($default, $query['list']));
                                break;
                        }
                        
                        $result = $helper->ask($input, $output, $question);
                        $req[$type] = $result;
                        
                        $output->writeln($result);
                        $output->writeln('');
                    }while(isset($query['required']) &&
                        $query['required'] == true &&
                        empty($result));
                }
            }
        }
    }
    
    /**
     * Affiche les films dans une table
     * 
     * @param array $movies
     * @param OutputInterface $output
     */
    public function showMoviesTable($movies, OutputInterface $output){
        $moivieList = [];
        array_map(function($data) use (&$moivieList){
            array_push($moivieList, [
                $data['id'],
                $data['title'],
                $data['release_date']
            ]);
        }, $movies);
            
        $table = new Table($output);
        $table->setHeaders(array('id', 'Title', 'Realease date'));
        $table->setRows($moivieList);
        
        $table->render();
    }
    
    public function getDefaultValue($base){
        if(is_array($base)){
            $result = $this->configs;
            
            foreach($base as $i){
                $result = $result[$i];
            }
                
            return $result;
        }
        
        return $base;
    }
}

